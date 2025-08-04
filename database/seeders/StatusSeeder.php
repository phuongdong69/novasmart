<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            // Status cho Product
            [
                'name' => 'Kích hoạt',
                'code' => 'active',
                'type' => 'product',
                'color' => '#22c55e',
                'priority' => 1,
                'is_active' => 1,
                'description' => 'Đang hoạt động',
            ],
            [
                'name' => 'Ngừng hoạt động',
                'code' => 'inactive',
                'type' => 'product',
                'color' => '#ef4444',
                'priority' => 2,
                'is_active' => 1,
                'description' => 'Không hoạt động',
            ],

            // Status cho Order
            [
                'name' => 'Chờ xác nhận',
                'code' => 'pending',
                'type' => 'order',
                'color' => '#f59e42',
                'priority' => 1,
                'is_active' => 1,
                'description' => 'Đơn hàng chờ xác nhận',
            ],
            [
                'name' => 'Đã xác nhận',
                'code' => 'confirmed',
                'type' => 'order',
                'color' => '#3b82f6',
                'priority' => 2,
                'is_active' => 1,
                'description' => 'Đơn hàng đã được xác nhận',
            ],
            [
                'name' => 'Đang giao hàng',
                'code' => 'shipping',
                'type' => 'order',
                'color' => '#8b5cf6',
                'priority' => 3,
                'is_active' => 1,
                'description' => 'Đơn hàng đang được giao',
            ],
            [
                'name' => 'Đã giao hàng',
                'code' => 'delivered',
                'type' => 'order',
                'color' => '#22c55e',
                'priority' => 4,
                'is_active' => 1,
                'description' => 'Đơn hàng đã giao thành công',
            ],
            [
                'name' => 'Đã hoàn thành',
                'code' => 'completed',
                'type' => 'order',
                'color' => '#059669',
                'priority' => 5,
                'is_active' => 1,
                'description' => 'User đã xác nhận hoàn thành đơn hàng',
            ],
            [
                'name' => 'Đã hủy',
                'code' => 'cancelled',
                'type' => 'order',
                'color' => '#ef4444',
                'priority' => 6,
                'is_active' => 1,
                'description' => 'Đơn hàng đã bị hủy',
            ],
            [
                'name' => 'Hoàn tiền',
                'code' => 'refunded',
                'type' => 'order',
                'color' => '#6b7280',
                'priority' => 7,
                'is_active' => 1,
                'description' => 'Đơn hàng đã hoàn tiền',
            ],

            // Status cho Product Variant
            [
                'name' => 'Còn hàng',
                'code' => 'in_stock',
                'type' => 'product_variant',
                'color' => '#22c55e',
                'priority' => 1,
                'is_active' => 1,
                'description' => 'Sản phẩm còn hàng',
            ],
            [
                'name' => 'Hết hàng',
                'code' => 'out_of_stock',
                'type' => 'product_variant',
                'color' => '#ef4444',
                'priority' => 2,
                'is_active' => 1,
                'description' => 'Sản phẩm hết hàng',
            ],
            // Status cho User
            [
                'name' => 'Hoạt động',
                'code' => 'active',
                'type' => 'user',
                'color' => '#22c55e',
                'priority' => 1,
                'is_active' => 1,
                'description' => 'Tài khoản đang hoạt động',
            ],
            [
                'name' => 'Tạm khóa',
                'code' => 'inactive',
                'type' => 'user',
                'color' => '#ef4444',
                'priority' => 2,
                'is_active' => 1,
                'description' => 'Tài khoản bị tạm khóa',
            ],
            [
                'name' => 'Chờ xác minh',
                'code' => 'pending_verify',
                'type' => 'user',
                'color' => '#facc15',
                'priority' => 3,
                'is_active' => 1,
                'description' => 'Chờ người dùng xác minh email hoặc số điện thoại',
            ],
            [
                'name' => 'Đã xóa',
                'code' => 'deleted',
                'type' => 'user',
                'color' => '#6b7280',
                'priority' => 4,
                'is_active' => 0,
                'description' => 'Tài khoản đã bị xóa hoặc không còn sử dụng',
            ],
        ];

        foreach ($statuses as $status) {
            \App\Models\Status::firstOrCreate(
                ['code' => $status['code'], 'type' => $status['type']],
                $status
            );
        }
    }
}
