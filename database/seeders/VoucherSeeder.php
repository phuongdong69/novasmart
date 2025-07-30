<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voucher;
use Carbon\Carbon;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        $vouchers = [
            [
                'code' => 'SALE10',
                'type' => 'percentage',
                'value' => 10,
                'max_discount' => 100000,
                'min_order_value' => 200000,
                'usage_limit' => 100,
                'used' => 0,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(30),
                'user_id' => null,
                'is_public' => true,
                'status_id' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'GIAM50K',
                'type' => 'fixed',
                'value' => 50000,
                'max_discount' => null,
                'min_order_value' => 300000,
                'usage_limit' => 50,
                'used' => 0,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(60),
                'user_id' => null,
                'is_public' => true,
                'status_id' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'FREESHIP',
                'type' => 'fixed',
                'value' => 30000,
                'max_discount' => null,
                'min_order_value' => 500000,
                'usage_limit' => 200,
                'used' => 0,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(15),
                'user_id' => null,
                'is_public' => true,
                'status_id' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'VIP20',
                'type' => 'percentage',
                'value' => 20,
                'max_discount' => 200000,
                'min_order_value' => 1000000,
                'usage_limit' => 10,
                'used' => 0,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(90),
                'user_id' => null,
                'is_public' => false,
                'status_id' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($vouchers as $voucher) {
            Voucher::create($voucher);
        }
    }
}
