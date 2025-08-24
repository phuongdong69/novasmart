<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

class MenuDataSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo categories
        $laptopCategory = Category::firstOrCreate(['name' => 'Laptop']);
        $mobileCategory = Category::firstOrCreate(['name' => 'Điện thoại']);
        $tabletCategory = Category::firstOrCreate(['name' => 'Máy tính bảng']);

        // Tạo brands và gán category
        $brands = [
            'Apple' => $mobileCategory->id,
            'Samsung' => $mobileCategory->id,
            'Dell' => $laptopCategory->id,
            'HP' => $laptopCategory->id,
            'Lenovo' => $laptopCategory->id,
            'Asus' => $laptopCategory->id,
            'Acer' => $laptopCategory->id,
            'Xiaomi' => $mobileCategory->id,
            'OPPO' => $mobileCategory->id,
            'Vivo' => $mobileCategory->id,
        ];

        foreach ($brands as $brandName => $categoryId) {
            Brand::firstOrCreate(
                ['name' => $brandName],
                ['category_id' => $categoryId]
            );
        }

        // Cập nhật brands hiện có
        Brand::where('name', 'Acer')->update(['category_id' => $laptopCategory->id]);
        Brand::where('name', 'Asus')->update(['category_id' => $laptopCategory->id]);

        echo "Menu data seeded successfully!\n";
        echo "Categories: " . Category::count() . "\n";
        echo "Brands: " . Brand::count() . "\n";
    }
} 