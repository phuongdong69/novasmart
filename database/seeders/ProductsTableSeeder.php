<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Origin;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $categoryId = Category::first()->id ?? 1;
    $brandId = Brand::first()->id ?? 1;
    $originId = Origin::first()->id ?? 1;

    for ($i = 1; $i <= 10; $i++) {
        Product::create([
            'category_id' => $categoryId,
            'brand_id' => $brandId,
            'origin_id' => $originId,
            'name' => 'Laptop điện tử mẫu ' . $i,
            'description' => 'Mô tả sản phẩm điện tử số ' . $i
        ]);
    }
}
}
