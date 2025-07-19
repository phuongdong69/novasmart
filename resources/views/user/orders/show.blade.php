@extends('user.layouts.client')

@section('title', 'Chi tiết đơn hàng #' . $order->order_code)
@section('meta_description', 'Xem chi tiết đơn hàng của bạn - Nova Smart')

@section('content')
<section class="relative md:py-24 py-16 bg-white">
    <div class="container relative mx-auto max-w-5xl">
        <div class="grid grid-cols-1 justify-center text-center mb-6">
            <h5 class="font-semibold text-3xl leading-normal mb-4">Đơn hàng #{{ $order->order_code }}</h5>
            <p class="text-slate-400">Chi tiết đơn hàng đã đặt</p>
        </div>

        <div class="bg-white shadow rounded-md p-6 space-y-6">
            {{-- Thông tin đơn hàng --}}
            <div>
                <h6 class="font-semibold text-lg mb-2">Thông tin đơn hàng</h6>
                <p><strong>👤 Người nhận:</strong> {{ $order->name }}</p>
                <p><strong>📞 Số điện thoại:</strong> {{ $order->phoneNumber }}</p>
                <p><strong>📍 Địa chỉ:</strong> {{ $order->address }}</p>
                <p>
                    <strong>📦 Trạng thái:</strong>
                    @if (is_object($order->status))
                        <span class="text-white px-2 py-1 rounded text-sm" style="background-color: {{ $order->status->color ?? '#999' }}">
                            {{ $order->status->name ?? 'Không rõ' }} ({{ $order->status->code ?? '---' }})
                        </span>
                    @else
                        <span class="text-white px-2 py-1 rounded bg-gray-500 text-sm">Không xác định</span>
                    @endif
                </p>
                <p><strong>🕓 Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>

                {{-- Thêm phương thức thanh toán --}}
                <p>
                    <strong>💳 Phương thức thanh toán:</strong>
                    {{ $order->payment->payment_method === 'vnpay' ? 'Thanh toán qua VNPay' : 'Thanh toán khi nhận hàng (COD)' }}
                </p>

                {{-- Thêm ghi chú nếu có --}}
                @if (!empty($order->payment->note))
                    <p><strong>📝 Ghi chú:</strong> {{ $order->payment->note }}</p>
                @endif
            </div>

            {{-- Danh sách sản phẩm --}}
            <div>
                <h6 class="font-semibold text-lg mb-2">Danh sách sản phẩm</h6>
                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200 text-left">
                        <thead class="bg-gray-100 text-sm uppercase">
                            <tr>
                                <th class="p-3">Ảnh</th>
                                <th class="p-3">Sản phẩm</th>
                                <th class="p-3">Giá</th>
                                <th class="p-3">Số lượng</th>
                                <th class="p-3">Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetails as $item)
                                @php
                                    $product = $item->productVariant->product ?? null;
                                    $image = $product->image ?? 'no-image.jpg';
                                @endphp
                                <tr class="border-t">
                                    <td class="p-3">
                                        <img src="{{ asset('storage/' . $image) }}" alt="Ảnh sản phẩm"
                                             class="h-16 w-16 object-cover rounded border">
                                    </td>
                                    <td class="p-3">{{ $product->name ?? '[SP đã xóa]' }}</td>
                                    <td class="p-3">{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                    <td class="p-3">{{ $item->quantity }}</td>
                                    <td class="p-3">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tổng tiền + nút quay lại + huỷ đơn nếu hợp lệ --}}
            <div class="flex flex-col md:flex-row justify-between items-center mt-6 gap-4">
                <h6 class="text-lg font-semibold text-gray-800">
                    💰 Tổng tiền: 
                    <span class="text-orange-600">
                        {{ number_format($order->total_price, 0, ',', '.') }}đ
                    </span>
                </h6>

                <div class="flex gap-3">
                    <a href="{{ route('user.orders.index') }}" class="px-6 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700">
                        ← Trở về danh sách đơn hàng
                    </a>

                    @if ($order->status->code === 'confirm')
                        <form method="POST" action="{{ route('user.orders.cancel', $order->id) }}"
                              onsubmit="return confirm('Bạn chắc chắn muốn huỷ đơn hàng này?')">
                            @csrf
                            <button type="submit"
                                    class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                🗑️ Huỷ đơn hàng
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
