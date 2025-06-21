<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VariantAttributeValue;
use Illuminate\Support\Facades\DB;

class VariantAttributeValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('variant_attribute_values')->delete();

        VariantAttributeValue::create([
            'product_variant_id' => 1,
            'attribute_id' => 1,
            'attribute_value_id' => 1 // Red
        ]);

        VariantAttributeValue::create([
            'product_variant_id' => 1,
            'attribute_id' => 2,
            'attribute_value_id' => 2 // Large
        ]);
    }
}
