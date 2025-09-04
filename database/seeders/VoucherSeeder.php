<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        $statusActive = \DB::table('statuses')
            ->where('type', 'voucher')
            ->where('code', 'active')
            ->value('id') ?: 1;

        Voucher::create([
            'code' => 'GIAM10K',
            'description' => 'Giảm 10.000đ cho đơn hàng bất kỳ',
            'discount_type' => 'fixed',
            'discount_value' => 10000,
            'quantity' => 100,
            'expired_at' => Carbon::now()->addDays(30),
            'status_id' => $statusActive,
        ]);

        Voucher::create([
            'code' => 'SALE50',
            'description' => 'Giảm 50% cho đơn hàng từ 500k',
            'discount_type' => 'percent',
            'discount_value' => 50,
            'quantity' => 50,
            'expired_at' => Carbon::now()->addDays(15),
            'status_id' => $statusActive,
        ]);
    }
}
