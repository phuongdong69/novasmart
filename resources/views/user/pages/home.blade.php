@extends('user.layouts.client')

@section('title', 'trang chủ')

@section('meta_description', 'Đây là trang chủ của nova smart.')

@section('content')
    <!-- Bắt đầu -->
    <section class="relative md:py-24 py-16">
        {{-- slideshow --}}
        @include('user.partials.slideshow')
         @include('user.partials.popup')
         @include('user.partials.toast')
        @if (session('success'))
        
        @endif
        <div class="container relative md:mt-24 mt-16">
            <div class="grid grid-cols-1 justify-center text-center mb-6">
                <h5 class="font-semibold text-3xl leading-normal mb-4">Sản Phẩm Mới </h5>
                <p class="text-slate-400 max-w-xl mx-auto">Mua sắm những sản phẩm mới nhất từ các bộ sưu tập được yêu thích
                    nhất</p>
            </div><!--end grid-->

            <div class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 pt-6 gap-6">
                @forelse($products as $product)
                    @php
                        $variant = $product->variants->first();
                        $status = $variant?->status;

                        $isOutOfStock =
                            $variant &&
                            (($status && $status->code === 'out_of_stock' && $status->type === 'product_variant') ||
                                $variant->quantity == 0);
                    @endphp
                    <div class="group">
                        <div
                            class="relative overflow-hidden shadow-sm dark:shadow-gray-800 group-hover:shadow-lg group-hover:dark:shadow-gray-800 rounded-md duration-500">
                            <a href="{{ route('products.show', $variant->id) }}">
                                <img src="{{ $product->thumbnails->where('is_primary', 1)->first() ? asset('storage/' . $product->thumbnails->where('is_primary', 1)->first()->url) : asset('assets/images/no-image.jpg') }}"
                                    class="group-hover:scale-110 duration-500 w-full h-64 object-cover"
                                    alt="{{ $product->name }}">
                            </a>

                            <div class="absolute -bottom-20 group-hover:bottom-3 start-3 end-3 duration-500">
                                @if ($variant)
                                    @if ($isOutOfStock)
                                        <button disabled
                                            class="py-2 px-5 inline-block font-semibold tracking-wide align-middle duration-500 text-base text-center bg-gray-300 text-gray-700 w-full rounded-md cursor-not-allowed">
                                            Hết Hàng
                                        </button>
                                    @else
                                        <a href="{{ route('products.show', $variant->id) }}"
                                            class="py-2 px-5 inline-block font-semibold tracking-wide align-middle duration-500 text-base text-center bg-slate-900 text-white w-full rounded-md hover:bg-slate-800 transition-colors">
                                            Xem Chi Tiết
                                        </a>
                                    @endif
                                @else
                                    <span
                                        class="py-2 px-5 inline-block font-semibold tracking-wide align-middle duration-500 text-base text-center bg-gray-300 text-gray-700 w-full rounded-md cursor-not-allowed">
                                        Liên hệ
                                    </span>
                                @endif
                            </div>

                            <!-- Nút yêu thích, xem nhanh, bookmark -->
                            <ul
                                class="list-none absolute top-[10px] end-4 opacity-0 group-hover:opacity-100 duration-500 space-y-1">
                                <li>
                                    <button onclick="toggleWishlist({{ $variant->id }}, this)"
                                        class="wishlist-btn size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow cursor-pointer"
                                        data-product-variant-id="{{ $variant->id }}">
                                        <i data-feather="heart" class="size-4"></i>
                                    </button>
                                </li>
                                <li class="mt-1"><a href="{{ route('products.show', $variant->id) }}"
                                        class="size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow"><i
                                            data-feather="eye" class="size-4"></i></a></li>
                                <li class="mt-1"><a href="javascript:void(0)"
                                        class="size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow"><i
                                            data-feather="bookmark" class="size-4"></i></a></li>
                            </ul>

                            @if ($variant && $variant->compare_price && $variant->compare_price > $variant->price)
                                <ul class="list-none absolute top-[10px] start-4">
                                    <li><span
                                            class="bg-orange-600 text-white text-[10px] font-bold px-2.5 py-0.5 rounded h-5">-{{ round(100 - ($variant->price / $variant->compare_price) * 100) }}%
                                            Giảm</span></li>
                                </ul>
                            @endif
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('products.show', $variant->id) }}" class="hover:text-orange-500 text-lg font-medium">{{ $product->name }}</a>
                            <div class="flex justify-between items-center mt-1">
                                <p>
                                    @if ($variant)
                                        <span class="text-red-600 font-semibold">{{ number_format($variant->price, 0, ',', '.') }}₫</span>
                                        @if ($variant->compare_price && $variant->compare_price > $variant->price)
                                            <del
                                                class="text-slate-400">{{ number_format($variant->compare_price, 0, ',', '.') }}₫</del>
                                        @endif
                                    @else
                                        Liên hệ
                                    @endif
                                </p>
                                @php
                                    $ratings = $product->ratings ?? collect();
                                    $averageRating = round($ratings->avg('rating') ?? 0, 1);
                                    $totalRatings = $ratings->count();
                                @endphp

                                <ul class="font-medium text-amber-400 list-none">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <li class="inline">
                                            <i class="mdi mdi-star{{ $i <= round($averageRating) ? '' : '-outline' }}"></i>
                                        </li>
                                    @endfor
                                    @if ($totalRatings > 0)
                                        <li class="inline text-slate-400 ms-1">{{ $averageRating }} ({{ $totalRatings }})</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center text-slate-400">Không có sản phẩm nào.</div>
                @endforelse
            </div>
        </div><!--end content-->

        </div><!--end grid-->
        </div><!--end container-->

        <div class="container-fluid relative md:mt-24 mt-16">
            <div class="grid grid-cols-1">
                <div
                    class="relative overflow-hidden py-24 px-4 md:px-10 bg-orange-600 bg-[url('../../assets/images/hero/bg3.html')] bg-center bg-no-repeat bg-cover">
                    <div
                        class="absolute inset-0 bg-[url('../../assets/images/hero/bg-shape.html')] bg-center bg-no-repeat bg-cover">
                    </div>
                    <div class="grid grid-cols-1 justify-center text-center relative z-1">
                        <h3 class="text-4xl leading-normal tracking-wide font-bold text-white">Thả ga mua sắm với voucher : novasmart 
                        <div id="countdown" class="mt-6">
                            <ul class="count-down list-none inline-block space-x-1">
                                <li id="days"
                                    class="text-[28px] leading-[72px] h-[80px] w-[80px] font-medium rounded-md shadow-sm shadow-gray-100 inline-block text-center text-white">
                                </li>
                                <li id="hours"
                                    class="text-[28px] leading-[72px] h-[80px] w-[80px] font-medium rounded-md shadow-sm shadow-gray-100 inline-block text-center text-white">
                                </li>
                                <li id="mins"
                                    class="text-[28px] leading-[72px] h-[80px] w-[80px] font-medium rounded-md shadow-sm shadow-gray-100 inline-block text-center text-white">
                                </li>
                                <li id="secs"
                                    class="text-[28px] leading-[72px] h-[80px] w-[80px] font-medium rounded-md shadow-sm shadow-gray-100 inline-block text-center text-white">
                                </li>
                                <li id="end" class="h1"></li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('products.list') }}"
                                class="py-2 px-5 inline-block font-semibold tracking-wide align-middle text-center bg-white text-orange-500 rounded-md"><i
                                    class="mdi mdi-cart-outline"></i> Mua Ngay</a>
                        </div>
                    </div><!--end grid-->
                </div>
            </div>
        </div><!--end container-->

        <div class="container relative md:mt-24 mt-16">
            <div class="grid grid-cols-1 mb-6">
                <div class="text-center">
                    <a href="{{ route('products.list') }}" class="hover:text-orange-500">
                        <h5 class="font-semibold text-3xl leading-normal mb-4">Sản Phẩm Phổ Biến</h5>
                        <p class="text-slate-400 max-w-xl mx-auto">Những sản phẩm phổ biến trong tuần này</p>
                    </a>
                </div>
            </div><!--end grid-->

            <div class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 pt-6 gap-6">
                @forelse($popularProducts as $product)
                    @php $variant = $product->variants->first(); @endphp
                    <div class="group">
                        <div
                            class="relative overflow-hidden shadow-sm dark:shadow-gray-800 group-hover:shadow-lg group-hover:dark:shadow-gray-800 rounded-md duration-500">
                            <a href="{{ route('products.show', $variant->id) }}">
                                <img src="{{ $product->thumbnails->where('is_primary', 1)->first() ? asset('storage/' . $product->thumbnails->where('is_primary', 1)->first()->url) : asset('assets/images/no-image.jpg') }}"
                                    class="group-hover:scale-110 duration-500 w-full h-64 object-cover"
                                    alt="{{ $product->name }}">
                            </a>
                            <div class="absolute -bottom-20 group-hover:bottom-3 start-3 end-3 duration-500">
                                @if ($variant)
                                    <a href="{{ route('products.show', $variant->id) }}"
                                        class="py-2 px-5 inline-block font-semibold tracking-wide align-middle duration-500 text-base text-center bg-slate-900 text-white w-full rounded-md hover:bg-slate-800 transition-colors">
                                        Xem Chi Tiết
                                    </a>
                                @else
                                    <span
                                        class="py-2 px-5 inline-block font-semibold tracking-wide align-middle duration-500 text-base text-center bg-gray-300 text-gray-700 w-full rounded-md cursor-not-allowed">Liên
                                        hệ</span>
                                @endif
                            </div>
                            <ul
                                class="list-none absolute top-[10px] end-4 opacity-0 group-hover:opacity-100 duration-500 space-y-1">
                                <li>
                                    <button onclick="toggleWishlist({{ $variant->id }}, this)"
                                        class="wishlist-btn size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow cursor-pointer"
                                        data-product-variant-id="{{ $variant->id }}">
                                        <i data-feather="heart" class="size-4"></i>
                                    </button>
                                </li>
                                <li class="mt-1"><a href="{{ route('products.show', $variant->id) }}"
                                        class="size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow"><i
                                            data-feather="eye" class="size-4"></i></a></li>
                                <li class="mt-1"><a href="javascript:void(0)"
                                        class="size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow"><i
                                            data-feather="bookmark" class="size-4"></i></a></li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('products.show', $variant->id) }}" class="hover:text-orange-500 text-lg font-medium">{{ $product->name }}</a>
                            <div class="flex justify-between items-center mt-1">
                                <p>
                                    @if ($variant)
                                        <span class="text-red-600 font-semibold">{{ number_format($variant->price, 0, ',', '.') }}₫</span>
                                        @if ($variant->compare_price && $variant->compare_price > $variant->price)
                                            <del
                                                class="text-slate-400">{{ number_format($variant->compare_price, 0, ',', '.') }}₫</del>
                                        @endif
                                    @else
                                        Liên hệ
                                    @endif
                                </p>
                                @php
                                    $ratings = $product->ratings ?? collect();
                                    $averageRating = round($ratings->avg('rating') ?? 0, 1);
                                    $totalRatings = $ratings->count();
                                @endphp

                                <ul class="font-medium text-amber-400 list-none">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <li class="inline">
                                            <i class="mdi mdi-star{{ $i <= round($averageRating) ? '' : '-outline' }}"></i>
                                        </li>
                                    @endfor
                                    @if ($totalRatings > 0)
                                        <li class="inline text-slate-400 ms-1">{{ $averageRating }} ({{ $totalRatings }})</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center text-slate-400">Không có sản phẩm phổ biến.</div>
                @endforelse
            </div>


        </div><!--end container-->

        <!-- Sản phẩm theo Brand -->
        @foreach($productsByBrand as $brandData)
            <div class="container relative md:mt-24 mt-16">
                <div class="grid grid-cols-1 mb-6">
                    <div class="text-center">
                        <a href="{{ route('products.list', ['brand' => $brandData['brand']->name]) }}" class="hover:text-orange-500">
                            <h5 class="font-semibold text-3xl leading-normal mb-4">Các sản phẩm từ {{ $brandData['brand']->name }}</h5>
                            <p class="text-slate-400 max-w-xl mx-auto">Khám phá những sản phẩm chất lượng từ {{ $brandData['brand']->name }}</p>
                        </a>
                    </div>
                </div><!--end grid-->

                <div class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 pt-6 gap-6">
                    @forelse($brandData['products'] as $product)
                        @php
                            $variant = $product->variants->first();
                            $status = $variant?->status;

                            $isOutOfStock =
                                $variant &&
                                (($status && $status->code === 'out_of_stock' && $status->type === 'product_variant') ||
                                    $variant->quantity == 0);
                        @endphp
                        <div class="group">
                            <div
                                class="relative overflow-hidden shadow-sm dark:shadow-gray-800 group-hover:shadow-lg group-hover:dark:shadow-gray-800 rounded-md duration-500">
                                <a href="{{ route('products.show', $variant->id) }}">
                                    <img src="{{ $product->thumbnails->where('is_primary', 1)->first() ? asset('storage/' . $product->thumbnails->where('is_primary', 1)->first()->url) : asset('assets/images/no-image.jpg') }}"
                                        class="group-hover:scale-110 duration-500 w-full h-64 object-cover"
                                        alt="{{ $product->name }}">
                                </a>

                                <div class="absolute -bottom-20 group-hover:bottom-3 start-3 end-3 duration-500">
                                    @if ($variant)
                                        @if ($isOutOfStock)
                                            <button disabled
                                                class="py-2 px-5 inline-block font-semibold tracking-wide align-middle duration-500 text-base text-center bg-gray-300 text-gray-700 w-full rounded-md cursor-not-allowed">
                                                Hết Hàng
                                            </button>
                                        @else
                                            <a href="{{ route('products.show', $variant->id) }}"
                                                class="py-2 px-5 inline-block font-semibold tracking-wide align-middle duration-500 text-base text-center bg-slate-900 text-white w-full rounded-md hover:bg-slate-800 transition-colors">
                                                Xem Chi Tiết
                                            </a>
                                        @endif
                                    @else
                                        <span
                                            class="py-2 px-5 inline-block font-semibold tracking-wide align-middle duration-500 text-base text-center bg-gray-300 text-gray-700 w-full rounded-md cursor-not-allowed">
                                            Liên hệ
                                        </span>
                                    @endif
                                </div>

                                <!-- Nút yêu thích, xem nhanh, bookmark -->
                                <ul
                                    class="list-none absolute top-[10px] end-4 opacity-0 group-hover:opacity-100 duration-500 space-y-1">
                                    <li>
                                        <button onclick="toggleWishlist({{ $variant->id }}, this)"
                                            class="wishlist-btn size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow cursor-pointer"
                                            data-product-variant-id="{{ $variant->id }}">
                                            <i data-feather="heart" class="size-4"></i>
                                        </button>
                                    </li>
                                    <li class="mt-1"><a href="{{ route('products.show', $variant->id) }}"
                                            class="size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow"><i
                                                data-feather="eye" class="size-4"></i></a></li>
                                    <li class="mt-1"><a href="javascript:void(0)"
                                            class="size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow"><i
                                                data-feather="bookmark" class="size-4"></i></a></li>
                                </ul>

                                @if ($variant && $variant->compare_price && $variant->compare_price > $variant->price)
                                    <ul class="list-none absolute top-[10px] start-4">
                                        <li><span
                                                class="bg-orange-600 text-white text-[10px] font-bold px-2.5 py-0.5 rounded h-5">-{{ round(100 - ($variant->price / $variant->compare_price) * 100) }}%
                                                Giảm</span></li>
                                    </ul>
                                @endif
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('products.show', $variant->id) }}" class="hover:text-orange-500 text-lg font-medium">{{ $product->name }}</a>
                                <div class="flex justify-between items-center mt-1">
                                    <p>
                                        @if ($variant)
                                            <span class="text-red-600 font-semibold">{{ number_format($variant->price, 0, ',', '.') }}₫</span>
                                            @if ($variant->compare_price && $variant->compare_price > $variant->price)
                                                <del
                                                    class="text-slate-400">{{ number_format($variant->compare_price, 0, ',', '.') }}₫</del>
                                            @endif
                                        @else
                                            Liên hệ
                                        @endif
                                    </p>
                                    @php
                                        $ratings = $product->ratings ?? collect();
                                        $averageRating = round($ratings->avg('rating') ?? 0, 1);
                                        $totalRatings = $ratings->count();
                                    @endphp

                                    <ul class="font-medium text-amber-400 list-none">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <li class="inline">
                                                <i class="mdi mdi-star{{ $i <= round($averageRating) ? '' : '-outline' }}"></i>
                                            </li>
                                        @endfor
                                        @if ($totalRatings > 0)
                                            <li class="inline text-slate-400 ms-1">{{ $averageRating }} ({{ $totalRatings }})</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-4 text-center text-slate-400">Không có sản phẩm nào cho {{ $brandData['brand']->name }}.</div>
                    @endforelse
                </div>


            </div><!--end container-->
        @endforeach

        {{-- <div class="container relative">
            <div class="grid grid-cols-1 justify-center text-center  mb-6">
                <h5 class="font-semibold text-3xl leading-normal  mb-4">Các thương hiệu được yêu thích nhất</h5>
                <p class="text-slate-400 max-w-xl mx-auto">Mua sắm những sản phẩm mới nhất từ các thương hiệu được yêu
                    thích nhất</p>
            </div><!--end grid--> --}}

            {{-- <div class="grid lg:grid-cols-5 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 pt-6 gap-6">
                <a href="#" class="text-center hover:text-orange-500">
                    <img src="{{ asset('assets/user/images/categories/acer.png') }}"
                        class="rounded-full shadow-sm dark:shadow-gray-800" alt="">
                    <span class="text-xl font-medium mt-3 block">Acer</span>
                </a>

                <a href="#" class="text-center hover:text-orange-500">
                    <img src="{{ asset('assets/user/images/categories/asus.png') }}"
                        class="rounded-full shadow-sm dark:shadow-gray-800" alt="">
                    <span class="text-xl font-medium mt-3 block">Asus</span>
                </a>

                <a href="#" class="text-center hover:text-orange-500">
                    <img src="{{ asset('assets/user/images/categories/apple.png') }}"
                        class="rounded-full shadow-sm dark:shadow-gray-800" alt="">
                    <span class="text-xl font-medium mt-3 block">Apple</span>
                </a>

                <a href="#" class="text-center hover:text-orange-500">
                    <img src="{{ asset('assets/user/images/categories/msi.png') }}"
                        class="rounded-full shadow-sm dark:shadow-gray-800" alt="">
                    <span class="text-xl font-medium mt-3 block">MSI</span>
                </a>

                <a href="#" class="text-center hover:text-orange-500">
                    <img src="{{ asset('assets/user/images/categories/samsung.png') }}"
                        class="rounded-full shadow-sm dark:shadow-gray-800" alt="">
                    <span class="text-xl font-medium mt-3 block">SAMSUNG</span>
                </a>
            </div><!--end grid--> --}}
        </div><!--end container-->
    </section><!--end section-->
    <style>
.custom-toast {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    min-width: 260px;
    max-width: 360px;
    background-color: #16a34a;
    color: #fff;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    animation: slideIn 0.3s ease-out;
    font-size: 14px;
    line-height: 1.4;
    transition: opacity 0.4s ease-out;
}

.toast-icon {
    width: 20px;
    height: 20px;
    stroke: #fff;
}

.toast-message {
    flex: 1;
    font-weight: 600;
}

.toast-close {
    background: transparent;
    border: none;
    color: #fff;
    cursor: pointer;
}

.toast-close-icon {
    width: 16px;
    height: 16px;
    stroke: #fff;
}

.toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 4px;
    background-color: #a3e635;
    animation: progressBar 4s linear forwards;
    width: 100%;
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(50%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes progressBar {
    from {
        width: 100%;
    }
    to {
        width: 0%;
    }
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
    </style>
<script src="{{ asset('assets/user/js/shop-cart.js') }}"></script>
@endsection
