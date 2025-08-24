@extends('user.layouts.client')
@include('user.partials.popup')
@include('user.partials.popup-review')
@include('user.partials.toast')
@section('title', $product->product->name)
@section('meta_description', $product->product->description)

@section('content')
@include('user.partials.product-detail-styles')
    <!-- Start Hero -->
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

                            @php
                                $ratings = $product->ratings()->with('user')->orderByDesc('created_at')->get();
                                $totalRatings = $ratings->count();
                                $averageRating = round($ratings->avg('rating') ?? 0, 1); // VD: 4.8
                            @endphp

                            <ul class="list-none inline-block text-orange-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    <li class="inline">
                                        <i class="mdi mdi-star{{ $i <= round($averageRating) ? '' : '-outline' }} text-lg"></i>
                                    </li>
                                @endfor
                                <li class="inline text-slate-400 font-semibold ms-1">
                                    {{ number_format($averageRating, 1) }} ({{ $totalRatings }})
                                </li>
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
                            <!-- Product Variants Section -->
                            @if ($relatedVariants->count() > 0)
                                <div class="mt-4 mb-4">
                                    <h5 class="text-lg font-semibold mb-3 text-slate-900 dark:text-white">Các biến thể khác:</h5>
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

                            <div class="mt-4 flex gap-4">
                                <form action="{{ route('cart.add') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="product_variant_id" value="{{ $product->id }}">
                                    <button type="submit"
                                        class="btn-add-cart py-3 px-6 inline-block font-semibold tracking-wide align-middle text-base text-center rounded-md bg-orange-500 hover:bg-orange-600 text-white transition-all duration-300 shadow-sm hover:shadow-md">
                                        <i data-feather="shopping-cart" class="size-4 me-2 inline"></i>
                                        Thêm vào giỏ
                                    </button>
                                </form>
                                <form action="{{ route('cart.buyNow') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="product_variant_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit"
                                        class="py-3 px-6 inline-block font-semibold tracking-wide align-middle text-base text-center rounded-md bg-red-600 hover:bg-red-700 text-white transition-all duration-300 shadow-sm hover:shadow-md">
                                        <i data-feather="credit-card" class="size-4 me-2 inline"></i>
                                        Mua ngay
                                    </button>
                                </form>
                                <button type="button" onclick="toggleWishlist({{ $product->id }}, this)"
                                    class="wishlist-btn py-3 px-6 inline-flex items-center justify-center font-semibold tracking-wide align-middle text-base text-center rounded-md bg-gray-100 text-gray-700 transition-all duration-300 cursor-pointer shadow-sm hover:shadow-md"
                                    data-product-variant-id="{{ $product->id }}">
                                    <i data-feather="heart" class="size-4 me-2"></i>
                                    <span class="wishlist-text">Yêu thích</span>
                                </button>
                            </div>
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
                                                    <span class="wishlist-text">Yêu thích</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endauth
                                </tbody>
                            </table>
                        </div>

                       <div id="review" role="tabpanel" aria-labelledby="review-tab">

    @php
    use Carbon\Carbon;
    use App\Models\Comment;

    Carbon::setLocale('vi');

    // Chỉ lấy ratings có status active + type review
    $ratings = $product->ratings()
        ->with(['user', 'status'])
        ->whereHas('status', function ($q) {
            $q->where('code', 'active')->where('type', 'review');
        })
        ->orderByDesc('created_at')
        ->get();

    // Lấy comment có status active + type review, khớp user + order_detail
    $comments = Comment::with('status')
        ->whereHas('status', function ($q) {
            $q->where('code', 'active')->where('type', 'review');
        })
        ->whereIn('user_id', $ratings->pluck('user_id'))
        ->whereIn('order_detail_id', $ratings->pluck('order_detail_id'))
        ->get()
        ->mapWithKeys(function ($comment) {
            return [$comment->user_id . '-' . $comment->order_detail_id => $comment];
        });

    $totalRatings = $ratings->count();
    $averageRating = $ratings->avg('rating') ?? 0;

    $ratingBreakdown = [
        5 => $ratings->where('rating', 5)->count(),
        4 => $ratings->where('rating', 4)->count(),
        3 => $ratings->where('rating', 3)->count(),
        2 => $ratings->where('rating', 2)->count(),
        1 => $ratings->where('rating', 1)->count(),
    ];

    $starFilter = request()->query('star');
    $isReload = request()->header('referer') === request()->fullUrl();

    $currentStar = (in_array($starFilter, ['1','2','3','4','5']) && !$isReload)
        ? $starFilter
        : 'all';

    $filteredRatings = $currentStar !== 'all'
        ? $ratings->filter(fn($r) => $r->rating == $currentStar)->values()
        : $ratings;
