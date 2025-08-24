<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Lấy id trạng thái "Kích hoạt" cho product
        $statusActive = DB::table('statuses')
            ->where('type', 'product')
            ->where('code', 'active')
            ->value('id');

        $attributes = [
            ['name' => 'Màu sắc', 'description' => 'Các tùy chọn màu sắc của sản phẩm'],
            ['name' => 'Màn hình', 'description' => 'Kích thước và độ phân giải màn hình'],
            ['name' => 'RAM', 'description' => 'Dung lượng bộ nhớ RAM'],
            ['name' => 'CPU', 'description' => 'Loại và tốc độ vi xử lý'],
            ['name' => 'Lưu trữ', 'description' => 'Dung lượng và loại ổ cứng/SSD'],
            ['name' => 'GPU', 'description' => 'Card đồ họa của sản phẩm'],
            ['name' => 'Kích thước & trọng lượng', 'description' => 'Kích thước vật lý và khối lượng sản phẩm'],
            ['name' => 'Camera', 'description' => 'Thông số camera trước/sau'],
            ['name' => 'Hệ điều hành', 'description' => 'Hệ điều hành cài đặt sẵn'],
            ['name' => 'Cổng kết nối', 'description' => 'Các cổng kết nối hỗ trợ'],
            ['name' => 'Tần số quét', 'description' => 'Tần số làm tươi của màn hình'],
        ];

        foreach ($attributes as $attr) {
            DB::table('attributes')->updateOrInsert(
                ['name' => $attr['name']],
                [
                    'status_id'   => $statusActive,
                    'description' => $attr['description'],
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ]
            );
        }
    }
}
