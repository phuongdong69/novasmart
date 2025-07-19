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
    public function index()
    {
        $cartItems = Auth::check()
            ? optional(Cart::with('items.productVariant.product')->where('user_id', Auth::id())->first())->items ?? collect()
            : collect(session('cart'))->map(function ($item) {
                $variantId = $item['variant_id'] ?? $item['product_variant_id'] ?? $item['id'] ?? null;
                $variant = $variantId ? ProductVariant::with('product')->find($variantId) : null;
                return $variant && $variant->quantity > 0 ? [
                    'variant' => $variant,
                    'quantity' => min($item['quantity'] ?? 1, $variant->quantity),
                ] : null;
            })->filter();

        $total = $cartItems->sum(function ($item) {
            $variant = is_array($item) ? $item['variant'] : $item->productVariant;
            $qty = is_array($item) ? $item['quantity'] : $item->quantity;
            return $variant->price * $qty;
        });

        $voucherData = session('voucher', []);
        $voucher = isset($voucherData['id']) ? Voucher::find($voucherData['id']) : null;
        $discount = $voucher
            ? ($voucher->discount_type === 'percentage'
                ? $total * ($voucher->discount_value / 100)
                : $voucher->discount_value)
            : 0;

        $finalTotal = max(0, $total - $discount); // đảm bảo không âm

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'Giỏ hàng trống! Vui lòng thêm sản phẩm trước khi thanh toán.');
        }

        return view('user.pages.checkout', compact('cartItems', 'total', 'voucher', 'finalTotal'));
    }

    public function store(StoreCheckoutRequest $request)
    {
        $userId = Auth::id();
        $cartItems = Auth::check()
            ? optional(Cart::with('items.productVariant.product')->where('user_id', $userId)->first())->items ?? collect()
            : collect(session('cart'))->map(function ($item) {
                $variantId = $item['variant_id'] ?? $item['product_variant_id'] ?? $item['id'] ?? null;
                $variant = $variantId ? ProductVariant::with('product')->find($variantId) : null;
                return $variant ? ['variant' => $variant, 'quantity' => $item['quantity'] ?? 1] : null;
            })->filter();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Giỏ hàng trống!');
        }

        DB::beginTransaction();
        try {
            // Tính lại total và discount
            $total = $cartItems->sum(function ($item) {
                $variant = is_array($item) ? $item['variant'] : $item->productVariant;
                $qty = is_array($item) ? $item['quantity'] : $item->quantity;
                return $variant->price * $qty;
            });

            $voucherId = $request->input('voucher_id') ?? (session('voucher')['id'] ?? null);
            $voucher = $voucherId ? Voucher::find($voucherId) : null;
            $discount = $voucher
                ? ($voucher->discount_type === 'percentage'
                    ? $total * ($voucher->discount_value / 100)
                    : $voucher->discount_value)
                : 0;

            $finalTotal = max(0, $total - $discount);
            $orderCode = strtoupper(Str::random(10));

            $payment = Payment::create([
                'status' => $request->payment_method === 'vnpay' ? 'unpaid' : 'pending',
                'payment_method' => $request->payment_method,
                'amount' => $finalTotal,
                'note' => $request->note,
            ]);

            // ✅ Lấy status_id từ DB
            $statusConfirm = \App\Models\Status::where('type', 'order')->where('code', 'confirm')->first();
            $statusId = $statusConfirm?->id ?? null;


            $order = Order::create([
                'user_id' => $userId,
                'voucher_id' => $voucherId,
                'payment_id' => $payment->id,
                'name' => $request->name,
                'phoneNumber' => $request->phoneNumber,
                'email' => $request->email,
                'address' => $request->address,
                'total_price' => $finalTotal,
                'order_code' => $orderCode,
                'status_id' => $statusId, // ✅ Gán đúng status_id
            ]);

            foreach ($cartItems as $item) {
                $variant = is_array($item) ? $item['variant'] : $item->productVariant;
                $qty = is_array($item) ? $item['quantity'] : $item->quantity;

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

                $variant->decrement('quantity', $qty);
            }

            if ($voucherId) {
                $voucher->decrement('quantity');
            }

            if ($request->payment_method === 'vnpay') {
                DB::commit();
                return app(PaymentController::class)->vnpayCheckout($request->merge(['order_code' => $orderCode]));
            }

            Auth::check() ? Cart::where('user_id', $userId)->delete() : session()->forget('cart');
            session()->forget('voucher');

            DB::commit();
            return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi đặt hàng: ' . $e->getMessage());
        }
    }


    public function applyVoucher(Request $request)
    {
        $code = $request->input('voucher_code');
        $voucher = Voucher::where('code', $code)->first();

        if (!$voucher || $voucher->quantity <= 0 || $voucher->expiry_date < now()) {
            return back()->with('error', 'Voucher không hợp lệ hoặc đã hết hạn.');
        }

        $cartTotal = Auth::check()
            ? optional(Cart::with('items.productVariant')->where('user_id', Auth::id())->first())->items->sum(fn($i) => $i->productVariant->price * $i->quantity)
            : collect(session('cart', []))->sum(function ($item) {
                $variantId = $item['variant_id'] ?? $item['product_variant_id'] ?? $item['id'] ?? null;
                $variant = $variantId ? ProductVariant::find($variantId) : null;
                return $variant ? $variant->price * $item['quantity'] : 0;
            });

        $discountAmount = $voucher->discount_type === 'percentage'
            ? $cartTotal * ($voucher->discount_value / 100)
            : $voucher->discount_value;

        session()->put('voucher', [
            'id' => $voucher->id,
            'code' => $voucher->code,
            'discount' => $discountAmount,
        ]);

        return redirect()->route('checkout.show')->with('success', 'Voucher áp dụng thành công!');
    }

    public function removeVoucher()
    {
        Session::forget('voucher');
        return back()->with('success', 'Đã xoá mã giảm giá.');
    }
}
