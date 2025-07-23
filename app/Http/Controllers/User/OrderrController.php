<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Status;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class OrderrController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng của người dùng,
     * có thể lọc theo trạng thái (pending, delivering, completed, cancelled).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $statusFilter = $request->query('status');

        $orders = Order::with([
            'orderStatus',
            'orderDetails.productVariant.product'
        ])
            ->where('user_id', $user->id)
            ->when($statusFilter, function ($query, $statusFilter) {
                $query->whereHas('orderStatus', function ($q) use ($statusFilter) {
                    $q->where('code', $statusFilter);
                });
            })
            ->latest()
            ->get();

        return view('user.orders.index', compact('orders', 'statusFilter'));
    }

    /**
     * Hiển thị chi tiết một đơn hàng cụ thể.
     */
    public function show($id)
    {
        $order = Order::with(['orderStatus', 'payment', 'orderDetails.productVariant.product'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.orders.show', compact('order'));
    }

    /**
     * Huỷ đơn hàng nếu đang ở trạng thái 'pending'.
     */
    public function cancel($id)
    {
        $order = Order::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $pendingStatus = Status::where('type', 'order')->where('code', 'pending')->first();
        $cancelStatus = Status::where('type', 'order')->where('code', 'cancelled')->first();

        if ($order->status_id !== $pendingStatus->id) {
            return back()->with('error', 'Chỉ huỷ được đơn hàng đang chờ xác nhận.');
        }

        $order->status_id = $cancelStatus->id;
        $order->save();

        return redirect()->route('user.orders.show', $order->id)->with('success', 'Đã huỷ đơn hàng thành công.');
    }

    /**
     * Xác nhận người dùng đã nhận được hàng → chuyển trạng thái sang 'completed'.
     */
    public function confirmReceived($id)
    {
        $order = Order::with('orderStatus')
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

        $order->updateStatus($completedStatus->id, auth()->id(), 'Người dùng xác nhận đã nhận hàng');

        return back()->with('success', 'Cảm ơn bạn đã xác nhận. Đơn hàng đã hoàn tất.');
    }
}