@endphp

   {{-- Tổng quan đánh giá --}}
<div class="bg-white rounded-md p-6 shadow border mb-6">
    <div class="flex flex-row items-center gap-6">
        {{-- Trái: Trung bình điểm --}}
        <div class="w-1/3 text-center">
            <div id="average-rating" class="text-5xl font-bold text-gray-900">
                {{ number_format($averageRating, 1) }} <span class="text-xl text-gray-500">/5</span>
            </div>

            <div id="average-rating-icons" class="flex justify-center text-yellow-400 text-xl mt-1">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="mdi mdi-star{{ $i <= round($averageRating) ? '' : '-outline' }}"></i>
                @endfor
            </div>

            <div id="total-rating-count" class="text-gray-600 mt-1">
                {{ $totalRatings }} lượt đánh giá
            </div>

        <button
            onclick="openReviewModal({{ $product->id }})"
            class="btn-write-review mt-3 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-md text-sm"
            data-product-variant-id="{{ $product->id }}">
            Viết đánh giá
        </button>
        </div>

        {{-- Biểu đồ sao --}}
        <div class="flex-1 space-y-2">
            @foreach ([5, 4, 3, 2, 1] as $star)
                @php
                    $count = $ratingBreakdown[$star];
                    $percent = $totalRatings ? ($count / $totalRatings) * 100 : 0;
                @endphp
                <div id="star-bar-icon"class="flex items-center gap-2">
                    <span class="w-4 text-sm font-medium">{{ $star }}</span>
                    <i class="mdi mdi-star text-yellow-400 text-sm"></i>
                    <div class="flex-1 bg-gray-200 rounded-full overflow-hidden relative" style="height: 8px;">
                        <div class="bg-red-600 rounded-full rating-bar" data-star="{{ $star }}" style="width: {{ $percent }}%; height: 100%;"></div>
                    </div>
                  
                    <span class="w-20 text-sm text-gray-500 text-right rating-count" data-star="{{ $star }}">
                        {{ $count }} đánh giá
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>

   {{-- Lọc đánh giá --}}
<div class="bg-white rounded-md p-4 shadow border mb-4">
    <h4 class="text-base font-semibold mb-3">Lọc đánh giá theo</h4>
    <div class="flex flex-wrap gap-2" id="review-filter-buttons">
    @foreach (['all' => 'Tất cả', 5 => '5 sao', 4 => '4 sao', 3 => '3 sao', 2 => '2 sao', 1 => '1 sao'] as $value => $label)
        <button type="button"
            data-star="{{ $value }}"
            class="px-4 py-1 border rounded-full text-sm filter-button
                {{ $currentStar == $value ? 'bg-blue-100 text-blue-600 border-blue-600' : 'hover:bg-gray-100 text-gray-700' }}">
            {{ $label }}
        </button>
    @endforeach
