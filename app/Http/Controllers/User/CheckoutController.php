<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCheckoutRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\{
    Order,
    OrderDetail,
    ProductVariant,
    Payment,
    Voucher,
    Cart,
    Status,
    VoucherUsage
};

class CheckoutController extends Controller
{
    public function index()
    {
        $selectedItems = $this->getSelectedItems();
        $total = $selectedItems->sum(fn($item) => $item['variant']->price * $item['quantity']);

        $voucherData = session('voucher', []);
        $voucher = isset($voucherData['id']) ? Voucher::find($voucherData['id']) : null;

        $discount = $voucher
            ? ($voucher->discount_type === 'percent'
                ? round($total * ($voucher->discount_value / 100))
                : min($voucher->discount_value, $total))
            : 0;

        $finalTotal = max(0, $total - $discount);

        $user = Auth::user();
        $prefill = [
            'name'        => $user->name        ?? '',
            'email'       => $user->email       ?? '',
            'phoneNumber' => $user->phoneNumber ?? '',
            'address'     => $user->address     ?? '',
        ];

        return view('user.pages.checkout', [
            'cartItems'  => $selectedItems,
            'total'      => $total,
            'voucher'    => $voucher,
            'discount'   => $discount,
            'finalTotal' => $finalTotal,
            'prefill'    => $prefill,
        ]);
    }

    public function store(StoreCheckoutRequest $request)
    {
        $selectedItems = $this->getSelectedItems();
        if ($selectedItems->isEmpty()) {
            return back()->with('error', 'Không có sản phẩm hợp lệ để đặt hàng.');
        }

        $groupedItems = $selectedItems->groupBy(fn($item) => $item['variant']->id)
            ->map(function ($items) {
                $first = $items->first();
                return [
                    'product_variant_id' => $first['variant']->id,
                    'quantity'           => $items->sum('quantity'),
                    'price'              => $first['variant']->price,
                ];
            })->values()->all();

        $variantIds = collect($groupedItems)->pluck('product_variant_id')->all();
        $amount     = collect($groupedItems)->sum(fn($item) => $item['price'] * $item['quantity']);
        $orderCode  = strtoupper(Str::random(10));
        $voucherId  = $request->input('voucher_id') ?? (session('voucher')['id'] ?? null);

        // ✅ Nếu có voucher thì yêu cầu đăng nhập để gắn voucher theo user
        if ($voucherId && !Auth::check()) {
            return back()->with('error', 'Bạn cần đăng nhập để sử dụng mã giảm giá.');
        }

        // ✅ Giới hạn: mỗi user chỉ dùng 1 lần / 1 mã (chỉ khi đã đăng nhập và có voucher)
        if ($voucherId && Auth::check()) {
            $alreadyUsed = VoucherUsage::where('voucher_id', $voucherId)
                ->where('user_id', Auth::id())
                ->exists();

            if ($alreadyUsed) {
                return back()->with('error', 'Bạn đã sử dụng mã giảm giá này trước đó. Mỗi tài khoản chỉ được dùng 1 lần.');
            }
        }

        // Tính giảm giá
        $discount = 0;
        if ($voucherId && ($voucher = Voucher::find($voucherId))) {
            $discount = $voucher->discount_type === 'percent'
                ? round($amount * ($voucher->discount_value / 100))
                : min($voucher->discount_value, $amount);
        }

        $finalTotal = max(0, $amount - $discount);

        DB::beginTransaction();
        try {
            $payment = Payment::create([
                'status_id'      => Status::where('code', 'unpaid')->first()->id,
                'payment_method' => 'cod',
                'amount'         => $finalTotal,
                'note'           => $request->note,
            ]);

            $order = Order::create([
                'user_id'         => Auth::id(), // có thể null nếu guest (khi không dùng voucher)
                'voucher_id'      => $voucherId,
                'discount_amount' => $discount,
                'payment_id'      => $payment->id,
                'status_id'       => Status::where('code', 'pending')->first()->id,
                'name'            => $request->name,
                'email'           => $request->email,
                'phoneNumber'     => $request->phoneNumber,
                'address'         => $request->address,
                'note'            => $request->note,
                'order_code'      => $orderCode,
                'total_price'     => $finalTotal,
            ]);

            // Tạo chi tiết đơn + trừ tồn
            foreach ($groupedItems as $item) {
                OrderDetail::create([
                    'order_id'           => $order->id,
                    'product_variant_id' => $item['product_variant_id'],
                    'quantity'           => $item['quantity'],
                    'price'              => $item['price'],
                ]);

                ProductVariant::find($item['product_variant_id'])
                    ?->decrement('quantity', $item['quantity']);
            }

            // ✅ Nếu có voucher: trừ số lượng & lưu usage (chỉ khi user đăng nhập)
            if ($voucherId) {
                Voucher::where('id', $voucherId)->decrement('quantity');

                if (Auth::check()) {
                    VoucherUsage::create([
                        'voucher_id' => $voucherId,
                        'user_id'    => Auth::id(),
                        'used_at'    => now(),
                    ]);
                }
            }

            // Xoá item đã mua khỏi giỏ
            $this->clearPurchasedItemsFromCart($variantIds);

            // Email xác nhận

            $subTotal = collect($groupedItems)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            // Tính số tiền được giảm
            $discountAmount = max(0, $subTotal - $finalTotal);

            // Nội dung email
            $body  = "Cảm ơn bạn đã đặt hàng tại Nova Smart!\n\n";
            $body .= "🧾 Mã đơn hàng: {$order->order_code}\n";
            $body .= "👤 Tên khách hàng: {$order->name}\n";
            $body .= "📧 Email: {$order->email}\n";
            $body .= "📞 Số điện thoại: {$order->phoneNumber}\n";
            $body .= "🏠 Địa chỉ: {$order->address}\n";
            $body .= "💵 Tạm tính: " . number_format($subTotal, 0, ',', '.') . "₫\n";

            // Nếu có voucher
            if (!empty($order->voucher)) {
                $body .= "🎁 Mã giảm giá: {$order->voucher->code}\n";
            }

            // Nếu có số tiền giảm
            if ($discountAmount > 0) {
                $body .= "🔻 Số tiền được giảm: -" . number_format($discountAmount, 0, ',', '.') . "₫\n";
            }

            // Tổng tiền cuối
            $body .= "✅ Tổng tiền (sau giảm): " . number_format($finalTotal, 0, ',', '.') . "₫\n\n";

            // Danh sách sản phẩm
            $body .= "🔹 Sản phẩm:\n";
            foreach ($groupedItems as $item) {
                $variant = ProductVariant::find($item['product_variant_id']);
                if ($variant) {
                    $variantName = $variant->name ?: 'Không có phân loại';
                    $body .= "- {$variant->product->name} ({$variantName}) × {$item['quantity']} = "
                        . number_format($item['quantity'] * $item['price'], 0, ',', '.') . "₫\n";
                }
            }

            // Footer
            $body .= "\nChúng tôi sẽ sớm xử lý đơn hàng của bạn.\n\nTrân trọng,\nNova Smart";

            // Gửi email
            Mail::raw($body, function ($message) use ($order) {
                $message->to($order->email, $order->name)
                    ->subject('Thông báo đặt hàng thành công - Nova Smart');
            });



            session()->flash('purchased_variant_ids', $variantIds);
            session()->forget(['checkout.selected_ids', 'voucher', 'buy_now']);

            DB::commit();
            return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Lỗi khi lưu đơn hàng: ' . $e->getMessage());
            return back()->with('error', 'Đặt hàng thất bại: ' . $e->getMessage());
        }
    }

