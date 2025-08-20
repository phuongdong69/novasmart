<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Cart, CartItem, ProductVariant, Voucher, VoucherUsage};
use Illuminate\Support\Facades\{Auth, Session};

class CartController extends Controller
{
    public function show()
    {
        $cart = $this->getCartWithItems();
        $voucher = session('voucher') ?? [];
        $selectedIds = session('voucher_selected_ids') ?? [];

        $selectedTotal = collect($cart['items'])
            ->filter(fn($i) => in_array($i->variant->id ?? null, $selectedIds))
            ->sum(fn($i) => $i->quantity * $i->price);

        $discount = $this->calculateVoucherDiscount($selectedTotal, $voucher);

        // build dữ liệu theo đúng cấu trúc bạn đang dùng
        $cart['voucher'] = $voucher;
        $cart['voucher_value'] = $discount;
        $cart['final'] = max(0, $cart['total_price'] - $discount);

        // ✅ Chỉ dùng shop-cart
        return view('user.pages.shop-cart', compact('cart'));
    }

    public function remove($itemId)
    {
        // Nếu đăng nhập: itemId có thể là cart_items.id hoặc product_variant_id
        if (Auth::check()) {
            // Tìm theo cart_item_id
            $item = CartItem::find($itemId);

            // Nếu không thấy, tìm theo product_variant_id trong giỏ của user hiện tại
            if (!$item) {
                $item = CartItem::whereHas('cart', fn($q) => $q->where('user_id', Auth::id()))
                    ->where('product_variant_id', $itemId)
                    ->first();
            }

            if (!$item) {
                return back()->with('error', 'Không tìm thấy sản phẩm trong giỏ.');
            }

            $cart = $item->cart; // giữ tham chiếu trước khi xóa
            $variantId = $item->product_variant_id;

            $item->delete();

            // Cập nhật tổng tiền giỏ
            $this->updateTotalPrice($cart->fresh('items'));

            // Nếu sản phẩm này đang nằm trong danh sách áp mã giảm giá thì loại ra
            $selected = session('voucher_selected_ids', []);
            if (in_array($variantId, $selected)) {
                $selected = array_values(array_diff($selected, [$variantId]));
                session(['voucher_selected_ids' => $selected]);
            }

            return back()->with('success', 'Đã xoá sản phẩm khỏi giỏ hàng.');
        }

        // Guest (giỏ lưu session)
        $cart = Session::get('cart', []);
        if (!isset($cart[$itemId])) {
            return back()->with('error', 'Không tìm thấy sản phẩm trong giỏ.');
        }

        unset($cart[$itemId]);
        Session::put('cart', $cart);

        // Nếu sản phẩm này đang nằm trong danh sách áp mã giảm giá thì loại ra
        $selected = session('voucher_selected_ids', []);
        if (in_array((int)$itemId, $selected)) {
            $selected = array_values(array_diff($selected, [(int)$itemId]));
            session(['voucher_selected_ids' => $selected]);
        }

        return back()->with('success', 'Đã xoá sản phẩm khỏi giỏ hàng.');
    }
    public function removeSelected(Request $request)
    {
        // nhận mảng ID hoặc chuỗi "1,2,3"
        $ids = $request->input('selected_ids', []);
        if (!is_array($ids)) {
            $ids = array_filter(array_map('intval', explode(',', $ids)));
        } else {
            $ids = array_map('intval', $ids);
        }

        if (empty($ids)) {
            return back()->with('error', 'Bạn chưa chọn sản phẩm để xoá.');
        }

        if (Auth::check()) {
            // Xoá các item thuộc giỏ của user hiện tại theo product_variant_id
            $cart = Auth::user()->cart()->with('items')->first();
            if (!$cart) {
                return back()->with('error', 'Giỏ hàng không tồn tại.');
            }

            \App\Models\CartItem::where('cart_id', $cart->id)
                ->whereIn('product_variant_id', $ids)
                ->delete();

            // cập nhật tổng tiền
            $cart->load('items');
            $this->updateTotalPrice($cart);
        } else {
            // Guest: giỏ trong session
            $cart = Session::get('cart', []);
            foreach ($ids as $id) {
                unset($cart[$id]);
            }
            Session::put('cart', $cart);
        }

        // Loại các id vừa xoá khỏi danh sách đang áp voucher (nếu có)
        $selected = session('voucher_selected_ids', []);
        if (!empty($selected)) {
            $selected = array_values(array_diff($selected, $ids));
            session(['voucher_selected_ids' => $selected]);
        }

        return back()->with('success', 'Đã xoá các sản phẩm đã chọn khỏi giỏ hàng.');
    }


