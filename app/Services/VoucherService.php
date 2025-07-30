<?php

namespace App\Services;

use App\Models\Voucher;
use App\Models\VoucherUsage;
use App\Models\Order;
use Carbon\Carbon;

class VoucherService
{
    /**
     * Validate voucher for a user and order total
     */
    public function validateVoucher($code, $userId, $orderTotal)
    {
        $voucher = Voucher::where('code', $code)->first();

        if (!$voucher) {
            return [
                'success' => false,
                'message' => 'Mã voucher không tồn tại trong hệ thống'
            ];
        }

        // Kiểm tra thời gian hiệu lực
        if (!$voucher->isValid()) {
            return [
                'success' => false,
                'message' => 'Voucher đã hết hạn hoặc không còn hiệu lực'
            ];
        }

        // Kiểm tra user có thể sử dụng voucher không
        if (!$voucher->canBeUsedByUser($userId)) {
            return [
                'success' => false,
                'message' => 'Bạn đã sử dụng voucher này rồi'
            ];
        }

        // Kiểm tra giá trị đơn hàng tối thiểu
        if ($orderTotal < $voucher->min_order_value) {
            return [
                'success' => false,
                'message' => 'Đơn hàng phải có giá trị tối thiểu ' . number_format($voucher->min_order_value) . ' VNĐ'
            ];
        }

        // Tính toán giá trị giảm
        $discountAmount = $voucher->calculateDiscount($orderTotal);

        return [
            'success' => true,
            'voucher' => $voucher,
            'discount_amount' => $discountAmount,
            'final_total' => $orderTotal - $discountAmount
        ];
    }

    /**
     * Apply voucher to an order
     */
    public function applyVoucher($voucherId, $orderId, $userId, $discountAmount)
    {
        $voucher = Voucher::findOrFail($voucherId);
        $order = Order::findOrFail($orderId);

        // Tạo voucher usage record
        VoucherUsage::create([
            'voucher_id' => $voucher->id,
            'user_id' => $userId,
            'order_id' => $orderId,
            'discount_amount' => $discountAmount,
        ]);

        // Cập nhật số lần sử dụng voucher
        $voucher->incrementUsage();

        // Cập nhật order với voucher và giảm giá
        $order->update([
            'voucher_id' => $voucher->id,
            'total_price' => $order->total_price - $discountAmount,
        ]);

        return [
            'success' => true,
            'message' => 'Voucher đã được áp dụng thành công'
        ];
    }

    /**
     * Remove voucher from order (when order is cancelled)
     */
    public function removeVoucherFromOrder($orderId)
    {
        $order = Order::with('voucher')->findOrFail($orderId);
        
        if ($order->voucher) {
            // Xóa voucher usage record
            VoucherUsage::where('order_id', $orderId)->delete();
            
            // Giảm số lần sử dụng voucher
            $order->voucher->decrementUsage();
            
            // Cập nhật order
            $order->update([
                'voucher_id' => null,
                'total_price' => $order->total_price + $order->voucher->calculateDiscount($order->total_price),
            ]);
        }

        return [
            'success' => true,
            'message' => 'Voucher đã được gỡ bỏ thành công'
        ];
    }

    /**
     * Get available vouchers for a user
     */
    public function getAvailableVouchers($userId, $orderTotal = 0)
    {
        return Voucher::where(function($query) use ($userId) {
                $query->where('is_public', true)
                      ->orWhere('user_id', $userId);
            })
            ->where('status_id', 1) // Active status
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->where('used', '<', 'usage_limit')
            ->where('min_order_value', '<=', $orderTotal)
            ->get();
    }

    /**
     * Get voucher usage statistics
     */
    public function getVoucherStats($voucherId)
    {
        $voucher = Voucher::with('usages')->findOrFail($voucherId);
        
        return [
            'total_usage' => $voucher->usages->count(),
            'remaining_usage' => $voucher->usage_limit - $voucher->used,
            'total_discount_given' => $voucher->usages->sum('discount_amount'),
            'usage_percentage' => ($voucher->used / $voucher->usage_limit) * 100,
        ];
    }
} 