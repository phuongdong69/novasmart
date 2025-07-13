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
                ->orWhere('customer_name', 'like', "%$search%")
                ->orWhere('customer_phone', 'like', "%$search%")
                ->orWhere('customer_email', 'like', "%$search%");
        }

        $orders = $query->with('status')->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }
} 