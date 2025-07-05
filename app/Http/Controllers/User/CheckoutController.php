<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCheckoutRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\{Order, OrderDetail, ProductVariant, Payment, Voucher, Cart};

class CheckoutController extends Controller
{
    // Hiển thị trang thanh toán
    public function index()
    {
        // Lấy danh sách sản phẩm trong giỏ hàng của người dùng (đăng nhập hoặc session)
        $cartItems = Auth::check()
            ? optional(Cart::with('items.productVariant.product')->where('user_id', Auth::id())->first())->items ?? collect()
            : collect(session('cart'))->map(function ($item) {
                $variantId = $item['variant_id'] ?? $item['product_variant_id'] ?? $item['id'] ?? null;
                $variant = $variantId ? ProductVariant::with('product')->find($variantId) : null;

                // Chỉ lấy những sản phẩm còn tồn kho
                return $variant && $variant->quantity > 0 ? [
                    'variant' => $variant,
                    'quantity' => min($item['quantity'] ?? 1, $variant->quantity),
                ] : null;
            })->filter();

        // Tính tổng tiền hàng
        $total = $cartItems->sum(function ($item) {
            $variant = is_array($item) ? $item['variant'] : $item->productVariant;
            $qty = is_array($item) ? $item['quantity'] : $item->quantity;
            return $variant->price * $qty;
        });

        // Tính giảm giá nếu có voucher
        $voucherData = session('voucher', []);
        $voucher = isset($voucherData['id']) ? Voucher::find($voucherData['id']) : null;
        $discount = $voucher
            ? ($voucher->discount_type === 'percentage'
                ? $total * ($voucher->discount_value / 100)
                : $voucher->discount_value)
            : 0;

        $finalTotal = $total - $discount;

        return view('user.pages.checkout', compact('cartItems', 'total', 'voucher', 'finalTotal'));
    }

    // Xử lý đặt hàng
    public function store(StoreCheckoutRequest $request)
    {
        $userId = Auth::id();

        // Lấy danh sách sản phẩm trong giỏ
        $cartItems = Auth::check()
            ? optional(Cart::with('items.productVariant.product')->where('user_id', $userId)->first())->items ?? collect()
            : collect(session('cart'))->map(function ($item) {
                $variantId = $item['variant_id'] ?? $item['product_variant_id'] ?? $item['id'] ?? null;
                $variant = $variantId ? ProductVariant::with('product')->find($variantId) : null;
                return $variant ? ['variant' => $variant, 'quantity' => $item['quantity'] ?? 1] : null;
            })->filter();

        // Nếu giỏ hàng trống
        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Giỏ hàng trống!');
        }

        DB::beginTransaction();

        try {
            // Lấy thông tin voucher nếu có
            $voucherId = $request->input('voucher_id') ?? (session('voucher')['id'] ?? null);
            $total = $request->input('final_total');

            // Tạo bản ghi thanh toán
            $payment = Payment::create([
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'amount' => $total,
                'note' => $request->note,
            ]);

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => $userId,
                'voucher_id' => $voucherId,
                'payment_id' => $payment->id,
                'name' => $request->name,
                'phoneNumber' => $request->phoneNumber,
                'email' => $request->email,
                'address' => $request->address,
                'total_price' => $total,
                'order_code' => strtoupper(Str::random(10)),
                'status' => 'pending',
            ]);

            // Duyệt qua từng sản phẩm để tạo chi tiết đơn hàng
            foreach ($cartItems as $item) {
                $variant = is_array($item) ? $item['variant'] : $item->productVariant;
                $qty = is_array($item) ? $item['quantity'] : $item->quantity;

                // Nếu vượt quá tồn kho thì huỷ
                if (!$variant || $qty <= 0 || $qty > $variant->quantity) {
                    DB::rollBack();
                    return back()->with('error', 'Số lượng sản phẩm vượt quá tồn kho.');
                }

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $variant->id,
                    'quantity' => $qty,
                    'price' => $variant->price,
                ]);

                // Trừ tồn kho
                $variant->decrement('quantity', $qty);
            }

            // Trừ số lượng voucher nếu có
            if ($voucherId) {
                Voucher::where('id', $voucherId)->decrement('quantity');
            }

            // Xoá giỏ hàng và voucher sau khi đặt hàng thành công
            Auth::check() ? Cart::where('user_id', $userId)->delete() : session()->forget('cart');
            session()->forget('voucher');

            DB::commit();
            return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi đặt hàng: ' . $e->getMessage());
        }
    }

    // Áp dụng mã giảm giá
    public function applyVoucher(Request $request)
    {
        $code = $request->input('voucher_code');
        $voucher = Voucher::where('code', $code)->first();

        // Kiểm tra tính hợp lệ của voucher
        if (!$voucher || $voucher->quantity <= 0 || $voucher->expiry_date < now()) {
            return back()->with('error', 'Voucher không hợp lệ hoặc đã hết hạn.');
        }

        // Tính tổng tiền giỏ hàng
        $cartTotal = Auth::check()
            ? optional(Cart::with('items.productVariant')->where('user_id', Auth::id())->first())->items->sum(fn($i) => $i->productVariant->price * $i->quantity)
            : collect(session('cart', []))->sum(function ($item) {
                $variantId = $item['variant_id'] ?? $item['product_variant_id'] ?? $item['id'] ?? null;
                $variant = $variantId ? ProductVariant::find($variantId) : null;
                return $variant ? $variant->price * $item['quantity'] : 0;
            });

        // Tính số tiền được giảm
        $discountAmount = $voucher->discount_type === 'percentage'
            ? $cartTotal * ($voucher->discount_value / 100)
            : $voucher->discount_value;

        // Lưu voucher vào session
        session()->put('voucher', [
            'id' => $voucher->id,
            'code' => $voucher->code,
            'discount' => $discountAmount,
        ]);

        return redirect()->route('checkout.show')->with('success', 'Voucher áp dụng thành công!');
    }
    // Xoá mã giảm giá voucher trong session
    public function removeVoucher()
    {
        Session::forget('voucher');
        return back()->with('success', 'Đã xoá mã giảm giá.');
    }
}