</div>

    {{-- Danh sách đánh giá --}}
    @if ($filteredRatings->count())
        <div class="bg-white rounded-md p-4 mb-6" id="review-list-container">
            @foreach ($filteredRatings as $loopIndex => $rating)
                @php
                    $user = $rating->user;
                    $commentKey = $rating->user_id . '-' . $rating->order_detail_id;
                    $comment = $comments[$commentKey] ?? null;
                    $initial = $user ? strtoupper(mb_substr($user->name, 0, 1)) : 'U';
                    $name = $user->name ?? 'Ẩn danh';
                    $createdTime = $comment?->created_at ?? $rating->created_at;
                @endphp

                <div class="py-4 review-item {{ $loopIndex > 3 ? 'hidden' : '' }}">
                    <div class="flex items-start gap-4">
                        {{-- Avatar --}}
                        @if ($user && $user->image_user)
                            <img src="{{ asset('storage/' . $user->image_user) }}" class="w-10 h-10 rounded-full object-cover" alt="{{ $name }}">
                        @else
                            <img src="{{ asset('images/default-avatar.png') }}" class="w-10 h-10 rounded-full object-cover" alt="Avatar mặc định">
                        @endif

                        {{-- Nội dung đánh giá --}}
                        <div class="flex-1">
                            <div class="flex items-center gap-2 flex-wrap mb-1">
                                <span class="font-medium text-gray-900">{{ $name }}</span>
                                <div class="flex items-center text-yellow-500 text-sm">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="mdi mdi-star{{ $i <= $rating->rating ? '' : '-outline' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-600 font-medium">
                                    @switch($rating->rating)
                                        @case(5) - Tuyệt vời @break
                                        @case(4) - Tốt @break
                                        @case(3) - Bình thường @break
                                        @case(2) - Tệ @break
                                        @case(1) - Rất tệ @break
                                        @default -
                                    @endswitch
                                </span>
                            </div>

                            @if ($comment && $comment->content)
                                <p class="text-sm text-gray-800 mt-2">{{ $comment->content }}</p>
                            @endif

                            <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                <i class="mdi mdi-clock-outline"></i>
                                Đánh giá đã đăng vào {{ $createdTime->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>

                @if (!$loop->last)
                    <hr class="my-2 border-gray-200">
                @endif
            @endforeach
        
        @if ($filteredRatings->count() > 4)
            <div class="text-center mt-4">
                <button id="load-more-reviews" class="btn-load-more">
                    Xem thêm đánh giá
                </button>
            </div>
        @endif
    </div> {{-- ✅ Đóng div đúng vị trí --}}
@else
    <div id="review-list-container" class="text-center text-gray-500 py-6">
        Không có đánh giá phù hợp.
    </div>
@endif
    </div>
<template id="review-item-template">
    <div class="py-4 review-item">
        <div class="flex items-start gap-4">
            <div class="user-avatar w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold bg-indigo-900 text-white">
                <span class="user-initial">?</span>
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-2 flex-wrap mb-1">
                    <span class="font-medium text-gray-900 user-name">Tên người dùng</span>
                    <div class="review-stars flex items-center text-yellow-500 text-sm"></div>
                    <span class="text-sm text-gray-600 font-medium review-label">Nhãn</span>
                </div>
                <p class="text-sm text-gray-800 mt-2 review-content">Nội dung đánh giá</p>
                <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                    <i class="mdi mdi-clock-outline"></i>
                    <span class="review-time">Vừa xong</span>
                </p>
            </div>
        </div>
        <hr class="my-2 border-gray-200">
    </div>
</template>

                    </div>
                </div>
            </div>


        </div>
    </section>
    <!-- End -->

    <!-- Start Similar Products -->
    @php
        $similarProducts = \App\Models\Product::with(['thumbnails', 'brand', 'category', 'variants'])
            ->where('brand_id', $product->product->brand_id)
            ->where('id', '!=', $product->product->id)
            ->take(5)
            ->get();
    @endphp

    @if($similarProducts->count() > 0)
        <section class="relative md:py-24 py-16 bg-gray-50 dark:bg-slate-800">
            <div class="container relative">
                <div class="grid grid-cols-1 mb-6 text-center">
                    <h3 class="font-semibold text-3xl leading-normal">Sản phẩm tương tự</h3>
                    <p class="text-slate-400 mt-3">Các sản phẩm cùng thương hiệu {{ $product->product->brand->name ?? 'N/A' }}</p>
                </div>

                <div class="grid lg:grid-cols-5 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6">
                    @foreach($similarProducts as $similarProduct)
                        @php
                            // Lấy biến thể đầu tiên của sản phẩm để hiển thị giá
                            $firstVariant = $similarProduct->variants->first();
                        @endphp
                        <div class="group">
                            <div class="relative overflow-hidden shadow-sm dark:shadow-gray-800 group-hover:shadow-lg group-hover:dark:shadow-gray-800 rounded-md duration-500">
                                @if($similarProduct->thumbnails->count() > 0)
                                    <img src="{{ asset('storage/' . $similarProduct->thumbnails->first()->url) }}"
                                         class="w-full h-48 object-cover group-hover:scale-110 duration-500"
                                         alt="{{ $similarProduct->name }}" loading="lazy"
                                         onerror="this.src='{{ asset('assets/user/images/shop/mens-jecket.jpg') }}'; this.onerror=null;">
                                @else
                                    <img src="{{ asset('assets/user/images/shop/mens-jecket.jpg') }}"
                                         class="w-full h-48 object-cover group-hover:scale-110 duration-500"
                                         alt="{{ $similarProduct->name }}">
                                @endif

                                <div class="absolute -bottom-20 group-hover:bottom-3 start-3 end-3 duration-500">
                                    <a href="{{ route('products.show', $firstVariant ? $firstVariant->id : '#') }}"
                                       class="py-2 px-5 inline-block font-semibold tracking-wide align-middle duration-500 text-base text-center bg-slate-900 text-white w-full rounded-md">
                                        Xem chi tiết
                                    </a>
                                </div>

                                <ul class="list-none absolute top-[10px] end-4 opacity-0 group-hover:opacity-100 duration-500 space-y-1">
                                    <li>
                                        <a href="javascript:void(0)"
                                           class="size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow">
                                            <i data-feather="heart" class="size-4"></i>
                                        </a>
                                    </li>
                                    <li class="mt-1">
                                        <a href="{{ route('products.show', $firstVariant ? $firstVariant->id : '#') }}"
                                           class="size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow">
                                            <i data-feather="eye" class="size-4"></i>
                                        </a>
                                    </li>
                                    <li class="mt-1">
                                        <a href="javascript:void(0)"
                                           class="size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow">
                                            <i data-feather="bookmark" class="size-4"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('products.show', $firstVariant ? $firstVariant->id : '#') }}"
                                   class="hover:text-orange-500 text-lg font-medium">{{ $similarProduct->name }}</a>
                                <div class="mt-2">
                                    <p class="font-semibold text-orange-500 text-lg">
                                        @if($firstVariant)
                                            {{ number_format($firstVariant->price) }} VNĐ
                                        @else
                                            Liên hệ
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- End Similar Products -->


    @include('user.partials.product-detailjs')
    <script src="{{ asset('assets/user/js/shop-cart.js') }}"></script>
    
    @include('user.partials.product-detail-script')

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
    background-color: #16a34a; /* xanh lá - success */
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
    background-color: #a3e635; /* lime-400 */
    animation: progressBar 4s linear forwards;
    width: 100%;
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
}

