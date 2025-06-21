<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Tạo sản phẩm mẫu nếu chưa có
        Product::firstOrCreate([
            'id' => 1,
            'name' => 'Sample Product 1',
            'category_id' => 1,  
            'brand_id' => 1,      
            'origin_id' => 1,     
            'description' => 'This is a sample product description.',
        ]);

        Product::firstOrCreate([
            'id' => 2,
            'name' => 'Sample Product 2',
            'category_id' => 1,
            'brand_id' => 1,
            'origin_id' => 1,
            'description' => 'This is another sample product description.',
        ]);
    }
}
