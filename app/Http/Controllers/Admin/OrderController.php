<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Status;


class OrderController extends Controller
{
    /**
     * Danh sách đơn hàng với tìm kiếm và lọc
     */
   public function index(Request $request)
{
    $query = Order::with('user');

    if ($request->has('status_id') && $request->status_id != '') {
        $query->where('status_id', $request->status_id);
    }

    $orders = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('admin.orders.index', compact('orders'));
}

    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function show($id)
    {
        $order = Order::with([
            'status',
            'user',
            'orderDetails.productVariant.product.thumbnails',
            'payment',
            'voucher'
        ])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status_id' => 'required|exists:statuses,id',
            'note' => 'nullable|string',
        ]);

        $order->updateStatus($request->status_id, auth()->id(), $request->note);

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    /**
     * Hiển thị lịch sử thay đổi trạng thái
     */
    public function statusLogs($id)
    {
        $order = Order::findOrFail($id);
        $logs = $order->statusLogs()
            ->with(['status', 'loggable'])
            ->orderByDesc('created_at')
            ->get();

        return view('admin.orders.status_logs', compact('order', 'logs'));
    }

    /**
     * Hiển thị form chỉnh sửa thông tin đơn hàng
     */
   


    /**
     * Cập nhật thông tin đơn hàng
     */

}
