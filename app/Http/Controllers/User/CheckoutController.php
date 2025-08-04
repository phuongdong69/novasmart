<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCheckoutRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\{Order, OrderDetail, ProductVariant, Payment, Voucher, Cart, Status};
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    // Trang hiển thị thông tin thanh toán (checkout)
    public function index()
    {
        $selectedItems = $this->getSelectedItems();

        // Tổng tiền sản phẩm đã chọn
        $total = $selectedItems->sum(fn($item) => $item['variant']->price * $item['quantity']);

        // Lấy voucher từ session nếu có
        $voucherData = session('voucher', []);
        $voucher = isset($voucherData['id']) ? Voucher::find($voucherData['id']) : null;

        // Tính giảm giá từ voucher
        $discount = $voucher
            ? ($voucher->discount_type === 'percent'
                ? round($total * ($voucher->discount_value / 100))
                : min($voucher->discount_value, $total))
            : 0;

        // Tổng tiền sau giảm
        $finalTotal = max(0, $total - $discount);

        // Tự động điền thông tin người dùng nếu đã đăng nhập
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

    // Lưu đơn hàng với phương thức COD
    public function store(StoreCheckoutRequest $request)
    {
        $selectedItems = $this->getSelectedItems();
        if ($selectedItems->isEmpty()) {
            return back()->with('error', 'Không có sản phẩm hợp lệ để đặt hàng.');
        }

        // Gom nhóm các item trùng variant để gộp số lượng
        $groupedItems = $selectedItems->groupBy(fn($item) => $item['variant']->id)
            ->map(function ($items) {
                $first = $items->first();
                return [
                    'product_variant_id' => $first['variant']->id,
                    'quantity'           => $items->sum('quantity'),
                    'price'              => $first['variant']->price,
                ];
            })->values()->all();

        // Lấy danh sách variant_id và tính tổng tiền
        $variantIds = collect($groupedItems)->pluck('product_variant_id')->all();
        $amount     = collect($groupedItems)->sum(fn($item) => $item['price'] * $item['quantity']);
        $orderCode  = strtoupper(Str::random(10));
        $voucherId  = $request->input('voucher_id') ?? (session('voucher')['id'] ?? null);

        // Tính giảm giá nếu có voucher
        $discount = 0;
        if ($voucherId && ($voucher = Voucher::find($voucherId))) {
            $discount = $voucher->discount_type === 'percent'
                ? round($amount * ($voucher->discount_value / 100))
                : min($voucher->discount_value, $amount);
        }

        $finalTotal = max(0, $amount - $discount);

        DB::beginTransaction();
        try {
            $voucherId = $request->input('voucher_id') ?? (session('voucher')['id'] ?? null);
            $total = $request->input('final_total');
            $orderCode = strtoupper(Str::random(10));

            $pendingStatus = \App\Models\Status::where('type', 'order')->where('code', 'pending')->first();

            // Tạo bản ghi thanh toán
            $payment = Payment::create([
                'status_id'      => Status::where('code', 'unpaid')->first()->id,
                'payment_method' => 'cod',
                'amount'         => $finalTotal,
                'note'           => $request->note,
            ]);

            // Tạo đơn hàng
            $order = Order::create([
                'user_id'     => Auth::id(),
                'voucher_id'  => $voucherId,
                'payment_id'  => $payment->id,
                'status_id'   => Status::where('code', 'pending')->first()->id,
                'name'        => $request->name,
                'email'       => $request->email,
                'phoneNumber' => $request->phoneNumber,
                'address'     => $request->address,
                'note'        => $request->note,
                'order_code'  => $orderCode,
                'total_price' => $finalTotal,
            ]);

            // Tạo chi tiết đơn hàng và giảm tồn kho
            foreach ($groupedItems as $item) {
                OrderDetail::create([
                    'order_id'           => $order->id,
                    'product_variant_id' => $item['product_variant_id'],
                    'quantity'           => $item['quantity'],
                    'price'              => $item['price'],
                ]);

                ProductVariant::find($item['product_variant_id'])?->decrement('quantity', $item['quantity']);
            }

            // Trừ voucher nếu có
            if ($voucherId) {
                Voucher::where('id', $voucherId)->decrement('quantity');
            }

            // Xóa khỏi giỏ hàng sau khi mua
            $this->clearPurchasedItemsFromCart($variantIds);

            // Soạn email dạng văn bản
            $body = "Cảm ơn bạn đã đặt hàng tại Nova Smart!\n\n";
            $body .= "🧾 Mã đơn hàng: {$order->order_code}\n";
            $body .= "👤 Tên khách hàng: {$order->name}\n";
            $body .= "📧 Email: {$order->email}\n";
            $body .= "📞 Số điện thoại: {$order->phoneNumber}\n";
            $body .= "🏠 Địa chỉ: {$order->address}\n";
            $body .= "💵 Tổng tiền: " . number_format($finalTotal, 0, ',', '.') . "₫\n\n";
            $body .= "🔹 Sản phẩm:\n";

            foreach ($groupedItems as $item) {
                $variant = ProductVariant::find($item['product_variant_id']);
                if ($variant) {
                    $body .= "- {$variant->product->name} ({$variant->name}) × {$item['quantity']} = " .
                        number_format($item['quantity'] * $item['price'], 0, ',', '.') . "₫\n";
                }
            }

            $body .= "\nChúng tôi sẽ sớm xử lý đơn hàng của bạn.\n\n";
            $body .= "Trân trọng,\nNova Smart";

            // Gửi mail đơn hàng thành công
            Mail::raw($body, function ($message) use ($order) {
                $message->to($order->email, $order->name)
                    ->subject('Thông báo đặt hàng thành công - Nova Smart');
            });

            // Xóa dữ liệu trong session sau khi đặt hàng
            session()->flash('purchased_variant_ids', $variantIds);
            session()->forget(['checkout.selected_ids', 'voucher']);

            DB::commit();
            return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Đặt hàng thất bại: ' . $e->getMessage());
        }
    }

    // Trang hiển thị khi đặt hàng thành công
    public function success()
    {
        $variantIdsToRemove = session()->get('purchased_variant_ids', []);

        if (!empty($variantIdsToRemove)) {
            $this->clearPurchasedItemsFromCart($variantIdsToRemove);
        }

        return view('checkout.success');
    }

    // Lấy các sản phẩm được chọn để thanh toán từ session
    private function getSelectedItems()
    {
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

        $items = $filtered->map(function ($item) {
            $variantId = $item['product_variant_id'] ?? ($item['variant']['id'] ?? null);
            $variant = ProductVariant::with('product')->find($variantId);
            if (!$variant) return null;

            return [
                'variant' => $variant,
                'quantity' => min($item['quantity'] ?? 1, $variant->quantity),
            ];
        })->filter()->values();

        return $items;
    }

    // Xóa sản phẩm đã mua ra khỏi giỏ hàng (session hoặc database)
    private function clearPurchasedItemsFromCart(array $variantIdsToRemove): void
    {
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
