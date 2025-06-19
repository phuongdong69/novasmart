<?php



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voucher;
use Illuminate\Support\Str;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Voucher::insert([
            [
                'code' => 'SALE10',
                'discount_type' => 'percentage',
                'discount_value' => 10,
                'expiry_date' => now()->addDays(30),
                'quantity' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'GIAM50K',
                'discount_type' => 'fixed',
                'discount_value' => 50000,
                'expiry_date' => now()->addDays(60),
                'quantity' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'FREESHIP',
                'discount_type' => 'fixed',
                'discount_value' => 30000,
                'expiry_date' => now()->addDays(15),
                'quantity' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
