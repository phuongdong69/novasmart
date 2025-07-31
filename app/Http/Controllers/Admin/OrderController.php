<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
        $order->updateStatus($request->status_id, auth()->id(), $request->note);
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
        return view('admin.orders.show', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::with(['orderStatus', 'user', 'voucher', 'payment', 'orderDetails.productVariant.product'])->findOrFail($id);
        $statuses = \App\Models\Status::getByType('order');
        return view('admin.orders.edit', compact('order', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $order = \App\Models\Order::findOrFail($id);
        $data = $request->all();
        // Xử lý status_code
        if (!empty($data['status_code'])) {
            $status = \App\Models\Status::findByCodeAndType($data['status_code'], 'order');
            if ($status) {
                $data['status_id'] = $status->id;
            }
        }
        $order->update($data);
        return redirect()->route('admin.orders.index')->with('success', 'Cập nhật đơn hàng thành công!');
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