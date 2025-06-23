<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductThumbnailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_thumbnails')->insert([
            [
                'product_id' => 1,
                'product_variant_id' => 1,
                'url' => 'uploads/products/1/thumb1.jpg',
                'is_primary' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'product_variant_id' => 2,
                'url' => 'uploads/products/1/thumb2.jpg',
                'is_primary' => false,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'product_variant_id' => 3,
                'url' => 'uploads/products/2/thumb1.jpg',
                'is_primary' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
