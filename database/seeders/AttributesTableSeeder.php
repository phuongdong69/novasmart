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
        $attributes = [
            ['name' => 'Màu sắc', 'description' => 'Màu sắc sản phẩm'],
            ['name' => 'RAM', 'description' => 'Dung lượng bộ nhớ RAM'],
            ['name' => 'Bộ nhớ', 'description' => 'Dung lượng bộ nhớ trong'],
            ['name' => 'Kích thước màn hình', 'description' => 'Kích thước của màn hình thiết bị']
        ];

        foreach ($attributes as $attr) {
            Attribute::create($attr);
        }
    }
}
