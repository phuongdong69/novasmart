<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // status cho product
        $statusProductActive = DB::table('statuses')
            ->where('type', 'product')->where('code', 'active')->value('id') ?: 1;

        // đảm bảo có sẵn brand / origin / category tối thiểu
        $brandId = DB::table('brands')->value('id') ?: DB::table('brands')->insertGetId([
            'name' => 'Apple', 'status_id' => DB::table('statuses')->where('type','brand')->where('code','active')->value('id') ?: 1,
            'created_at'=>$now,'updated_at'=>$now,
        ]);

        $originId = DB::table('origins')->value('id') ?: DB::table('origins')->insertGetId([
            'country' => 'Việt Nam', 'status_id' => DB::table('statuses')->where('type','origin')->where('code','active')->value('id') ?: 1,
            'created_at'=>$now,'updated_at'=>$now,
        ]);

        $categoryId = DB::table('categories')->value('id') ?: DB::table('categories')->insertGetId([
            'name' => 'Laptop', 'status_id' => DB::table('statuses')->where('type','category')->where('code','active')->value('id') ?: 1,
            'created_at'=>$now,'updated_at'=>$now,
        ]);

        // vài sản phẩm mẫu
        $items = [
            ['name' => 'MacBook Air M3',         'description' => 'Laptop mỏng nhẹ, hiệu năng tốt.'],
            ['name' => 'MacBook Pro 14 inch M4', 'description' => 'Hiệu năng mạnh mẽ cho dev/design.'],
            ['name' => 'Dell Inspiron 14 5440',  'description' => 'Học tập và làm việc bền bỉ.'],
            ['name' => 'ASUS TUF Gaming A15',    'description' => 'Gaming ổn định, tản nhiệt tốt.'],
            ['name' => 'iPhone 16 Pro Max',      'description' => 'Màn lớn, camera mạnh.'],
        ];

        foreach ($items as $p) {
            DB::table('products')->updateOrInsert(
                ['name' => $p['name']],
                [
                    'status_id'   => $statusProductActive,
                    'brand_id'    => $brandId,
                    'origin_id'   => $originId,
                    'category_id' => $categoryId,
                    'description' => $p['description'],
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ]
            );
        }
    }
}
