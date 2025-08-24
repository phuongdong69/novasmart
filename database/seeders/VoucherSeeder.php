<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        Voucher::create([
            'code' => 'GIAM10K',
            'description' => 'Giảm 10.000đ cho đơn hàng bất kỳ',
            'discount_type' => 'fixed',
            'discount_value' => 10000,
            'quantity' => 100,
            'expired_at' => Carbon::now()->addDays(30),
            'status_id' => 1, // bạn cần đảm bảo status_id = 1 đang tồn tại (ví dụ "Đang hoạt động")
        ]);

        Voucher::create([
            'code' => 'SALE50',
            'description' => 'Giảm 50% cho đơn hàng từ 500k',
            'discount_type' => 'percent',
            'discount_value' => 50,
            'quantity' => 50,
            'expired_at' => Carbon::now()->addDays(15),
            'status_id' => 1,
        ]);
    }
}
