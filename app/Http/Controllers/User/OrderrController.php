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

class OrderrController extends Controller
{
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

    public function show($id)
    {
        $order = Order::with(['orderStatus', 'payment', 'orderDetails.productVariant.product'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.orders.show', compact('order'));
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
        $order = Order::with('orderDetails.productVariant')
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
            $order->status_id = Status::where('name', 'Đã huỷ')->first()->id;
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

                if ($voucher && $voucher->quantity !== null) {
                    $voucher->quantity += 1;
                    $voucher->save();
                }
            }


            // Giả lập hoàn tiền
            if ($order->payment && $order->payment->payment_method === 'vnpay') {
                logger("Đã hoàn tiền cho đơn hàng #{$order->id} qua VNPay.");
            }
            DB::commit();
            return redirect()->route('user.orders.show', $order->id)->with('success', 'Đã huỷ đơn hàng thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger('Lỗi huỷ đơn: ' . $e->getMessage());
            return back()->with('error', $e->getMessage()); // ❗ Thêm dòng này ở đây
        }
    }


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
