<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Cart, CartItem, ProductVariant};
use Illuminate\Support\Facades\{Session, Auth};

class CartController extends Controller
{
    // Hiển thị trang giỏ hàng với các sản phẩm hiện có
    public function show()
    {
        $cart = $this->getCartWithItems();
        return view('user.pages.shop-cart', compact('cart'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function add(Request $request)
    {
        $variantId = $request->input('product_variant_id');
        $quantity = (int) $request->input('quantity', 1);
        $variant = ProductVariant::findOrFail($variantId);

        // Nếu sản phẩm hết hàng
        if ($variant->quantity <= 0) {
            return back()->with('error', 'Sản phẩm đã hết hàng.');
        }

        if (Auth::check()) {
            // Giỏ hàng của người dùng đăng nhập
            $cart = Auth::user()->cart()->firstOrCreate(['user_id' => Auth::id()]);
            $item = $cart->items()->firstOrNew(['product_variant_id' => $variantId]);
            $currentQty = $item->quantity ?? 0;

            // Kiểm tra vượt quá tồn kho
            if ($currentQty + $quantity > $variant->quantity) {
                return back()->with('error', 'Số lượng sản phẩm vượt quá tồn kho.');
            }

            // Cập nhật thông tin giỏ hàng
            $item->fill([
                'quantity' => $currentQty + $quantity,
                'price' => $variant->price,
            ])->save();

            $this->updateTotalPrice($cart);
        } else {
            // Giỏ hàng lưu trong session cho người chưa đăng nhập
            $cart = Session::get('cart', []);
            $currentQty = $cart[$variantId]['quantity'] ?? 0;

            if ($currentQty + $quantity > $variant->quantity) {
                return back()->with('error', 'Số lượng sản phẩm vượt quá tồn kho.');
            }

            $cart[$variantId] = [
                'product_variant_id' => $variant->id,
                'price' => $variant->price,
                'quantity' => $currentQty + $quantity,
            ];
            Session::put('cart', $cart);
        }

        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    // Cập nhật số lượng sản phẩm trong giỏ
    public function updateQuantity(Request $request, $itemId)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $qty = (int) $request->quantity;

        if (Auth::check()) {
            $item = CartItem::findOrFail($itemId);
            $variant = $item->productVariant;

            // Kiểm tra vượt quá tồn kho
            if ($qty > $variant->quantity) {
                return response()->json(['success' => false, 'message' => 'Số lượng vượt quá tồn kho.'], 400);
            }

            $item->update(['quantity' => $qty]);
            $this->updateTotalPrice($item->cart);
            $total = number_format($qty * $item->price, 2);
        } else {
            $cart = Session::get('cart', []);

            // Không tìm thấy sản phẩm trong session
            if (!isset($cart[$itemId])) {
                return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại.'], 404);
            }

            $variant = ProductVariant::find($itemId);
            if (!$variant || $qty > $variant->quantity) {
                return response()->json(['success' => false, 'message' => 'Số lượng vượt quá tồn kho.'], 400);
            }

            $cart[$itemId]['quantity'] = $qty;
            Session::put('cart', $cart);
            $total = number_format($qty * $cart[$itemId]['price'], 2);
        }

        return response()->json(['success' => true, 'item_total' => $total]);
    }

    // Xoá sản phẩm khỏi giỏ hàng
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

        return redirect()->route('cart.show')->with('success', 'Đã xóa sản phẩm khỏi giỏ.');
    }

    // Cập nhật tổng tiền giỏ hàng
    public function updateTotalPrice(Cart $cart)
    {
        $cart->update([
            'total_price' => $cart->items->sum(fn($item) => $item->quantity * $item->price)
        ]);
    }

    // Tính tổng tiền giỏ hàng (dùng cho hiển thị nhanh hoặc API)
    public function getCartTotal()
    {
        if (Auth::check()) {
            return Auth::user()->cart->items->sum(fn($item) => $item->quantity * $item->productVariant->price);
        }

        $sessionCart = Session::get('cart', []);
        return array_reduce($sessionCart, fn($sum, $item) => $sum + $item['price'] * $item['quantity'], 0);
    }

    // Xoá mã giảm giá voucher trong session
    public function removeVoucher()
    {
        Session::forget('voucher');
        return back()->with('success', 'Đã xoá mã giảm giá.');
    }

    // Lấy dữ liệu giỏ hàng kèm thông tin sản phẩm
    public function getCartWithItems()
    {
        if (Auth::check()) {
            return Auth::user()->cart()->with('items.productVariant.product.thumbnails')->first();
        }

        $cartItems = Session::get('cart', []);
        $variants = ProductVariant::with('product.thumbnails')->whereIn('id', array_keys($cartItems))->get();

        $items = $variants->map(function ($variant) use ($cartItems) {
            $qty = $cartItems[$variant->id]['quantity'];
            $price = $cartItems[$variant->id]['price'];
            return [
                'variant' => $variant,
                'product' => $variant->product,
                'quantity' => $qty,
                'price' => $price,
                'total' => $qty * $price,
            ];
        });

        return [
            'items' => $items,
            'total_price' => $items->sum('total'),
        ];
    }
}
