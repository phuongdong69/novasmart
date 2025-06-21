@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-6"> <h2 class="text-2xl font-bold mb-6">Danh sách sản phẩm</h2>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse ($products as $product)
        @php
            $variant = $product->variants->first();
            $priceOld = $variant?->price ?? 0;
            $priceSale = $priceOld > 0 ? round($priceOld * 0.8) : 0;
            $discountPercent = $priceOld > 0 ? round(100 - ($priceSale / $priceOld * 100)) : 0;
        @endphp

        <div class="bg-white rounded-lg shadow hover:shadow-md transition duration-300">
            <div class="relative">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                        class="w-full h-48 object-cover rounded-t-lg">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400 text-sm rounded-t-lg">
                        Chưa có ảnh
                    </div>
                @endif

                @if ($discountPercent > 0)
                    <div class="absolute top-0 left-0 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-br-lg">
                        -{{ $discountPercent }}%
                    </div>
                @endif
            </div>

            <div class="p-4">
                <h3 class="text-base font-semibold text-gray-800 mb-1">{{ $product->name }}</h3>

                @if ($priceOld > 0)
                    <div class="text-sm mb-2">
                        <span class="line-through text-gray-400 mr-2">{{ number_format($priceOld, 0, ',', '.') }}đ</span>
                        <span class="text-red-600 font-bold">{{ number_format($priceSale, 0, ',', '.') }}đ</span>
                    </div>
                @else
                    <div class="text-sm text-gray-500 mb-2">Chưa có giá</div>
                @endif

                @if ($variant)
                    <p class="text-xs text-gray-500 mb-2">
                        SKU: {{ $variant->sku ?? 'Không rõ' }} | Tồn kho: {{ $variant->quantity ?? 'N/A' }}
                    </p>

                    <form action="{{ route('cart.add') }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        <input type="hidden" name="product_variant_id" value="{{ $variant->id }}">
                        <input type="number" name="quantity" value="1" min="1"
                            class="border rounded px-2 py-1 w-16 text-sm">
                        <button type="submit"
                            class="bg-green-500 text-white px-3 py-1 text-sm rounded hover:bg-green-600 transition">
                            Thêm vào giỏ
                        </button>
                    </form>
                @else
                    <p class="text-xs text-red-500 mt-2">Không có biến thể sản phẩm</p>
                @endif

                <a href="{{ route('products.show', $product->id) }}"
                    class="text-sm text-blue-600 hover:underline mt-2 inline-block">
                    Xem chi tiết
                </a>
            </div>
        </div>
    @empty
        <p class="text-gray-500 col-span-4">Không có sản phẩm nào để hiển thị.</p>
    @endforelse
</div>

<div class="mt-6">
    {{ $products->links('pagination::bootstrap-4') }}
</div>
</div> @endsection