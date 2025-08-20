<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $orderIds   = DB::table('orders')->pluck('id')->all();
        $variantIds = DB::table('product_variants')->pluck('id')->all();

        if (empty($orderIds) || empty($variantIds)) {
            $this->command->warn('⚠️ Cần có orders và product_variants trước.');
            return;
        }

        foreach ($orderIds as $oid) {
            $variantId = $variantIds[array_rand($variantIds)];
            $variant   = DB::table('product_variants')->where('id', $variantId)->first();
            $qty       = rand(1,2);

            DB::table('order_details')->insert([
                'order_id'          => $oid,
                'product_variant_id'=> $variantId,
                'quantity'          => $qty,
                'price'             => $variant->price,
                'created_at'        => $now,
                'updated_at'        => $now,
            ]);

            DB::table('orders')->where('id',$oid)->update([
                'total_price' => $qty * $variant->price,
                'updated_at'  => now(),
            ]);
        }
    }
}