/* Hiệu ứng */
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

/* ✅ Style riêng cho toast-error */
#toast-error {
    background-color: #dc2626; /* đỏ */
    color: #fff;
}

#toast-error .toast-progress {
    background-color: #f87171; /* đỏ nhạt */
}

#toast-error .toast-icon,
#toast-error .toast-close-icon {
    stroke: #fff;
}
/* ⭐ Tổng điểm trung bình */
#average-rating {
    font-size: 48px;
    font-weight: bold;
    color: #111827; /* text-gray-900 */
}

#average-rating span {
    font-size: 20px;
    color: #9CA3AF; /* text-gray-400 */
}

/* ⭐ Dãy sao trung bình */
#average-rating-icons i {
    font-size: 20px;
    color: #facc15 !important; /* text-yellow-400 */
}

/* ⭐ Tổng số lượt đánh giá */
#total-rating-count {
    color: #6B7280; /* text-gray-500 */
    font-size: 14px;
    margin-top: 0.5rem;
}

/* ⭐ Nút viết đánh giá */
.btn-write-review {
    background-color: #dc2626; /* bg-red-600 */
    color: white;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 14px;
    margin-top: 1rem;
    transition: background-color 0.3s ease;
}

.btn-write-review:hover {
    background-color: #b91c1c; /* hover:bg-red-700 */
}

/* ⭐ Thanh biểu đồ đánh giá */
.rating-bar {
    height: 100%; /* Chiều cao bằng container cha */
    background-color: #dc2626; /* bg-red-600 */
    border-radius: 4px;
    transition: width 0.3s ease;
}

/* ⭐ Container biểu đồ sao */
.rating-bar-container {
    height: 8px;
    background-color: #e5e7eb; /* bg-gray-200 */
    border-radius: 4px;
    overflow: hidden;
    position: relative;
}

/* ⭐ Tổng số lượt đánh giá từng sao */
.rating-count {
    font-size: 14px;
    color: #6B7280; /* text-gray-500 */
    width: 80px;
    text-align: right;
}
/* ⭐ Container lọc đánh giá */
#review-filter-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem; /* tương đương gap-2 */
}

/* ⭐ Nút lọc mặc định */
.filter-button {
    padding: 0.25rem 1rem;      /* tương đương py-1 px-4 */
    border: 1px solid #d1d5db;  /* border-gray-300 */
    border-radius: 9999px;      /* rounded-full */
    font-size: 0.875rem;        /* text-sm */
    color: #374151;             /* text-gray-700 */
    background-color: #ffffff; /* bg-white */
    transition: background-color 0.2s, border-color 0.2s, color 0.2s;
    cursor: pointer;
}

.filter-button:hover {
    background-color: #f3f4f6;  /* hover:bg-gray-100 */
}

/* ⭐ Nút lọc đang được chọn */
.filter-button.active,
.filter-button.bg-blue-100.text-blue-600.border-blue-600 {
    background-color: #dbeafe;  /* bg-blue-100 */
    border-color: #2563eb;      /* border-blue-600 */
    color: #2563eb;             /* text-blue-600 */
}

/* ⭐ Trạng thái focus (tab/enter) */
.filter-button:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5); /* ring-blue-500/50 */
}
.filter-button {
        transition: all 0.2s ease-in-out;
    }

    .filter-button:hover {
        background-color: #f3f4f6; /* hover:bg-gray-100 */
    }

    .filter-button.bg-blue-100 {
        font-weight: 500;
    }

    /* Box đánh giá */
    .review-item {
        transition: background-color 0.3s ease;
    }

    .review-item:hover {
        background-color: #f9fafb;
    }

    /* Badge (tag mô tả) */
    .review-badges span,
    .review-item span.badge {
        background-color: #f3f4f6;
        color: #374151;
        font-size: 0.875rem;
        padding: 2px 8px;
        border-radius: 6px;
        display: inline-block;
        margin-top: 4px;
    }

    /* Avatar mặc định */
    .review-item .user-initial {
        background-color: #312e81; /* indigo-900 */
        color: white;
    }

    /* Tên người dùng */
    .review-item .user-name {
        font-weight: 600;
        color: #111827; /* gray-900 */
    }

    /* Label đánh giá (Tốt, Tuyệt vời...) */
    .review-item .review-label {
        color: #6b7280; /* gray-600 */
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Nội dung bình luận */
    .review-item .review-content {
        font-size: 0.9375rem;
        color: #1f2937; /* gray-800 */
    }

    /* Thời gian */
    .review-item .review-time {
        font-size: 0.75rem;
        color: #6b7280;
    }

    /* Icon sao */
    .mdi-star,
    .mdi-star-outline {
        font-size: 16px;
    }

    /* Đường phân cách */
    #review-list-container hr {
        border-color: #e5e7eb; /* border-gray-200 */
    }
    .btn-load-more {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 20px;
        background-color: #e5e7eb; /* Tailwind bg-gray-200 */
        color: #000; /* chữ đen */
        font-size: 14px;
        font-weight: 500;
        border-radius: 9999px; /* bo tròn full */
        border: none;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .btn-load-more:hover {
        background-color: #d1d5db; /* Tailwind bg-gray-300 */
    }

    /* Ẩn thanh cuộn cho scroll ngang */
    .scrollbar-hide {
        -ms-overflow-style: none;  /* Internet Explorer 10+ */
        scrollbar-width: none;  /* Firefox */
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;  /* Safari and Chrome */
    }
    </style>
    @include('user.partials.product-detailjs')
    <script src="{{ asset('assets/user/js/shop-cart.js') }}"></script>
    <script src="{{ asset('assets/user/js/review.js') }}"></script>
    
@endsection
