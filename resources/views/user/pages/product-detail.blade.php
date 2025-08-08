@extends('user.layouts.client')
@include('user.partials.popup')
@section('title', $product->product->name)
@section('meta_description', $product->product->description)

@section('content')
@include('user.partials.product-detail-styles')
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
                    <ul class="product-imgs flex list-none items-start gap-4">
                        <li>
                            <ul class="img-select list-none space-y-2">
                                @if ($product->product->thumbnails->count() > 0)
                                    @foreach ($product->product->thumbnails as $index => $thumbnail)
                                        <li class="p-px">
                                            <a href="#" data-id="{{ $index + 1 }}" class="block">
                                                <img src="{{ asset('storage/' . $thumbnail->url) }}" 
                                                     class="shadow-sm dark:shadow-gray-800 w-20 h-20 object-cover rounded cursor-pointer hover:opacity-80 transition-opacity" 
                                                     alt="{{ $product->product->name }}"
                                                     onerror="this.src='{{ asset('assets/user/images/shop/mens-jecket.jpg') }}'; this.onerror=null;">
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="p-px">
                                        <a href="#" data-id="1" class="block">
                                            <img src="{{ asset('assets/user/images/shop/mens-jecket.jpg') }}" 
                                                 class="shadow-sm dark:shadow-gray-800 w-20 h-20 object-cover rounded cursor-pointer hover:opacity-80 transition-opacity" 
                                                 alt="{{ $product->product->name }}">
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>

                        <li class="flex-1 overflow-hidden shadow-sm dark:shadow-gray-800 rounded">
                            <div class="img-showcase flex w-full duration-500">
                                @if ($product->product->thumbnails->count() > 0)
                                    @foreach ($product->product->thumbnails as $thumbnail)
                                        <img src="{{ asset('storage/' . $thumbnail->url) }}" 
                                             class="min-w-full h-96 object-cover flex-shrink-0" 
                                             alt="{{ $product->product->name }}"
                                             onerror="this.src='{{ asset('assets/user/images/shop/mens-jecket.jpg') }}'; this.onerror=null;">
                                    @endforeach
                                @else
                                    <img src="{{ asset('assets/user/images/shop/mens-jecket.jpg') }}" 
                                         class="min-w-full h-96 object-cover flex-shrink-0" 
                                         alt="{{ $product->product->name }}">
                                @endif
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="lg:col-span-7">
                    <div class="lg:ms-6 sticky top-20">
                        <h5 class="text-2xl font-semibold">{{ $product->product->name }}</h5>
                        <div class="mt-2">
                            <span class="text-red-600 font-semibold me-1" style="color: #dc2626 !important;">{{ number_format($product->price) }} VNĐ</span>

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

                                <div class="mt-4 flex gap-4">
                                    <button type="submit"
                                        class="btn-add-cart py-3 px-6 inline-block font-semibold tracking-wide align-middle text-base text-center rounded-md bg-orange-500 hover:bg-orange-600 text-white transition-all duration-300 shadow-sm hover:shadow-md">
                                        <i data-feather="shopping-cart" class="size-4 me-2 inline"></i>
                                        Thêm vào giỏ
                                    </button>
                                    <button type="button" onclick="toggleWishlist({{ $product->id }}, this)"
                                        class="wishlist-btn py-3 px-6 inline-flex items-center justify-center font-semibold tracking-wide align-middle text-base text-center rounded-md bg-gray-100 text-gray-700 transition-all duration-300 cursor-pointer shadow-sm hover:shadow-md"
                                        data-product-variant-id="{{ $product->id }}">
                                        <i data-feather="heart" class="size-4 me-2"></i>
                                        <span class="wishlist-text">Yêu thích</span>
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

                        <!-- Product Variants Section -->
                        @if ($relatedVariants->count() > 0)
                            <div class="mt-6">
                                <h5 class="text-lg font-semibold mb-4 text-slate-900 dark:text-white">Các biến thể khác:</h5>
                                <div class="flex gap-4 overflow-x-auto pb-2 scrollbar-hide">
                                    @foreach ($relatedVariants as $variant)
                                        @php
                                            // Lấy tên biến thể hoặc SKU
                                            $variantName = $variant->sku ?? 'Biến thể ' . $loop->iteration;
                                            
                                            // Lấy hình ảnh thumbnail
                                            $thumbnail = $variant->product->thumbnails->first();
                                            $imageUrl = $thumbnail ? asset('storage/' . $thumbnail->url) : asset('assets/user/images/shop/mens-jecket.jpg');
                                        @endphp
                                        
                                        <a href="javascript:void(0)" 
                                           data-variant-id="{{ $variant->id }}"
                                           class="variant-option border-2 rounded-lg p-3 transition-all duration-300 flex-shrink-0 cursor-pointer
                                                  {{ $variant->id === $product->id ? 'selected border-green-500 bg-green-50' : 'border-gray-200 hover:border-orange-500 hover:bg-gray-50' }}">
                                            
                                            <!-- Hình ảnh -->
                                            <div class="w-10 h-10 mb-2">
                                                <img src="{{ $imageUrl }}" 
                                                     class="w-full h-full object-cover rounded" 
                                                     alt="{{ $variant->product->name }}"
                                                     loading="lazy"
                                                     onerror="this.src='{{ asset('assets/user/images/shop/mens-jecket.jpg') }}'; this.onerror=null;" />
                                            </div>
                                            
                                            <!-- Tên biến thể -->
                                            <div class="text-xs font-medium text-center text-gray-800 mb-1">{{ $variantName }}</div>
                                            
                                            <!-- Giá -->
                                            <div class="text-xs text-red-600 font-semibold text-center">{{ number_format($variant->price) }} ₫</div>
                                            

                                        </a>
                                    @endforeach
                                </div>
                            </div>
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
                                                    <span class="wishlist-text">Yêu thích</span>
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
                        <h3 class="font-semibold text-3xl leading-normal">Các mẫu khác mời bạn tham khảo:</h3>
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

    @include('user.partials.product-detailjs')
    <script src="{{ asset('assets/user/js/shop-cart.js') }}"></script>
    
    @include('user.partials.product-detail-script')
@endsection
