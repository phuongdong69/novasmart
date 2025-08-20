<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Status;
use App\Models\Payment;
use App\Models\ProductVariant;
use App\Models\Voucher;
use App\Models\OrderHistory;
use App\Models\OrderCancellation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class OrderrController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $statusFilter = $request->query('status');

        $orders = Order::with([
            'orderStatus',
            'payment.status', // ✅ load luôn payment status
            'orderDetails.productVariant.product'
        ])
            ->where('user_id', $user->id)
            ->when($statusFilter, function ($query, $statusFilter) {
                if ($statusFilter === 'refunded') {
                    // lọc theo trạng thái thanh toán
                    $query->whereHas('payment.status', function ($q) {
                        $q->where('code', 'refunded');
                    });
                } else {
                    // lọc theo trạng thái đơn hàng
                    $query->whereHas('orderStatus', function ($q) use ($statusFilter) {
                        $q->where('code', $statusFilter);
                    });
                }
            })
            ->latest()
            ->get();

        return view('user.orders.index', compact('orders', 'statusFilter'));
    }


    public function show($id)
    {
        $order = Order::with(['orderStatus', 'payment.status', 'voucher', 'orderDetails.productVariant.product'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        // Tính tổng tiền gốc (chưa trừ giảm giá)
        $subtotal = $order->orderDetails->sum(fn($item) => $item->price * $item->quantity);
        $discountAmount = $subtotal - $order->total_price;

        return view('user.orders.show', compact('order', 'subtotal', 'discountAmount'));
    }


    /**
     * Huỷ đơn hàng nếu đang ở trạng thái 'pending'.
     * - Nhập lý do
     * - Hoàn kho
     * - Hoàn voucher
     * - Giả lập hoàn tiền nếu thanh toán online
     */



    public function cancel(Request $request, $id)
    {
        $order = Order::with(['orderDetails.productVariant.product', 'payment', 'voucher'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $pendingStatus = Status::where('type', 'order')->where('code', 'pending')->first();
        $cancelStatus = Status::where('type', 'order')->where('code', 'cancelled')->first();

        if (!$pendingStatus || !$cancelStatus) {
            return back()->with('error', 'Không tìm thấy trạng thái cần thiết.');
        }

        if ($order->status_id !== $pendingStatus->id) {
            return back()->with('error', 'Chỉ huỷ được đơn hàng đang chờ xác nhận.');
        }

        $request->validate([
            'note' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Cập nhật trạng thái và lý do
            $order->status_id = $cancelStatus->id;
            $order->cancel_reason = $request->note;
            $order->save();

            // Hoàn kho
            foreach ($order->orderDetails as $detail) {
                $variant = $detail->productVariant;
                if ($variant) {
                    $variant->quantity += $detail->quantity;
                    $variant->save();
                }
            }

            // Hoàn voucher
            if ($order->voucher_id) {
                $voucher = Voucher::find($order->voucher_id);

                // Tăng lại số lượng voucher nếu có giới hạn
                if ($voucher && $voucher->quantity !== null) {
                    $voucher->quantity += 1;
                    $voucher->save();
                }

                // Xóa bản ghi trong bảng voucher_usages để cho phép dùng lại
                DB::table('voucher_usages')
                    ->where('voucher_id', $order->voucher_id)
                    ->where('user_id', $order->user_id)
                    ->delete();
            }

            // Giả lập hoàn tiền
            if ($order->payment && $order->payment->payment_method === 'vnpay') {
                logger("Đã hoàn tiền cho đơn hàng #{$order->id} qua VNPay.");
            }

            // 🔔 Gửi email thông báo huỷ hàng
            $body = "Bạn đã huỷ đơn hàng tại Nova Smart.\n\n";
            $body .= "🧾 Mã đơn hàng: {$order->order_code}\n";
            $body .= "👤 Tên khách hàng: {$order->name}\n";
            $body .= "📧 Email: {$order->email}\n";
            $body .= "📞 Số điện thoại: {$order->phoneNumber}\n";
            $body .= "🏠 Địa chỉ: {$order->address}\n";
            $body .= "❌ Lý do huỷ: {$order->cancel_reason}\n";

            // 👉 Tính tạm tính và giảm giá
            $subTotal = $order->orderDetails->sum(fn($item) => $item->price * $item->quantity);
            $discountAmount = $subTotal - $order->total_price;

            $body .= "💵 Tạm tính: " . number_format($subTotal, 0, ',', '.') . "₫\n";

            if ($discountAmount > 0) {
                $voucherCode = $order->voucher->code ?? '';
                $body .= "🔖 Mã giảm giá: {$voucherCode}\n";
                $body .= "🧾 Đã giảm: -" . number_format($discountAmount, 0, ',', '.') . "₫\n";
            }

            $body .= "💰 Tổng tiền (sau giảm): " . number_format($order->total_price, 0, ',', '.') . "₫\n\n";

            $body .= "🔹 Các sản phẩm trong đơn hàng:\n";

            foreach ($order->orderDetails as $item) {
                $variant = $item->productVariant;
                if ($variant) {
                    $body .= "- {$variant->product->name} ({$variant->name}) × {$item->quantity} = " .
                        number_format($item->quantity * $item->price, 0, ',', '.') . "₫\n";
                }
            }

            $body .= "\nĐơn hàng của bạn đã được huỷ thành công.\n\n";
            $body .= "Trân trọng,\nNova Smart";

            // Gửi email
            Mail::raw($body, function ($message) use ($order) {
                $message->to($order->email, $order->name)
                    ->subject("Huỷ đơn hàng thành công - Nova Smart");
            });

            DB::commit();
            return redirect()->route('user.orders.show', $order->id)
                ->with('success', 'Đã huỷ đơn hàng thành công và gửi email xác nhận.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger('Lỗi huỷ đơn: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }



    public function confirmReceived($id)
    {
        $order = Order::with([
            'orderStatus',
            'orderDetails.productVariant.product',
            'voucher'
        ])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($order->orderStatus->code !== 'delivered') {
            return back()->with('error', 'Chỉ xác nhận đơn hàng đã được giao.');
        }

        $completedStatus = Status::where('type', 'order')->where('code', 'completed')->first();

        if (!$completedStatus) {
            return back()->with('error', 'Không tìm thấy trạng thái hoàn thành.');
        }

        // ✅ Cập nhật trạng thái
        $order->updateStatus($completedStatus->id, auth()->id(), 'Người dùng xác nhận đã nhận hàng');

        // ✅ Soạn nội dung email
        $body = "🎉 Bạn đã xác nhận đã nhận đơn hàng tại Nova Smart.\n\n";
        $body .= "🧾 Mã đơn hàng: {$order->order_code}\n";
        $body .= "👤 Tên khách hàng: {$order->name}\n";
        $body .= "📧 Email: {$order->email}\n";
        $body .= "📞 SĐT: {$order->phoneNumber}\n";
        $body .= "🏠 Địa chỉ: {$order->address}\n";

        // ✅ Tính tạm tính & giảm giá
        $subTotal = $order->orderDetails->sum(fn($item) => $item->price * $item->quantity);
        $discountAmount = $subTotal - $order->total_price;

        $body .= "💵 Tạm tính: " . number_format($subTotal, 0, ',', '.') . "₫\n";

        if ($order->voucher) {
            $body .= "🎁 Mã giảm giá: {$order->voucher->code}\n";
        }

        if ($discountAmount > 0) {
            $body .= "🔻 Số tiền được giảm: -" . number_format($discountAmount, 0, ',', '.') . "₫\n";
        }

        $body .= "✅ Tổng tiền (sau giảm): " . number_format($order->total_price, 0, ',', '.') . "₫\n";

        $body .= "\n🔹 Các sản phẩm trong đơn hàng:\n";

        foreach ($order->orderDetails as $item) {
            $variant = $item->productVariant;
            if ($variant) {
                $body .= "- {$variant->product->name} ({$variant->name}) × {$item->quantity} = " .
                    number_format($item->quantity * $item->price, 0, ',', '.') . "₫\n";
            }
        }

        $body .= "\n✅ Cảm ơn bạn đã mua sắm tại Nova Smart. Rất mong được phục vụ bạn lần sau!\n\n";
        $body .= "Trân trọng,\nNova Smart";

        // ✅ Gửi email
        Mail::raw($body, function ($message) use ($order) {
            $message->to($order->email, $order->name)
                ->subject("Xác nhận đã nhận hàng - Nova Smart");
        });


        return back()->with('success', 'Cảm ơn bạn đã xác nhận. Đơn hàng đã hoàn tất và email xác nhận đã được gửi.');
    }
}
