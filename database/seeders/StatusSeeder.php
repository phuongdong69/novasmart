<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        // Xoá tất cả dữ liệu cũ (nếu có)
        DB::table('statuses')->delete();

        // Reset AUTO_INCREMENT về 1
        DB::statement('ALTER TABLE statuses AUTO_INCREMENT = 1');

        // Danh sách dữ liệu mặc định
        $statuses = [
            // Các trạng thái sản phẩm
            [
                'name' => 'Kích hoạt',
                'code' => 'active',
                'type' => 'product',
                'color' => '#22655e',
                'priority' => 1,
                'is_active' => 1,
                'description' => 'Sản phẩm đang hoạt động',
            ],
            [
                'name' => 'Ngừng hoạt động',
                'code' => 'inactive',
                'type' => 'product',
                'color' => '#ef4444',
                'priority' => 2,
                'is_active' => 0,
                'description' => 'Sản phẩm ngừng kinh doanh',
            ],
            [
                'name' => 'Chờ duyệt',
                'code' => 'pending',
                'type' => 'product',
                'color' => '#f59e0b',
                'priority' => 3,
                'is_active' => 0,
                'description' => 'Sản phẩm đang chờ duyệt',
            ],

            // Các trạng thái đơn hàng
            [
                'name' => 'Chờ xác nhận',
                'code' => 'confirm',
                'type' => 'order',
                'color' => '#f59e0b',
                'priority' => 1,
                'is_active' => 1,
                'description' => 'Đơn hàng chờ xác nhận',
            ],
            [
                'name' => 'Đang giao',
                'code' => 'shipping',
                'type' => 'order',
                'color' => '#3b82f6',
                'priority' => 2,
                'is_active' => 1,
                'description' => 'Đơn hàng đang được giao',
            ],
            [
                'name' => 'Hoàn thành',
                'code' => 'completed',
                'type' => 'order',
                'color' => '#10b981',
                'priority' => 3,
                'is_active' => 1,
                'description' => 'Đơn hàng đã hoàn tất',
            ],
            [
                'name' => 'Đã hủy',
                'code' => 'cancelled',
                'type' => 'order',
                'color' => '#ef4444',
                'priority' => 4,
                'is_active' => 0,
                'description' => 'Đơn hàng bị huỷ',
            ],
            [
                'name' => 'Chờ xử lý',
                'code' => 'processing',
                'type' => 'order',
                'color' => '#f59e0b',
                'priority' => 5,
                'is_active' => 1,
                'description' => 'Đơn hàng đang chờ xử lý',
            ],
            [
                'name' => 'Chưa thanh toán',
                'code' => 'unpaid',
                'type' => 'order',
                'color' => '#f59e0b',
                'priority' => 6,
                'is_active' => 1,
                'description' => 'Đơn hàng chưa thanh toán',
            ],
            [
                'name' => 'Đã thanh toán',
                'code' => 'paid',
                'type' => 'order',
                'color' => '#22655e',
                'priority' => 7,
                'is_active' => 1,
                'description' => 'Đơn hàng đã thanh toán',
            ],
        ];

        // Thêm thời gian
        $now = Carbon::now();
        foreach ($statuses as &$status) {
            $status['created_at'] = $now;
            $status['updated_at'] = $now;
        }

        // Thêm vào DB
        DB::table('statuses')->insert($statuses);
    }
}
