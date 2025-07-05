<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;
use App\Models\Order;

class StatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            // Order statuses
            ['name' => 'Chờ xử lý', 'code' => 'pending', 'type' => 'order', 'color' => '#f59e42', 'priority' => 1, 'is_active' => true, 'description' => 'Đơn hàng mới, chờ xử lý'],
            ['name' => 'Đang giao', 'code' => 'shipping', 'type' => 'order', 'color' => '#3490dc', 'priority' => 2, 'is_active' => true, 'description' => 'Đơn hàng đang được giao'],
            ['name' => 'Đã hoàn thành', 'code' => 'completed', 'type' => 'order', 'color' => '#38c172', 'priority' => 3, 'is_active' => true, 'description' => 'Đơn hàng đã giao thành công'],
            ['name' => 'Đã hủy', 'code' => 'cancelled', 'type' => 'order', 'color' => '#e3342f', 'priority' => 4, 'is_active' => true, 'description' => 'Đơn hàng đã bị hủy'],
            // User statuses
            ['name' => 'Hoạt động', 'code' => 'active', 'type' => 'user', 'color' => '#38c172', 'priority' => 1, 'is_active' => true, 'description' => 'Tài khoản đang hoạt động'],
            ['name' => 'Khóa', 'code' => 'banned', 'type' => 'user', 'color' => '#e3342f', 'priority' => 2, 'is_active' => true, 'description' => 'Tài khoản bị khóa'],
            // Product statuses
            ['name' => 'Đang bán', 'code' => 'selling', 'type' => 'product', 'color' => '#38c172', 'priority' => 1, 'is_active' => true, 'description' => 'Sản phẩm đang bán'],
            ['name' => 'Ngừng bán', 'code' => 'stopped', 'type' => 'product', 'color' => '#e3342f', 'priority' => 2, 'is_active' => true, 'description' => 'Sản phẩm ngừng bán'],
        ];
        foreach ($statuses as $status) {
            Status::updateOrCreate([
                'code' => $status['code'],
                'type' => $status['type'],
            ], $status);
        }

        $order = Order::find(1);
        $order->updateStatus($status_id, $user_id, 'Ghi chú thay đổi trạng thái');
    }
} 