    public function success()
    {
        $variantIdsToRemove = session()->get('purchased_variant_ids', []);
        if (!empty($variantIdsToRemove)) {
            $this->clearPurchasedItemsFromCart($variantIdsToRemove);
        }
        return view('checkout.success');
    }

    private function getSelectedItems()
    {
        // Kiểm tra xem có phải là mua ngay không
        $buyNowData = session('buy_now');
        if ($buyNowData) {
            $variant = ProductVariant::with('product')->find($buyNowData['product_variant_id']);
            if (!$variant) {
                return collect();
            }
            return collect([
                [
                    'variant'  => $variant,
                    'quantity' => min($buyNowData['quantity'], $variant->quantity),
                ]
            ]);
        }

        $variantIds = session('checkout.selected_ids', []);
        if (empty($variantIds)) {
            return collect();
        }

        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart;
            if (!$cart) {
                return collect();
            }

            $items = $cart->items()
                ->whereIn('product_variant_id', $variantIds)
                ->with('productVariant.product')
                ->get();

            return $items->map(function ($item) {
                $variant = $item->productVariant;
                if (!$variant) return null;
                return [
                    'variant'  => $variant,
                    'quantity' => min($item->quantity, $variant->quantity),
                ];
            })->filter()->values();
        }

        $cart = session('cart', []);
        $filtered = collect($cart)->filter(function ($item) use ($variantIds) {
            $variantId = $item['product_variant_id'] ?? ($item['variant']['id'] ?? null);
            return in_array((int) $variantId, $variantIds);
        });

        return $filtered->map(function ($item) {
            $variantId = $item['product_variant_id'] ?? ($item['variant']['id'] ?? null);
            $variant = ProductVariant::with('product')->find($variantId);
            if (!$variant) return null;
            return [
                'variant'  => $variant,
                'quantity' => min($item['quantity'] ?? 1, $variant->quantity),
            ];
        })->filter()->values();
    }

    private function clearPurchasedItemsFromCart(array $variantIdsToRemove): void
    {
        // Nếu là buy_now thì không cần xóa khỏi giỏ hàng
        if (session('buy_now')) {
            return;
        }

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                $cart->items()->whereIn('product_variant_id', $variantIdsToRemove)->delete();
            }
        } else {
            $cart = session('cart', []);
            $updatedCart = [];
            foreach ($cart as $key => $item) {
                $variantId = $item['product_variant_id'] ?? ($item['variant']['id'] ?? null);
                if (!in_array((int) $variantId, $variantIdsToRemove)) {
                    $updatedCart[$variantId] = $item;
                }
            }
            session()->put('cart', $updatedCart);
        }
    }
}