    public function add(Request $request)
    {
        $variant = ProductVariant::findOrFail($request->product_variant_id);
        $quantity = max((int) $request->input('quantity', 1), 1);

        if ($variant->quantity <= 0) return back()->with('error', 'Sản phẩm đã hết hàng.');

        if (Auth::check()) {
            $cart = Auth::user()->cart()->firstOrCreate(['user_id' => Auth::id()], ['total_price' => 0]);
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

        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    public function updateQuantity(Request $request, $itemId)
    {
        $qty = max((int) $request->input('quantity', 1), 1);

        if (Auth::check()) {
            // Hỗ trợ cả cart_item_id lẫn product_variant_id
            $item = CartItem::find($itemId);
            if (!$item) {
                $item = CartItem::whereHas('cart', fn($q) => $q->where('user_id', Auth::id()))
                    ->where('product_variant_id', $itemId)
                    ->first();
            }

            $variant = $item?->productVariant;
            if (!$item || !$variant) return response()->json(['success' => false, 'message' => 'Không hợp lệ.'], 400);

            $qty = min($qty, $variant->quantity);
            $item->update(['quantity' => $qty]);

            $this->updateTotalPrice($item->cart->fresh('items'));

            // giữ nguyên hành vi: logged-in dùng selected_ids
            $voucher = session('voucher');
            $selected = session('voucher_selected_ids') ?? [];
            $selectedTotal = $item->cart->items->whereIn('product_variant_id', $selected)
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

        // Guest: giữ nguyên hành vi cũ (discount dựa trên tổng giỏ)
        $cart = Session::get('cart', []);
        if (!isset($cart[$itemId])) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm.']);
        }

        $variant = ProductVariant::find($itemId);
        if (!$variant) return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại.']);

        $qty = min($qty, $variant->quantity);
        $cart[$itemId]['quantity'] = $qty;
        Session::put('cart', $cart);

        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
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

    public function checkoutSelected(Request $request)
    {
        $variantIds = is_array($request->selected_ids)
            ? array_map('intval', $request->selected_ids)
            : array_map('intval', explode(',', $request->selected_ids));

        if (empty($variantIds)) return back()->with('error', 'Bạn chưa chọn sản phẩm nào.');

        $items = Auth::check()
            ? Auth::user()->cart->items()->whereIn('product_variant_id', $variantIds)
            ->with('productVariant.product')->get()->map(fn($i) => [
                'variant' => $i->productVariant,
                'quantity' => min($i->quantity, $i->productVariant->quantity)
            ])
            : collect(session('cart', []))->filter(function ($item) use ($variantIds) {
                $id = $item['product_variant_id'] ?? ($item['variant']['id'] ?? null);
                return in_array((int) $id, $variantIds);
            })->map(function ($item) {
                $variant = ProductVariant::with('product')->find($item['product_variant_id'] ?? $item['variant']['id']);
                return $variant ? ['variant' => $variant, 'quantity' => min($item['quantity'], $variant->quantity)] : null;
            })->filter();

        if ($items->isEmpty()) return back()->with('error', 'Không tìm thấy sản phẩm đã chọn.');

        session()->put('checkout.selected_ids', $variantIds);
        return redirect()->route('checkout.show');
    }

    public function applyVoucher(Request $request)
    {
        $voucherCode = $request->voucher_code;
        $items = $request->input('items', []);

        $voucher = Voucher::with('status')
            ->where('code', $voucherCode)
            ->whereDate('expired_at', '>=', now())
            ->where('quantity', '>', 0)
            ->whereHas('status', fn($q) => $q->where('code', 'active'))
            ->first();

        if (!$voucher) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Mã giảm giá không tồn tại hoặc đã hết hạn.']);
            }
            return back()->with('error', 'Mã giảm giá không tồn tại hoặc đã hết hạn.');
        }

        if (empty($items)) {
            $selectedIdsRaw = $request->input('selected_ids', '');
            $selectedIds = array_filter(array_map('intval', explode(',', $selectedIdsRaw)));
            $items = array_map(fn($id) => ['id' => $id, 'quantity' => 1], $selectedIds);
        }

        if (empty($items)) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Bạn chưa chọn sản phẩm để áp mã.']);
            }
            return back()->with('error', 'Bạn chưa chọn sản phẩm để áp mã.');
        }

