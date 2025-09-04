<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddTabletCategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Lấy id trạng thái "Kích hoạt" cho category
        $statusActive = DB::table('statuses')
            ->where('type', 'category')
            ->where('code', 'active')
            ->value('id');

        // Thêm category "Máy tính bảng"
        DB::table('categories')->updateOrInsert(
            ['name' => 'Máy tính bảng'],
            [
                'status_id'  => $statusActive,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        echo "Category 'Máy tính bảng' đã được thêm thành công!\n";
    }
}
