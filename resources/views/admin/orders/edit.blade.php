@extends('admin.layouts.app')

@section('title', 'Cập nhật đơn hàng')

@section('content')
<div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
    <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl">
        <div class="flex items-center justify-between">
            <h3 class="dark:text-white">Cập nhật đơn hàng #{{ $order->id }}</h3>
            <div class="flex space-x-2">
                <a href="{{ route('admin.orders.index') }}" class="inline-block px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">
                    <i class="fas fa-arrow-left mr-2"></i>Quay lại
                </a>
                <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-block px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                    <i class="fas fa-eye mr-2"></i>Xem chi tiết
                </a>
            </div>
        </div>
    </div>

    <div class="flex-auto p-6">
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            
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
                            <span class="text-gray-600 dark:text-gray-300">Tổng tiền:</span>
                            <span class="font-semibold text-lg text-red-600 dark:text-red-400">{{ number_format($order->total_price) }} VNĐ</span>
                        </div>
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
                    </div>
                </div>
            </div>

            <!-- Cập nhật trạng thái -->
            <div class="mt-6 bg-gray-50 dark:bg-slate-800 rounded-lg p-6">
                <h6 class="text-lg font-semibold mb-4 dark:text-white">Cập nhật trạng thái</h6>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="status_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Trạng thái đơn hàng
                        </label>
                        <select name="status_code" id="status_code" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:border-gray-600 dark:text-white">
                            @foreach($statuses as $status)
                                <option value="{{ $status->code }}" {{ $order->status_code == $status->code ? 'selected' : '' }} style="color: {{ $status->color }};">
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="note" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Ghi chú
                        </label>
                        <textarea name="note" id="note" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:border-gray-600 dark:text-white"
                                  placeholder="Nhập ghi chú cho đơn hàng...">{{ $order->note }}</textarea>
                        @error('note')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Hiển thị trạng thái hiện tại -->
                <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <h6 class="font-medium text-blue-800 dark:text-blue-200 mb-2">Trạng thái hiện tại:</h6>
                    @if($order->status)
                        <span class="px-3 py-1 text-sm font-semibold rounded-full" 
                              style="background-color: {{ $order->status->color }}20; color: {{ $order->status->color }};">
                            {{ $order->status->name }}
                        </span>
                    @else
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-600">
                            Chưa xác định
                        </span>
                    @endif
                </div>
            </div>

            <!-- Nút submit -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.orders.index') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Hủy
                </a>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i>Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 