        if (Auth::check() && VoucherUsage::where('voucher_id', $voucher->id)->where('user_id', Auth::id())->exists()) {
            $msg = 'Bạn đã sử dụng mã này trước đó. Không thể dùng lại.';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $msg]);
            }
            return back()->with('error', $msg);
        }

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

        if ($total <= 0) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Tổng tiền sản phẩm không hợp lệ.']);
            }
            return back()->with('error', 'Tổng tiền sản phẩm không hợp lệ.');
        }

        $discount = $this->calculateVoucherDiscount($total, [
            'type' => $voucher->discount_type,
            'discount_value' => $voucher->discount_value
        ]);

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

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'discount_value' => '-' . number_format($discount, 0, ',', '.') . '₫',
                'final_total' => max($total - $discount, 0),
            ]);
        }

        return back()->with('success', 'Áp dụng mã giảm giá thành công.');
    }

    public function removeVoucher()
    {
        session()->forget(['voucher', 'voucher_selected_ids']);
        return back();
    }

    private function calculateVoucherDiscount($total, $voucher)
    {
        if (!is_array($voucher) || !isset($voucher['type'], $voucher['discount_value'])) return 0;

        $type = strtolower((string) $voucher['type']);
        $value = (float) $voucher['discount_value'];

        $discount = ($type === 'percent' || $type === 'percentage')
            ? round($total * ($value / 100))
            : $value;

        return (int) min($discount, $total);
    }

    private function updateTotalPrice(Cart $cart)
    {
        $cart->update(['total_price' => $cart->items->sum(fn($i) => $i->quantity * $i->price)]);
    }

    private function getCartWithItems()
    {
        if (Auth::check()) {
            $cart = Auth::user()->cart()->with('items.productVariant.product.thumbnails')->first();
            if (!$cart) return ['items' => collect(), 'total_price' => 0];

            $items = $cart->items->map(fn($i) => (object) [
                'variant' => $i->productVariant,
                'quantity' => $i->quantity,
                'price' => $i->price,
                'total' => $i->price * $i->quantity,
            ]);

            return ['items' => $items, 'total_price' => $items->sum('total')];
        }

        $sessionCart = Session::get('cart', []);
        if (!$sessionCart) return ['items' => collect(), 'total_price' => 0];

        // ✅ sửa typo: sessionCarta -> sessionCart
        $variants = ProductVariant::with('product.thumbnails')
            ->whereIn('id', array_keys($sessionCart))
            ->get()->keyBy('id');

        $items = collect($sessionCart)->map(function ($row, $id) use ($variants) {
            $v = $variants->get((int) $id);
            if (!$v) return null;
            $qty = (int) $row['quantity'];
            $price = (int) $row['price'];
            return (object) [
                'variant' => $v,
                'quantity' => $qty,
                'price' => $price,
                'total' => $price * $qty,
            ];
        })->filter();

        return ['items' => $items, 'total_price' => $items->sum('total')];
    }
}
