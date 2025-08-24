<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryAttributeSeeder extends Seeder
{
    public function run()
    {
        $now = now();

        $getCatId = function ($name) {
            return DB::table('categories')->where('slug', Str::slug($name))->value('id')
                ?: DB::table('categories')->where('name', $name)->value('id');
        };

        

        // Nhóm danh mục -> danh sách slug thuộc tính
        $map = [
            'Laptop'         => ['mau-sac','man-hinh','ram','cpu','luu-tru','gpu','he-dieu-hanh','cong-ket-noi','tan-so-quet','kich-thuoc-trong-luong','camera'],
            'PC Gaming'      => ['cpu','ram','gpu','luu-tru','cong-ket-noi','he-dieu-hanh'],
            'PC Văn Phòng'   => ['cpu','ram','luu-tru','cong-ket-noi','he-dieu-hanh'],
            'Màn Hình Máy Tính' => ['man-hinh','tan-so-quet','cong-ket-noi','mau-sac'],
            'Bàn Phím'       => ['mau-sac','cong-ket-noi'],
            'Chuột'          => ['mau-sac','cong-ket-noi'],
            'Tai Nghe Gaming'=> ['mau-sac','cong-ket-noi'],
            'Ổ Cứng SSD'     => ['luu-tru','cong-ket-noi'],
            'Ổ Cứng HDD'     => ['luu-tru','cong-ket-noi'],
            'Card Màn Hình (GPU)' => ['gpu','cong-ket-noi'],
            'Mainboard (Bo mạch chủ)' => ['cong-ket-noi'],
            'CPU (Bộ vi xử lý)' => ['cpu'],
            'Nguồn Máy Tính (PSU)' => [],
            'Tản Nhiệt CPU'       => [],
            'RAM (Bộ nhớ trong)'  => ['ram'],
            'USB & Ổ cứng di động'=> ['luu-tru','cong-ket-noi','mau-sac'],
            'Phụ Kiện Máy Tính Khác' => ['mau-sac','cong-ket-noi'],
            'Điện thoại'      => ['mau-sac','man-hinh','ram','cpu','luu-tru','camera','he-dieu-hanh','kich-thuoc-trong-luong'],
        ];

        foreach ($map as $categoryName => $attrSlugs) {
            $catId = $getCatId($categoryName);
            if (!$catId) continue;

            foreach ($attrSlugs as $slug) {
                $attrId = $getAttrId($slug);
                if (!$attrId) continue;

                DB::table('category_attribute')->updateOrInsert(
                    ['category_id' => $catId, 'attribute_id' => $attrId],
                    [
                        'category_id' => $catId,
                        'attribute_id'=> $attrId,
                        'created_at'  => $now,
                        'updated_at'  => $now,
                    ]
                );
            }
        }
    }
}
