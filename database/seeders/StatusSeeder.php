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
        DB::table('statuses')->insert([
            // Status cho Product
            [
                'name' => 'Kích hoạt',
                'code' => 'active',
                'type' => 'product',
                'color' => '#22c55e', // xanh lá
                'priority' => 1,
                'is_active' => 1,
                'description' => 'Đang hoạt động',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ngừng hoạt động',
                'code' => 'inactive',
                'type' => 'product',
                'color' => '#ef4444', // đỏ
                'priority' => 2,
                'is_active' => 1,
                'description' => 'Không hoạt động',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Status cho Order
            [
                'name' => 'Chờ xác nhận',
                'code' => 'pending',
                'type' => 'order',
                'color' => '#f59e42', // cam
                'priority' => 1,
                'is_active' => 1,
                'description' => 'Đơn hàng chờ xác nhận',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Đã xác nhận',
                'code' => 'confirmed',
                'type' => 'order',
                'color' => '#3b82f6', // xanh dương
                'priority' => 2,
                'is_active' => 1,
                'description' => 'Đơn hàng đã được xác nhận',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Đang giao hàng',
                'code' => 'shipping',
                'type' => 'order',
                'color' => '#8b5cf6', // tím
                'priority' => 3,
                'is_active' => 1,
                'description' => 'Đơn hàng đang được giao',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Đã giao hàng',
                'code' => 'delivered',
                'type' => 'order',
                'color' => '#22c55e', // xanh lá
                'priority' => 4,
                'is_active' => 1,
                'description' => 'Đơn hàng đã giao thành công',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Đã hoàn thành',
                'code' => 'completed',
                'type' => 'order',
                'color' => '#059669', // xanh lá đậm
                'priority' => 5,
                'is_active' => 1,
                'description' => 'User đã xác nhận hoàn thành đơn hàng',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Đã hủy',
                'code' => 'cancelled',
                'type' => 'order',
                'color' => '#ef4444', // đỏ
                'priority' => 6,
                'is_active' => 1,
                'description' => 'Đơn hàng đã bị hủy',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hoàn tiền',
                'code' => 'refunded',
                'type' => 'order',
                'color' => '#6b7280', // xám
                'priority' => 7,
                'is_active' => 1,
                'description' => 'Đơn hàng đã hoàn tiền',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Status cho Product Variant
            [
                'name' => 'Còn hàng',
                'code' => 'in_stock',
                'type' => 'product_variant',
                'color' => '#22c55e', // xanh lá
                'priority' => 1,
                'is_active' => 1,
                'description' => 'Sản phẩm còn hàng',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hết hàng',
                'code' => 'out_of_stock',
                'type' => 'product_variant',
                'color' => '#ef4444', // đỏ
                'priority' => 2,
                'is_active' => 1,
                'description' => 'Sản phẩm hết hàng',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
