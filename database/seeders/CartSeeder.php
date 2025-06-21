<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use App\Models\ProductVariant;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy 1 user ngẫu nhiên (bạn có thể fix ID nếu muốn)
        $user = User::inRandomOrder()->first();

        if (!$user) {
            $this->command->warn('Không có user nào trong CSDL.');
            return;
        }

        // Tạo cart cho user đó
        $cart = Cart::create([
            'user_id' => $user->id,
            'total_price' => 0,
        ]);

        // Lấy một số sản phẩm ngẫu nhiên
        $products = ProductVariant::inRandomOrder()->take(3)->get();

        $total = 0;

        foreach ($products as $product) {
            $quantity = rand(1, 3);
            $price = $product->price;

            CartItem::create([
                'cart_id' => $cart->id,
                'product_variant_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
            ]);

            $total += $quantity * $price;
        }

        // Cập nhật lại tổng giá cho cart
        $cart->update(['total_price' => $total]);

        $this->command->info("Đã tạo giỏ hàng mẫu cho user ID: {$user->id}");
    }
}
