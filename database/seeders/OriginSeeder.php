<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OriginSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Lấy status "active" cho type = origin
        $statusActive = DB::table('statuses')
            ->where('type', 'origin')
            ->where('code', 'active')
            ->value('id');

        // Nếu chưa có thì để tạm 1
        $statusActive = $statusActive ?: 1;

        $origins = [
            'Việt Nam',
            'Trung Quốc',
            'Hàn Quốc',
            'Nhật Bản',
            'Mỹ',
            'Đài Loan',
            'Thái Lan',
            'Đức',
            'Singapore',
        ];

        foreach ($origins as $country) {
            DB::table('origins')->updateOrInsert(
                ['country' => $country],
                [
                    'status_id'  => $statusActive,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
