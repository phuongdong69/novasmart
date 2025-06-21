<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function show()
    {
        if (Auth::check()) {
            $cart = Auth::user()->cart()->with('items.productVariant.product')->first();
        } else {
            $cartItems = Session::get('cart', []);
            $variants = ProductVariant::with('product')->whereIn('id', array_keys($cartItems))->get();

            $items = [];
            foreach ($variants as $variant) {
                $items[] = [
                    'variant' => $variant,
                    'product' => $variant->product,
                    'quantity' => $cartItems[$variant->id]['quantity'],
                    'price' => $cartItems[$variant->id]['price'],
                    'total' => $cartItems[$variant->id]['quantity'] * $cartItems[$variant->id]['price']
                ];
            }

            $cart = [
                'items' => $items,
                'total_price' => array_sum(array_map(fn($i) => $i['total'], $items))
            ];
        }

        return view('user.cart', compact('cart'));
    }

    // Thêm sản phẩm vào giỏ
    public function add(Request $request)
    {
        $productVariantId = $request->input('product_variant_id');
        $quantity = $request->input('quantity', 1);

        $product = ProductVariant::findOrFail($productVariantId);

        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);

            $item = $cart->items()->where('product_variant_id', $productVariantId)->first();
            if ($item) {
                $item->increment('quantity', $quantity);
            } else {
                $cart->items()->create([
                    'product_variant_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price
                ]);
            }

            $this->updateTotalPrice($cart);
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$productVariantId])) {
                $cart[$productVariantId]['quantity'] += $quantity;
            } else {
                $cart[$productVariantId] = [
                    'product_variant_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price
                ];
            }
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.show')->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    // Cập nhật số lượng
    public function updateQuantity(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if (Auth::check()) {
            $item = CartItem::findOrFail($itemId);
            $item->update(['quantity' => $request->quantity]);
            $this->updateTotalPrice($item->cart);
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$itemId])) {
                $cart[$itemId]['quantity'] = $request->quantity;
                Session::put('cart', $cart);
            }
        }

        return redirect()->route('cart.show')->with('success', 'Cập nhật số lượng thành công');
    }

    // Xoá sản phẩm
    public function remove($itemId)
    {
        if (Auth::check()) {
            $item = CartItem::findOrFail($itemId);
            $cart = $item->cart;
            $item->delete();
            $this->updateTotalPrice($cart);
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$itemId])) {
                unset($cart[$itemId]);
                Session::put('cart', $cart);
            }
        }

        return redirect()->route('cart.show')->with('success', 'Xoá sản phẩm thành công');
    }

    // Cập nhật tổng giá trị giỏ hàng trong DB
    protected function updateTotalPrice(Cart $cart)
    {
        $total = $cart->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $cart->update(['total_price' => $total]);
    }
}
