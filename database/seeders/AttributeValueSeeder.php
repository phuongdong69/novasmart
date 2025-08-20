<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeValueSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Helper: lấy attribute_id theo name
        $getAttrId = function ($name) {
            return DB::table('attributes')->where('name', $name)->value('id');
        };

        $values = [
            'Màu sắc' => ['Đen', 'Bạc', 'Xám', 'Xanh', 'Vàng', 'Trắng', 'Titan tự nhiên'],
            'Màn hình' => ['13.6 inch', '14 inch', '15.6 inch', '16 inch', '6.1 inch', '6.7 inch', '6.9 inch', 'FHD', 'QHD', '4K'],
            'RAM' => ['8GB', '16GB', '24GB', '32GB', '64GB'],
            'CPU' => ['Apple M3', 'Apple M4', 'Core i5', 'Core i7', 'Ryzen 5', 'Ryzen 7', 'Apple A18 Pro'],
            'Lưu trữ' => ['256GB', '512GB', '1TB', '2TB'],
            'GPU' => ['Tích hợp', 'RTX 3050', 'RTX 4060', 'RTX 4070'],
            'Kích thước & trọng lượng' => [
                '1.15kg / 30.41 x 21.24 x 1.13 cm',
                '1.6kg / 35.7 x 25.2 x 1.8 cm'
            ],
            'Camera' => ['FaceTime HD 1080p', 'HD 720p', 'Sau 48MP + 12MP + 12MP; Trước 12MP'],
            'Hệ điều hành' => ['macOS', 'Windows 11', 'Android', 'iOS'],
            'Cổng kết nối' => ['USB-A', 'USB-C', 'Thunderbolt 4', 'HDMI', 'Audio 3.5mm'],
            'Tần số quét' => ['60Hz', '120Hz', '144Hz', '165Hz']
        ];

        foreach ($values as $attrName => $list) {
            $attrId = $getAttrId($attrName);
            if (!$attrId) continue;

            foreach ($list as $val) {
                DB::table('attribute_values')->updateOrInsert(
                    ['attribute_id' => $attrId, 'value' => $val],
                    [
                        'attribute_id' => $attrId,
                        'value'        => $val,
                        'created_at'   => $now,
                        'updated_at'   => $now,
                    ]
                );
            }
        }
    }
}
