@extends('admin.layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div class="max-w-6xl mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Chi tiết Voucher</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.vouchers.usages', $voucher->id) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Lịch sử sử dụng</a>
            <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Sửa</a>
            <a href="{{ route('admin.vouchers.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">Quay lại</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Thông tin voucher -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Thông tin Voucher</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="font-medium">Mã voucher:</span>
                    <span class="text-lg font-bold text-blue-600">{{ $voucher->code }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="font-medium">Trạng thái:</span>
                    <span class="px-2 py-1 text-xs rounded {{ $voucher->getStatusClass() }}">
                        {{ $voucher->getStatusText() }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="font-medium">Loại giảm giá:</span>
                    <span>{{ $voucher->type == 'percentage' ? 'Phần trăm' : 'Cố định' }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="font-medium">Giá trị giảm:</span>
                    <span>
                        @if($voucher->type == 'percentage')
                            {{ $voucher->value }}%
                            @if($voucher->max_discount)
                                (Tối đa {{ number_format($voucher->max_discount) }} VNĐ)
                            @endif
                        @else
                            {{ number_format($voucher->value) }} VNĐ
                        @endif
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="font-medium">Đơn hàng tối thiểu:</span>
                    <span>{{ number_format($voucher->min_order_value) }} VNĐ</span>
                </div>

                <div class="flex justify-between">
                    <span class="font-medium">Sử dụng:</span>
                    <span>{{ $voucher->used }}/{{ $voucher->usage_limit }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="font-medium">Thời gian hiệu lực:</span>
                    <span>{{ $voucher->start_date->format('d/m/Y') }} - {{ $voucher->end_date->format('d/m/Y') }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="font-medium">Trạng thái:</span>
                    <span>{{ $voucher->status ? $voucher->status->name : 'N/A' }}</span>
                </div>

                @if($voucher->user)
                <div class="flex justify-between">
                    <span class="font-medium">Gán cho:</span>
                    <span>{{ $voucher->user->name }} ({{ $voucher->user->email }})</span>
                </div>
                @endif

                <div class="flex justify-between">
                    <span class="font-medium">Công khai:</span>
                    <span>{{ $voucher->is_public ? 'Có' : 'Không' }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="font-medium">Ngày tạo:</span>
                    <span>{{ $voucher->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Lịch sử sử dụng -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Lịch sử sử dụng</h3>
            @if($voucher->usages->count() > 0)
                <div class="space-y-3">
                    @foreach($voucher->usages as $usage)
                        <div class="border rounded p-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium">{{ $usage->user->name }}</p>
                                    <p class="text-sm text-gray-600">Đơn hàng: {{ $usage->order->order_code }}</p>
                                    <p class="text-sm text-gray-600">{{ $usage->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-green-600">-{{ number_format($usage->discount_amount) }} VNĐ</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Chưa có lịch sử sử dụng</p>
            @endif
        </div>
    </div>
</div>
@endsection
