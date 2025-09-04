<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        // Eager load để dùng ngay các quan hệ trong email
        $order = Order::with(['orderStatus', 'payment.status', 'orderDetails.productVariant.product', 'voucher', 'user'])
            ->findOrFail($id);

        // --- Validate: cho phép gửi 1 trong 2 field ---
        $data = $request->validate([
            'status_id'          => ['nullable', 'exists:statuses,id'], // trạng thái ĐƠN HÀNG
            'payment_status_id'  => ['nullable', 'exists:statuses,id'], // trạng thái THANH TOÁN
            'note'               => ['nullable', 'string'],
        ], [], [
            'status_id'         => 'Trạng thái đơn hàng',
            'payment_status_id' => 'Trạng thái thanh toán',
            'note'              => 'Ghi chú',
        ]);

        if (empty($data['status_id']) && empty($data['payment_status_id'])) {
            throw ValidationException::withMessages([
                'status_id' => 'Bạn phải chọn ít nhất một trạng thái để cập nhật.',
            ]);
        }

        // =====================================================================
        // 1) CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG (nếu có status_id)
        // =====================================================================
        if (!empty($data['status_id'])) {
            $oldStatusCode = $order->orderStatus->code ?? null;

            // Gọi hàm domain của bạn (giữ nguyên)
            $order->updateStatus($data['status_id'], auth()->id(), $data['note'] ?? null);

            $status = Status::findOrFail($data['status_id']);

            // ----- Huỷ đơn hàng -----
            if ($status->code === 'cancelled' && $oldStatusCode !== 'cancelled') {
                // Hoàn lại số lượng sản phẩm
                foreach ($order->orderDetails as $detail) {
                    if ($detail->productVariant) {
                        $detail->productVariant->increment('quantity', $detail->quantity);
                    }
                }

                // Hoàn voucher nếu có
                if ($order->voucher_id) {
                    $order->voucher->increment('quantity');
                    \DB::table('voucher_usages')
                        ->where('voucher_id', $order->voucher_id)
                        ->where('user_id', $order->user_id)
                        ->delete();
                }

                // Gửi mail: HUỶ ĐƠN
                $this->sendCancelMail($order, $data['note'] ?? null);
            }

            // ----- Giao hàng thành công -----
            if ($status->code === 'delivered') {
                // Tự động chuyển trạng thái thanh toán sang "đã thanh toán" nếu đang là "chưa thanh toán"
                if ($order->payment) {
                    $currentPayCode = optional($order->payment->status)->code;
                    if ($currentPayCode === 'unpaid' || $currentPayCode === null) {
                        $paidStatusId = Status::where('type', 'payment')->where('code', 'paid')->value('id');
                        if ($paidStatusId) {
                            $order->payment->update(['status_id' => $paidStatusId]);
                        }
                    }
                }

                $this->sendDeliveredMail($order);

                // ================================================================
                // 🔁 Auto set trạng thái THANH TOÁN = "paid" khi ĐƠN HÀNG = "delivered"
                // ---------------------------------------------------------------
                // - Chỉ chạy nếu đơn đã có bản ghi payment.
                // - Tránh ghi đè các trạng thái "nhạy cảm" như refunded.
                // - Tìm status "paid" theo type = 'payment' để đúng ngữ nghĩa hệ thống.
                // - Không loại bỏ/đổi chỗ bất kỳ logic hiện có nào khác.
                // ================================================================
                if ($order->payment) { // Có bản ghi thanh toán thì mới xét tự động
                    // Lấy status "paid" trong nhóm trạng thái thanh toán (type = payment)
                    $paidPaymentStatus = Status::where('type', 'payment')->where('code', 'paid')->first();

                    if ($paidPaymentStatus) { // Đảm bảo có cấu hình status "paid"
                        // Lấy code hiện tại của thanh toán (nếu có)
                        $currentPayCode = optional($order->payment->status)->code;

                        // Chỉ cập nhật nếu CHƯA phải 'paid' và KHÔNG phải 'refunded'
                        // -> Tránh ghi đè khi đã hoàn tiền hoặc đã paid trước đó
                        if (!in_array($currentPayCode, ['paid', 'refunded'])) {
                            // Cập nhật status_id sang "paid"
                            $order->payment->update([
                                'status_id' => $paidPaymentStatus->id,
                            ]);
                        }
                    }
                    // Nếu không tìm thấy status "paid" thì bỏ qua lặng lẽ để tránh lỗi runtime.
                }
                // ================================================================
                // 🔁 Hết phần auto set thanh toán khi giao hàng
                // ================================================================
            }
        }

        // =====================================================================
        // 2) CẬP NHẬT TRẠNG THÁI THANH TOÁN (nếu có payment_status_id)
        // =====================================================================
        if (!empty($data['payment_status_id'])) {
            if (!$order->payment) {
                return back()->withErrors(['refund' => 'Đơn này chưa có bản ghi thanh toán.']);
            }

            // Cập nhật trạng thái thanh toán
            $order->payment->update([
                'status_id' => $data['payment_status_id'],
            ]);

            // Nếu trạng thái thanh toán mới là "refunded" ⇒ gửi mail xác nhận hoàn tiền
            $payStatus = Status::find($data['payment_status_id']);

            if ($payStatus && $payStatus->code === 'refunded') {
                $this->sendRefundMail($order);
            }
        }

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    // ============ EMAIL HELPERS ============

    protected function sendCancelMail(Order $order, ?string $note = null): void
    {
        $subTotal       = $order->orderDetails->sum(fn($i) => ($i->price * $i->quantity));
        $discountAmount = max(0, $subTotal - $order->total_price);

        $body  = "❌ Đơn hàng của bạn đã bị huỷ bởi Nova Smart.\n\n";
        $body .= "🧾 Mã đơn hàng: {$order->order_code}\n";
        $body .= "👤 Tên khách hàng: {$order->name}\n";
        $body .= "📧 Email: {$order->email}\n";
        $body .= "📞 SĐT: {$order->phoneNumber}\n";
        $body .= "🏠 Địa chỉ: {$order->address}\n";
        $body .= "💵 Tạm tính: " . number_format($subTotal, 0, ',', '.') . "₫\n";

        if ($order->voucher) {
            $body .= "🎁 Mã giảm giá: {$order->voucher->code}\n";
        }
        if ($discountAmount > 0) {
            $body .= "🔻 Số tiền được giảm: -" . number_format($discountAmount, 0, ',', '.') . "₫\n";
        }

        $body .= "✅ Tổng thanh toán: " . number_format($order->total_price, 0, ',', '.') . "₫\n\n";
        if (!empty($note)) {
            $body .= "📋 Lý do huỷ: {$note}\n\n";
        }
        $body .= "💚 Cảm ơn bạn đã quan tâm đến sản phẩm của Nova Smart.\n";
        $body .= "Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ với chúng tôi.\n\n";
        $body .= "Trân trọng,\nNova Smart";

        \Mail::raw($body, function ($message) use ($order) {
            $message->to($order->email, $order->name)
                ->subject('Thông báo huỷ đơn hàng - Nova Smart');
        });
    }

    protected function sendDeliveredMail(Order $order): void
    {
        $subTotal       = $order->orderDetails->sum(fn($i) => ($i->price * $i->quantity));
        $discountAmount = max(0, $subTotal - $order->total_price);

        $body  = "📦 Đơn hàng của bạn đã được giao thành công bởi Nova Smart!\n\n";
        $body .= "🧾 Mã đơn hàng: {$order->order_code}\n";
        $body .= "👤 Tên khách hàng: {$order->name}\n";
        $body .= "📧 Email: {$order->email}\n";
        $body .= "📞 SĐT: {$order->phoneNumber}\n";
        $body .= "🏠 Địa chỉ: {$order->address}\n";
        $body .= "💵 Tạm tính: " . number_format($subTotal, 0, ',', '.') . "₫\n";

        if ($order->voucher) {
            $body .= "🎁 Mã giảm giá: {$order->voucher->code}\n";
        }
        if ($discountAmount > 0) {
            $body .= "🔻 Số tiền được giảm: -" . number_format($discountAmount, 0, ',', '.') . "₫\n";
        }

        $body .= "✅ Tổng thanh toán: " . number_format($order->total_price, 0, ',', '.') . "₫\n\n";
        $body .= "🔹 Sản phẩm:\n";
        foreach ($order->orderDetails as $item) {
            $variant = $item->productVariant;
            if ($variant) {
                $body .= "- {$variant->product->name} ({$variant->name}) × {$item->quantity} = "
                    . number_format($item->price * $item->quantity, 0, ',', '.') . "₫\n";
            }
        }
        $body .= "\n💚 Cảm ơn bạn đã mua sắm tại Nova Smart!\n";
        $body .= "Nếu có bất kỳ thắc mắc nào, hãy liên hệ với chúng tôi.\n\n";
        $body .= "Trân trọng,\nNova Smart";

        \Mail::raw($body, function ($message) use ($order) {
            $message->to($order->email, $order->name)
                ->subject('Đơn hàng của bạn đã được giao - Nova Smart');
        });
    }

    protected function sendRefundMail(Order $order): void
    {
        $subTotal       = $order->orderDetails->sum(fn($i) => ($i->price * $i->quantity));
        $discountAmount = max(0, $subTotal - $order->total_price);

        $body  = "💰 Đơn hàng của bạn đã được hoàn tiền thành công từ Nova Smart!\n\n";
        $body .= "🧾 Mã đơn hàng: {$order->order_code}\n";
        $body .= "👤 Tên khách hàng: {$order->name}\n";
        $body .= "📧 Email: {$order->email}\n";
        $body .= "📞 SĐT: {$order->phoneNumber}\n";
        $body .= "🏠 Địa chỉ: {$order->address}\n";
        $body .= "💵 Tạm tính: " . number_format($subTotal, 0, ',', '.') . "₫\n";
        $body .= "💵 Số tiền hoàn lại: " . number_format($order->total_price, 0, ',', '.') . "₫\n";
        if ($order->voucher) {
            $body .= "🎁 Mã giảm giá: {$order->voucher->code}\n";
        }
        if ($discountAmount > 0) {
            $body .= "🔻 Số tiền được giảm: -" . number_format($discountAmount, 0, ',', '.') . "₫\n";
        }
        $body .= "✅ Tổng thanh toán: " . number_format($order->total_price, 0, ',', '.') . "₫\n\n";
        $body .= "🔹 Sản phẩm:\n";
        foreach ($order->orderDetails as $item) {
            $variant = $item->productVariant;
            if ($variant) {
                $body .= "- {$variant->product->name} ({$variant->name}) × {$item->quantity} = "
                    . number_format($item->price * $item->quantity, 0, ',', '.') . "₫\n";
            }
        }
        $body .= "\n💚 Cảm ơn bạn đã tin tưởng mua sắm tại Nova Smart.\n";
        $body .= "Nếu có bất kỳ thắc mắc nào về khoản hoàn tiền, vui lòng liên hệ với chúng tôi.\n\n";
        $body .= "Trân trọng,\nNova Smart";

        \Mail::raw($body, function ($message) use ($order) {
            $message->to($order->email, $order->name)
                ->subject('Xác nhận hoàn tiền đơn hàng - Nova Smart');
        });
    }

    // ================== CÁC ACTION KHÁC (giữ nguyên) ==================

    public function statusLogs($id)
    {
        $order = \App\Models\Order::findOrFail($id);
        $logs = $order->statusLogs()->with('status', 'loggable')->orderByDesc('created_at')->get();
        return view('admin.orders.status_logs', compact('order', 'logs'));
    }

    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                    ->orWhere('name', 'like', "%$search%")
                    ->orWhere('phoneNumber', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        // Nên eager load thêm payment.status để hiển thị nhanh ở list
        $orders = $query->with(['orderStatus', 'payment.status', 'user'])
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['orderStatus', 'payment.status', 'user', 'voucher', 'orderDetails.productVariant.product'])
            ->findOrFail($id);
        $statusLogs = $order->statusLogs()->with('status', 'user')->orderByDesc('created_at')->get();

        $subTotal = $order->orderDetails->sum(fn($item) => $item->price * $item->quantity);
        $discountAmount = max(0, $subTotal - $order->total_price);

        return view('admin.orders.show', compact('order', 'statusLogs', 'subTotal', 'discountAmount'));
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        foreach ($order->orderDetails as $detail) {
            if ($detail->productVariant) {
                $detail->productVariant->increment('quantity', $detail->quantity);
            }
        }

        if ($order->voucher_id) {
            $order->voucher->increment('quantity');
            \DB::table('voucher_user')
                ->where('user_id', $order->user_id)
                ->where('voucher_id', $order->voucher_id)
                ->delete();
        }

        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Đã xóa đơn hàng thành công!');
    }
}
