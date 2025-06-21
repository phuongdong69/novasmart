<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function show()
    {
        $user = Auth::user();
        $cart = $user->cart;

        if ($cart) {
            $cart->load('items.productVariant');
        }

        return view('user.cart', compact('cart'));
    }

    // Thêm sản phẩm vào giỏ
    public function add(Request $request)
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        $cart = $user->cart;
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $user->id,
                'total_price' => 0
            ]);
        }

        $item = $cart->items()->where('product_variant_id', $request->product_variant_id)->first();

        $product = ProductVariant::findOrFail($request->product_variant_id);

        if ($item) {
            $item->increment('quantity', $request->quantity);
        } else {
            $cart->items()->create([
                'product_variant_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }

        $this->updateTotalPrice($cart);

        return redirect()->route('cart.show')->with('success', 'Đã thêm sản phẩm vào giỏ hàng');
    }

    // Cập nhật số lượng
    public function updateQuantity(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $item = CartItem::findOrFail($itemId);
        $item->update(['quantity' => $request->quantity]);

        $this->updateTotalPrice($item->cart);

        return back()->with('success', 'Cập nhật số lượng thành công');
    }

    // Xoá sản phẩm
    public function remove($itemId)
    {
        $item = CartItem::findOrFail($itemId);
        $cart = $item->cart;
        $item->delete();

        $this->updateTotalPrice($cart);

        return back()->with('success', 'Xoá sản phẩm thành công');
    }

    // Tính lại tổng giá giỏ hàng
    protected function updateTotalPrice(Cart $cart)
    {
        $total = $cart->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $cart->update(['total_price' => $total]);
    }
}
