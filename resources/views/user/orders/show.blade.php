@extends('user.layouts.client')

@section('title', 'Chi tiết đơn hàng #' . $order->order_code)
@section('meta_description', 'Xem chi tiết đơn hàng của bạn - Nova Smart')

@section('content')
    <section class="relative md:py-24 py-16 bg-white">
        <div class="container relative mx-auto max-w-5xl">
            {{-- Thông báo flash --}}
            @if (session('success'))
                <div class="mb-6 px-4 py-3 rounded border border-green-300 bg-green-50 text-green-800 shadow">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 px-4 py-3 rounded border border-red-300 bg-red-50 text-red-800 shadow">
                    ❌ {{ session('error') }}
                </div>
            @endif

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
                        @if (is_object($order->orderStatus))
                            <span class="text-white px-2 py-1 rounded text-sm"
                                style="background-color: {{ $order->orderStatus->color ?? '#999' }};">
                                {{ $order->orderStatus->name ?? 'Không rõ' }} 
                            </span>
                        @else
                            <span class="text-white px-2 py-1 rounded bg-gray-500 text-sm">Không xác định</span>
                        @endif
                    </p>
                    <p><strong>🕓 Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>

                    {{-- Phương thức thanh toán --}}
                    <p>
                        <strong>💳 Phương thức thanh toán:</strong>
                        {{ $order->payment->payment_method === 'vnpay' ? 'Thanh toán qua VNPay' : 'Thanh toán khi nhận hàng (COD)' }}
                    </p>

                    {{-- Ghi chú nếu có --}}
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
                                        $thumb = $product && $product->thumbnails ? $product->thumbnails->where('is_primary', true)->first() : null;
                                    @endphp
                                    <tr class="border-t">
                                        <td class="p-3">
                                            @if($thumb)
                                                <img src="{{ asset('storage/' . $thumb->url) }}" alt="Ảnh sản phẩm" class="h-16 w-16 object-cover rounded border">
                                            @else
                                                <img src="{{ asset('assets/user/images/no-image.png') }}" alt="No image" class="h-16 w-16 object-cover rounded border">
                                            @endif
                                        </td>
                                        <td class="p-3">{{ $product->name ?? '[SP đã xóa]' }}</td>
                                        <td class="p-3">{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                        <td class="p-3">{{ $item->quantity }}</td>
                                        <td class="p-3">
                                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ
                                        </td>
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
                        @if ($order->orderStatus && $order->orderStatus->code === 'delivered')
                            <form method="POST" action="{{ route('user.orders.confirm-received', $order->id) }}"
                                onsubmit="return confirm('Bạn xác nhận đã nhận được đơn hàng này?')">
                                @csrf
                                <button type="submit"
                                    class="inline-block font-semibold px-6 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700">
                                    ✅ Tôi đã nhận hàng
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('user.orders.index') }}"
                            class="px-6 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700">
                            ← Trở về danh sách đơn hàng
                        </a>

                        @if ($order->orderStatus && $order->orderStatus->code === 'pending')
                            <!-- Nút mở modal huỷ -->
                            <button type="button"
                                onclick="document.getElementById('cancelModal').classList.remove('hidden')"
                                class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                🗑️ Huỷ đơn hàng
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal nhập lý do huỷ -->
    @if ($order->orderStatus && $order->orderStatus->code === 'pending')
        <div id="cancelModal" class="hidden fixed inset-0 bg-white bg-opacity-80 flex items-center justify-center z-50">

            <div class="bg-white p-6 rounded-lg shadow max-w-md w-full">
                <h2 class="text-lg font-semibold mb-4">Nhập lý do huỷ đơn hàng</h2>
                <form method="POST" action="{{ route('user.orders.cancel', $order->id) }}">
                    @csrf
                    <textarea name="note" rows="4" required
                        class="w-full border rounded p-2 focus:outline-none focus:ring focus:border-blue-400"
                        placeholder="Vui lòng nhập lý do..."></textarea>
                    <div class="flex justify-end mt-4 gap-3">
                        <button type="button" onclick="document.getElementById('cancelModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400">
                            Hủy
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Xác nhận huỷ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection
