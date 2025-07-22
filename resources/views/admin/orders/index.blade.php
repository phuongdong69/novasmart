@extends('admin.layouts.app')
@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <h1 class="text-2xl font-bold mb-6">Quản lý đơn hàng</h1>
        <div class="overflow-x-auto bg-white shadow rounded-lg w-full">
            <table class="w-full min-w-0 table-auto divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Khách hàng</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tổng tiền</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Lịch sử trạng thái</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ngày tạo</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $order->id }}</td>
                            <td class="px-4 py-2">{{ $order->user->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ number_format($order->total_amount, 0, ',', '.') }} ₫</td>
                            <td class="px-4 py-2">
                                @php
                                    $orderStatuses = \App\Models\Status::where('type', 'order')
                                        ->where('is_active', 1)
                                        ->orderBy('priority')
                                        ->get();
                                    $currentStatus = $order->orderStatus;
                                    // Chỉ kiểm tra 'Đã giao hàng' (delivered), không kiểm tra 'hoàn thành'
                                    $isDelivered =
                                        $currentStatus &&
                                        (str_contains(strtolower($currentStatus->name), 'đã giao hàng') ||
                                            str_contains(strtolower($currentStatus->code), 'delivered'));
                                    $currentStatusIndex = $currentStatus
                                        ? $orderStatuses->search(function ($status) use ($currentStatus) {
                                            return $status->id == $currentStatus->id;
                                        })
                                        : -1;
                                    $nextStatus =
                                        $currentStatusIndex >= 0 && $currentStatusIndex < $orderStatuses->count() - 1
                                            ? $orderStatuses->get($currentStatusIndex + 1)
                                            : null;
                                    $isLastStatus = $currentStatusIndex === $orderStatuses->count() - 1;
                                @endphp

                                <div class="flex items-center gap-2 flex-wrap"
                                    style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                    @if ($nextStatus && !$isLastStatus && !$isDelivered)
                                        <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST"
                                            style="display: inline-block; margin: 0; padding: 0;">
                                            @csrf
                                            <input type="hidden" name="status_id" value="{{ $nextStatus->id }}">
                                            <button type="submit"
                                                style="display: inline-block; padding: 6px 12px; background-color: {{ $currentStatus ? $currentStatus->color ?? '#10b981' : '#10b981' }}; color: white; border: none; border-radius: 4px; font-size: 12px; font-weight: 500; cursor: pointer; min-width: 80px; text-decoration: none; line-height: 1.2; transition: background-color 0.2s ease;"
                                                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                                {{ $currentStatus ? $currentStatus->name : 'Chưa có trạng thái' }}
                                            </button>
                                        </form>
                                    @elseif($isDelivered)
                                        <span
                                            style="display: inline-block; padding: 6px 12px; background-color: {{ $currentStatus ? $currentStatus->color ?? '#10b981' : '#10b981' }}; color: white; border-radius: 4px; font-size: 12px; font-weight: 500; cursor: not-allowed; min-width: 80px; text-decoration: none; line-height: 1.2;">
                                            {{ $currentStatus ? $currentStatus->name : 'Chưa có trạng thái' }}
                                        </span>
                                    @else
                                        <span
                                            style="display: inline-block; padding: 6px 12px; background-color: #d1d5db; color: #4b5563; border-radius: 4px; font-size: 12px; font-weight: 500; cursor: not-allowed; min-width: 80px; text-decoration: none; line-height: 1.2;">
                                            Hoàn thành
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.orders.status_logs', $order) }}" class="text-blue-500">Xem lịch
                                    sử</a>
                            </td>
                            <td class="px-4 py-2">{{ $order->created_at ? $order->created_at->format('d/m/Y') : '-' }}</td>
                            <td class="px-4 py-2 flex flex-wrap gap-2">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-white text-blue-600 text-xs font-semibold rounded-md shadow-sm hover:bg-blue-500 hover:text-white transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 mr-2"
                                    style="border: none;"
                                    title="Xem chi tiết">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                @php
                                    $cancelStatus = \App\Models\Status::where('type', 'order')
                                        ->where('code', 'cancelled')
                                        ->first();
                                @endphp
                                @if ($cancelStatus && !$isDelivered && $currentStatus && $currentStatus->code !== 'cancelled')
                                    <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">
                                        @csrf
                                        <input type="hidden" name="status_id" value="{{ $cancelStatus->id }}">
                                        <button type="submit"
                                            style="width: 2rem; height: 2rem; background: #ef4444; color: #fff; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; border: none; box-shadow: 0 1px 2px rgba(0,0,0,0.04); transition: background 0.2s; margin-left: 4px;"
                                            onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'"
                                            title="Hủy đơn hàng">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M4.93 4.93a10 10 0 0114.14 0M4.93 19.07a10 10 0 010-14.14M19.07 19.07a10 10 0 01-14.14 0" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">Không có đơn hàng nào phù hợp.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $orders->appends(request()->except('page'))->links() }}</div>
    </div>
@endsection
