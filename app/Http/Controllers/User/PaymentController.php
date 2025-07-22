<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB};
use Illuminate\Support\Str;
use App\Models\{Order, OrderDetail, ProductVariant, Payment, Voucher, Cart};

class PaymentController extends Controller
{
    // Gửi yêu cầu đến VNPay để thanh toán
    public function vnpayCheckout(Request $request)
    {
        $vnp_TmnCode    = config('vnpay.vnp_TmnCode');
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $vnp_Url        = config('vnpay.vnp_Url');
        $vnp_Returnurl  = config('vnpay.vnp_Returnurl');

        $amount = (int) str_replace('.', '', $request->input('final_total', 0));
        if ($amount < 5000 || $amount > 100000000) {
            return back()->with('error', 'Số tiền không hợp lệ.');
        }

        $orderCode = strtoupper(Str::random(10));

        // Lưu thông tin đơn hàng vào session
        session()->put('checkout', [
            'order_code' => $orderCode,
            'name'       => $request->input('name'),
            'email'      => $request->input('email'),
            'phoneNumber'=> $request->input('phoneNumber'),
            'address'    => $request->input('address'),
            'note'       => $request->input('note'),
            'voucher_id' => session('voucher_id'),
            'cart'       => Auth::check()
                ? Cart::with('items.productVariant.product')
                    ->where('user_id', Auth::id())
                    ->first()?->items->map(fn($item) => [
                        'variant' => $item->productVariant->toArray(),
                        'quantity' => $item->quantity,
                    ])->toArray()
                : collect(session('cart'))->map(function ($item) {
                    $variantId = $item['variant_id'] ?? $item['product_variant_id'] ?? $item['id'] ?? null;
                    $variant = ProductVariant::with('product')->find($variantId);

                    return [
                        'variant' => $variant?->toArray() ?? [],
                        'quantity' => $item['quantity'] ?? 1,
                    ];
                })->toArray()
        ]);

        // Tạo URL chuyển hướng đến VNPay
        $inputData = [
            "vnp_Version"    => "2.1.0",
            "vnp_TmnCode"    => $vnp_TmnCode,
            "vnp_Amount"     => $amount * 100,
            "vnp_Command"    => "pay",
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode"   => "VND",
            "vnp_IpAddr"     => $request->ip(),
            "vnp_Locale"     => 'vn',
            "vnp_OrderInfo"  => "Thanh toan don hang $orderCode",
            "vnp_OrderType"  => "billpayment",
            "vnp_ReturnUrl"  => $vnp_Returnurl,
            "vnp_TxnRef"     => $orderCode,
        ];

        ksort($inputData);
        $hashData = http_build_query($inputData);
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $paymentUrl = $vnp_Url . '?' . $hashData . '&vnp_SecureHash=' . $secureHash;

        return redirect($paymentUrl);
    }

    // Xử lý kết quả từ VNPay trả về
    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $vnp_SecureHash = $request->input('vnp_SecureHash');
        $inputData = $request->except(['vnp_SecureHash', 'vnp_SecureHashType']);

        ksort($inputData);
        $secureHash = hash_hmac('sha512', http_build_query($inputData), $vnp_HashSecret);
        $responseCode = $request->input('vnp_ResponseCode');

        // Nếu thanh toán thành công
        if ($secureHash === $vnp_SecureHash && $responseCode === '00') {
            $data = session('checkout');
            $orderCode = $data['order_code'] ?? $request->input('vnp_TxnRef');

            if (!$data || empty($data['cart'])) {
                return redirect()->route('checkout.show')->with('error', 'Không tìm thấy dữ liệu phiên!');
            }

            DB::beginTransaction();
            try {
                // Tạo payment record
                $payment = Payment::create([
                    'status'           => 'completed',
                    'payment_method'   => 'vnpay',
                    'amount'           => $request->input('vnp_Amount') / 100,
                    'transaction_code' => $request->input('vnp_TransactionNo'),
                    'note'             => $data['note'] ?? null,
                ]);

                // Thêm ở đầu hàm vnpayReturn:
                $pendingStatus = \App\Models\Status::where('type', 'order')->where('code', 'pending')->first();

                // Tạo order
                $order = Order::create([
                    'user_id'     => Auth::id(),
                    'voucher_id'  => $data['voucher_id'],
                    'payment_id'  => $payment->id,
                    'name'        => $data['name'],
                    'phoneNumber' => $data['phoneNumber'],
                    'email'       => $data['email'],
                    'address'     => $data['address'],
                    'total_price' => $payment->amount,
                    'order_code'  => $orderCode,
                    'status_id' => $pendingStatus ? $pendingStatus->id : null,
                ]);

                // Tạo chi tiết đơn hàng và trừ tồn kho
                foreach ($data['cart'] as $item) {
                    $variant = $item['variant'];
                    $qty     = $item['quantity'];

                    if (!$variant || $qty <= 0 || $qty > $variant['quantity']) {
                        DB::rollBack();
                        return redirect()->route('checkout.show')->with('error', 'Sản phẩm không hợp lệ.');
                    }

                    OrderDetail::create([
                        'order_id'           => $order->id,
                        'product_variant_id' => $variant['id'],
                        'quantity'           => $qty,
                        'price'              => $variant['price'],
                    ]);

                    ProductVariant::where('id', $variant['id'])->decrement('quantity', $qty);
                }

                // Trừ lượt dùng voucher
                if ($data['voucher_id']) {
                    Voucher::where('id', $data['voucher_id'])->decrement('quantity');
                }

                // Xóa giỏ hàng
                if (Auth::check()) {
                    Cart::where('user_id', Auth::id())->delete();
                }

                session()->forget(['cart', 'voucher', 'checkout']);
                DB::commit();

                return redirect()->route('checkout.success')->with('success', 'Thanh toán VNPay thành công!');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('checkout.show')->with('error', 'Lỗi xử lý đơn hàng: ' . $e->getMessage());
            }
        }

        // Nếu hủy hoặc lỗi
        if ($responseCode === '24') {
            return redirect()->route('checkout.show')->with('error', 'Bạn đã hủy thanh toán.');
        }

        return redirect()->route('checkout.show')->with('error', 'Thanh toán thất bại. Mã lỗi: ' . $responseCode);
    }
}
