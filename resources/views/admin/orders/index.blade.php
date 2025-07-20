@extends('admin.layouts.app')
@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <h1 class="text-2xl font-bold mb-6">Quản lý đơn hàng</h1>
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
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
                                $orderStatuses = \App\Models\Status::where('type', 'order')->where('is_active', 1)->orderBy('priority')->get();
                                $currentStatus = $order->orderStatus;
                                
                                // Kiểm tra xem trạng thái hiện tại có phải là "Đã giao hàng" không
                                $isDelivered = $currentStatus && (str_contains(strtolower($currentStatus->name), 'đã giao hàng') || str_contains(strtolower($currentStatus->name), 'delivered') || str_contains(strtolower($currentStatus->name), 'hoàn thành'));
                                
                                // Tìm trạng thái tiếp theo
                                $currentStatusIndex = $currentStatus ? $orderStatuses->search(function($status) use ($currentStatus) {
                                    return $status->id == $currentStatus->id;
                                }) : -1;
                                $nextStatus = $currentStatusIndex >= 0 && $currentStatusIndex < $orderStatuses->count() - 1 ? $orderStatuses->get($currentStatusIndex + 1) : null;
                                $isLastStatus = $currentStatusIndex === $orderStatuses->count() - 1;
                            @endphp
                            
                            <div class="flex items-center gap-2 flex-wrap" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                @if($nextStatus && !$isLastStatus && !$isDelivered)
                                    <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" style="display: inline-block; margin: 0; padding: 0;">
                                        @csrf
                                        <input type="hidden" name="status_id" value="{{ $nextStatus->id }}">
                                        <button type="submit" style="display: inline-block; padding: 6px 12px; background-color: {{ $currentStatus ? ($currentStatus->color ?? '#10b981') : '#10b981' }}; color: white; border: none; border-radius: 4px; font-size: 12px; font-weight: 500; cursor: pointer; min-width: 80px; text-decoration: none; line-height: 1.2; transition: background-color 0.2s ease;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                            {{ $currentStatus ? $currentStatus->name : 'Chưa có trạng thái' }}
                                        </button>
                                    </form>
                                @elseif($isDelivered)
                                    <span style="display: inline-block; padding: 6px 12px; background-color: {{ $currentStatus ? ($currentStatus->color ?? '#10b981') : '#10b981' }}; color: white; border-radius: 4px; font-size: 12px; font-weight: 500; cursor: not-allowed; min-width: 80px; text-decoration: none; line-height: 1.2;">
                                        {{ $currentStatus ? $currentStatus->name : 'Chưa có trạng thái' }}
                                    </span>
                                @else
                                    <span style="display: inline-block; padding: 6px 12px; background-color: #d1d5db; color: #4b5563; border-radius: 4px; font-size: 12px; font-weight: 500; cursor: not-allowed; min-width: 80px; text-decoration: none; line-height: 1.2;">
                                        Hoàn thành
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.orders.status_logs', $order) }}" class="text-blue-500">Xem lịch sử</a>
                        </td>
                        <td class="px-4 py-2">{{ $order->created_at ? $order->created_at->format('d/m/Y') : '-' }}</td>
                        <td class="px-4 py-2 flex flex-wrap gap-2">
                            <a href="#" class="px-3 py-1 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">Xem</a>
                            <form action="#" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xoá đơn hàng này?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">Xoá</button>
                            </form>
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