@extends('admin.layouts.app')
@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Chi tiết đơn hàng #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
            Quay lại danh sách
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Thông tin đơn hàng -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Thông tin đơn hàng</h2>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="font-medium">Mã đơn hàng:</span>
                    <span class="font-mono">{{ $order->order_code }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Trạng thái:</span>
                    <span class="px-2 py-1 rounded text-white text-sm" style="background-color: {{ $order->orderStatus->color ?? '#6b7280' }}">
                        {{ $order->orderStatus->name ?? 'Chưa có trạng thái' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Tổng tiền:</span>
                    <span class="font-semibold text-lg">{{ number_format($order->total_price, 0, ',', '.') }} ₫</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium">Ngày tạo:</span>
                    <span>{{ $order->created_at->format('d/m/Y H:i:s') }}</span>
                </div>
                @if($order->voucher)
                <div class="flex justify-between">
                    <span class="font-medium">Mã giảm giá:</span>
                    <span class="text-green-600">{{ $order->voucher->code }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Thông tin khách hàng -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Thông tin khách hàng</h2>
            <div class="space-y-3">
                <div>
                    <span class="font-medium">Họ tên:</span>
                    <span>{{ $order->name }}</span>
                </div>
                <div>
                    <span class="font-medium">Số điện thoại:</span>
                    <span>{{ $order->phoneNumber }}</span>
                </div>
                <div>
                    <span class="font-medium">Email:</span>
                    <span>{{ $order->email }}</span>
                </div>
                <div>
                    <span class="font-medium">Địa chỉ:</span>
                    <span>{{ $order->address }}</span>
                </div>
                @if($order->user)
                <div>
                    <span class="font-medium">Tài khoản:</span>
                    <span>{{ $order->user->name }} ({{ $order->user->email }})</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="mt-6 bg-white shadow rounded-lg">
        <div class="p-6">
            <h2 class="text-lg font-semibold mb-4">Danh sách sản phẩm</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sản phẩm</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Biến thể</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Đơn giá</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Số lượng</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->orderDetails as $detail)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($detail->productVariant->product->thumbnails->where('is_primary', true)->first())
                                        <img src="{{ asset('storage/' . $detail->productVariant->product->thumbnails->where('is_primary', true)->first()->url) }}" 
                                             alt="{{ $detail->productVariant->product->name }}" 
                                             class="w-12 h-12 object-cover rounded mr-3">
                                    @endif
                                    <div>
                                        <div class="font-medium">{{ $detail->productVariant->product->name }}</div>
                                        <div class="text-sm text-gray-500">SKU: {{ $detail->productVariant->sku ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $detail->productVariant->name ?? 'Mặc định' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ number_format($detail->price, 0, ',', '.') }} ₫</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $detail->quantity }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} ₫</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Thông tin thanh toán -->
    @if($order->payment)
    <div class="mt-6 bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Thông tin thanh toán</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <span class="font-medium">Phương thức:</span>
                <span class="ml-2">{{ ucfirst($order->payment->payment_method) }}</span>
            </div>
            <div>
                <span class="font-medium">Trạng thái:</span>
                <span class="ml-2 px-2 py-1 rounded text-white text-sm 
                    {{ $order->payment->status === 'completed' ? 'bg-green-500' : 
                       ($order->payment->status === 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                    {{ ucfirst($order->payment->status) }}
                </span>
            </div>
            @if($order->payment->transaction_code)
            <div>
                <span class="font-medium">Mã giao dịch:</span>
                <span class="ml-2 font-mono">{{ $order->payment->transaction_code }}</span>
            </div>
            @endif
            @if($order->payment->note)
            <div>
                <span class="font-medium">Ghi chú:</span>
                <span class="ml-2">{{ $order->payment->note }}</span>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection 