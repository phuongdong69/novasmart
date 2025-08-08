@extends('user.layouts.client')

@section('title', isset($brand) ? 'Sản phẩm ' . $brand->name : (isset($category) ? 'Sản phẩm ' . $category->name : 'Tất cả sản phẩm'))

@section('content')
<!-- Start -->
<section class="relative md:py-24 py-16 bg-gray-50 dark:bg-slate-800">
    <div class="container relative">
        <div class="grid grid-cols-1 pb-8 text-center">
            <h3 class="mb-4 md:text-3xl md:leading-normal text-2xl leading-normal font-semibold">
                @if(isset($brand))
                    Sản phẩm {{ $brand->name }}
                @elseif(isset($category))
                    Sản phẩm {{ $category->name }}
                @else
                    Tất cả sản phẩm
                @endif
            </h3>
            
            <p class="text-slate-400 max-w-xl mx-auto">
                @if(isset($brand))
                    Khám phá các sản phẩm chất lượng từ thương hiệu {{ $brand->name }}
                @elseif(isset($category))
                    Khám phá các sản phẩm {{ $category->name }} chất lượng cao
                @else
                    Khám phá bộ sưu tập sản phẩm đa dạng và chất lượng
                @endif
            </p>
        </div><!--end grid-->

        <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-6">
            @forelse($products as $product)
            @php
                // Lấy biến thể đầu tiên có sẵn của sản phẩm
                $firstVariant = $product->variants->first();
                
                if (!$firstVariant) {
                    continue; // Bỏ qua sản phẩm không có biến thể
                }
            @endphp
            <div class="group">
                <div class="relative overflow-hidden shadow dark:shadow-gray-800 group-hover:shadow-lg group-hover:shadow-orange-500/20 dark:group-hover:shadow-orange-500/20 transition-all duration-500 rounded-2xl">
                    <div class="relative overflow-hidden">
                        <img src="{{ $product->thumbnails->where('is_primary', 1)->first()?->url ? asset('storage/' . $product->thumbnails->where('is_primary', 1)->first()->url) : asset('assets/images/shop/placeholder.jpg') }}" 
                             class="group-hover:scale-110 transition-all duration-500" alt="{{ $product->name }}">
                        
                        @if($firstVariant->compare_price && $firstVariant->compare_price > $firstVariant->price)
                            <div class="absolute top-4 start-4">
                                <span class="bg-orange-500 text-white text-[12px] font-bold px-2.5 py-0.5 rounded h-5">Sale</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-6">
                        <div class="pb-3">
                            <a href="{{ route('products.show', $firstVariant->id) }}" class="h5 text-lg font-semibold hover:text-orange-500 transition-all duration-500">{{ $product->name }}</a>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <div class="flex items-center mb-0">
                                <span class="text-orange-500 font-semibold text-lg">
                                    {{ number_format($firstVariant->price) }}đ
                                </span>
                                @if($firstVariant->compare_price && $firstVariant->compare_price > $firstVariant->price)
                                    <span class="text-slate-400 text-sm line-through ms-2">
                                        {{ number_format($firstVariant->compare_price) }}đ
                                    </span>
                                @endif
                            </div>
                            
                            <div class="flex items-center">
                                <span class="text-slate-400 text-sm">{{ $product->brand->name }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('products.show', $firstVariant->id) }}" 
                               class="btn bg-orange-500 hover:bg-orange-600 border-orange-500 hover:border-orange-600 text-white rounded-md w-full">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="text-slate-400 text-lg">
                    <i class="mdi mdi-package-variant text-6xl mb-4"></i>
                    <p>Không tìm thấy sản phẩm nào.</p>
                </div>
            </div>
            @endforelse
        </div><!--end grid-->

        @if($products->hasPages())
        <div class="grid md:grid-cols-12 grid-cols-1 mt-8">
            <div class="md:col-span-12 text-center">
                <nav class="flex items-center justify-center">
                    {{ $products->links() }}
                </nav>
            </div>
        </div>
        @endif
    </div><!--end container-->
</section><!--end section-->
<!-- End -->
@endsection 