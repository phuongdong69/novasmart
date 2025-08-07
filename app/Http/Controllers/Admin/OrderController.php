<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Cập nhật trạng thái cho order và ghi log
     */
    public function updateStatus(Request $request, $id)
    {
        $order = \App\Models\Order::findOrFail($id);
        $request->validate([
            'status_id' => 'required|exists:statuses,id',
            'note' => 'nullable|string',
        ]);

        // Cập nhật trạng thái
        $order->updateStatus($request->status_id, auth()->id(), $request->note);

        // Kiểm tra nếu trạng thái mới là "delivered"
        $status = \App\Models\Status::findOrFail($request->status_id);
        if ($status->code === 'delivered') {

            $subTotal = $order->orderDetails->sum(fn($item) => $item->price * $item->quantity);
            $discountAmount = $order->discount_amount ?? 0;

            $body = "📦 Đơn hàng của bạn đã được giao thành công bởi Nova Smart!\n\n";
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
                    $body .= "- {$variant->product->name} ({$variant->name}) × {$item->quantity} = " .
                        number_format($item->price * $item->quantity, 0, ',', '.') . "₫\n";
                }
            }

            $body .= "\n💚 Cảm ơn bạn đã mua sắm tại Nova Smart!\n";
            $body .= "Nếu có bất kỳ thắc mắc nào, hãy liên hệ với chúng tôi.\n\n";
            $body .= "Trân trọng,\nNova Smart";

            // Gửi email
            \Mail::raw($body, function ($message) use ($order) {
                $message->to($order->email, $order->name)
                    ->subject('Đơn hàng của bạn đã được giao - Nova Smart');
            });
        }

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }



    /**
     * Hiển thị lịch sử thay đổi trạng thái của order
     */
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
            $query->where('id', 'like', "%$search%")
                ->orWhere('name', 'like', "%$search%")
                ->orWhere('phoneNumber', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        $orders = $query->with(['orderStatus', 'user'])->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function show($id)
    {
        $order = Order::with(['orderStatus', 'user', 'voucher', 'payment', 'orderDetails.productVariant.product'])->findOrFail($id);
        $statusLogs = $order->statusLogs()->with('status', 'user')->orderByDesc('created_at')->get();
        return view('admin.orders.show', compact('order', 'statusLogs'));
    }

    /**
     * Xóa đơn hàng
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Hoàn trả số lượng sản phẩm về kho
        foreach ($order->orderDetails as $detail) {
            $detail->productVariant->increment('quantity', $detail->quantity);
        }

        // Hoàn trả voucher nếu có
        if ($order->voucher_id) {
            $order->voucher->increment('quantity');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Đã xóa đơn hàng thành công!');
    }
}
