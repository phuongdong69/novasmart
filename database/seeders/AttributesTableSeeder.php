<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Attribute;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run()
    {
        // Thêm một số thuộc tính mẫu vào bảng 'attributes'
        Attribute::firstOrCreate([
            'id' => 1,
            'name' => 'Color',
        ]);

        Attribute::firstOrCreate([
            'id' => 2,
            'name' => 'Size',
        ]);
    }
}
