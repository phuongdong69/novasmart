@extends('admin.layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div class="max-w-7xl mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Lịch sử sử dụng: {{ $voucher->code }}</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.vouchers.show', $voucher->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Chi tiết voucher</a>
            <a href="{{ route('admin.vouchers.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">Quay lại</a>
        </div>
    </div>
    
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <!-- Thông tin voucher -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Thông tin Voucher</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <span class="font-medium">Mã voucher:</span>
                <span class="text-lg font-bold text-blue-600">{{ $voucher->code }}</span>
            </div>
            <div>
                <span class="font-medium">Loại:</span>
                <span>{{ $voucher->type == 'percentage' ? 'Phần trăm' : 'Cố định' }}</span>
            </div>
            <div>
                <span class="font-medium">Giá trị:</span>
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
            <div>
                <span class="font-medium">Sử dụng:</span>
                <span>{{ $voucher->used }}/{{ $voucher->usage_limit }}</span>
            </div>
            <div>
                <span class="font-medium">Đơn hàng tối thiểu:</span>
                <span>{{ number_format($voucher->min_order_value) }} VNĐ</span>
            </div>
            <div>
                <span class="font-medium">Trạng thái:</span>
                <span class="px-2 py-1 text-xs rounded {{ $voucher->isValid() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $voucher->isValid() ? 'Hiệu lực' : 'Hết hạn' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Bảng lịch sử sử dụng -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Lịch sử sử dụng</h3>
        </div>
        
        @if($voucher->usages->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Người dùng
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Đơn hàng
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Số tiền giảm
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ngày sử dụng
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($voucher->usages as $usage)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $usage->user->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $usage->user->email }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $usage->order->order_code }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ number_format($usage->order->total_price) }} VNĐ
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-green-600">
                                        -{{ number_format($usage->discount_amount) }} VNĐ
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $usage->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-8 text-center text-gray-500">
                <p>Chưa có lịch sử sử dụng voucher này</p>
            </div>
        @endif
    </div>
</div>
@endsection 