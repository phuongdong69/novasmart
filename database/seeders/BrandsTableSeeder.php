<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandsTableSeeder extends Seeder
{
    public function run()
    {
        // Insert sample brands if not already present
        Brand::firstOrCreate([
            'id' => 1,
            'name' => 'dell',           
        ]);

        Brand::firstOrCreate([
            'id' => 2,
            'name' => 'asus',
        ]);
    }
}