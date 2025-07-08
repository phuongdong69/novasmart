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


    <div class="container relative">
        <div class="grid lg:grid-cols-12 md:grid-cols-2 grid-cols-1 gap-6">
            <div class="lg:col-span-8">
                <div class="p-6 rounded-md shadow-sm dark:shadow-gray-800">
                    <h3 class="text-xl font-semibold">Thông tin thanh toán</h3>
                    <form id="checkout-form" method="POST" action="{{ route('checkout.store') }}" data-vnpay-route="{{ route('payment.vnpay.checkout') }}">


                        @csrf

                        @php
                        $voucher = session('voucher') ?? [];
                        $voucherId = $voucher['id'] ?? null;
                        $voucherDiscount = $voucher['discount'] ?? 0;
                        $finalTotal = $total - $voucherDiscount;
                        @endphp

                        <input type="hidden" name="voucher_id" value="{{ $voucherId }}">
                        <input type="hidden" name="final_total" value="{{ (int) $finalTotal }}">
                        <input type="hidden" name="amount" id="amount" value="{{ (int) $finalTotal }}">


                        <div class="grid lg:grid-cols-12 grid-cols-1 mt-6 gap-5">
                            <div class="lg:col-span-12">
                                <label class="form-label font-semibold">Họ và tên :</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}"
                                    class="form-input w-full py-2 px-3 h-10 border border-gray-300 rounded"
                                    placeholder="Nhập họ và tên">
                                <span id="name-error" class="text-red-600 text-sm mt-1 hidden"></span>
                            </div>

                            <div class="lg:col-span-6">
                                <label class="form-label font-semibold">Số điện thoại :</label>
                                <input id="phoneNumber" type="text" name="phoneNumber" value="{{ old('phoneNumber') }}"
                                    class="form-input w-full py-2 px-3 h-10 border border-gray-300 rounded"
                                    placeholder="Nhập số điện thoại">
                                <span id="phoneNumber-error" class="text-red-600 text-sm mt-1 hidden"></span>
                            </div>

                            <div class="lg:col-span-6">
                                <label class="form-label font-semibold">Email :</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                    class="form-input w-full py-2 px-3 h-10 border border-gray-300 rounded"
                                    placeholder="Nhập Email">
                                <span id="email-error" class="text-red-600 text-sm mt-1 hidden"></span>
                            </div>

                            <div class="lg:col-span-12">
                                <label class="form-label font-semibold">Địa chỉ :</label>
                                <input id="address" type="text" name="address" value="{{ old('address') }}"
                                    class="form-input w-full py-2 px-3 h-10 border border-gray-300 rounded"
                                    placeholder="Nhập địa chỉ">
                                <span id="address-error" class="text-red-600 text-sm mt-1 hidden"></span>
                            </div>

                            <div class="lg:col-span-12">
                                <label class="form-label font-semibold">Ghi chú :</label>
                                <textarea name="note"
                                    class="form-input w-full py-2 px-3 border border-gray-300 rounded"
                                    placeholder="Ghi chú đơn hàng" rows="4">{{ old('note') }}</textarea>
                            </div>

                            <div class="lg:col-span-12">
                                <label class="form-label font-semibold">Phương thức thanh toán :</label>
                                <select name="payment_method"
                                    class="form-input w-full py-2 px-3 h-10 border border-gray-300 rounded">
                                    <option value="">-- Chọn phương thức --</option>
                                    <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>COD</option>
                                    <option value="vnpay" {{ old('payment_method') == 'vnpay' ? 'selected' : '' }}>VNPay</option>
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

            <div class="lg:col-span-4">
                <div class="p-6 rounded-md shadow-sm dark:shadow-gray-800">
                    <div class="flex justify-between items-center">
                        <h5 class="text-lg font-semibold">Giỏ hàng</h5>
                        <span class="bg-orange-500 text-white text-xs font-bold px-2.5 py-0.5 rounded-full">
                            {{ count($cartItems) }}
                        </span>
                    </div>

                    <div class="mt-4">
                        @foreach ($cartItems as $item)
                        <div class="p-3 flex justify-between items-center border-b">
                            <div>
                                @if (is_array($item))
                                <h5 class="font-semibold">{{ $item['variant']->product->name ?? 'N/A' }}</h5>
                                <p class="text-sm text-gray-500">{{ $item['variant']->name ?? '' }}</p>
                                @else
                                <h5 class="font-semibold">{{ $item->productVariant->product->name ?? 'N/A' }}</h5>
                                <p class="text-sm text-gray-500">{{ $item->productVariant->name ?? '' }}</p>
                                <div class="flex items-center space-x-1 text-sm">
                                    <span class="font-semibold">{{ $item->quantity ?? '' }}</span>
                                    <span class="text-gray-500">×</span>
                                    <span class="text-red-500">{{ number_format($item->price ?? 0, 0, ',', '.') }}₫</span>
                                </div>

                                @endif
                            </div>
                            <p class="font-semibold text-right">
                                {{ number_format((is_array($item) ? $item['variant']->price * $item['quantity'] : $item->productVariant->price * $item->quantity), 0, ',', '.') }}₫
                            </p>
                        </div>
                        @endforeach

                        @if(session('voucher'))
                        <div class="p-3 flex justify-between items-center bg-gray-50 text-green-600">
                            <div>
                                <h5 class="font-semibold">Mã giảm giá</h5>
                                <p class="text-sm">{{ session('voucher')['code'] }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <p class="text-red-600 font-semibold">
                                    -{{ number_format($voucherDiscount, 0, ',', '.') }}₫
                                </p>
                                <form action="{{ route('checkout.remove-voucher') }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-lg">✕</button>
                                </form>
                            </div>
                        </div>
                        @endif

                        <div class="p-3 flex justify-between items-center border-t">
                            <h5 class="font-semibold">Tổng tiền</h5>
                            <p class="font-semibold">{{ number_format($finalTotal, 0, ',', '.') }}₫</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <form class="relative" action="{{ route('checkout.apply-voucher') }}" method="POST">
                            @csrf
                            <input type="text" name="voucher_code"
                                class="py-3 pe-40 ps-6 w-full h-[50px] rounded-full bg-white border shadow-sm"
                                placeholder="Mã giảm giá">
                            <button type="submit"
                                class="py-2 px-5 absolute top-[2px] end-[3px] h-[46px] bg-orange-500 text-white rounded-full">
                                Áp dụng
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script src="{{ asset('assets/user/js/checkout.js') }}"></script>
@endsection