<?php



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voucher;
use Illuminate\Support\Str;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Voucher::create([
                'code' => 'SALE' . rand(100, 999),
                'discount_type' => rand(0, 1) ? 'percentage' : 'fixed',
                'discount_value' => rand(5, 50) * (rand(0, 1) ? 1 : 1000), // 5–50% hoặc 5000–50000
                'expiry_date' => now()->addDays(rand(10, 90)),
                'quantity' => rand(10, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
