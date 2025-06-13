<?php

namespace Database\Seeders;

use App\Models\Origin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OriginSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['country' => 'Việt Nam'],
            ['country' => 'Hoa Kỳ'],
            ['country' => 'Nhật Bản'],
            ['country' => 'Hàn Quốc'],
            ['country' => 'Pháp'],
        ];

        foreach ($data as $item) {
            Origin::create($item);
        }
    }
}
