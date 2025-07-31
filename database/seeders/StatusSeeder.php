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
            // Order statuses
            [
                'code' => 'pending',
                'name' => 'Chờ xử lý',
                'type' => 'order',
                'color' => '#f59e42',
                'sort_order' => 1,
                'is_active' => true,
                'description' => 'Đơn hàng mới, chờ xử lý',
            ],
            [
                'code' => 'processing',
                'name' => 'Đang xử lý',
                'type' => 'order',
                'color' => '#3490dc',
                'sort_order' => 2,
                'is_active' => true,
                'description' => 'Đơn hàng đang được xử lý',
            ],
            [
                'code' => 'shipped',
                'name' => 'Đang giao',
                'type' => 'order',
                'color' => '#3490dc',
                'sort_order' => 3,
                'is_active' => true,
                'description' => 'Đơn hàng đang được giao',
            ],
            [
                'code' => 'completed',
                'name' => 'Đã hoàn thành',
                'type' => 'order',
                'color' => '#38c172',
                'sort_order' => 4,
                'is_active' => true,
                'description' => 'Đơn hàng đã giao thành công',
            ],
            [
                'code' => 'cancelled',
                'name' => 'Đã hủy',
                'type' => 'order',
                'color' => '#e3342f',
                'sort_order' => 5,
                'is_active' => true,
                'description' => 'Đơn hàng đã bị hủy',
            ],

            // User statuses
            [
                'code' => 'active',
                'name' => 'Hoạt động',
                'type' => 'user',
                'color' => '#38c172',
                'sort_order' => 1,
                'is_active' => true,
                'description' => 'Tài khoản đang hoạt động',
            ],
            [
                'code' => 'suspended',
                'name' => 'Bị khóa',
                'type' => 'user',
                'color' => '#e3342f',
                'sort_order' => 2,
                'is_active' => true,
                'description' => 'Tài khoản bị khóa',
            ],
            [
                'code' => 'pending_verification',
                'name' => 'Chờ xác thực',
                'type' => 'user',
                'color' => '#f59e42',
                'sort_order' => 0,
                'is_active' => true,
                'description' => 'Tài khoản chờ xác thực email',
            ],

            // Product statuses
            [
                'code' => 'draft',
                'name' => 'Bản nháp',
                'type' => 'product',
                'color' => '#6c757d',
                'sort_order' => 0,
                'is_active' => true,
                'description' => 'Sản phẩm chưa được xuất bản',
            ],
            [
                'code' => 'published',
                'name' => 'Đã xuất bản',
                'type' => 'product',
                'color' => '#3490dc',
                'sort_order' => 1,
                'is_active' => true,
                'description' => 'Sản phẩm đã được xuất bản',
            ],
            [
                'code' => 'in_stock',
                'name' => 'Còn hàng',
                'type' => 'product',
                'color' => '#38c172',
                'sort_order' => 2,
                'is_active' => true,
                'description' => 'Sản phẩm đang bán',
            ],
            [
                'code' => 'out_of_stock',
                'name' => 'Ngừng bán',
                'type' => 'product',
                'color' => '#e3342f',
                'sort_order' => 3,
                'is_active' => true,
                'description' => 'Sản phẩm ngừng bán',
            ],

            // Voucher statuses
            [
                'code' => 'draft',
                'name' => 'Bản nháp',
                'type' => 'voucher',
                'color' => '#6c757d',
                'sort_order' => 0,
                'is_active' => true,
                'description' => 'Voucher chưa được kích hoạt',
            ],
            [
                'code' => 'active',
                'name' => 'Hoạt động',
                'type' => 'voucher',
                'color' => '#38c172',
                'sort_order' => 1,
                'is_active' => true,
                'description' => 'Voucher đang hoạt động',
            ],
            [
                'code' => 'inactive',
                'name' => 'Ngừng hoạt động',
                'type' => 'voucher',
                'color' => '#e3342f',
                'sort_order' => 2,
                'is_active' => true,
                'description' => 'Voucher ngừng hoạt động',
            ],
            [
                'code' => 'expired',
                'name' => 'Hết hạn',
                'type' => 'voucher',
                'color' => '#e3342f',
                'sort_order' => 3,
                'is_active' => true,
                'description' => 'Voucher đã hết hạn',
            ],
        ];

        foreach ($statuses as $status) {
            $statusModel = Status::updateOrCreate(
                ['code' => $status['code'], 'type' => $status['type']],
                $status
            );
            // Log id của status active user
            if ($status['type'] === 'user' && $status['code'] === 'active') {
                echo "User active status id: {$statusModel->id}\n";
            }
        }
    }
}
