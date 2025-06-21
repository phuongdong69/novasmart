<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Thumbnail;
use Illuminate\Support\Facades\DB;

class ThumbnailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('thumbnails')->delete();

        Thumbnail::create([
            'product_id' => 1,
            'product_variant_id' => 1,
            'url' => 'https://example.com/images/product1_thumbnail.jpg',
            'is_primary' => true,
            'sort_order' => 1
        ]);

        Thumbnail::create([
            'product_id' => 2,
            'product_variant_id' => 2,
            'url' => 'https://example.com/images/product2_thumbnail.jpg',
            'is_primary' => true,
            'sort_order' => 1
        ]);
    }
}
