@extends('admin.layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
    <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl">
        <div class="flex items-center justify-between">
            <h6 class="dark:text-white">Chi tiết đơn hàng #{{ $order->id }}</h6>
            <div class="flex space-x-2">
                <a href="{{ route('admin.orders.index') }}" class="inline-block px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">
                    <i class="fas fa-arrow-left mr-2"></i>Quay lại
                </a>
                <a href="{{ route('admin.orders.edit', $order->id) }}" class="inline-block px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                    <i class="fas fa-edit mr-2"></i>Cập nhật
                </a>
            </div>
        </div>
    </div>

    <div class="flex-auto p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Thông tin đơn hàng -->
            <div class="bg-gray-50 dark:bg-slate-800 rounded-lg p-6">
                <h6 class="text-lg font-semibold mb-4 dark:text-white">Thông tin đơn hàng</h6>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-300">Mã đơn hàng:</span>
                        <span class="font-semibold dark:text-white">{{ $order->order_code }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-300">Ngày đặt:</span>
                        <span class="dark:text-white">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-300">Trạng thái:</span>
                        @if($order->status)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full" 
                                  style="background-color: {{ $order->status->color }}20; color: {{ $order->status->color }};">
                                {{ $order->status->name }}
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">
                                Chưa xác định
                            </span>
                        @endif
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-300">Tổng tiền:</span>
                        <span class="font-semibold text-lg text-red-600 dark:text-red-400">{{ number_format($order->total_price) }} VNĐ</span>
                    </div>
                    @if($order->note)
                    <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                        <span class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Ghi chú:</span>
                        <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">{{ $order->note }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Thông tin khách hàng -->
            <div class="bg-gray-50 dark:bg-slate-800 rounded-lg p-6">
                <h6 class="text-lg font-semibold mb-4 dark:text-white">Thông tin khách hàng</h6>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-300">Họ tên:</span>
                        <span class="font-semibold dark:text-white">{{ $order->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-300">Email:</span>
                        <span class="dark:text-white">{{ $order->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-300">Số điện thoại:</span>
                        <span class="dark:text-white">{{ $order->phoneNumber }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-300">Địa chỉ:</span>
                        <span class="dark:text-white text-right">{{ $order->address }}</span>
                    </div>
                    @if($order->user)
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-300">Tài khoản:</span>
                        <span class="dark:text-white">{{ $order->user->email }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="mt-6 bg-gray-50 dark:bg-slate-800 rounded-lg p-6">
            <h6 class="text-lg font-semibold mb-4 dark:text-white">Danh sách sản phẩm</h6>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs uppercase bg-gray-100 dark:bg-slate-700">
                        <tr>
                            <th class="px-4 py-3 dark:text-white">Sản phẩm</th>
                            <th class="px-4 py-3 dark:text-white">Thuộc tính</th>
                            <th class="px-4 py-3 dark:text-white">Số lượng</th>
                            <th class="px-4 py-3 dark:text-white">Đơn giá</th>
                            <th class="px-4 py-3 dark:text-white">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->orderDetails as $detail)
                        <tr class="border-b dark:border-gray-700">
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    @if($detail->productVariant && $detail->productVariant->product)
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg mr-3 flex-shrink-0">
                                            @if($detail->productVariant->product->thumbnails->first())
                                                <img src="{{ asset('storage/' . $detail->productVariant->product->thumbnails->first()->image_path) }}" 
                                                     alt="{{ $detail->productVariant->product->name }}" 
                                                     class="w-full h-full object-cover rounded-lg">
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-medium dark:text-white">{{ $detail->productVariant->product->name }}</div>
                                        </div>
                                    @else
                                        <span class="text-gray-500">Sản phẩm đã bị xóa</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($detail->productVariant && $detail->productVariant->attributeValues)
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        @foreach($detail->productVariant->attributeValues as $attrValue)
                                            <span class="inline-block px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs mr-1 mb-1">
                                                {{ $attrValue->attribute->name }}: {{ $attrValue->value }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 dark:text-white">{{ $detail->quantity }}</td>
                            <td class="px-4 py-3 dark:text-white">{{ number_format($detail->price) }} VNĐ</td>
                            <td class="px-4 py-3 font-semibold dark:text-white">{{ number_format($detail->price * $detail->quantity) }} VNĐ</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center text-gray-500">Không có sản phẩm nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Thông tin thanh toán -->
        @if($order->payment || $order->voucher)
        <div class="mt-6 bg-gray-50 dark:bg-slate-800 rounded-lg p-6">
            <h6 class="text-lg font-semibold mb-4 dark:text-white">Thông tin thanh toán</h6>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($order->payment)
                <div>
                    <h6 class="font-medium mb-2 dark:text-white">Phương thức thanh toán</h6>
                    <p class="text-gray-600 dark:text-gray-300">{{ $order->payment->name }}</p>
                </div>
                @endif
                
                @if($order->voucher)
                <div>
                    <h6 class="font-medium mb-2 dark:text-white">Mã giảm giá</h6>
                    <p class="text-gray-600 dark:text-gray-300">{{ $order->voucher->code }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 