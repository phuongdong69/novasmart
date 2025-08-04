@extends('user.layouts.client')
@include('user.partials.popup')
@section('title', $product->product->name)
@section('meta_description', $product->product->description)

@section('content')
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check wishlist status for this product
            const wishlistBtn = document.querySelector('.wishlist-btn');
            if (wishlistBtn && isAuthenticated()) {
                const productVariantId = wishlistBtn.getAttribute('data-product-variant-id');
                
                fetch('/wishlist/check', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_variant_id: productVariantId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.is_liked) {
                        wishlistBtn.classList.add('liked');
                        wishlistBtn.style.backgroundColor = '#ef4444';
                        wishlistBtn.style.color = 'white';
                        // Update text if exists
                        const textElement = wishlistBtn.querySelector('.wishlist-text');
                        if (textElement) {
                            textElement.textContent = 'Đã yêu thích';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking wishlist status:', error);
                });
            }
        });
    </script>
@endpush
    <!-- Start Hero -->
    @if (session('success'))
        <div id="toast-success" class="custom-toast">
            <svg class="toast-icon" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <span class="toast-message">{{ session('success') }}</span>
            <button class="toast-close" onclick="this.parentElement.remove()">
                <svg xmlns="http://www.w3.org/2000/svg" class="toast-close-icon" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="toast-progress"></div>
        </div>
    @endif
    <section class="relative table w-full py-20 lg:py-24 md:pt-28 bg-gray-50 dark:bg-slate-800">
        <div class="container relative">
            <div class="grid grid-cols-1 mt-14">
                <h3 class="text-3xl leading-normal font-semibold">{{ $product->product->name }}</h3>
            </div>

            <div class="relative mt-3">
                <ul class="tracking-[0.5px] mb-0 inline-block">
                    <li class="inline-block uppercase text-[13px] font-bold duration-500 ease-in-out hover:text-orange-500">
                        <a href="{{ route('home') }}">Trang Chủ</a></li>
                    <li class="inline-block text-base text-slate-950 dark:text-white mx-0.5"><i
                            class="mdi mdi-chevron-right"></i></li>
                    <li class="inline-block uppercase text-[13px] font-bold duration-500 ease-in-out hover:text-orange-500">
                        <a href="{{ route('products.list') }}">Cửa Hàng</a></li>
                    <li class="inline-block text-base text-slate-950 dark:text-white mx-0.5"><i
                            class="mdi mdi-chevron-right"></i></li>
                    <li class="inline-block uppercase text-[13px] font-bold text-orange-500" aria-current="page">
                        {{ $product->product->name }}</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- End Hero -->

    <!-- Start -->
    <section class="relative md:py-24 py-16">
        <div class="container relative">
            <div class="grid lg:grid-cols-12 md:grid-cols-2 grid-cols-1 gap-6">
                <div class="lg:col-span-5">
                    <div class="grid md:grid-cols-12 gap-3">
                        @if ($product->product->thumbnails->count() > 0)
                            @foreach ($product->product->thumbnails as $index => $thumbnail)
                                <div class="{{ $index === 0 ? 'md:col-span-12' : 'md:col-span-6' }}">
                                    <a href="{{ asset('storage/' . $thumbnail->url) }}"
                                        class="lightbox duration-500 group-hover:scale-105 block"
                                        title="{{ $product->product->name }}">
                                        <img src="{{ asset('storage/' . $thumbnail->url) }}"
                                            class="w-full h-64 object-cover shadow-sm dark:shadow-gray-700 rounded-md hover:scale-105 transition-transform duration-300"
                                            alt="{{ $product->product->name }}" loading="lazy"
                                            onerror="this.src='{{ asset('assets/user/images/shop/mens-jecket.jpg') }}'; this.onerror=null;">
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <!-- Fallback image if no thumbnails -->
                            <div class="md:col-span-12">
                                <img src="{{ asset('assets/user/images/shop/mens-jecket.jpg') }}"
                                    class="w-full h-64 object-cover shadow-sm dark:shadow-gray-700 rounded-md"
                                    alt="{{ $product->product->name }}">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div class="lg:ms-6 sticky top-20">
                        <h5 class="text-2xl font-semibold">{{ $product->product->name }}</h5>
                        <div class="mt-2">
                            <span class="text-slate-400 font-semibold me-1">{{ number_format($product->price) }} VNĐ</span>

                            <ul class="list-none inline-block text-orange-400">
                                <li class="inline"><i class="mdi mdi-star text-lg"></i></li>
                                <li class="inline"><i class="mdi mdi-star text-lg"></i></li>
                                <li class="inline"><i class="mdi mdi-star text-lg"></i></li>
                                <li class="inline"><i class="mdi mdi-star text-lg"></i></li>
                                <li class="inline"><i class="mdi mdi-star text-lg"></i></li>
                                <li class="inline text-slate-400 font-semibold">4.8 (45)</li>
                            </ul>
                        </div>

                        <div class="mt-4">
                            <h5 class="text-lg font-semibold">Mô tả:</h5>
                            <p class="text-slate-400 mt-2">
                                {{ $product->product->description ?? 'Chưa có mô tả cho sản phẩm này.' }}</p>

                            <ul class="list-none text-slate-400 mt-4">
                                <li class="mb-1 flex"><i
                                        class="mdi mdi-check-circle-outline text-orange-500 text-xl me-2"></i> Thương hiệu:
                                    {{ $product->product->brand->name ?? 'N/A' }}</li>
                                <li class="mb-1 flex"><i
                                        class="mdi mdi-check-circle-outline text-orange-500 text-xl me-2"></i> Xuất xứ:
                                    {{ $product->product->origin->country ?? 'N/A' }}</li>
                                <li class="mb-1 flex"><i
                                        class="mdi mdi-check-circle-outline text-orange-500 text-xl me-2"></i> Danh mục:
                                    {{ $product->product->category->name ?? 'N/A' }}</li>
                            </ul>
                        </div>

                        <div class="grid lg:grid-cols-2 grid-cols-1 gap-6 mt-4">
                            @php
                                $sizeAttribute = $product->variantAttributeValues
                                    ->where('attribute.name', 'like', '%size%')
                                    ->first();
                                $colorAttribute = $product->variantAttributeValues
                                    ->where('attribute.name', 'like', '%màu%')
                                    ->first();
                            @endphp

                            @if ($sizeAttribute)
                                <div class="flex items-center">
                                    <h5 class="text-lg font-semibold me-2">Kích thước:</h5>
                                    <div class="space-x-1">
                                        @foreach ($relatedVariants as $variant)
                                            @php
                                                $variantSize = $variant->variantAttributeValues
                                                    ->where('attribute.name', 'like', '%size%')
                                                    ->first();
                                            @endphp
                                            @if ($variantSize)
                                                <a href="{{ route('products.show', $variant->id) }}"
                                                    class="size-9 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md {{ $variant->id === $product->id ? 'bg-orange-500 text-white' : 'bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white' }}">
                                                    {{ $variantSize->attributeValue->value }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($colorAttribute)
                                <div class="flex items-center">
                                    <h5 class="text-lg font-semibold me-2">Màu sắc:</h5>
                                    <div class="space-x-2">
                                        @foreach ($relatedVariants as $variant)
                                            @php
                                                $variantColor = $variant->variantAttributeValues
                                                    ->where('attribute.name', 'like', '%màu%')
                                                    ->first();
                                            @endphp
                                            @if ($variantColor)
                                                <a href="{{ route('products.show', $variant->id) }}"
                                                    class="size-6 rounded-full ring-2 ring-gray-200 dark:ring-slate-800 {{ $variant->id === $product->id ? 'ring-orange-500' : '' }} inline-flex align-middle"
                                                    title="{{ $variantColor->attributeValue->value }}"
                                                    style="background-color: {{ $variantColor->attributeValue->value }};">
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        @php

                            $status = $product?->status;

                            $isOutOfStock =
                                $product &&
                                (($status && $status->code === 'out_of_stock' && $status->type === 'product_variant') ||
                                    $product->quantity == 0);
                        @endphp
                        @if ($product && !$isOutOfStock)
                            <form action="{{ route('cart.add') }}" method="POST" class="mt-4 space-y-3">
                                @csrf
                                <input type="hidden" name="product_variant_id" value="{{ $product->id }}">

                                <div class="flex items-center">
                                    <h5 class="text-lg font-semibold me-2">Số lượng:</h5>
                                    <div class="qty-icons ms-3 space-x-0.5">
                                        <button type="button"
                                            onclick="this.parentNode.querySelector('input[type=number]').stepDown()"
                                            class="size-9 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white minus">-</button>

                                        <input min="1" name="quantity" value="1" type="number"
                                            class="h-9 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white pointer-events-none w-16 ps-4 quantity">

                                        <button type="button"
                                            onclick="this.parentNode.querySelector('input[type=number]').stepUp()"
                                            class="size-9 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white plus">+</button>
                                    </div>
                                </div>

                                <div class="mt-2 flex gap-2">
                                    <button type="submit"
                                        class="btn-add-cart py-2 px-5 inline-block font-semibold tracking-wide align-middle text-base text-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white">
                                        Thêm vào giỏ
                                    </button>
                                    <button type="button" onclick="toggleWishlist({{ $product->id }}, this)"
                                        class="wishlist-btn py-2 px-5 inline-flex items-center justify-center font-semibold tracking-wide align-middle text-base text-center rounded-md bg-gray-100 hover:bg-red-500 text-gray-700 hover:text-white transition-colors duration-300 cursor-pointer"
                                        data-product-variant-id="{{ $product->id }}">
                                        <i data-feather="heart" class="size-4 me-2"></i>
                                        Yêu thích
                                    </button>
                                </div>
                            </form>
                        @elseif ($isOutOfStock)
                            <button disabled
                                class="py-2 px-5 inline-block font-semibold tracking-wide align-middle duration-500 text-base text-center bg-gray-300 text-gray-700 w-full rounded-md cursor-not-allowed">
                                Hết hàng
                            </button>
                        @else
                            <span
                                class="py-2 px-2 inline-block font-semibold tracking-wide align-middle duration-500 text-base text-center bg-gray-300 text-gray-700 w-full rounded-md cursor-not-allowed">
                                Liên hệ
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-12 grid-cols-1 mt-6 gap-6">
                <div class="lg:col-span-3 md:col-span-5">
                    <div class="sticky top-20">
                        <ul class="flex-column p-6 bg-white dark:bg-slate-900 shadow-sm dark:shadow-gray-800 rounded-md"
                            id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                            <li role="presentation">
                                <button
                                    class="px-4 py-2 text-start text-base font-semibold rounded-md w-full hover:text-orange-500 duration-500"
                                    id="description-tab" data-tabs-target="#description" type="button" role="tab"
                                    aria-controls="description" aria-selected="true">Mô tả</button>
                            </li>
                            <li role="presentation">
                                <button
                                    class="px-4 py-2 text-start text-base font-semibold rounded-md w-full mt-3 duration-500"
                                    id="addinfo-tab" data-tabs-target="#addinfo" type="button" role="tab"
                                    aria-controls="addinfo" aria-selected="false">Thông tin bổ sung</button>
                            </li>
                            <li role="presentation">
                                <button
                                    class="px-4 py-2 text-start text-base font-semibold rounded-md w-full mt-3 duration-500"
                                    id="review-tab" data-tabs-target="#review" type="button" role="tab"
                                    aria-controls="review" aria-selected="false">Đánh giá</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="lg:col-span-9 md:col-span-7">
                    <div id="myTabContent"
                        class="p-6 bg-white dark:bg-slate-900 shadow-sm dark:shadow-gray-800 rounded-md">
                        <div class="" id="description" role="tabpanel" aria-labelledby="profile-tab">
                            <p class="text-slate-400">
                                {{ $product->product->description ?? 'Chưa có mô tả chi tiết cho sản phẩm này.' }}</p>
                        </div>

                        <div class="hidden" id="addinfo" role="tabpanel" aria-labelledby="addinfo-tab">
                            <table class="w-full text-start">
                                <tbody>
                                    <tr class="bg-white dark:bg-slate-900">
                                        <td class="font-semibold pb-4" style="width: 100px;">Thương hiệu</td>
                                        <td class="text-slate-400 pb-4">{{ $product->product->brand->name ?? 'N/A' }}</td>
                                    </tr>

                                    <tr class="bg-white dark:bg-slate-900 border-t border-gray-100 dark:border-gray-700">
                                        <td class="font-semibold py-4">Xuất xứ</td>
                                        <td class="text-slate-400 py-4">{{ $product->product->origin->country ?? 'N/A' }}
                                        </td>
                                    </tr>

                                    <tr class="bg-white dark:bg-slate-900 border-t border-gray-100 dark:border-gray-700">
                                        <td class="font-semibold pt-4">Danh mục</td>
                                        <td class="text-slate-400 pt-4">{{ $product->product->category->name ?? 'N/A' }}
                                        </td>
                                    </tr>

                                    <tr class="bg-white dark:bg-slate-900 border-t border-gray-100 dark:border-gray-700">
                                        <td class="font-semibold pt-4">SKU</td>
                                        <td class="text-slate-400 pt-4">{{ $product->sku }}</td>
                                    </tr>

                                    <tr class="bg-white dark:bg-slate-900 border-t border-gray-100 dark:border-gray-700">
                                        <td class="font-semibold pt-4">Tồn kho</td>
                                        <td class="text-slate-400 pt-4">{{ $product->quantity }} sản phẩm</td>
                                    </tr>

                                    @auth
                                        <tr class="bg-white dark:bg-slate-900 border-t border-gray-100 dark:border-gray-700">
                                            <td class="font-semibold pt-4">Yêu thích</td>
                                            <td class="text-slate-400 pt-4">
                                                <button onclick="toggleWishlist({{ $product->id }}, this)"
                                                    class="wishlist-btn inline-flex items-center px-3 py-1 rounded-md text-sm font-medium transition-colors duration-300 cursor-pointer"
                                                    data-product-variant-id="{{ $product->id }}">
                                                    <i data-feather="heart" class="size-4 me-1"></i>
                                                    <span class="wishlist-text">Thêm vào yêu thích</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endauth
                                </tbody>
                            </table>
                        </div>

                        <div class="hidden" id="review" role="tabpanel" aria-labelledby="review-tab">
                            <div class="text-center py-8">
                                <p class="text-slate-400">Chưa có đánh giá nào cho sản phẩm này.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($relatedVariants->count() > 0)
                <div class="container lg:mt-24 mt-16">
                    <div class="grid grid-cols-1 mb-6 text-center">
                        <h3 class="font-semibold text-3xl leading-normal">Các sản phẩm tương tự</h3>
                    </div>

                    <div class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6 pt-6">
                        @foreach ($relatedVariants->take(4) as $variant)
                            <div class="group">
                                <div
                                    class="relative overflow-hidden shadow-sm dark:shadow-gray-800 group-hover:shadow-lg group-hover:dark:shadow-gray-800 rounded-md duration-500">
                                    @if ($variant->product->thumbnails->count() > 0)
                                        <img src="{{ asset('storage/' . $variant->product->thumbnails->first()->url) }}"
                                            class="w-full h-32 object-cover group-hover:scale-110 duration-500"
                                            alt="{{ $variant->product->name }}" loading="lazy"
                                            onerror="this.src='{{ asset('assets/user/images/shop/mens-jecket.jpg') }}'; this.onerror=null;">
                                    @else
                                        <img src="{{ asset('assets/user/images/shop/mens-jecket.jpg') }}"
                                            class="w-full h-32 object-cover group-hover:scale-110 duration-500"
                                            alt="{{ $variant->product->name }}">
                                    @endif

                                    <div class="absolute -bottom-20 group-hover:bottom-3 start-3 end-3 duration-500">
                                        <a href="{{ route('products.show', $variant->id) }}"
                                            class="py-2 px-5 inline-block font-semibold tracking-wide align-middle duration-500 text-base text-center bg-slate-900 text-white w-full rounded-md">Xem
                                            chi tiết</a>
                                    </div>

                                    <ul
                                        class="list-none absolute top-[10px] end-4 opacity-0 group-hover:opacity-100 duration-500 space-y-1">
                                        <li><a href="javascript:void(0)"
                                                class="size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow"><i
                                                    data-feather="heart" class="size-4"></i></a></li>
                                        <li class="mt-1"><a href="{{ route('products.show', $variant->id) }}"
                                                class="size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow"><i
                                                    data-feather="eye" class="size-4"></i></a></li>
                                        <li class="mt-1"><a href="javascript:void(0)"
                                                class="size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow"><i
                                                    data-feather="bookmark" class="size-4"></i></a></li>
                                    </ul>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('products.show', $variant->id) }}"
                                        class="hover:text-orange-500 text-lg font-medium">{{ $variant->product->name }}</a>
                                    <div class="flex justify-between items-center mt-1">
                                        <p class="font-semibold text-orange-500">{{ number_format($variant->price) }} VNĐ
                                        </p>
                                        <ul class="font-medium text-amber-400 list-none">
                                            <li class="inline"><i class="mdi mdi-star"></i></li>
                                            <li class="inline"><i class="mdi mdi-star"></i></li>
                                            <li class="inline"><i class="mdi mdi-star"></i></li>
                                            <li class="inline"><i class="mdi mdi-star"></i></li>
                                            <li class="inline"><i class="mdi mdi-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- End -->
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
    </style>
    @include('user.partials.product-detailjs')
    <script src="{{ asset('assets/user/js/shop-cart.js') }}"></script>
@endsection
