<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $statusInStock = DB::table('statuses')
            ->where('type','product_variant')->where('code','in_stock')->value('id') ?: 1;

        $productIds = DB::table('products')->pluck('id')->all();
        if (empty($productIds)) {
            $this->command->warn('⚠️ Chưa có products. Hãy chạy ProductSeeder trước.');
            return;
        }

        foreach ($productIds as $pid) {
            $variants = [
                ['price'=> 15990000, 'quantity'=> 50],
                ['price'=> 20990000, 'quantity'=> 30],
                ['price'=> 25990000, 'quantity'=> 20],
            ];

            foreach ($variants as $index => $v) {
                DB::table('product_variants')->insert([
                    'status_id'  => $statusInStock,
                    'product_id' => $pid,
                    // 👇 Thêm SKU bắt buộc
                    'sku'        => 'SKU-'.$pid.'-'.str_pad($index+1, 3, '0', STR_PAD_LEFT).'-'.strtoupper(Str::random(4)),
                    'price'      => $v['price'],
                    'quantity'   => $v['quantity'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
