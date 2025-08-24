<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Lấy id trạng thái "Kích hoạt" cho category
        $statusActive = DB::table('statuses')
            ->where('type', 'category')
            ->where('code', 'active')
            ->value('id');

        $categories = [
            'Laptop',
            'PC Gaming',
            'PC Văn Phòng',
            'Màn Hình Máy Tính',
            'Bàn Phím',
            'Chuột',
            'Tai Nghe Gaming',
            'Loa Máy Tính',
            'Ổ Cứng SSD',
            'Ổ Cứng HDD',
            'Card Màn Hình (GPU)',
            'Mainboard (Bo mạch chủ)',
            'CPU (Bộ vi xử lý)',
            'Nguồn Máy Tính (PSU)',
            'Tản Nhiệt CPU',
            'RAM (Bộ nhớ trong)',
            'USB & Ổ cứng di động',
            'Phụ Kiện Máy Tính Khác',
            'Điện thoại'
        ];

        foreach ($categories as $name) {
            DB::table('categories')->updateOrInsert(
                ['name' => $name],
                [
                    'status_id'  => $statusActive,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
