@extends('admin.layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div class="max-w-7xl mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Danh sách Voucher</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.vouchers.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Thêm Voucher mới</a>
        </div>
    </div>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif
    
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" style="min-width: 1200px;">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Mã voucher</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Loại</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Giá trị</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Đơn hàng tối thiểu</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Sử dụng</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Thời gian</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Trạng thái</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Công khai</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Thao tác</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($vouchers as $voucher)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $voucher->code }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $voucher->type == 'percentage' ? 'Phần trăm' : 'Cố định' }}
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @if($voucher->type == 'percentage')
                                    {{ $voucher->value }}%
                                    @if($voucher->max_discount)
                                        <br><span class="text-xs text-gray-500">Tối đa {{ number_format($voucher->max_discount) }} VNĐ</span>
                                    @endif
                                @else
                                    {{ number_format($voucher->value) }} VNĐ
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ number_format($voucher->min_order_value) }} VNĐ</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $voucher->used }}/{{ $voucher->usage_limit }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $voucher->start_date->format('d/m/Y') }} - {{ $voucher->end_date->format('d/m/Y') }}
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded {{ $voucher->getStatusClass() }}">
                                {{ $voucher->getStatusText() }}
                            </span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $voucher->is_public ? 'Có' : 'Không' }}
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" 
                                   class="text-blue-600 hover:text-blue-900">Sửa</a>
                                <a href="{{ route('admin.vouchers.show', $voucher->id) }}" 
                                   class="text-green-600 hover:text-green-900">Chi tiết</a>
                                <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa voucher này?')">
                                        Xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection