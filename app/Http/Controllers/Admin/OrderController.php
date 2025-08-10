<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        $order = \App\Models\Order::findOrFail($id);
        $request->validate([
            'status_id' => 'required|exists:statuses,id',
            'note' => 'nullable|string',
        ]);

        $oldStatus = $order->orderStatus->code ?? null;
        $order->updateStatus($request->status_id, auth()->id(), $request->note);

        $status = \App\Models\Status::findOrFail($request->status_id);

        // ✅ Huỷ đơn hàng
        if ($status->code === 'cancelled' && $oldStatus !== 'cancelled') {
            // Hoàn lại số lượng sản phẩm
            foreach ($order->orderDetails as $detail) {
                $detail->productVariant->increment('quantity', $detail->quantity);
            }

            // Hoàn voucher nếu có
            if ($order->voucher_id) {
                $order->voucher->increment('quantity');
                \DB::table('voucher_usages')
                    ->where('voucher_id', $order->voucher_id)
                    ->where('user_id', $order->user_id)
                    ->delete();
            }

            // 📩 Gửi email thông báo huỷ đơn
            $subTotal = $order->orderDetails->sum(fn($item) => $item->price * $item->quantity);
            $discountAmount = max(0, $subTotal - $order->total_price);

            $body = "❌ Đơn hàng của bạn đã bị huỷ bởi Nova Smart.\n\n";
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

            if (!empty($request->note)) {
                $body .= "📋 Lý do huỷ: {$request->note}\n\n";
            }

            $body .= "💚 Cảm ơn bạn đã quan tâm đến sản phẩm của Nova Smart.\n";
            $body .= "Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ với chúng tôi.\n\n";
            $body .= "Trân trọng,\nNova Smart";

            \Mail::raw($body, function ($message) use ($order) {
                $message->to($order->email, $order->name)
                    ->subject('Thông báo huỷ đơn hàng - Nova Smart');
            });
        }

        // ✅ Hoàn tiền
        if ($status->code === 'refunded') {
            $subTotal = $order->orderDetails->sum(fn($item) => $item->price * $item->quantity);
            $discountAmount = max(0, $subTotal - $order->total_price);

            $body = "💰 Đơn hàng của bạn đã được hoàn tiền thành công từ Nova Smart!\n\n";
            $body .= "🧾 Mã đơn hàng: {$order->order_code}\n";
            $body .= "👤 Tên khách hàng: {$order->name}\n";
            $body .= "📧 Email: {$order->email}\n";
            $body .= "📞 SĐT: {$order->phoneNumber}\n";
            $body .= "🏠 Địa chỉ: {$order->address}\n";
            $body .= "💵 Tạm tính: " . number_format($subTotal, 0, ',', '.') . "₫\n";
            $body .= "💵 Số tiền hoàn lại: " . number_format($order->total_price, 0, ',', '.') . "₫\n\n";
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

            $body .= "\n💚 Cảm ơn bạn đã tin tưởng mua sắm tại Nova Smart.\n";
            $body .= "Nếu có bất kỳ thắc mắc nào về khoản hoàn tiền, vui lòng liên hệ với chúng tôi.\n\n";
            $body .= "Trân trọng,\nNova Smart";

            \Mail::raw($body, function ($message) use ($order) {
                $message->to($order->email, $order->name)
                    ->subject('Xác nhận hoàn tiền đơn hàng - Nova Smart');
            });
        }

        // ✅ Giao hàng thành công
        if ($status->code === 'delivered') {
            $subTotal = $order->orderDetails->sum(fn($item) => $item->price * $item->quantity);
            $discountAmount = max(0, $subTotal - $order->total_price);

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

            \Mail::raw($body, function ($message) use ($order) {
                $message->to($order->email, $order->name)
                    ->subject('Đơn hàng của bạn đã được giao - Nova Smart');
            });
        }

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }

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

        $orders = $query->with(['orderStatus', 'user'])
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['orderStatus', 'user', 'voucher', 'payment', 'orderDetails.productVariant.product'])
            ->findOrFail($id);
        $statusLogs = $order->statusLogs()->with('status', 'user')->orderByDesc('created_at')->get();

        $subTotal = $order->orderDetails->sum(fn($item) => $item->price * $item->quantity);
        $discountAmount = max(0, $subTotal - $order->total_price);

        return view('admin.orders.show', compact('order', 'statusLogs', 'subTotal', 'discountAmount'));
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Hoàn số lượng sản phẩm
        foreach ($order->orderDetails as $detail) {
            $detail->productVariant->increment('quantity', $detail->quantity);
        }

        // Hoàn voucher
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
