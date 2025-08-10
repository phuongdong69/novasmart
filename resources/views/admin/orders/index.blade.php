@extends('admin.layouts.app')

@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <h1 class="text-2xl font-bold mb-6">Quản lý đơn hàng</h1>

        <div class="overflow-x-auto bg-white shadow rounded-lg w-full">
            <table class="w-full min-w-0 table-auto divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Mã đơn hàng</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Khách hàng</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Tổng tiền</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Trạng thái thanh toán</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Ngày tạo</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-center">{{ $order->order_code }}</td>
                            <td class="px-4 py-2 text-center">{{ $order->user->name ?? '-' }}</td>
                            <td class="px-4 py-2 text-center">{{ number_format($order->total_price, 0, ',', '.') }} ₫</td>
                            <td class="px-4 py-2 text-center" style="position:relative;">
                                @php
                                    $orderStatuses = \App\Models\Status::where('type', 'order')->where('is_active', 1)->orderBy('priority')->get();
                                    $currentStatus = $order->orderStatus;
                                    $currentStatusIndex = $currentStatus
                                        ? $orderStatuses->search(function ($status) use ($currentStatus) {
                                            return $status->id == $currentStatus->id;
                                        })
                                        : -1;
                                    $nextStatus =
                                        $currentStatusIndex >= 0 && $currentStatusIndex < $orderStatuses->count() - 1
                                            ? $orderStatuses->get($currentStatusIndex + 1)
                                            : null;
                                    $isDelivered = $currentStatus && (
                                        str_contains(strtolower($currentStatus->name), 'đã giao hàng') ||
                                        str_contains(strtolower($currentStatus->code), 'delivered')
                                    );
                                    $isCompleted = $currentStatus && (
                                        str_contains(strtolower($currentStatus->name), 'hoàn thành') ||
                                        str_contains(strtolower($currentStatus->code), 'completed')
                                    );
                                @endphp
                                <span style="padding: 6px 12px; background-color: {{ $currentStatus->color ?? '#6b7280' }}; color: white; border-radius: 4px; font-size: 12px; font-weight: 500; display: inline-block; min-width: 80px;">
                                    {{ $currentStatus ? $currentStatus->name : 'Chưa có trạng thái' }}
                                </span>
                                @if (!$isCompleted && !$isDelivered && $nextStatus && (!($currentStatus && $currentStatus->code === 'refunded')))
                                    <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" style="display:inline-block; position:absolute; right:8px; top:50%; transform:translateY(-50%);">
                                        @csrf
                                        <input type="hidden" name="status_id" value="{{ $nextStatus->id }}">
                                        <button type="submit"
                                            style="padding: 3px 6px; background: linear-gradient(90deg, #6366f1 0%, #06b6d4 100%); color: white; border: none; border-radius: 4px; font-size: 14px; font-weight: 500; cursor: pointer; min-width: 28px; display: flex; align-items: center; justify-content: center; transition: background 0.2s;"
                                            onmouseover="this.style.background='linear-gradient(90deg, #7c3aed 0%, #6366f1 100%)'" onmouseout="this.style.background='linear-gradient(90deg, #6366f1 0%, #06b6d4 100%)'"
                                            title="Chuyển trạng thái">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" style="width: 16px; height: 16px;">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </td>

                            <td class="px-4 py-2 text-center">
                                @if($order->payment && $order->payment->status)
                                    <span class="px-2 py-1 rounded text-white text-xs font-semibold" style="background-color: {{ $order->payment->status->color ?? '#6b7280' }};">
                                        {{ $order->payment->status->name ?? 'Không xác định' }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded text-xs font-semibold bg-gray-300 text-gray-700">Chưa có</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center">{{ $order->created_at ? $order->created_at->format('d/m/Y') : '-' }}</td>

                            <td class="px-4 py-2 flex flex-wrap gap-2 justify-center">
                                <a href="{{ route('admin.orders.show', $order->id) }}" title="Xem chi tiết"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-white text-blue-600 text-xs font-semibold rounded-md shadow-sm hover:bg-blue-500 hover:text-white transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                @php
                                    $cancelStatus = \App\Models\Status::where('type', 'order')->where('code', 'cancelled')->first();
                                    $allowCancel = $currentStatus && in_array($currentStatus->code, ['pending', 'confirmed']);
                                @endphp
                                @if ($cancelStatus)
                                    <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" onsubmit="return {{ $allowCancel ? 'confirm(\'Bạn có chắc chắn muốn hủy đơn hàng này?\')' : 'false' }}">
                                        @csrf
                                        <input type="hidden" name="status_id" value="{{ $cancelStatus->id }}">
                                        <button type="submit"
                                            style="width: 2rem; height: 2rem; background: #ef4444; color: #fff; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; border: none; opacity: {{ $allowCancel ? '1' : '0.5' }}; cursor: {{ $allowCancel ? 'pointer' : 'not-allowed' }};"
                                            {{ $allowCancel ? '' : 'disabled' }}
                                            title="Hủy đơn hàng">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M4.93 4.93a10 10 0 0114.14 0M4.93 19.07a10 10 0 010-14.14M19.07 19.07a10 10 0 01-14.14 0" />
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

        <div class="mt-4">
            {{ $orders->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection
