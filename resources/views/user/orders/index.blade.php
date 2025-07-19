@extends('user.layouts.client')

@section('title', 'Đơn hàng của tôi')
@section('meta_description', 'Xem và quản lý đơn hàng cá nhân - Nova Smart')

@section('content')
    <section class="relative md:py-24 py-16 bg-white">
        <div class="container max-w-6xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-800">📦 Đơn hàng của tôi</h2>
                <p class="text-gray-500 mt-2">Theo dõi trạng thái đơn hàng của bạn một cách dễ dàng.</p>
            </div>

            {{-- Tabs trạng thái --}}
            <div class="flex justify-center flex-wrap gap-3 mb-8">
                @php
                    $tabs = [
                        '' => 'Tất cả',
                        'confirm' => '🕐 Chờ xác nhận',
                        'shipping' => '🚚 Đang giao',
                        'completed' => '✅ Đã giao',
                        'cancelled' => '❌ Đã hủy',
                    ];
                @endphp

                @foreach ($tabs as $code => $label)
                    <a href="{{ route('user.orders.index', ['status' => $code]) }}"
                        class="px-4 py-2 rounded-md text-sm font-medium shadow-sm
                        {{ $statusFilter === $code ? 'bg-orange-500 text-white' : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            {{-- Danh sách đơn hàng --}}
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700 uppercase font-semibold border-b">
                        <tr>
                            <th class="py-3 px-6">Mã đơn</th>
                            <th class="py-3 px-6">Sản phẩm</th>
                            <th class="py-3 px-6">Ảnh sản phẩm</th>
                            <th class="py-3 px-6">Ngày đặt</th>
                            <th class="py-3 px-6">Trạng thái</th>
                            <th class="py-3 px-6">Tổng tiền</th>
                            <th class="py-3 px-6 text-center">Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            @php
                                $firstDetail = $order->orderDetails->first();
                                $product = $firstDetail->productVariant->product ?? null;
                                $image = $product->image ?? null;
                                $name = $product->name ?? 'Không rõ sản phẩm';
                            @endphp
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 px-6 font-medium text-gray-800">{{ $order->order_code }}</td>
                                <td class="py-4 px-6">{{ $name }}</td>
                                <td class="py-4 px-6">
                                    @if ($image)
                                        <img src="{{ asset('storage/' . $image) }}" alt="Ảnh"
                                            class="w-14 h-14 object-cover rounded">
                                    @else
                                        <span class="text-gray-400 italic">Không có ảnh</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-4 px-6">
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium"
                                        style="background-color: {{ $order->status->color ?? '#e2e8f0' }}; color: white;">
                                        {{ $order->status->name ?? 'Không rõ' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-green-600 font-semibold">
                                    {{ number_format($order->total_price, 0, ',', '.') }} ₫
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <a href="{{ route('user.orders.show', $order->id) }}"
                                        class="text-blue-500 hover:underline">
                                        Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-6 px-6 text-center text-gray-500 italic">
                                    Không có đơn hàng nào phù hợp.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Nút quay lại --}}
            <div class="text-center mt-12">
                <a href="{{ route('user.pages.home') }}"
                    class="px-6 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700">
                    ← Quay lại trang chủ
                </a>
            </div>
        </div>
    </section>
@endsection
