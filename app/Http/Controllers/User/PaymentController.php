<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Log};
use Illuminate\Support\Str;
use App\Models\{Order, OrderDetail, ProductVariant, Payment, Voucher, Cart, Status};
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    // Hàm khởi tạo thanh toán VNPay
    public function vnpayCheckout(Request $request)
    {
        // Lấy và chuẩn hóa tổng thanh toán
        $amount = (int) str_replace('.', '', $request->input('final_total', 0));

        // Kiểm tra tổng tiền hợp lệ
        if ($amount < 5000 || $amount > 100000000) {
            return back()->with('error', 'Số tiền không hợp lệ.');
        }

        // Lấy sản phẩm đã chọn trong giỏ
        $selectedItems = $this->getSelectedItems();
        if ($selectedItems->isEmpty()) {
            return back()->with('error', 'Không tìm thấy sản phẩm hợp lệ trong session.');
        }

        // Gom nhóm sản phẩm theo variant
        $groupedItems = $selectedItems->groupBy(fn($item) => $item['variant']->id)
            ->map(function ($items) {
                $first = $items->first();
                return [
                    'product_variant_id' => $first['variant']->id,
                    'quantity'           => $items->sum('quantity'),
                    'price'              => $first['variant']->price,
                ];
            })->values()->all();

        // Lưu dữ liệu thanh toán vào session để xử lý sau khi thanh toán xong
        $variantIds = collect($groupedItems)->pluck('product_variant_id')->all();
        $totalPrice = collect($groupedItems)->sum(fn($item) => $item['price'] * $item['quantity']);
        session()->put('checkout.selected_items', $groupedItems);
        session()->put('vnpay_order_data', [
            'order_code'  => $request->input('order_code') ?? strtoupper(Str::random(10)),
            'name'        => $request->input('name'),
            'email'       => $request->input('email'),
            'phoneNumber' => $request->input('phoneNumber'),
            'address'     => $request->input('address'),
            'note'        => $request->input('note'),
            'voucher_id'  => $request->input('voucher_id') ?? session('voucher_id'),
            'variant_ids' => $variantIds,
            'cart'        => $groupedItems,
            'total_price' => $totalPrice,
            'final_total' => $amount,
        ]);

        // Cấu hình thông tin từ file config/vnpay.php
        $vnp_TmnCode    = config('vnpay.vnp_TmnCode');
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $vnp_Url        = config('vnpay.vnp_Url');
        $vnp_Returnurl  = config('vnpay.vnp_Returnurl');

        // Tạo dữ liệu gửi đến VNPay
        $inputData = [
            "vnp_Version"    => "2.1.0",
            "vnp_TmnCode"    => $vnp_TmnCode,
            "vnp_Amount"     => $amount * 100, // Nhân 100 theo yêu cầu VNPay
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

        // Sắp xếp dữ liệu và tạo chuỗi ký
        ksort($inputData);
        $hashData   = http_build_query($inputData);
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        // Tạo URL thanh toán và chuyển hướng
        $paymentUrl = $vnp_Url . '?' . $hashData . '&vnp_SecureHash=' . $secureHash;
        return redirect($paymentUrl);
    }

    // Hàm xử lý khi người dùng thanh toán xong và VNPay gọi lại
    public function vnpayReturn(Request $request)
    {
        // Lấy key bảo mật từ config
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');

        // Loại bỏ hash khỏi request để tính toán lại
        $inputData = $request->except(['vnp_SecureHash', 'vnp_SecureHashType']);
        ksort($inputData);
        $secureHash = hash_hmac('sha512', http_build_query($inputData), $vnp_HashSecret);

        // Xác thực thanh toán thành công từ VNPay
        if ($secureHash === $request->input('vnp_SecureHash') && $request->input('vnp_ResponseCode') === '00') {
            DB::beginTransaction();
            try {
                $data = session('vnpay_order_data');
                $orderCode = $request->input('vnp_TxnRef');
                $amount = $request->input('vnp_Amount') / 100;

                // Kiểm tra lại dữ liệu từ session
                if (!$data || ($data['order_code'] ?? '') !== $orderCode) {
                    return redirect()->route('checkout.show')->with('error', 'Không tìm thấy đơn hàng trong session.');
                }

                // Nếu đơn hàng đã tồn tại -> không tạo lại
                $existingOrder = Order::where('order_code', $orderCode)->first();
                if ($existingOrder) {
                    DB::commit();
                    return redirect()->route('checkout.success')->with('success', 'Thanh toán thành công!');
                }

                // Tạo thông tin thanh toán
                $payment = Payment::create([
                    'status_id'        => Status::where('code', 'paid')->first()->id,
                    'payment_method'   => 'vnpay',
                    'amount'           => $amount,
                    'transaction_code' => $request->input('vnp_TransactionNo'),
                    'note'             => $data['note'],
                ]);


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

                // Tạo chi tiết đơn hàng và giảm tồn kho
                foreach ($data['cart'] as $item) {
                    OrderDetail::create([
                        'order_id'           => $order->id,
                        'product_variant_id' => $item['product_variant_id'],
                        'quantity'           => $item['quantity'],
                        'price'              => $item['price'],
                    ]);

                    ProductVariant::find($item['product_variant_id'])?->decrement('quantity', $item['quantity']);
                }

                // Trừ số lượng voucher nếu có
                if ($data['voucher_id']) {
                    Voucher::where('id', $data['voucher_id'])->decrement('quantity');
                }

                // Xóa các item đã mua khỏi cart
                $this->clearPurchasedItemsFromCart($data['variant_ids'] ?? []);

                // Soạn email đơn hàng
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
                        $body .= "- {$variant->product->name} ({$variant->name}) × {$item['quantity']} = " .
                            number_format($item['quantity'] * $item['price'], 0, ',', '.') . "₫\n";
                    }
                }

                $body .= "\nChúng tôi sẽ sớm xử lý đơn hàng của bạn.\n\n";
                $body .= "Trân trọng,\nNova Smart";

                // Gửi mail thông báo đặt hàng
                Mail::raw($body, function ($message) use ($order) {
                    $message->to($order->email, $order->name)
                        ->subject('Thông báo đặt hàng thành công - Nova Smart');
                });

                // Xóa session liên quan đến checkout
                session()->forget([
                    'voucher',
                    'vnpay_order_data',
                    'checkout.selected_items',
                    'checkout.selected_ids',
                ]);

                DB::commit();
                return redirect()->route('checkout.success')->with('success', 'Thanh toán VNPay thành công! Đã gửi email xác nhận.');
            } catch (\Throwable $e) {
                DB::rollBack();
                return redirect()->route('checkout.show')->with('error', 'Lỗi xử lý đơn hàng: ' . $e->getMessage());
            }
        }

        return redirect()->route('checkout.show')->with('error', 'Thanh toán thất bại hoặc bị hủy.');
    }

    // Lấy danh sách item đã chọn từ session
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

    // Xoá các item đã mua ra khỏi cart (session hoặc database)
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
