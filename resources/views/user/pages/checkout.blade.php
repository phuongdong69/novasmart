@extends('user.layouts.client')
@section('title', 'Thanh toán')
@section('meta_description', 'Đây là trang thanh toán nova smart.')

@section('content')
<section class="relative table w-full py-20 lg:py-24 bg-gray-50 dark:bg-slate-800">
    <div class="container relative">
        <div class="grid grid-cols-1 mt-14">
            <h3 class="text-3xl leading-normal font-semibold">Thanh toán</h3>
        </div>
        <div class="relative mt-3">
            <ul class="tracking-[0.5px] mb-0 inline-block">
                <li class="inline-block uppercase text-[13px] font-bold hover:text-orange-500">
                    <a href="/shop-cart">Giỏ hàng</a>
                </li>
                <li class="inline-block mx-0.5"><i class="mdi mdi-chevron-right"></i></li>
                <li class="inline-block uppercase text-[13px] font-bold text-orange-500">Thanh toán</li>
            </ul>
        </div>
    </div>
</section>

<section class="relative md:py-24 py-16">
    @if (session('error'))
    <div class="w-full bg-red-500 text-white text-center py-3 font-semibold text-base">
        {{ session('error') }}
    </div>
    @endif

    @php
    $uniqueItems = collect();
    $seenIds = [];

    foreach ($cartItems as $item) {
        $variant = is_array($item) ? ($item['variant'] ?? null) : ($item->productVariant ?? null);
        $quantity = is_array($item) ? ($item['quantity'] ?? 1) : ($item->quantity ?? 1);

        if ($variant && !in_array($variant->id, $seenIds)) {
            $seenIds[] = $variant->id;
            $uniqueItems->push([
                'variant' => $variant,
                'quantity' => $quantity,
            ]);
        }
    }

    $total = $uniqueItems->sum(fn($i) => $i['variant']->price * $i['quantity']);

    $voucher = session('voucher') ?? [];
    $voucherId = $voucher['id'] ?? null;

    $discount = 0;
    if ($voucherId) {
        $voucherModel = \App\Models\Voucher::find($voucherId);
        if ($voucherModel) {
            $discount = $voucherModel->discount_type === 'percent'
                ? round($total * ($voucherModel->discount_value / 100))
                : min($voucherModel->discount_value, $total);
        }
    }

    $finalTotal = max(0, $total - $discount);

    $user = Auth::user();
    @endphp

    <div class="container relative">
        <div class="grid lg:grid-cols-12 md:grid-cols-2 grid-cols-1 gap-6">
            {{-- FORM THANH TOÁN --}}
            <div class="lg:col-span-8">
                <div class="p-6 rounded-md shadow-sm dark:shadow-gray-800">
                    <h3 class="text-xl font-semibold">Thông tin thanh toán</h3>
                    <form id="checkout-form" method="POST"
                        action="{{ route('checkout.store') }}"
                        data-vnpay-route="{{ route('payment.vnpay.checkout') }}">
                        @csrf

                        {{-- ✅ Hidden Voucher ID để gửi về controller --}}
                        @if($voucherId)
                            <input type="hidden" name="voucher_id" value="{{ $voucherId }}">
                        @endif

                        <input type="hidden" name="final_total" value="{{ (int) $finalTotal }}">
                        <input type="hidden" name="amount" id="amount" value="{{ (int) $finalTotal }}">

                        <div class="grid lg:grid-cols-12 grid-cols-1 mt-6 gap-5">
                            {{-- Họ và tên --}}
                            <div class="lg:col-span-12">
                                <label class="form-label font-semibold">Họ và tên :</label>
                                <input id="name" type="text" name="name"
                                    value="{{ old('name', $user->name ?? '') }}"
                                    class="form-input w-full py-2 px-3 h-10 border border-gray-300 rounded"
                                    placeholder="Nhập họ và tên"
                                    @auth readonly @endauth>
                                <span id="name-error" class="text-red-600 text-sm mt-1 hidden"></span>
                            </div>

                            {{-- Số điện thoại --}}
                            <div class="lg:col-span-6">
                                <label class="form-label font-semibold">Số điện thoại :</label>
                                <input id="phoneNumber" type="text" name="phoneNumber"
                                    value="{{ old('phoneNumber', $user->phoneNumber ?? '') }}"
                                    class="form-input w-full py-2 px-3 h-10 border border-gray-300 rounded"
                                    placeholder="Nhập số điện thoại"
                                    @auth readonly @endauth>
                                <span id="phoneNumber-error" class="text-red-600 text-sm mt-1 hidden"></span>
                            </div>

                            {{-- Email --}}
                            <div class="lg:col-span-6">
                                <label class="form-label font-semibold">Email :</label>
                                <input id="email" type="email" name="email"
                                    value="{{ old('email', $user->email ?? '') }}"
                                    class="form-input w-full py-2 px-3 h-10 border border-gray-300 rounded"
                                    placeholder="Nhập Email"
                                    @auth readonly @endauth>
                                <span id="email-error" class="text-red-600 text-sm mt-1 hidden"></span>
                            </div>

                            {{-- Địa chỉ --}}
                            <div class="lg:col-span-12">
                                <label class="form-label font-semibold">Địa chỉ :</label>
                                <input id="address" type="text" name="address"
                                    value="{{ old('address', $user->address ?? '') }}"
                                    class="form-input w-full py-2 px-3 h-10 border border-gray-300 rounded"
                                    placeholder="Nhập địa chỉ">
                                <span id="address-error" class="text-red-600 text-sm mt-1 hidden"></span>
                            </div>

                            {{-- Ghi chú --}}
                            <div class="lg:col-span-12">
                                <label class="form-label font-semibold">Ghi chú :</label>
                                <textarea name="note"
                                    class="form-input w-full py-2 px-3 border border-gray-300 rounded"
                                    placeholder="Ghi chú đơn hàng" rows="4">{{ old('note') }}</textarea>
                            </div>

                            {{-- Phương thức thanh toán --}}
                            <div class="lg:col-span-12">
                                <label class="form-label font-semibold">Phương thức thanh toán :</label>
                                <select name="payment_method"
                                    class="form-input w-full py-2 px-3 h-10 border border-gray-300 rounded">
                                    <option value="">-- Chọn phương thức --</option>
                                    <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>COD </option>
                                    <option value="vnpay" {{ old('payment_method') == 'vnpay' ? 'selected' : '' }}>VNPay</option>
                                    <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>COD</option>
                                </select>
                                <span id="payment_method-error" class="text-red-600 text-sm mt-1 hidden"></span>
                            </div>

                            <div class="lg:col-span-12">
                                <button type="submit"
                                    class="mt-6 py-2 px-5 bg-orange-500 text-white rounded w-full hover:bg-orange-600 transition duration-200">
                                    Đặt hàng
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- THÔNG TIN ĐƠN HÀNG --}}
            <div class="lg:col-span-4">
                <div class="p-6 rounded-md shadow-sm dark:shadow-gray-800 bg-white">
                    <h4 class="text-lg font-semibold mb-4">Đơn hàng của bạn</h4>

                    <div class="flex justify-between font-semibold border-b pb-2">
                        <span>Sản phẩm</span>
                        <span>Tạm tính</span>
                    </div>

                    @foreach ($uniqueItems as $item)
                        <input type="hidden" name="selected_items[]" value="{{ $item['variant']->id }}">
                        <div class="flex justify-between items-start py-2 border-b">
                            <div>
                                <p class="text-sm font-medium">{{ $item['variant']->product->name ?? 'Tên sản phẩm' }}</p>
                                <p class="text-xs text-gray-500">{{ $item['variant']->name ?? '' }} × {{ $item['quantity'] }}</p>
                            </div>
                            <p class="text-sm font-semibold whitespace-nowrap">
                                {{ number_format($item['variant']->price * $item['quantity'], 0, ',', '.') }}₫
                            </p>
                        </div>
                    @endforeach

                    <div class="pt-4 space-y-1 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tạm tính</span>
                            <span id="original-total" data-amount="{{ $total }}">
                                {{ number_format($total, 0, ',', '.') }}₫
                            </span>
                        </div>

                        @if ($discount > 0)
                        <div class="flex justify-between text-red-600">
                            <span>Giảm giá</span>
                            <span id="discount-value" data-amount="{{ $discount }}">
                                -{{ number_format($discount, 0, ',', '.') }}₫
                            </span>
                        </div>
                        @endif

                        <div class="flex justify-between font-bold text-base pt-1 border-t mt-2">
                            <span>Tổng cộng</span>
                            <span>{{ number_format($finalTotal, 0, ',', '.') }}₫</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('assets/user/js/checkout.js') }}"></script>
@endsection
