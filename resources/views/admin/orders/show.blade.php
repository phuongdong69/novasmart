@extends('admin.layouts.app')
@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Chi tiết đơn hàng {{ $order->order_code }}</h1>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                Quay lại danh sách
            </a>
            @php
                $orderStatuses = \App\Models\Status::where('type', 'order')->where('is_active', 1)->orderBy('priority')->get();
                $currentStatus = $order->orderStatus;
                $isDelivered = $currentStatus && (
                    str_contains(strtolower($currentStatus->name), 'đã giao hàng') ||
                    str_contains(strtolower($currentStatus->code), 'delivered')
                );
                $cancelStatus = \App\Models\Status::where('type', 'order')->where('code', 'cancelled')->first();
                $allowCancel = $currentStatus && in_array($currentStatus->code, ['pending', 'confirmed']);
            @endphp
            @if ($cancelStatus && $allowCancel)
                <button type="button"
                    onclick="document.getElementById('cancelModal').classList.remove('hidden')"
                    style="background: #ef4444; color: #fff; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px; font-size: 15px; font-weight: 600; padding: 6px 16px; border: none; box-shadow: 0 1px 2px rgba(0,0,0,0.04); transition: background 0.2s;"
                    onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'"
                    title="Hủy đơn hàng">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M4.93 4.93a10 10 0 0114.14 0M4.93 19.07a10 10 0 010-14.14M19.07 19.07a10 10 0 01-14.14 0" />
                    </svg>
                    Hủy đơn
                </button>
            @endif
        </div>
    </div>

    <!-- Modal nhập lý do huỷ cho admin -->
    @if ($cancelStatus && $allowCancel)
        <div id="cancelModal" class="hidden fixed inset-0 bg-white bg-opacity-80 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow max-w-md w-full">
                <h2 class="text-lg font-semibold mb-4">Nhập lý do huỷ đơn hàng</h2>
                <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status_id" value="{{ $cancelStatus->id }}">
                    <textarea name="note" rows="4" required
                        class="w-full border rounded p-2 focus:outline-none focus:ring focus:border-blue-400"
                        placeholder="Vui lòng nhập lý do..."></textarea>
                    <div class="flex justify-end mt-4 gap-3">
                        <button type="button" onclick="document.getElementById('cancelModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400">
                            Đóng
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Xác nhận huỷ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Thông tin đơn hàng -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-bold mb-5 border-b pb-2">Thông tin đơn hàng</h2>
            <div class="grid grid-cols-1 gap-0">
                <div class="flex items-center py-2 border-b last:border-b-0">
                    <span class="text-gray-600 font-medium w-2/5 text-left">Mã đơn hàng:</span>
                    <span class="w-3/5 font-mono text-gray-900 text-left">{{ $order->order_code }}</span>
                </div>
                <div class="flex items-center py-2 border-b last:border-b-0">
                    <span class="text-gray-600 font-medium w-2/5 text-left">Trạng thái:</span>
                    <span class="w-3/5 text-left">
                        @php
                            $orderStatuses = \App\Models\Status::where('type', 'order')->where('is_active', 1)->orderBy('priority')->get();
                            $currentStatus = $order->orderStatus;
                            $isDelivered = $currentStatus && (
                                str_contains(strtolower($currentStatus->name), 'đã giao hàng') ||
                                str_contains(strtolower($currentStatus->code), 'delivered')
                            );
                            $currentStatusIndex = $currentStatus ? $orderStatuses->search(function($status) use ($currentStatus) {
                                return $status->id == $currentStatus->id;
                            }) : -1;
                            $nextStatus = $currentStatusIndex >= 0 && $currentStatusIndex < $orderStatuses->count() - 1 ? $orderStatuses->get($currentStatusIndex + 1) : null;
                            $isLastStatus = $currentStatusIndex === $orderStatuses->count() - 1;
                        @endphp
                        <div class="flex items-center gap-2 flex-wrap">
                            @if($currentStatus && in_array($currentStatus->code, ['cancelled', 'refunded']))
                                <span style="display: inline-block; padding: 6px 12px; background-color: {{ $currentStatus->color ?? '#6b7280' }}; color: white; border-radius: 4px; font-size: 12px; font-weight: 500; min-width: 80px;">
                                    {{ $currentStatus->name }}
                                </span>
                            @elseif($nextStatus && !$isLastStatus && !$isDelivered)
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
                    </span>
                </div>
                <div class="flex items-center py-2 border-b last:border-b-0">
                    <span class="text-gray-600 font-medium w-2/5 text-left">Tổng tiền:</span>
                    <span class="w-3/5 text-lg font-bold text-green-600 text-left">{{ number_format($order->total_price, 0, ',', '.') }} ₫</span>
                </div>
                <div class="flex items-center py-2 border-b last:border-b-0">
                    <span class="text-gray-600 font-medium w-2/5 text-left">Ngày tạo:</span>
                    <span class="w-3/5 text-left">{{ $order->created_at->format('d/m/Y') }}</span>
                </div>
                @if($order->voucher)
                <div class="flex items-center py-2 border-b last:border-b-0">
                    <span class="text-gray-600 font-medium w-2/5 text-left">Mã giảm giá:</span>
                    <span class="w-3/5 text-green-600 text-left">{{ $order->voucher->code }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Thông tin khách hàng -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-bold mb-5 border-b pb-2">Thông tin khách hàng</h2>
            <div class="grid grid-cols-1 gap-0">
                <div class="flex items-center py-2 border-b last:border-b-0">
                    <span class="text-gray-600 font-medium w-2/5 text-left">Họ tên:</span>
                    <span class="w-3/5 text-gray-900 text-left">{{ $order->name }}</span>
                </div>
                <div class="flex items-center py-2 border-b last:border-b-0">
                    <span class="text-gray-600 font-medium w-2/5 text-left">Số điện thoại:</span>
                    <span class="w-3/5 text-gray-900 text-left">{{ $order->phoneNumber }}</span>
                </div>
                <div class="flex items-center py-2 border-b last:border-b-0">
                    <span class="text-gray-600 font-medium w-2/5 text-left">Email:</span>
                    <span class="w-3/5 text-gray-900 text-left">{{ $order->email }}</span>
                </div>
                <div class="flex items-center py-2 border-b last:border-b-0">
                    <span class="text-gray-600 font-medium w-2/5 text-left">Địa chỉ:</span>
                    <span class="w-3/5 text-gray-900 text-left">{{ $order->address }}</span>
                </div>
                @if($order->user)
                <div class="flex items-center py-2 border-b last:border-b-0">
                    <span class="text-gray-600 font-medium w-2/5 text-left">Tài khoản:</span>
                    <span class="w-3/5 text-gray-900 text-left">{{ $order->user->name }} ({{ $order->user->email }})</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="mt-6 bg-white shadow rounded-lg w-full">
        <div class="p-6">
            <h2 class="text-lg font-semibold mb-4">Danh sách sản phẩm</h2>
            <div class="overflow-x-auto w-full">
                <table class="w-full min-w-0 table-auto divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sản phẩm</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Biến thể (SKU)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thuộc tính</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Đơn giá</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Số lượng</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->orderDetails as $detail)
                        <tr>
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center">
                                    @php
                                        $thumb = $detail->productVariant->product->thumbnails->where('is_primary', true)->first();
                                    @endphp
                                    @if($thumb)
                                        <img src="{{ asset('storage/' . $thumb->url) }}" alt="{{ $detail->productVariant->product->name }}" class="w-12 h-12 object-cover rounded mr-3">
                                    @endif
                                    <div>
                                        <div class="font-medium text-base">{{ $detail->productVariant->product->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle text-base text-gray-700">
                                {{ $detail->productVariant->sku ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 align-middle text-base text-gray-900">
                                @php $variant = $detail->productVariant; @endphp
                                @if(isset($variant->variantAttributeValues) && count($variant->variantAttributeValues))
                                    <div class="flex flex-col gap-1">
                                    @foreach($variant->variantAttributeValues as $attrValue)
                                        <span class="inline-block px-2.5 py-0.5 rounded text-base font-semibold bg-blue-100 text-blue-800">
                                            {{ $attrValue->attributeValue->attribute->name ?? '' }}: <span class="font-normal">{{ $attrValue->attributeValue->value ?? '' }}</span>
                                        </span>
                                    @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400">Không có thuộc tính</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 align-middle text-base text-right text-gray-900">
                                {{ number_format($detail->price, 0, ',', '.') }} ₫
                            </td>
                            <td class="px-6 py-4 align-middle text-base text-right text-gray-900">
                                {{ $detail->quantity }}
                            </td>
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
        <h2 class="text-lg font-bold mb-5 border-b pb-2">Thông tin thanh toán</h2>
        <div class="grid grid-cols-1 gap-0">
            <div class="flex items-center py-2 border-b last:border-b-0">
                <span class="text-gray-600 font-medium w-2/5 text-left">Phương thức:</span>
                <span class="w-3/5 text-left">{{ ucfirst($order->payment->payment_method) }}</span>
            </div>
            <div class="flex items-center py-2 border-b last:border-b-0">
                <span class="text-gray-600 font-medium w-2/5 text-left">Trạng thái:</span>
                <span class="w-3/5 text-left">
                    @if($order->payment->status)
                        <span class="px-2 py-1 rounded text-white text-xs font-semibold" style="background-color: {{ $order->payment->status->color ?? '#6b7280' }};">
                            {{ $order->payment->status->name ?? 'Không xác định' }}
                        </span>
                    @else
                        <span class="px-2 py-1 rounded text-xs font-semibold bg-gray-300 text-gray-700">Chưa có</span>
                    @endif
                </span>
            </div>
            @if($order->payment->transaction_code)
            <div class="flex items-center py-2 border-b last:border-b-0">
                <span class="text-gray-600 font-medium w-2/5 text-left">Mã giao dịch:</span>
                <span class="w-3/5 text-left font-mono">{{ $order->payment->transaction_code }}</span>
            </div>
            @endif
            @if($order->payment->note)
            <div class="flex items-center py-2 border-b last:border-b-0">
                <span class="text-gray-600 font-medium w-2/5 text-left">Ghi chú:</span>
                <span class="w-3/5 text-left">{{ $order->payment->note }}</span>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection 