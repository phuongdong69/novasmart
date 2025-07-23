<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Cart, CartItem, ProductVariant, Voucher};
use Illuminate\Support\Facades\{Auth, Session, Log};

class CartController extends Controller
{
    // Hiển thị giỏ hàng và tính toán giá cuối cùng kèm voucher nếu có
    public function show()
    {
        $cart = $this->getCartWithItems();
        $voucher = session('voucher') ?? [];
        $selectedIds = session('voucher_selected_ids') ?? [];

        $selectedTotal = collect($cart['items'])
            ->filter(fn($i) => in_array($i->variant->id ?? null, $selectedIds))
            ->sum(fn($i) => $i->quantity * $i->price);

        $discount = $this->calculateVoucherDiscount($selectedTotal, $voucher);

        $cart['voucher'] = $voucher;
        $cart['voucher_value'] = $discount;
        $cart['final'] = max(0, $cart['total_price'] - $discount);

        return view('user.pages.shop-card', compact('cart'));
    }

    // Thêm sản phẩm vào giỏ hàng (đăng nhập hoặc không đăng nhập)
    public function add(Request $request)
    {
        $variant = ProductVariant::findOrFail($request->product_variant_id);
        $quantity = max((int) $request->input('quantity', 1), 1);

        if ($variant->quantity <= 0) return back()->with('error', 'Sản phẩm đã hết hàng.');

        if (Auth::check()) {
            $cart = Auth::user()->cart()->firstOrCreate(
                ['user_id' => Auth::id()],
                ['total_price' => 0]
            );
            $item = $cart->items()->firstOrNew(['product_variant_id' => $variant->id]);
            $newQty = ($item->quantity ?? 0) + $quantity;

            if ($newQty > $variant->quantity) return back()->with('error', 'Vượt quá tồn kho.');

            $item->fill(['quantity' => $newQty, 'price' => $variant->price])->save();
            $this->updateTotalPrice($cart);
        } else {
            $cart = Session::get('cart', []);
            $id = $variant->id;
            $newQty = ($cart[$id]['quantity'] ?? 0) + $quantity;

            if ($newQty > $variant->quantity) return back()->with('error', 'Vượt quá tồn kho.');

            $cart[$id] = ['product_variant_id' => $id, 'price' => $variant->price, 'quantity' => $newQty];
            Session::put('cart', $cart);
        }

        return back()->with('success', 'Đã thêm sản phẩm vào giỏ.');
    }

    
    public function updateQuantity(Request $request, $itemId)
    {
        $qty = max((int) $request->input('quantity', 1), 1);

        if (Auth::check()) {
            $item = CartItem::find($itemId);
            if (!$item || !$item->productVariant || $qty > $item->productVariant->quantity)
                return response()->json(['success' => false, 'message' => 'Không hợp lệ.'], 400);

            $item->quantity = $qty;
            $item->save();
            $this->updateTotalPrice($item->cart);

            $voucher = session('voucher');
            $selected = session('voucher_selected_ids') ?? [];
            $selectedTotal = $item->cart->items->filter(fn($i) => in_array($i->product_variant_id, $selected))
                ->sum(fn($i) => $i->quantity * $i->price);
            $discount = $this->calculateVoucherDiscount($selectedTotal, $voucher);
            $final = max($item->cart->total_price - $discount, 0);

            return response()->json([
                'success' => true,
                'item_total' => number_format($qty * $item->price, 0, ',', '.') . '₫',
                'cart_total' => number_format($item->cart->total_price, 0, ',', '.') . '₫',
                'discount_value' => number_format($discount, 0, ',', '.') . '₫',
                'final_total' => number_format($final, 0, ',', '.') . '₫'
            ]);
        }

        $cart = Session::get('cart', []);
        if (!isset($cart[$itemId])) return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm.']);

        $variant = ProductVariant::find($itemId);
        if (!$variant || $qty > $variant->quantity) return response()->json(['success' => false, 'message' => 'Vượt quá tồn kho.']);

        $cart[$itemId]['quantity'] = $qty;
        Session::put('cart', $cart);

        $total = collect($cart)->reduce(fn($sum, $i) => $sum + $i['price'] * $i['quantity'], 0);
        $discount = $this->calculateVoucherDiscount($total, session('voucher'));
        $final = max($total - $discount, 0);

        return response()->json([
            'success' => true,
            'item_total' => number_format($qty * $cart[$itemId]['price'], 0, ',', '.') . '₫',
            'cart_total' => number_format($total, 0, ',', '.') . '₫',
            'discount_value' => number_format($discount, 0, ',', '.') . '₫',
            'final_total' => number_format($final, 0, ',', '.') . '₫'
        ]);
    }
    // Chọn sản phẩm để thanh toán
    public function checkoutSelected(Request $request)
    {
        $raw = $request->input('selected_ids');

        $variantIds = is_array($raw)
            ? array_map('intval', array_filter($raw))
            : array_map('intval', array_filter(explode(',', $raw)));

        if (empty($variantIds)) {
            return back()->with('error', 'Bạn chưa chọn sản phẩm nào.');
        }

        $items = collect();

        if (Auth::check()) {
            $rawItems = Auth::user()->cart->items()
                ->whereIn('product_variant_id', $variantIds)
                ->with('productVariant.product')
                ->get();

            $items = $rawItems->map(function ($item) {
                return [
                    'variant'  => $item->productVariant,
                    'quantity' => min($item->quantity, $item->productVariant->quantity),
                ];
            });
        } else {
            $sessionCart = session('cart', []);
            $items = collect($sessionCart)->filter(function ($item) use ($variantIds) {
                $variantId = $item['product_variant_id'] ?? ($item['variant']['id'] ?? null);
                return in_array((int)$variantId, $variantIds);
            })->map(function ($item) {
                $variantId = $item['product_variant_id'] ?? ($item['variant']['id'] ?? null);
                $variant = ProductVariant::with('product')->find($variantId);
                if (!$variant) return null;
                return [
                    'variant' => $variant,
                    'quantity' => min($item['quantity'] ?? 1, $variant->quantity),
                ];
            })->filter();
        }

        if ($items->isEmpty()) {
            return back()->with('error', 'Không tìm thấy sản phẩm đã chọn.');
        }

        session()->put('checkout.selected_ids', $variantIds);

        return redirect()->route('checkout.show');
    }
    // Xóa một sản phẩm khỏi giỏ
    public function remove($itemId)
    {
        if (Auth::check()) {
            CartItem::findOrFail($itemId)->delete();
            $this->updateTotalPrice(Auth::user()->cart);
        } else {
            $cart = Session::get('cart', []);
            unset($cart[$itemId]);
            Session::put('cart', $cart);
        }

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ.');
    }
    // Xóa nhiều sản phẩm đã chọn khỏi giỏ
    public function removeSelected(Request $request)
    {
        $ids = array_filter(explode(',', $request->selected_ids)); // Danh sách variant_id cần xóa

        if (empty($ids)) {
            return back()->with('error', 'Không có sản phẩm nào được chọn để xóa.');
        }

        if (Auth::check()) {
            $cart = Auth::user()->cart;
            if ($cart) {
                CartItem::where('cart_id', $cart->id)
                    ->whereIn('product_variant_id', $ids)
                    ->delete();

                $this->updateTotalPrice($cart);
            }
        } else {
            $cart = Session::get('cart', []);
            foreach ($cart as $key => $item) {
                $variantId = $item['product_variant_id'] ?? $key;
                if (in_array($variantId, $ids)) {
                    unset($cart[$key]);
                }
            }
            Session::put('cart', $cart);
        }

        return back()->with('success', 'Đã xóa các sản phẩm đã chọn.');
    }

