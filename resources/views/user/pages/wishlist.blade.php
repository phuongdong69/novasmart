@extends('user.layouts.client')

@section('title', 'Danh sách yêu thích')

@section('meta_description', 'Danh sách sản phẩm yêu thích của bạn.')

@section('content')
    <!-- Bắt đầu -->
    <section class="relative md:py-24 py-16">
        <div class="container relative md:mt-24 mt-16">
            <div class="grid grid-cols-1 justify-center text-center mb-6">
                <h5 class="font-semibold text-3xl leading-normal mb-4">Danh Sách Yêu Thích</h5>
                <p class="text-slate-400 max-w-xl mx-auto">Những sản phẩm bạn đã thêm vào danh sách yêu thích</p>
            </div>

            <div class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 pt-6 gap-6">
                @forelse($wishlists as $wishlist)
                    @php
                        $product = $wishlist->productVariant->product;
                        $variant = $wishlist->productVariant;
                        $status = $variant->status;

                        $isOutOfStock =
                            $variant &&
                            (($status && $status->code === 'out_of_stock' && $status->type === 'product_variant') ||
                                $variant->quantity == 0);
                    @endphp
                    <div class="group wishlist-item">
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
                                        class="wishlist-btn size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-red-500 text-white shadow liked cursor-pointer"
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
                    <div class="col-span-4 text-center text-slate-400">
                        <div class="py-8">
                            <i data-feather="heart" class="size-16 mx-auto text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-semibold mb-2">Danh sách yêu thích trống</h3>
                            <p class="text-gray-500 mb-4">Bạn chưa có sản phẩm nào trong danh sách yêu thích.</p>
                            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                                <i data-feather="shopping-bag" class="size-4 mr-2"></i>
                                Mua sắm ngay
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/user/js/wishlist.js') }}"></script>
@endpush 