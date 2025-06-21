<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\DB;

class AttributeValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Thêm một số giá trị thuộc tính mẫu vào bảng 'attribute_values'
        AttributeValue::firstOrCreate([
            'id' => 1,
            'attribute_id' => 1,  // Liên kết với 'attribute_id' hợp lệ
            'value' => 'Red',      // Giá trị thuộc tính
        ]);

        AttributeValue::firstOrCreate([
            'id' => 2,
            'attribute_id' => 1,
            'value' => 'Blue',
        ]);

        AttributeValue::firstOrCreate([
            'id' => 3,
            'attribute_id' => 2,  // Liên kết với một thuộc tính khác
            'value' => 'Small',
        ]);
    }
}