    // Áp dụng mã giảm giá vào sản phẩm đã chọn
    public function applyVoucher(Request $request)
    {
        $voucherCode = $request->voucher_code;
        $items = $request->input('items', []);

        $voucher = Voucher::where('code', $voucherCode)
            ->whereDate('expiry_date', '>=', now())
            ->where('quantity', '>', 0)->first();

        if (!$voucher || empty($items)) return response()->json(['success' => false, 'message' => 'Mã hoặc sản phẩm không hợp lệ.']);

        $total = 0;
        $selectedIds = [];

        foreach ($items as $item) {
            $id = (int) ($item['id'] ?? 0);
            $qty = max(1, (int) ($item['quantity'] ?? 1));

            if (!$id) continue;

            if (Auth::check()) {
                $cartItem = CartItem::whereHas('cart', fn($q) => $q->where('user_id', Auth::id()))
                    ->where('product_variant_id', $id)->first();
                if ($cartItem) {
                    $total += $cartItem->price * $qty;
                    $selectedIds[] = $id;
                }
            } else {
                $cart = session('cart', []);
                if (isset($cart[$id])) {
                    $total += $cart[$id]['price'] * $qty;
                    $selectedIds[] = $id;
                }
            }
        }

        if ($total <= 0) return response()->json(['success' => false, 'message' => 'Tổng không hợp lệ.']);

        $discount = $this->calculateVoucherDiscount($total, ['type' => $voucher->discount_type, 'discount_value' => $voucher->discount_value]);

        session([
            'voucher' => [
                'code' => $voucher->code,
                'discount' => $discount,
                'type' => $voucher->discount_type,
                'discount_value' => $voucher->discount_value,
                'id' => $voucher->id
            ],
            'voucher_selected_ids' => $selectedIds
        ]);

        return response()->json(['success' => true, 'discount' => number_format($discount, 0, ',', '.') . '₫']);
    }
    // Cập nhật lại mã giảm giá sau khi thay đổi số lượng
    public function updateVoucher(Request $request)
    {
        $items = $request->input('items', []);
        $voucher = session('voucher');

        if (!$voucher || empty($items)) return response()->json(['success' => false, 'message' => 'Thiếu mã hoặc sản phẩm.']);

        $total = 0;
        if (Auth::check()) {
            $cartItems = Auth::user()->cart->items()->whereIn('product_variant_id', array_column($items, 'id'))->get()->keyBy('product_variant_id');
            foreach ($items as $item) if (isset($cartItems[$item['id']])) $total += $cartItems[$item['id']]->price * max(1, $item['quantity']);
        } else {
            $cart = session('cart', []);
            foreach ($items as $item) if (isset($cart[$item['id']])) $total += $cart[$item['id']]['price'] * max(1, $item['quantity']);
        }

        $discount = $this->calculateVoucherDiscount($total, $voucher);
        $final = max($total - $discount, 0);

        return response()->json([
            'success' => true,
            'discount_value' => number_format($discount, 0, ',', '.') . '₫',
            'discount_raw' => $discount,
            'final_total' => $final,
            'final_total_formatted' => number_format($final, 0, ',', '.') . '₫'
        ]);
    }
    // Xóa mã giảm giá khỏi session
    public function removeVoucher(Request $request)
    {
        session()->forget(['voucher', 'voucher_selected_ids']);
        return $request->expectsJson() ? response()->json(['success' => true]) : redirect()->back();
    }
    // Tính giá trị giảm giá dựa trên loại voucher (percent hoặc số tiền cố định)
    private function calculateVoucherDiscount($total, $voucher)
    {
        if (!is_array($voucher) || !isset($voucher['type'], $voucher['discount_value'])) return 0;

        $total = is_numeric($total) ? (float) $total : 0;
        $discount = 0;

        if (in_array($voucher['type'], ['percent', 'percentage'])) {
            $discount = round($total * floatval($voucher['discount_value']) / 100);
        } else {
            $discount = floatval($voucher['discount_value']);
        }

        return min($discount, $total);
    }
     // Cập nhật tổng tiền cho giỏ hàng
    private function updateTotalPrice(Cart $cart)
    {
        $cart->update(['total_price' => $cart->items->sum(fn($i) => $i->quantity * $i->price)]);
    }
    // Lấy item từ session dựa vào variant_id
    protected function getSessionItemsByVariantIds(array $variantIds)
    {
        $cart = session('cart', []);

        $filtered = [];

        foreach ($cart as $item) {
            if (isset($item['product_variant_id']) && in_array($item['product_variant_id'], $variantIds)) {
                $variant = ProductVariant::with('product.thumbnails')->find($item['product_variant_id']);
                if ($variant) {
                    $filtered[] = (object)[
                        'productVariant' => $variant,
                        'product' => $variant->product,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ];
                }
            }
        }

        return collect($filtered);
    }
    // Lấy dữ liệu giỏ hàng từ DB hoặc session (tuỳ trạng thái đăng nhập)
    private function getCartWithItems()
    {
        if (Auth::check()) {
            $cart = Auth::user()->cart()->with('items.productVariant.product.thumbnails')->first();
            return [
                'items' => $cart?->items ?? collect(),
                'total_price' => $cart?->items->sum(fn($i) => $i->quantity * $i->price) ?? 0
            ];
        }

        $sessionCart = Session::get('cart', []);
        if (!$sessionCart) return ['items' => collect(), 'total_price' => 0];

        $variants = ProductVariant::with('product.thumbnails')->whereIn('id', array_keys($sessionCart))->get();
        $items = $variants->map(function ($v) use ($sessionCart) {
            return (object) [
                'variant' => $v,
                'product' => $v->product,
                'quantity' => $sessionCart[$v->id]['quantity'],
                'price' => $sessionCart[$v->id]['price'],
                'total' => $sessionCart[$v->id]['price'] * $sessionCart[$v->id]['quantity']
            ];
        });

        return ['items' => $items, 'total_price' => $items->sum('total')];
    }
}
