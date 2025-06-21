@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4">Giỏ hàng của bạn</h2>

    @if ($cart && count($cart['items']))
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            {{-- Danh sách sản phẩm --}}
            <div class="md:col-span-3 space-y-4">
                @foreach ($cart['items'] as $item)
                    @php
                        $variant = $item['variant'] ?? ($item->productVariant ?? null);
                        $product = $item['product'] ?? ($variant->product ?? null);
                        $quantity = $item['quantity'] ?? $item->quantity ?? 1;
                        $price = $item['price'] ?? $variant->price ?? 0;
                        $priceOld = $price * 1.2;
                        $total = $quantity * $price;
                        $id = $variant->id ?? $item->id;
                        $cartItemId = $item['id'] ?? $item->id;
                    @endphp

                    <div class="flex bg-white rounded-lg shadow p-4">
                        {{-- Ảnh --}}
                        <div class="w-24 h-24 flex-shrink-0 mr-4">
                            @if (!empty($product->image))
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover rounded">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400 text-sm rounded">
                                    Không ảnh
                                </div>
                            @endif
                        </div>

                        {{-- Thông tin --}}
                        <div class="flex-grow">
                            <h3 class="text-lg font-semibold">{{ $product->name ?? 'Sản phẩm không tồn tại' }}</h3>
                            <p class="text-sm text-gray-500">Mã SP: {{ $variant->sku ?? 'N/A' }}</p>

                            <div class="flex items-center mt-2 space-x-2">
                                <span class="line-through text-gray-400 text-sm">{{ number_format($priceOld, 0, ',', '.') }}đ</span>
                                <span class="text-red-600 font-bold text-base">{{ number_format($price, 0, ',', '.') }}đ</span>
                            </div>

                            {{-- Cập nhật số lượng --}}
                            <div class="flex items-center mt-2">
                                <form method="POST" action="{{ route('cart.update', $id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex items-center space-x-2">
                                        <input type="number" name="quantity" value="{{ $quantity }}" min="1" class="w-16 border px-2 py-1 rounded">
                                        <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded text-sm">Cập nhật</button>
                                    </div>
                                </form>

                                {{-- Xoá --}}
                                <form method="POST" action="{{ route('cart.remove', $cartItemId) }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600 hover:underline text-sm">Xoá</button>
</form>
                            </div>
                        </div>

                        {{-- Tổng tiền --}}
                        <div class="text-right w-32">
                            <p class="text-base text-red-600 font-semibold">{{ number_format($total, 0, ',', '.') }}đ</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Tóm tắt đơn hàng --}}
            <div class="md:col-span-1 bg-white shadow rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-2">Tóm tắt đơn hàng</h3>

                <div class="space-y-1 text-sm">
                    <div class="flex justify-between">
                        <span>Tạm tính</span>
                        <span>{{ number_format($cart['total_price'], 0, ',', '.') }}đ</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Giảm giá</span>
                        <span>0đ</span>
                    </div>
                    <div class="border-t pt-2 flex justify-between font-bold text-red-600">
                        <span>Thành tiền</span>
                        <span>{{ number_format($cart['total_price'], 0, ',', '.') }}đ</span>
                    </div>
                </div>

                <a href="" class="block text-center mt-4 bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                    Tiến hành đặt hàng
                </a>
            </div>
        </div>
    @else
        <p class="text-gray-600">Giỏ hàng của bạn đang trống.</p>
    @endif
</div>
@endsection
