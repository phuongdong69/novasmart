<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            [
                'name' => 'Kích hoạt',
                'code' => 'active',
                'type' => 'product',
                'color' => '#22c55e', // xanh lá
                'priority' => 1,
                'is_active' => 1,
                'description' => 'Đang hoạt động',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ngừng hoạt động',
                'code' => 'inactive',
                'type' => 'product',
                'color' => '#ef4444', // đỏ
                'priority' => 2,
                'is_active' => 1,
                'description' => 'Không hoạt động',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chờ duyệt',
                'code' => 'pending',
                'type' => 'product',
                'color' => '#f59e42', // cam
                'priority' => 3,
                'is_active' => 1,
                'description' => 'Chờ duyệt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
