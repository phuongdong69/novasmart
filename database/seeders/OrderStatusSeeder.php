<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class OrderStatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            [
                'name' => 'Chờ xử lý',
                'code' => 'pending',
                'type' => 'order',
                'color' => '#f59e0b',
                'priority' => 1,
                'is_active' => true,
                'description' => 'Đơn hàng mới được đặt, chờ xác nhận'
            ],
            [
                'name' => 'Đã xác nhận',
                'code' => 'confirmed',
                'type' => 'order',
                'color' => '#3b82f6',
                'priority' => 2,
                'is_active' => true,
                'description' => 'Đơn hàng đã được xác nhận và đang chuẩn bị'
            ],
            [
                'name' => 'Đang giao hàng',
                'code' => 'shipping',
                'type' => 'order',
                'color' => '#8b5cf6',
                'priority' => 3,
                'is_active' => true,
                'description' => 'Đơn hàng đang được vận chuyển'
            ],
            [
                'name' => 'Đã giao hàng',
                'code' => 'delivered',
                'type' => 'order',
                'color' => '#10b981',
                'priority' => 4,
                'is_active' => true,
                'description' => 'Đơn hàng đã được giao thành công'
            ],
            [
                'name' => 'Hoàn thành',
                'code' => 'completed',
                'type' => 'order',
                'color' => '#059669',
                'priority' => 5,
                'is_active' => true,
                'description' => 'Đơn hàng đã hoàn thành'
            ],
            [
                'name' => 'Đã hủy',
                'code' => 'cancelled',
                'type' => 'order',
                'color' => '#ef4444',
                'priority' => 6,
                'is_active' => true,
                'description' => 'Đơn hàng đã bị hủy'
            ],
            [
                'name' => 'Hoàn tiền',
                'code' => 'refunded',
                'type' => 'order',
                'color' => '#6b7280',
                'priority' => 7,
                'is_active' => true,
                'description' => 'Đơn hàng đã được hoàn tiền'
            ]
        ];

        foreach ($statuses as $status) {
            Status::updateOrCreate(
                ['code' => $status['code'], 'type' => $status['type']],
                $status
            );
        }
    }
} 