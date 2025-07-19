@extends('admin.layouts.app')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    {{-- Tiêu đề --}}
    <div class="flex items-center justify-between mb-4">
        <h6 class="dark:text-white text-lg font-semibold">Danh sách đơn hàng</h6>
    </div>

    {{-- Thông báo --}}
    @if (session('success'))
        <div class="alert alert-success mt-3 mx-6">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mt-3 mx-6">{{ session('error') }}</div>
    @endif

    {{-- Form lọc --}}
    <div class="flex justify-end mb-4">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex items-center gap-2">
            <select name="status_id"
                class="form-control form-control-sm rounded border px-3 py-2 text-sm">
                <option value="">-- Tất cả trạng thái --</option>
                @foreach (\App\Models\Status::where('type', 'order')->where('is_active', 1)->orderBy('priority')->get() as $status)
                    <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>
                        {{ $status->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit"
                class="text-sm px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Lọc
            </button>
        </form>
    </div>

    {{-- Bảng đơn hàng --}}
    <div class="bg-white shadow-xl rounded-2xl overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                <tr>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Khách hàng</th>
                    <th class="px-6 py-3 text-left">Tổng tiền</th>
                    <th class="px-6 py-3 text-left">Trạng thái</th>
                    <th class="px-6 py-3 text-left">Lịch sử</th>
                    <th class="px-6 py-3 text-left">Ngày mua</th>
                    <th class="px-6 py-3 text-left">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $order->id }}</td>
                        <td class="px-6 py-4">{{ $order->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-green-600 font-semibold">
                            {{ number_format($order->total_price, 0, ',', '.') }} ₫
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST">
                                @csrf
                                <select name="status_id" onchange="this.form.submit()"
                                    class="px-3 py-2 border rounded-md text-sm text-gray-700 bg-white shadow-sm focus:ring-2 focus:ring-blue-500">
                                    @foreach (\App\Models\Status::where('type', 'order')->where('is_active', 1)->orderBy('priority')->get() as $status)
                                        <option value="{{ $status->id }}" {{ $order->status_id == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.orders.status_logs', $order) }}"
                                class="text-blue-600 hover:underline text-sm">🕘 Xem lịch sử trạng thái</a>
                        </td>
                        <td class="px-6 py-4">{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '-' }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.orders.show', $order) }}"
                                class="text-red bg-blue-600 hover:bg-blue-700 text-xs px-3 py-2 rounded transition">
                                👁️ Xem chi tiết đơn hàng
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-sm text-gray-500">Không có đơn hàng nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4 flex justify-center">
        {{ $orders->appends(request()->except('page'))->links('pagination::tailwind') }}
    </div>
</div>
@endsection
