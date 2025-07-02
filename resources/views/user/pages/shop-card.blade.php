@extends('user.layouts.client')

@section('title', 'Giỏ hàng')

@section('content')
<section class="relative table w-full py-20 lg:py-24 bg-gray-50 dark:bg-slate-800">
    <div class="container relative">
                <div class="grid grid-cols-1 mt-14">
                    <h3 class="text-3xl leading-normal font-semibold">Giỏ hàng</h3>
                </div><!--end grid-->

                <div class="relative mt-3">
                    <ul class="tracking-[0.5px] mb-0 inline-block">
                        <li class="inline-block uppercase text-[13px] font-bold duration-500 ease-in-out hover:text-orange-500"><a href="index.html">Trang chủ</a></li>
                        <li class="inline-block text-base text-slate-950 dark:text-white mx-0.5 ltr:rotate-0 rtl:rotate-180"><i class="mdi mdi-chevron-right"></i></li>
                        <li class="inline-block uppercase text-[13px] font-bold text-orange-500" aria-current="page">Giỏ hàng</li>
                    </ul>
                </div>
            </div><!--end container-->
</section>

<section class="relative md:py-24 py-16">
    <div class="container relative">
        <div class="grid lg:grid-cols-1">
            <div class="relative overflow-x-auto shadow-sm dark:shadow-gray-800 rounded-md">
                <table class="w-full text-start">
                    <thead class="text-sm uppercase bg-slate-50 dark:bg-slate-800">
                        <tr>
                            <th class="p-4 w-4"></th>
                            <th class="text-start p-4 min-w-[220px]">Sản phẩm</th>
                            <th class="p-4 w-24 text-center">Giá</th>
                            <th class="p-4 w-56 text-center">Số lượng</th>
                            <th class="p-4 w-24 text-right">Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cart['items'] ?? [] as $item)
                        @php
                            $isObject = is_object($item);
                            $variant = $isObject ? $item->productVariant : ($item['variant'] ?? null);
                            $product = $isObject ? $item->productVariant->product : ($item['product'] ?? null);
                            $quantity = $isObject ? $item->quantity : ($item['quantity'] ?? 1);
                            $price = $variant->price ?? 0;
                            $total = $quantity * $price;
                            $id = $isObject ? $item->id : ($item['variant']->id ?? 0);
                            $thumbnail = $product->thumbnails->where('is_primary', true)->first();
                            $imageUrl = $thumbnail ? asset('storage/' . $thumbnail->url) : ($product->image ? asset('storage/' . $product->image) : asset('images/default-product.jpg'));
                        @endphp
                        <tr class="bg-white dark:bg-slate-900 border-t border-gray-100 dark:border-gray-800">
                            <td class="p-4 align-middle">
                                <form method="POST" action="{{ route('cart.remove', $id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="mdi mdi-window-close"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="p-4 align-middle">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-20 h-20 rounded-md object-cover border border-gray-200 dark:border-gray-700 shadow-sm">
                                    <span class="font-semibold">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-center align-middle">
                                <span class="unit-price" data-price="{{ $price }}">{{ number_format($price, 0, ',', '.') }}₫</span>
                            </td>
                            <td class="p-4 text-center align-middle">
                                <div class="form-update-qty" data-id="{{ $id }}">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" class="btn-decrease size-9 flex items-center justify-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white">-</button>
                                        <input type="number"
                                            name="quantity"
                                            value="{{ $quantity }}"
                                            min="1"
                                            max="{{ $variant->quantity }}"
                                            data-max="{{ $variant->quantity }}"
                                            class="quantity-input h-9 text-center rounded-md bg-orange-500/5 text-orange-500 w-16">
                                        <button type="button" class="btn-increase size-9 flex items-center justify-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white">+</button>
                                    </div>
                                    <div class="error-message text-sm text-red-500 mt-1 hidden"></div>
                                </div>
                            </td>
                            <td class="p-4 text-end align-middle">
                                <span class="item-total">{{ number_format($total, 0, ',', '.') }}₫</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-6">Giỏ hàng của bạn đang trống.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if (!empty($cart['items']))
        <div class="mt-8 text-end">
            <a href="" class="inline-block px-6 py-3 bg-orange-500 text-white font-semibold text-base rounded-md shadow hover:bg-orange-600 transition duration-300">
                ← Tiếp tục xem sản phẩm
            </a>
            <a href="{{ route('checkout.show') }}" class="inline-block px-6 py-3 bg-orange-500 text-white font-semibold text-base rounded-md shadow hover:bg-orange-600 transition duration-300">
                Tiến hành thanh toán
            </a>
        </div>
        @endif
    </div>
</section>

<script src="{{ asset('assets/user/js/shop-cart.js') }}"></script>
@endsection
