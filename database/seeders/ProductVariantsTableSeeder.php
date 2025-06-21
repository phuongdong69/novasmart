<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class ProductVariantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('product_variants')->delete();

        ProductVariant::create([
            'product_id' => 1,
            'sku' => 'P1-SKU1',
            'price' => 100.00,
            'status' => 1,  // 'available' = 1
            'quantity' => 50
        ]);
        ProductVariant::firstOrCreate([
            'id' => 1,
            'product_id' => 1,  // Liên kết đến product_id hợp lệ
            'sku' => 'P1-SKU1',
            'price' => 100.00,
            'status' => 1,  // Sử dụng kiểu integer (1 = available)
            'quantity' => 50,
        ]);

        ProductVariant::firstOrCreate([
            'id' => 2,
            'product_id' => 2,
            'sku' => 'P2-SKU1',
            'price' => 150.00,
            'status' => 0,  // out_of_stock
            'quantity' => 0,
        ]);
        ProductVariant::create([
            'product_id' => 2,
            'sku' => 'P2-SKU1',
            'price' => 150.00,
            'status' => 0,  // 'out_of_stock' = 0
            'quantity' => 0
        ]);
    }
}
