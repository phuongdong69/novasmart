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
                                @if (!empty($order->cancel_reason))
                                    - Lý do: ( {{ $order->cancel_reason }} )
                                @endif
                            </span>
                        @else
                            <span class="text-white px-2 py-1 rounded bg-gray-500 text-sm">Không xác định</span>
                        @endif
                    </p>

                    <p>
                        <strong>💳 Trạng thái thanh toán:</strong>
                        @php $payStatus = $order->payment?->status; @endphp
                        @if ($payStatus)
                            <span class="text-white px-2 py-1 rounded text-sm"
                                style="background-color: {{ $payStatus->color ?? '#6b7280' }};">
                                {{ $payStatus->name ?? 'Không rõ' }}
                            </span>
                        @else
                            <span class="text-white px-2 py-1 rounded bg-gray-500 text-sm">Chưa có</span>
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
                                    <th class="p-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderDetails as $item)
                                    @php
                                        $product = $item->productVariant->product ?? null;
                                        $thumb =
                                            $product && $product->thumbnails
                                                ? $product->thumbnails->where('is_primary', true)->first()
                                                : null;
                                                 // Kiểm tra đã đánh giá chưa (theo order_detail_id)
                                        $hasReviewed = \App\Models\Rating::where('order_detail_id', $item->id)
                                                        ->where('user_id', Auth::id())
                                                        ->exists();
                                    @endphp
                                    <tr class="border-t">
                                        <td class="p-3">
                                            @if ($thumb)
                                                <img src="{{ asset('storage/' . $thumb->url) }}" alt="Ảnh sản phẩm"
                                                    class="h-16 w-16 object-cover rounded border">
                                            @else
                                                <img src="{{ asset('assets/user/images/no-image.png') }}" alt="No image"
                                                    class="h-16 w-16 object-cover rounded border">
                                            @endif
                                        </td>
                                        <td class="p-3">{{ $product->name ?? '[SP đã xóa]' }}</td>
                                        <td class="p-3">{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                        <td class="p-3">{{ $item->quantity }}</td>
                                        <td class="p-3">
                                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ
                                        </td>
                                        <td class="p-3 text-center">
                                    @if (
                                        $order->orderStatus &&
                                        $order->orderStatus->code === 'completed' &&
                                        $order->orderStatus->type === 'order' &&
                                        $product &&
                                        !$hasReviewed
                                    )
                                        <button 
                                            type="button"
                                            class="btn-write-review inline-flex items-center justify-center w-10 h-10 bg-blue-600 rounded-full hover:bg-blue-700 transition"
                                            data-product-variant-id="{{ $item->productVariant->id }}"
                                            data-order-detail-id="{{ $item->id }}"
                                            title="Viết đánh giá"
                                        >
                                            <i class="mdi mdi-comment-text-outline text-xl"></i>
                                        </button>
                                    @else
                                        <span class="inline-block w-10 h-10"></span>
                                    @endif
                                </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Tổng tiền + nút quay lại + huỷ đơn nếu hợp lệ --}}
                {{-- Tổng tiền + mã giảm giá --}}
                <div class="bg-gray-50 border p-4 mt-6 rounded-lg">
                    <p class="font-semibold mb-2">💰 Tóm tắt thanh toán:</p>

                    <div class="flex justify-between text-sm mb-1">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($subtotal, 0, ',', '.') }}₫</span>
                    </div>

                    @if ($order->voucher && $discountAmount > 0)
                        <div class="flex justify-between text-sm mb-1">
                            <span>Mã giảm giá: <span
                                    class="text-green-600 font-semibold">{{ $order->voucher->code }}</span></span>
                            <span class="text-red-500">-{{ number_format($discountAmount, 0, ',', '.') }}₫</span>
                        </div>
                    @endif

                    <div class="flex justify-between font-bold border-t pt-2 mt-2 text-base">
                        <span>Tổng thanh toán:</span>
                        <span class="text-green-600">{{ number_format($order->total_price, 0, ',', '.') }}₫</span>
                    </div>
                </div>





                {{-- Các nút hành động --}}
                <div class="flex flex-col md:flex-row justify-between items-center mt-6 gap-4">
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
<style>
        .custom-toast {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    min-width: 260px;
    max-width: 360px;
    background-color: #16a34a; /* xanh lá - success */
    color: #fff;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    animation: slideIn 0.3s ease-out;
    font-size: 14px;
    line-height: 1.4;
    transition: opacity 0.4s ease-out;
}

.toast-icon {
    width: 20px;
    height: 20px;
    stroke: #fff;
}

.toast-message {
    flex: 1;
    font-weight: 600;
}

.toast-close {
    background: transparent;
    border: none;
    color: #fff;
    cursor: pointer;
}

.toast-close-icon {
    width: 16px;
    height: 16px;
    stroke: #fff;
}

.toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 4px;
    background-color: #a3e635; /* lime-400 */
    animation: progressBar 4s linear forwards;
    width: 100%;
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
}

/* Hiệu ứng */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(50%);
    }

    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes progressBar {
    from {
        width: 100%;
    }

    to {
        width: 0%;
    }
}

/* ✅ Style riêng cho toast-error */
#toast-error {
    background-color: #dc2626; /* đỏ */
    color: #fff;
}

#toast-error .toast-progress {
    background-color: #f87171; /* đỏ nhạt */
}

#toast-error .toast-icon,
#toast-error .toast-close-icon {
    stroke: #fff;
}
</style>
{{-- Popup & Toast đặt cuối content --}}
@include('user.partials.popup-review')
@include('user.partials.toast')

@endsection

@push('scripts')
<script>
    window.isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
</script>
<script src="{{ asset('assets/user/js/review.js') }}"></script>
@endpush
