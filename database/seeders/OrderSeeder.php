<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $statusPending = DB::table('statuses')->where('type','order')->where('code','pending')->value('id') ?: 1;
        $userIds = DB::table('users')->pluck('id')->all();

        if (empty($userIds)) {
            $this->command->warn('⚠️ Chưa có users. Hãy chạy AuthorSeeder trước.');
            return;
        }

        // tạo 3 đơn
        for ($i=0; $i<3; $i++) {
            DB::table('orders')->insert([
                'status_id'      => $statusPending,
                'user_id'        => $userIds[array_rand($userIds)],
                'voucher_id'     => null,
                'payment_id'     => null,
                'name'           => 'Khách ' . ($i+1),
                'phoneNumber'    => '090000000' . ($i+1),
                'address'        => '123 Đường ABC, Quận XYZ',
                'email'          => 'khach'.($i+1).'@example.com',
                'total_price'    => 0,
                'discount_amount'=> 0,
                'order_code'     => 'OD' . strtoupper(Str::random(8)),
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);
        }
    }
}
