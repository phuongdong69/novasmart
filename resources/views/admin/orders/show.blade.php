@extends('admin.layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="relative flex flex-col min-w-0 break-words bg-gradient-to-br from-white to-gray-50 border-0 shadow-2xl dark:from-slate-900 dark:to-slate-800 rounded-2xl bg-clip-border">
    <div class="p-6 pb-0 mb-0 border-b border-gray-200 dark:border-gray-700 rounded-t-2xl">
        <div class="flex items-center justify-between">
            <h6 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Chi tiết đơn hàng #{{ $order->id }}</h6>
            <div class="flex space-x-3">
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all duration-200 dark:text-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">
                    <i class="fas fa-arrow-left mr-2"></i> Quay lại
                </a>
                
            </div>
        </div>
    </div>

    <div class="flex-auto p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Thông tin đơn hàng -->
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300">
                <h6 class="text-xl font-semibold mb-5 text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">Thông tin đơn hàng</h6>
                <div class="space-y-5">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400 font-medium">Mã đơn hàng:</span>
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $order->order_code }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400 font-medium">Ngày đặt:</span>
                        <span class="text-gray-900 dark:text-white">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400 font-medium">Trạng thái:</span>
                        @if($order->status)
                            <?php
                            $statusColor = $order->status->color ?? '#ccc';
                            $lightColor = '#' . ltrim(substr($statusColor, 1), '0') . '80'; // Màu nhạt với độ trong suốt
                            ?>
                            <span class="px-3 py-1.5 text-sm font-semibold rounded-full" 
                                  style="background-color: {{ $lightColor }}; color: {{ $statusColor }}; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">
                                {{ $order->status->name ?? 'Chưa xác định' }}
                            </span>
                        @else
                            <span class="px-3 py-1.5 text-sm font-semibold rounded-full bg-gray-200 text-gray-700 dark:bg-gray-600 dark:text-gray-300">
                                Chưa xác định
                            </span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400 font-medium">Tổng tiền:</span>
                        <span class="text-xl font-bold text-red-600 dark:text-red-400">{{ number_format($order->total_price) }} VNĐ</span>
                    </div>
                    @if($order->note)
                    <div class="mt-5 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl border border-yellow-200 dark:border-yellow-800">
                        <span class="text-base font-medium text-yellow-800 dark:text-yellow-200">Ghi chú:</span>
                        <p class="text-gray-700 dark:text-yellow-300 mt-2">{{ $order->note }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Thông tin khách hàng -->
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300">
                <h6 class="text-xl font-semibold mb-5 text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">Thông tin khách hàng</h6>
                <div class="space-y-5">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400 font-medium">Họ tên:</span>
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $order->name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400 font-medium">Email:</span>
                        <span class="text-gray-900 dark:text-white">{{ $order->email ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400 font-medium">Số điện thoại:</span>
                        <span class="text-gray-900 dark:text-white">{{ $order->phoneNumber ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400 font-medium">Địa chỉ:</span>
                        <span class="text-gray-900 dark:text-white">{{ $order->address ?? '-' }}</span>
                    </div>
                    @if($order->user)
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400 font-medium">Tài khoản:</span>
                        <span class="text-gray-900 dark:text-white">{{ $order->user->email ?? '-' }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="mt-6 bg-white dark:bg-slate-800 rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300">
            <h6 class="text-xl font-semibold mb-5 text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">Danh sách sản phẩm</h6>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-xs uppercase bg-gray-100 dark:bg-slate-700">
                        <tr>
                            <th class="px-6 py-3 text-left dark:text-white font-medium">Sản phẩm</th>
                            <th class="px-6 py-3 text-left dark:text-white font-medium">Thuộc tính</th>
                            <th class="px-6 py-3 text-center dark:text-white font-medium">Số lượng</th>
                            <th class="px-6 py-3 text-right dark:text-white font-medium">Đơn giá</th>
                            <th class="px-6 py-3 text-right dark:text-white font-medium">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->orderDetails as $detail)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    @if($detail->productVariant && $detail->productVariant->product && $detail->productVariant->product->thumbnails->first())
                                        <div class="w-14 h-14 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                                            <img src="{{ asset('storage/' . $detail->productVariant->product->thumbnails->first()->image_path) }}" 
                                                 alt="{{ $detail->productVariant->product->name }}" 
                                                 class="w-full h-full object-cover" 
                                                 onerror="this.style.display='none'">
                                        </div>
                                    @endif
                                    <div class="text-gray-900 dark:text-white font-medium">{{ $detail->productVariant->product->name ?? 'Sản phẩm đã xóa' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($detail->productVariant && $detail->productVariant->attributeValues)
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($detail->productVariant->attributeValues as $attrValue)
                                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs rounded-full">
                                                {{ $attrValue->attribute->name ?? '' }}: {{ $attrValue->value ?? '' }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-gray-900 dark:text-white">{{ $detail->quantity }}</td>
                            <td class="px-6 py-4 text-right text-gray-900 dark:text-white">{{ number_format($detail->price) }} VNĐ</td>
                            <td class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-white">{{ number_format($detail->price * $detail->quantity) }} VNĐ</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Không có sản phẩm nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Thông tin thanh toán -->
        @if($order->payment || $order->voucher)
        <div class="mt-6 bg-white dark:bg-slate-800 rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300">
            <h6 class="text-xl font-semibold mb-5 text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">Thông tin thanh toán</h6>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($order->payment)
                <div>
                    <h6 class="text-base font-medium mb-2 text-gray-900 dark:text-white">Phương thức thanh toán</h6>
                    <p class="text-gray-600 dark:text-gray-400">{{ $order->payment->payment_method ?? 'Chưa xác định' }}</p>
                </div>
                @endif
                @if($order->voucher)
                <div>
                    <h6 class="text-base font-medium mb-2 text-gray-900 dark:text-white">Mã giảm giá</h6>
                    <p class="text-gray-600 dark:text-gray-400">{{ $order->voucher->code ?? 'Không áp dụng' }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection