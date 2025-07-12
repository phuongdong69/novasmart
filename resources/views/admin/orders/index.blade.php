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
                            <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" class="inline">
                                @csrf
                                <select name="status_id" onchange="this.form.submit()" class="border rounded px-2 py-1">
                                    @foreach(\App\Models\Status::where('type', 'order')->where('is_active', 1)->orderBy('priority')->get() as $status)
                                        <option value="{{ $status->id }}" @if($order->status_id == $status->id) selected @endif>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </form>
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