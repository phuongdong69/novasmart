@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-6">{{ $product->name }}</h2>

    <div class="bg-white rounded-lg shadow p-4">
        @if ($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                 class="w-full h-48 object-cover rounded-t-lg">
        @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400 text-sm">
                Chưa có ảnh
            </div>
        @endif

        <h3 class="text-lg font-semibold mt-4">Mô tả</h3>
        <p class="text-gray-600">{{ $product->description }}</p>

        <h3 class="text-lg font-semibold mt-4">Biến thể sản phẩm</h3>
        <ul class="mt-2">
            @foreach ($product->productVariants as $variant)
                <li class="text-gray-600 text-sm">
                    SKU: {{ $variant->sku }} - Giá: {{ number_format($variant->price, 0, ',', '.') }} đ - Số lượng: {{ $variant->quantity }}
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
