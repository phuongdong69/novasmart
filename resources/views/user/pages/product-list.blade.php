@extends('user.layouts.client')

@section('content')
<section class="relative lg:py-24 py-16">
    <div class="container relative">
        <div class="grid grid-cols-1 mt-14">
            <h3 class="text-3xl leading-normal font-semibold">Sản phẩm</h3>
        </div><!--end grid-->

        <div class="relative mt-3">
            <ul class="tracking-[0.5px] mb-0 inline-block">
                <li class="inline-block uppercase text-[13px] font-bold duration-500 ease-in-out hover:text-orange-500">
                    <a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="inline-block text-base text-slate-950 dark:text-white mx-0.5 ltr:rotate-0 rtl:rotate-180">
                    <i class="mdi mdi-chevron-right"></i>
                </li>
                <li class="inline-block text-base text-slate-950 dark:text-white mx-0.5 ltr:rotate-0 rtl:rotate-180">
                    <a href="#" class="hover:text-orange-500">Sản phẩm</a>
                </li>
            </ul>
        </div><!--end relative-->
    </div><!--end container-->

    <div class="container relative mt-8">
        <div class="grid lg:grid-cols-12 md:grid-cols-2 grid-cols-1 gap-6">
            <!-- Filter Sidebar -->
            @include('user.partials.filter')

            <!-- Product List -->
            <div class="lg:col-span-9 md:col-span-8">
                <div class="md:flex justify-between items-center mb-6">
                    <span class="font-semibold">
                        Hiển thị {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} 
                        trên tổng số {{ $products->total() }} sản phẩm
                    </span>

                    <div class="md:flex items-center">
                        <label class="font-semibold md:me-2">Sắp xếp theo:</label>
                        <select name="sort" onchange="this.form.submit()" form="filterForm"
                                class="form-select form-input md:w-36 w-full md:mt-0 mt-1 py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-100 dark:border-gray-800 focus:ring-0">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>
                        </select>
                    </div>
                </div>

                <!-- Danh sách sản phẩm -->
                <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6">
                    @forelse($products as $variant)
                        @php
                            $product = $variant->product;
                            $thumbnail = $product->thumbnails->where('is_primary', true)->first();
                            $imageUrl = $thumbnail ? asset('storage/' . $thumbnail->url) : asset('assets/user/images/shop/default-product.jpg');
                            
                            // Lấy các thuộc tính để hiển thị
                            $attributes = $variant->variantAttributeValues->map(function($vav) {
                                return $vav->attribute->name . ': ' . $vav->attributeValue->value;
                            })->implode(', ');
                            $variant = $product->variants->first();
                            $status = $variant?->status;

                            $isOutOfStock = $variant && (
                            ($status && $status->code === 'out_of_stock' && $status->type === 'product_variant')
                            || $variant->quantity == 0
                            );
                        @endphp
                        <div class="group">
                            <div class="relative overflow-hidden rounded-md shadow dark:shadow-gray-800">
                                <img src="{{ $imageUrl }}" class="group-hover:scale-110 duration-500 w-full h-64 object-cover" alt="{{ $product->name }}">
                                
                                <div class="absolute top-4 end-4">
                                    <a href="{{ route('products.show', $variant->id) }}" class="size-10 inline-flex items-center justify-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow">
                                        <i data-feather="eye" class="size-4"></i>
                                    </a>
                                </div>
                                
                                @if($variant->quantity <= 0)
                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                        <span class="text-white font-semibold">Hết hàng</span>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('products.show', $variant->id) }}" class="h5 text-lg font-semibold hover:text-orange-500">{{ $product->name }}</a>
                                
                                @if($product->brand)
                                    <p class="text-slate-400 mt-1">{{ $product->brand->name }}</p>
                                @endif
                                
                                @if($attributes)
                                    <p class="text-sm text-slate-500 mt-1">{{ $attributes }}</p>
                                @endif
                                
                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-lg font-semibold">{{ number_format($variant->price) }}₫</span>
                                    
                            @if(!$isOutOfStock)
                                <form action="{{ route('cart.add') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="product_variant_id" value="{{ $variant->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="py-2 px-5 inline-block font-semibold tracking-wide align-middle duration-500 text-base text-center bg-slate-900 text-white w-full rounded-md hover:bg-orange-500">
                                        Thêm vào giỏ
                                    </button>
                                </form>
                            @else
                                <button disabled class="py-2 px-5 inline-block font-semibold tracking-wide align-middle duration-500 text-base text-center bg-gray-400 text-white w-full rounded-md cursor-not-allowed">
                                Hết hàng
                            </button>
                            @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <i data-feather="package" class="size-16 mx-auto text-gray-400 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-600 mb-2">Không tìm thấy sản phẩm</h3>
                            <p class="text-gray-500">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
                        </div>
                    @endforelse
                </div>

                <!-- Phân trang -->
                @if($products->hasPages())
                <div class="grid md:grid-cols-12 grid-cols-1 mt-6">
                    <div class="md:col-span-12 text-center">
                        {{ $products->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
