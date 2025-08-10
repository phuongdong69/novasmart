<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        // Tắt FK để xóa và chèn lại an toàn
        Schema::disableForeignKeyConstraints();

        // Xóa sạch & reset auto increment
        DB::table('statuses')->delete();
        DB::statement('ALTER TABLE statuses AUTO_INCREMENT = 1');

        // Chèn đúng 19 bản ghi như ảnh
        DB::table('statuses')->insert([
            // 1-2: product
            ['id' => 1,  'name' => 'Kích hoạt',        'code' => 'active',    'type' => 'product',        'color' => '#22c55e', 'priority' => 1, 'is_active' => 1, 'description' => 'Đang hoạt động',           'created_at' => '2025-07-22 16:36:27', 'updated_at' => '2025-07-22 16:36:27'],
            ['id' => 2,  'name' => 'Ngừng hoạt động',  'code' => 'inactive',  'type' => 'product',        'color' => '#ef4444', 'priority' => 2, 'is_active' => 1, 'description' => 'Không hoạt động',          'created_at' => '2025-07-22 16:36:27', 'updated_at' => '2025-07-22 16:36:27'],

            // 3-9: order
            ['id' => 3,  'name' => 'Chờ xác nhận',     'code' => 'pending',   'type' => 'order',          'color' => '#f59e42', 'priority' => 1, 'is_active' => 1, 'description' => 'Đơn hàng chờ xác nhận',     'created_at' => '2025-07-22 16:36:27', 'updated_at' => '2025-07-22 16:36:27'],
            ['id' => 4,  'name' => 'Đã xác nhận',      'code' => 'confirmed', 'type' => 'order',          'color' => '#3b82f6', 'priority' => 2, 'is_active' => 1, 'description' => 'Đơn hàng đã được xác nhận', 'created_at' => '2025-07-22 16:36:27', 'updated_at' => '2025-07-22 16:36:27'],
            ['id' => 5,  'name' => 'Đang giao hàng',   'code' => 'shipping',  'type' => 'order',          'color' => '#8b5cf6', 'priority' => 3, 'is_active' => 1, 'description' => 'Đơn hàng đang được giao',   'created_at' => '2025-07-22 16:36:27', 'updated_at' => '2025-07-22 16:36:27'],
            ['id' => 6,  'name' => 'Đã giao hàng',     'code' => 'delivered', 'type' => 'order',          'color' => '#22c55e', 'priority' => 4, 'is_active' => 1, 'description' => 'Đơn hàng đã giao thành công', 'created_at' => '2025-07-22 16:36:27', 'updated_at' => '2025-07-22 16:36:27'],
            ['id' => 7,  'name' => 'Đã hoàn thành',    'code' => 'completed', 'type' => 'order',          'color' => '#059669', 'priority' => 5, 'is_active' => 1, 'description' => 'User đã xác nhận hoàn thành đơn hàng', 'created_at' => '2025-07-22 16:36:27', 'updated_at' => '2025-07-22 16:36:27'],
            ['id' => 8,  'name' => 'Đã hủy',           'code' => 'cancelled', 'type' => 'order',          'color' => '#ef4444', 'priority' => 6, 'is_active' => 1, 'description' => 'Đơn hàng đã bị hủy',        'created_at' => '2025-07-22 16:36:27', 'updated_at' => '2025-07-22 16:36:27'],
            ['id' => 9,  'name' => 'Hoàn tiền',        'code' => 'refunded',  'type' => 'order',          'color' => '#6b7280', 'priority' => 7, 'is_active' => 1, 'description' => 'Đơn hàng đã hoàn tiền',     'created_at' => '2025-07-22 16:36:27', 'updated_at' => '2025-07-22 16:36:27'],

            // 10-11: product_variant
            ['id' => 10, 'name' => 'Còn hàng',         'code' => 'in_stock',  'type' => 'product_variant', 'color' => '#22c55e', 'priority' => 1, 'is_active' => 1, 'description' => 'Sản phẩm còn hàng',       'created_at' => '2025-07-22 16:36:27', 'updated_at' => '2025-07-22 16:36:27'],
            ['id' => 11, 'name' => 'Hết hàng',         'code' => 'out_of_stock', 'type' => 'product_variant', 'color' => '#ef4444', 'priority' => 2, 'is_active' => 1, 'description' => 'Sản phẩm hết hàng',     'created_at' => '2025-07-22 16:36:27', 'updated_at' => '2025-07-22 16:36:27'],

            // 12-13: payment (timestamps = NULL)
            ['id' => 12, 'name' => 'Chưa thanh toán',  'code' => 'unpaid',    'type' => 'payment',        'color' => '#eab308', 'priority' => 1, 'is_active' => 1, 'description' => 'Đơn hàng chưa được thanh toán', 'created_at' => null, 'updated_at' => null],
            ['id' => 13, 'name' => 'Đã thanh toán',    'code' => 'paid',      'type' => 'payment',        'color' => '#10b981', 'priority' => 2, 'is_active' => 1, 'description' => 'Đơn hàng đã được thanh toán', 'created_at' => null, 'updated_at' => null],

            // 14-15: category
            ['id' => 14, 'name' => 'Kích hoạt',        'code' => 'active',    'type' => 'category',       'color' => '#22c55e', 'priority' => 1, 'is_active' => 1, 'description' => 'Đang hoạt động',           'created_at' => '2025-07-22 16:36:27', 'updated_at' => '2025-07-22 16:36:27'],
            ['id' => 15, 'name' => 'Ngừng hoạt động',  'code' => 'inactive',  'type' => 'category',       'color' => '#ef4444', 'priority' => 2, 'is_active' => 1, 'description' => 'Không hoạt động',          'created_at' => '2025-07-22 16:36:27', 'updated_at' => '2025-07-22 16:36:27'],

            // 16-17: origin
            ['id' => 16, 'name' => 'Kích hoạt',        'code' => 'active',    'type' => 'origin',         'color' => '#22c55e', 'priority' => 1, 'is_active' => 1, 'description' => 'Đang hoạt động',           'created_at' => '2025-07-22 16:36:27', 'updated_at' => '2025-07-22 16:36:27'],
            ['id' => 17, 'name' => 'Ngừng hoạt động',  'code' => 'inactive',  'type' => 'origin',         'color' => '#ef4444', 'priority' => 2, 'is_active' => 1, 'description' => 'Không hoạt động',          'created_at' => '2025-07-22 16:36:27', 'updated_at' => '2025-07-22 16:36:27'],

            // 18-19: voucher
            ['id' => 18, 'name' => 'Đang hoạt động',   'code' => 'active',    'type' => 'voucher',        'color' => '#22c55e', 'priority' => 1, 'is_active' => 1, 'description' => 'Voucher còn sử dụng được', 'created_at' => '2025-08-10 07:26:46', 'updated_at' => '2025-08-10 07:26:46'],
            ['id' => 19, 'name' => 'Hết hạn',          'code' => 'expired',   'type' => 'voucher',        'color' => '#6b7280', 'priority' => 2, 'is_active' => 1, 'description' => 'Voucher đã hết hạn sử dụng', 'created_at' => '2025-08-10 07:26:46', 'updated_at' => '2025-08-10 07:26:46'],
        ]);

        // Đặt lại AUTO_INCREMENT về 20 giống DB
        DB::statement('ALTER TABLE statuses AUTO_INCREMENT = 20');

        // Bật lại FK
        Schema::enableForeignKeyConstraints();
    }
}
