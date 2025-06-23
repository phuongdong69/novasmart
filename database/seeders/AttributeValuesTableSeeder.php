<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AttributeValue;
use App\Models\Attribute;
use Illuminate\Support\Facades\DB;

class AttributeValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $values = [
            'Màu sắc' => ['Đen', 'Trắng', 'Xám'],
            'RAM' => ['4GB', '8GB', '16GB'],
            'Bộ nhớ' => ['64GB', '128GB', '256GB'],
            'Kích thước màn hình' => ['6.1"', '6.5"', '6.7"']
        ];

        foreach ($values as $attrName => $attrValues) {
            $attribute = Attribute::where('name', $attrName)->first();
            foreach ($attrValues as $val) {
                AttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'value' => $val
                ]);
            }
        }
    }
}
