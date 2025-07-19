@extends('user.layouts.client')

@section('title', 'Chi tiết đơn hàng')
@section('meta_description', 'Xem chi tiết đơn hàng của bạn - Nova Smart')

@section('content')
<section class="relative md:py-24 py-16 bg-white">
    <div class="container relative mx-auto max-w-5xl">
        <div class="grid grid-cols-1 justify-center text-center mb-6">
            <h5 class="font-semibold text-3xl leading-normal mb-4">Chi tiết đơn hàng #{{ $order->id }}</h5>
            <p class="text-slate-400 max-w-xl mx-auto">Thông tin chi tiết các sản phẩm bạn đã đặt</p>
        </div>

        {{-- Thông tin chung --}}
        <div class="bg-white shadow rounded-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 text-sm">
                <div>
                    <p><strong>📆 Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p><strong>📌 Trạng thái:</strong> 
                        <span class="inline-block px-2 py-1 text-white rounded"
                            style="background-color: {{ $order->status->color ?? '#aaa' }}">
                            {{ $order->status->name ?? 'Không xác định' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Bảng sản phẩm --}}
        <div class="bg-white shadow rounded-md overflow-x-auto">
            <table class="w-full text-sm border border-gray-200">
                <thead class="bg-gray-100 text-gray-700 uppercase">
                    <tr>
                        <th class="p-3 border">Ảnh</th>
                        <th class="p-3 border">Sản phẩm</th>
                        <th class="p-3 border">Số lượng</th>
                        <th class="p-3 border">Đơn giá</th>
                        <th class="p-3 border">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $detail)
                        @php
                            $product = $detail->productVariant->product ?? null;
                            $image = $product->image ?? 'no-image.jpg';
                        @endphp
                        <tr class="text-center border-t">
                            <td class="p-2">
                                <img src="{{ asset('storage/' . $image) }}" alt="Ảnh"
                                     class="h-16 w-16 object-cover mx-auto rounded">
                            </td>
                            <td class="p-2 text-left">
                                {{ $product->name ?? 'Không xác định' }}
                            </td>
                            <td class="p-2">{{ $detail->quantity }}</td>
                            <td class="p-2 text-right">{{ number_format($detail->price, 0, ',', '.') }}₫</td>
                            <td class="p-2 text-right">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}₫</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Tổng cộng & nút --}}
        <div class="flex flex-col md:flex-row justify-between items-center mt-6">
            <a href="{{ route('user.orders.index') }}"
               class="px-6 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 mb-3 md:mb-0">
                ← Quay lại danh sách
            </a>

            <div class="text-lg font-semibold text-gray-800">
                Tổng đơn hàng: 
                <span class="text-orange-600">
                    {{ number_format($order->orderDetails->sum(fn($item) => $item->price * $item->quantity), 0, ',', '.') }}₫
                </span>
            </div>
        </div>
    </div>
</section>
@endsection
