@extends('admin.layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div class="max-w-7xl mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Lịch sử sử dụng Voucher</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.vouchers.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">Quay lại</a>
        </div>
    </div>
    
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Voucher
                        </th>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Thao tác
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($usages as $usage)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $usage->voucher->code }}
                                    </div>
                                    <div class="text-sm text-gray-500 ml-2">
                                        ({{ $usage->voucher->type == 'percentage' ? $usage->voucher->value . '%' : number_format($usage->voucher->value) . ' VNĐ' }})
                                    </div>
                                </div>
                            </td>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.vouchers.show', $usage->voucher->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 mr-3">
                                    Xem voucher
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Chưa có lịch sử sử dụng voucher nào
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($usages->hasPages())
            <div class="px-6 py-3 border-t border-gray-200">
                {{ $usages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 