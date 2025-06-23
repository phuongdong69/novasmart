<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductVariantsTableSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            // Tạo 2 biến thể mỗi sản phẩm
            for ($i = 1; $i <= 2; $i++) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'sku' => 'SKU-' . $product->id . '-' . $i,
                    'price' => rand(500, 1500),
                    'status' => true,
                    'quantity' => rand(10, 100),
                ]);
            }
        }
    }
}
