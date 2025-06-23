<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductVariant;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\VariantAttributeValue;

class VariantAttributeValuesTableSeeder extends Seeder
{
    public function run(): void
    {
        $attributes = Attribute::with('values')->get();
        $variants = ProductVariant::all();

        foreach ($variants as $variant) {
            foreach ($attributes as $attribute) {
                // Lấy giá trị ngẫu nhiên trong attribute đó
                $value = $attribute->values->random();

                VariantAttributeValue::create([
                    'product_variant_id' => $variant->id,
                    'attribute_id' => $attribute->id,
                    'attribute_value_id' => $value->id,
                ]);
            }
        }
    }
}
