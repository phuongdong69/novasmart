<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            // Product statuses
            [
                'code' => 'active',
                'name' => 'Kích hoạt (Active)',
                'type' => 'product',
                'color' => '#22c55e',
                'priority' => 1,
                'is_active' => true,
                'description' => 'Đang hoạt động (Operating)',
            ],
            [
                'code' => 'inactive',
                'name' => 'Ngừng hoạt động (Inactive)',
                'type' => 'product',
                'color' => '#ef4444',
                'priority' => 2,
                'is_active' => true,
                'description' => 'Không hoạt động (Not operating)',
            ],

            // Order statuses
            [
                'code' => 'pending',
                'name' => 'Chờ xác nhận (Pending confirmation)',
                'type' => 'order',
                'color' => '#f59e42',
                'priority' => 1,
                'is_active' => true,
                'description' => 'Đơn hàng chờ xác nhận (Order awaiting confirmation)',
            ],
            [
                'code' => 'confirmed',
                'name' => 'Đã xác nhận (Confirmed)',
                'type' => 'order',
                'color' => '#3b82f6',
                'priority' => 2,
                'is_active' => true,
                'description' => 'Đơn hàng đã được xác nhận (Order has been confirmed)',
            ],
            [
                'code' => 'shipping',
                'name' => 'Đang giao hàng (Shipping)',
                'type' => 'order',
                'color' => '#8b5cf6',
                'priority' => 3,
                'is_active' => true,
                'description' => 'Đơn hàng đang được giao (Order is being delivered)',
            ],
            [
                'code' => 'delivered',
                'name' => 'Đã giao hàng (Delivered)',
                'type' => 'order',
                'color' => '#22c55e',
                'priority' => 4,
                'is_active' => true,
                'description' => 'Đơn hàng đã giao thành công (Order delivered successfully)',
            ],
            [
                'code' => 'completed',
                'name' => 'Đã hoàn thành (Completed)',
                'type' => 'order',
                'color' => '#059669',
                'priority' => 5,
                'is_active' => true,
                'description' => 'User đã xác nhận hoàn thành đơn hàng (User has confirmed order completion)',
            ],
            [
                'code' => 'cancelled',
                'name' => 'Đã hủy (Cancelled)',
                'type' => 'order',
                'color' => '#ef4444',
                'priority' => 6,
                'is_active' => true,
                'description' => 'Đơn hàng đã bị hủy (Order has been cancelled)',
            ],
            [
                'code' => 'refunded',
                'name' => 'Hoàn tiền (Refunded)',
                'type' => 'order',
                'color' => '#6b7280',
                'priority' => 7,
                'is_active' => true,
                'description' => 'Đơn hàng đã hoàn tiền (Order has been refunded)',
            ],

            // Product variant statuses
            [
                'code' => 'in_stock',
                'name' => 'Còn hàng (In stock)',
                'type' => 'product_variant',
                'color' => '#22c55e',
                'priority' => 1,
                'is_active' => true,
                'description' => 'Sản phẩm còn hàng (Product in stock)',
            ],
            [
                'code' => 'out_of_stock',
                'name' => 'Hết hàng (Out of stock)',
                'type' => 'product_variant',
                'color' => '#ef4444',
                'priority' => 2,
                'is_active' => true,
                'description' => 'Sản phẩm hết hàng (Product out of stock)',
            ],

            // Payment statuses
            [
                'code' => 'unpaid',
                'name' => 'Chưa thanh toán (Unpaid)',
                'type' => 'payment',
                'color' => '#eab308',
                'priority' => 1,
                'is_active' => true,
                'description' => 'Đơn hàng chưa được thanh toán (Order not yet paid)',
            ],
            [
                'code' => 'paid',
                'name' => 'Đã thanh toán (Paid)',
                'type' => 'payment',
                'color' => '#10b981',
                'priority' => 2,
                'is_active' => true,
                'description' => 'Đơn hàng đã được thanh toán (Order has been paid)',
            ],
        ];

        foreach ($statuses as $status) {
            $statusModel = Status::updateOrCreate(
                ['code' => $status['code'], 'type' => $status['type']],
                $status
            );
        }
    }
}

