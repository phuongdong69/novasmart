<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Cart, CartItem, ProductVariant};
use Illuminate\Support\Facades\{Session, Auth};

class CartController extends Controller
{
    public function show()
    {
        if (Auth::check()) {
            $cart = Auth::user()->cart()->with('items.productVariant.product.thumbnails')->first();
        } else {
            $cartItems = Session::get('cart', []);
            $variants = ProductVariant::with('product.thumbnails')->whereIn('id', array_keys($cartItems))->get();

            $items = collect($variants)->map(function ($variant) use ($cartItems) {
                $qty = $cartItems[$variant->id]['quantity'];
                $price = $cartItems[$variant->id]['price'];
                return [
                    'variant' => $variant,
                    'product' => $variant->product,
                    'quantity' => $qty,
                    'price' => $price,
                    'total' => $qty * $price
                ];
            });

            $cart = [
                'items' => $items,
                'total_price' => $items->sum('total')
            ];
        }

        return view('user.pages.shop-card', compact('cart'));
    }

    public function add(Request $request)
    {
        $variantId = $request->input('product_variant_id');
        $quantity = (int) $request->input('quantity', 1);
        $product = ProductVariant::findOrFail($variantId);

        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);
            $item = $cart->items()->firstOrNew(['product_variant_id' => $variantId]);

            $item->quantity += $quantity;
            $item->price = $product->price;
            $item->save();

            $this->updateTotalPrice($cart);
        } else {
            $cart = Session::get('cart', []);
            $cart[$variantId]['product_variant_id'] = $product->id;
            $cart[$variantId]['price'] = $product->price;
            $cart[$variantId]['quantity'] = ($cart[$variantId]['quantity'] ?? 0) + $quantity;
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.show')->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function updateQuantity(Request $request, $itemId)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $qty = (int) $request->quantity;

        if (Auth::check()) {
            $item = CartItem::findOrFail($itemId);
            $item->update(['quantity' => $qty]);
            $this->updateTotalPrice($item->cart);
            $total = number_format($item->quantity * $item->price, 2);
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$itemId])) {
                $cart[$itemId]['quantity'] = $qty;
                Session::put('cart', $cart);
                $total = number_format($qty * $cart[$itemId]['price'], 2);
            } else {
                $total = 0;
            }
        }

        return response()->json(['success' => true, 'item_total' => $total]);
    }

    public function remove($itemId)
    {
        if (Auth::check()) {
            $item = CartItem::findOrFail($itemId);
            $item->delete();
            $this->updateTotalPrice($item->cart);
        } else {
            $cart = Session::get('cart', []);
            unset($cart[$itemId]);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.show')->with('success', 'Xóa sản phẩm thành công');
    }

    protected function updateTotalPrice(Cart $cart)
    {
        $cart->update([
            'total_price' => $cart->items->sum(fn($i) => $i->quantity * $i->price)
        ]);
    }
}
