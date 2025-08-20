<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Lấy status "active" cho type = brand
        $statusActive = DB::table('statuses')
            ->where('type', 'brand')
            ->where('code', 'active')
            ->value('id');

        $statusActive = $statusActive ?: 1;

        $brands = [
            'Apple',
            'Samsung',
            'Dell',
            'Asus',
            'HP',
            'Lenovo',
            'Acer',
            'MSI',
            'Sony',
            'LG',
            'Xiaomi',
            'Huawei',
            'Logitech',
            'Razer',
            'Corsair',
        ];

        foreach ($brands as $brand) {
            DB::table('brands')->updateOrInsert(
                ['name' => $brand],
                [
                    'status_id'  => $statusActive,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
