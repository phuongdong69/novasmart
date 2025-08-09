<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Log};
use Illuminate\Support\Str;
use App\Models\{Order, OrderDetail, ProductVariant, Payment, Voucher, Cart, Status, VoucherUsage};
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    // Khởi tạo thanh toán VNPay
    public function vnpayCheckout(Request $request)
    {
        // Tổng thanh toán
        $amount = (int) str_replace('.', '', $request->input('final_total', 0));
        if ($amount < 5000 || $amount > 100000000) {
            return back()->with('error', 'Số tiền không hợp lệ.');
        }

        // Lấy sản phẩm đã chọn trong giỏ
        $selectedItems = $this->getSelectedItems();
        if ($selectedItems->isEmpty()) {
            return back()->with('error', 'Không tìm thấy sản phẩm hợp lệ trong session.');
        }

        // Gom nhóm theo variant
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
        $totalPrice = collect($groupedItems)->sum(fn($i) => $i['price'] * $i['quantity']);

        // ✅ Lấy voucher_id đúng nguồn (form hoặc session('voucher.id'))
        $voucherId = $request->input('voucher_id') ?? (session('voucher')['id'] ?? null);

        // Lưu vào session để dùng ở callback
        session()->put('checkout.selected_items', $groupedItems);
        session()->put('vnpay_order_data', [
            'order_code'  => $request->input('order_code') ?? strtoupper(Str::random(10)),
            'name'        => $request->input('name'),
            'email'       => $request->input('email'),
            'phoneNumber' => $request->input('phoneNumber'),
            'address'     => $request->input('address'),
            'note'        => $request->input('note'),
            'voucher_id'  => $voucherId,                                    // ✅ fixed
            'variant_ids' => $variantIds,
            'cart'        => $groupedItems,
            'total_price' => $totalPrice,
            'final_total' => $amount,
        ]);

        // Cấu hình VNPay
        $vnp_TmnCode    = config('vnpay.vnp_TmnCode');
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $vnp_Url        = config('vnpay.vnp_Url');
        $vnp_Returnurl  = config('vnpay.vnp_Returnurl');

        $inputData = [
            "vnp_Version"    => "2.1.0",
            "vnp_TmnCode"    => $vnp_TmnCode,
            "vnp_Amount"     => $amount * 100,
            "vnp_Command"    => "pay",
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode"   => "VND",
            "vnp_IpAddr"     => $request->ip(),
            "vnp_Locale"     => 'vn',
            "vnp_OrderInfo"  => "Thanh toán đơn hàng",
            "vnp_OrderType"  => "billpayment",
            "vnp_ReturnUrl"  => $vnp_Returnurl,
            "vnp_TxnRef"     => session('vnpay_order_data.order_code'),
        ];

        ksort($inputData);
        $hashData   = http_build_query($inputData);
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        return redirect($vnp_Url . '?' . $hashData . '&vnp_SecureHash=' . $secureHash);
    }

    // Callback từ VNPay
    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');

        $inputData = $request->except(['vnp_SecureHash', 'vnp_SecureHashType']);
        ksort($inputData);
        $secureHash = hash_hmac('sha512', http_build_query($inputData), $vnp_HashSecret);

        if ($secureHash === $request->input('vnp_SecureHash') && $request->input('vnp_ResponseCode') === '00') {
            DB::beginTransaction();
            try {
                $data = session('vnpay_order_data');
                $orderCode = $request->input('vnp_TxnRef');
                $amount = $request->input('vnp_Amount') / 100;

                if (!$data || ($data['order_code'] ?? '') !== $orderCode) {
                    return redirect()->route('checkout.show')->with('error', 'Không tìm thấy đơn hàng trong session.');
                }

                // Nếu đơn đã tồn tại -> không tạo lại
                $existingOrder = Order::where('order_code', $orderCode)->first();
                if ($existingOrder) {
                    DB::commit();
                    return redirect()->route('checkout.success')->with('success', 'Thanh toán thành công!');
                }

                // Tạo thanh toán
                $payment = Payment::create([
                    'status_id'        => Status::where('code', 'paid')->first()->id,
                    'payment_method'   => 'vnpay',
                    'amount'           => $amount,
                    'transaction_code' => $request->input('vnp_TransactionNo'),
                    'note'             => $data['note'],
                ]);

                // Tạo đơn hàng
                $order = Order::create([
                    'user_id'     => Auth::id(),
                    'voucher_id'  => $data['voucher_id'],
                    'payment_id'  => $payment->id,
                    'status_id'   => Status::where('code', 'pending')->where('type', 'order')->first()->id,
                    'name'        => $data['name'],
                    'email'       => $data['email'],
                    'phoneNumber' => $data['phoneNumber'],
                    'address'     => $data['address'],
                    'note'        => $data['note'],
                    'order_code'  => $orderCode,
                    'total_price' => $amount,
                ]);

                // Chi tiết đơn + trừ tồn
                foreach ($data['cart'] as $item) {
                    OrderDetail::create([
                        'order_id'           => $order->id,
                        'product_variant_id' => $item['product_variant_id'],
                        'quantity'           => $item['quantity'],
                        'price'              => $item['price'],
                    ]);

                    ProductVariant::find($item['product_variant_id'])
                        ?->decrement('quantity', $item['quantity']);
                }

                // Trừ voucher & ✅ Lưu lịch sử sử dụng
                if (!empty($data['voucher_id'])) {
                    Voucher::where('id', $data['voucher_id'])->decrement('quantity');

                    // ✅ rất quan trọng: ghi nhận voucher đã dùng (mỗi user 1 lần / mã)
                    if (Auth::check()) {
                        VoucherUsage::firstOrCreate(
                            ['voucher_id' => $data['voucher_id'], 'user_id' => Auth::id()],
                            ['used_at' => now()]
                        );
                    }
                }

                // Xoá item đã mua khỏi giỏ
                $this->clearPurchasedItemsFromCart($data['variant_ids'] ?? []);

                // Soạn email
                $body = "Cảm ơn bạn đã đặt hàng tại Nova Smart!\n\n";
                $body .= "🧾 Mã đơn hàng: {$order->order_code}\n";
                $body .= "👤 Tên khách hàng: {$order->name}\n";
                $body .= "📧 Email: {$order->email}\n";
                $body .= "📞 Số điện thoại: {$order->phoneNumber}\n";
                $body .= "🏠 Địa chỉ: {$order->address}\n";
                $body .= "💵 Tổng tiền: " . number_format($order->total_price, 0, ',', '.') . "₫\n\n";
                $body .= "🔹 Sản phẩm:\n";
                foreach ($data['cart'] as $item) {
                    $variant = ProductVariant::find($item['product_variant_id']);
                    if ($variant) {
                        $body .= "- {$variant->product->name} ({$variant->name}) × {$item['quantity']} = "
                            . number_format($item['quantity'] * $item['price'], 0, ',', '.') . "₫\n";
                    }
                }
                $body .= "\nChúng tôi sẽ sớm xử lý đơn hàng của bạn.\n\nTrân trọng,\nNova Smart";

                // ✅ Commit trước khi gửi mail để không rollback usage nếu mail lỗi
                DB::commit();

                try {
                    Mail::raw($body, function ($message) use ($order) {
                        $message->to($order->email, $order->name)
                            ->subject('Thông báo đặt hàng thành công - Nova Smart');
                    });
                } catch (\Throwable $mailEx) {
                    Log::warning('Gửi mail thất bại: ' . $mailEx->getMessage());
                }

                // Dọn session
                session()->forget([
                    'voucher',
                    'vnpay_order_data',
                    'checkout.selected_items',
                    'checkout.selected_ids',
                ]);

                return redirect()->route('checkout.success')->with('success', 'Thanh toán VNPay thành công! Đã gửi email xác nhận.');
            } catch (\Throwable $e) {
                DB::rollBack();
                return redirect()->route('checkout.show')->with('error', 'Lỗi xử lý đơn hàng: ' . $e->getMessage());
            }
        }

        return redirect()->route('checkout.show')->with('error', 'Thanh toán thất bại hoặc bị hủy.');
    }

    // Lấy item đã chọn từ session
    private function getSelectedItems()
    {
        $variantIds = session('checkout.selected_ids', []);
        if (empty($variantIds)) return collect();

        if (Auth::check()) {
            $items = Auth::user()->cart->items()
                ->whereIn('product_variant_id', $variantIds)
                ->with('productVariant.product')
                ->get();

            return $items->map(function ($item) {
                $variant = $item->productVariant;
                return [
                    'variant'  => $variant,
                    'quantity' => min($item->quantity, $variant->quantity),
                ];
            })->filter()->values();
        }

        $cart = session('cart', []);
        return collect($cart)->filter(function ($item) use ($variantIds) {
            $variantId = $item['product_variant_id'] ?? ($item['variant']['id'] ?? null);
            return in_array((int)$variantId, $variantIds);
        })->map(function ($item) {
            $variantId = $item['product_variant_id'] ?? ($item['variant']['id'] ?? null);
            $variant = ProductVariant::with('product')->find($variantId);
            if (!$variant) return null;
            return [
                'variant'  => $variant,
                'quantity' => min($item['quantity'] ?? 1, $variant->quantity),
            ];
        })->filter()->values();
    }

    // Xoá item đã mua khỏi giỏ
    private function clearPurchasedItemsFromCart(array $variantIdsToRemove): void
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            $cart?->items()->whereIn('product_variant_id', $variantIdsToRemove)->delete();
            Log::debug('🧹 Xoá DB cart:', $variantIdsToRemove);
        } else {
            $cart = session('cart', []);
            $updated = [];
            foreach ($cart as $item) {
                $variantId = $item['product_variant_id'] ?? ($item['variant']['id'] ?? null);
                if (!in_array((int)$variantId, $variantIdsToRemove)) {
                    $updated[$variantId] = $item;
                }
            }
            session()->put('cart', $updated);
        }
    }
}
