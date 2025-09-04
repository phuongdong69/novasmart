<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddAccessoryCategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Lấy id trạng thái "Kích hoạt" cho category
        $statusActive = DB::table('statuses')
            ->where('type', 'category')
            ->where('code', 'active')
            ->value('id');

        // Thêm category "Phụ Kiện Máy Tính Khác"
        DB::table('categories')->updateOrInsert(
            ['name' => 'Phụ Kiện Máy Tính Khác'],
            [
                'status_id'  => $statusActive,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        echo "Category 'Phụ Kiện Máy Tính Khác' đã được thêm thành công!\n";
    }
}
