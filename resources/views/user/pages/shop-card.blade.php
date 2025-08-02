@extends('user.layouts.client')

@section('title', 'Giỏ hàng')

@section('content')
<section class="relative w-full py-16 lg:py-20 bg-gray-50 dark:bg-slate-800">
    <div class="container">
        <div class="grid grid-cols-1 mt-10">
            <h3 class="text-3xl font-semibold">Giỏ hàng</h3>
        </div>

        <ul class="mt-4 tracking-[0.5px]">
            <li class="inline-block uppercase text-[13px] font-bold hover:text-orange-500">
                <a href="{{ route('home') }}">Trang chủ</a>
            </li>
            <li class="inline-block text-base text-slate-950 dark:text-white mx-1">
                <i class="mdi mdi-chevron-right"></i>
            </li>
            <li class="inline-block uppercase text-[13px] font-bold text-orange-500">Giỏ hàng</li>
        </ul>
        @if (session('success'))
        <div id="toast-success" class="custom-toast">
            <svg class="toast-icon" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <span class="toast-message">{{ session('success') }}</span>
            <button class="toast-close" onclick="this.parentElement.remove()">
                <svg xmlns="http://www.w3.org/2000/svg" class="toast-close-icon" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="toast-progress"></div>
        </div>
        @endif
        @if (session('error'))
        <div id="toast-error" class="custom-toast bg-red-600">
        <svg class="toast-icon" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M12 2a10 10 0 1010 10A10 10 0 0012 2z" />
        </svg>
        <span class="toast-message">{{ session('error') }}</span>
        <button class="toast-close" onclick="this.parentElement.remove()">
            <svg xmlns="http://www.w3.org/2000/svg" class="toast-close-icon" fill="none" stroke="currentColor"
                 stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="toast-progress bg-red-400"></div>
        </div>
        @endif

        @if (!empty($cart['items']) && count($cart['items']) > 0)
        @php
        $selectedIds = explode(',', old('selected_ids', request('selected_ids', session('voucher_selected_ids') ? implode(',', session('voucher_selected_ids')) : '')));
        @endphp

        <div class="cart-grid mt-8">
            <div class="cart-left bg-white p-6 rounded-lg shadow-md">
                <table class="w-full text-start min-w-[700px]">
                    <thead class="text-sm uppercase bg-slate-100 text-gray-700">
                        <tr>
                            <th class="p-4 text-center">
                                <input type="checkbox" id="check-all" class="form-checkbox text-orange-500 rounded">
                            </th>
                            <th class="p-4 text-start">Sản phẩm</th>
                            <th class="p-4 text-center">Đơn giá</th>
                            <th class="p-4 text-center">Số lượng</th>
                            <th class="p-4 text-right">Tạm tính</th>
                            <th class="p-4 text-center">
                                <form method="POST" action="{{ route('cart.removeselected') }}" id="remove-selected-form" class="mb-4">
                                    @csrf
                                    <input type="hidden" name="selected_ids" id="selected-ids-remove">
                                    <button type="submit" class="p-2 text-600 hover:text-800 rounded-full">
                                        <i class="mdi mdi-delete-outline text-2xl"></i>
                                    </button>
                                </form>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($cart['items'] as $item)
                        @php
                        $isObject = is_object($item);
                        $variant = $isObject ? $item->productVariant : ($item['variant'] ?? null);
                        $product = $isObject ? $item->productVariant->product : ($item['product'] ?? null);
                        $quantity = $isObject ? $item->quantity : ($item['quantity'] ?? 1);
                        $price = $variant->price ?? 0;
                        $total = $quantity * $price;
                        $id = $isObject ? $item->id : ($item['variant']->id ?? 0);
                        $thumbnail = $product->thumbnails->where('is_primary', true)->first();
                        $imageUrl = $thumbnail ? asset('storage/' . $thumbnail->url) : ($product->image ? asset('storage/' . $product->image) : asset('images/default-product.jpg'));
                        $isProductInactive = $product->status?->code !== 'active';
                        $isVariantOutOfStock = $variant->quantity == 0 || $variant->status?->code === 'out_of_stock';
                        $outOfStock = $isProductInactive || $isVariantOutOfStock;
                        $statusMessage = '';
                        if ($isProductInactive) {
                        $statusMessage = 'Sản phẩm không hoạt động';
                        } elseif ($isVariantOutOfStock) {
                        $statusMessage = 'Sản phẩm hết hàng';
                        }
                        @endphp
                        <tr class="border-b border-gray-100 dark:border-gray-800 {{ $outOfStock ? 'row-disabled' : '' }}"
                            data-out-of-stock="{{ $outOfStock ? '1' : '0' }}"
                            title="{{ $statusMessage }}">

                            <td class="p-4 text-center">
                                <input type="checkbox"
                                    class="item-checkbox form-checkbox text-orange-500 rounded"
                                    value="{{ $variant->id }}"
                                    {{ in_array($variant->id, $selectedIds) ? 'checked' : '' }}
                                    {{ $outOfStock ? 'disabled' : '' }}>
                            </td>

                            <td class="p-4">
                                <div class="flex items-start gap-3">
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}"
                                        class="w-20 h-20 rounded-md object-cover border border-gray-200 dark:border-gray-700 shadow-sm">
                                    <div>
                                        <span class="font-semibold block">{{ $product->name }}</span>

                                        @if ($outOfStock && $statusMessage)
                                        <span class="text-xs text-red-500 italic mt-1 block">{{ $statusMessage }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="p-4 text-center">
                                <span class="unit-price" data-price="{{ $price }}">{{ number_format($price, 0, ',', '.') }}₫</span>
                            </td>

                            <td class="p-4 text-center">
                                <div class="form-update-qty" data-id="{{ $id }}">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button"
                                            class="btn-decrease size-9 flex items-center justify-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white"
                                            {{ $outOfStock ? 'disabled' : '' }}>-</button>
                                        <input type="number"
                                            name="quantity"
                                            value="{{ $quantity }}"
                                            readonly
                                            min="1"
                                            max="{{ $variant->quantity }}"
                                            data-max="{{ $variant->quantity }}"
                                            class="quantity-input h-9 text-center rounded-md bg-orange-500/5 text-orange-500 w-16"
                                            {{ $outOfStock ? 'disabled' : '' }}>
                                        <button type="button"
                                            class="btn-increase size-9 flex items-center justify-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white"
                                            {{ $outOfStock ? 'disabled' : '' }}>+</button>
                                    </div>
                                    <div class="error-message text-sm text-red-500 mt-1 hidden"></div>
                                </div>
                            </td>

                            <td class="p-4 text-end">
                                <span class="item-total">{{ number_format($total, 0, ',', '.') }}₫</span>
                            </td>

                            <td class="p-4 text-center">
                                <form method="POST" action="{{ route('cart.remove', $id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text--600 hover:text-800">
                                        <i class="mdi mdi-delete-outline text-2xl"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6 text-end">
                    <a href="{{ route('home') }}" class="custom-btn full-width back-btn">← Tiếp tục xem sản phẩm</a>
                </div>
            </div>

            <div class="cart-summary-wrapper">
                <div class="cart-summary">
                    <h4 class="text-xl font-bold mb-4">Tổng tiền giỏ hàng</h4>
                    @php
                    $cartTotal = $cart['total_price'] ?? 0;
                    $voucher = session('voucher') ?? [];
                    $voucherDiscount = $cart['voucher_value'] ?? ($voucher['discount'] ?? 0);
                    $finalTotal = $cart['final'] ?? ($cartTotal - $voucherDiscount);
                    @endphp

                    <div class="flex justify-between py-1 text-gray-700 dark:text-gray-300">
                        <span>Tạm tính</span>
                        <span id="temp-value">{{ number_format($cartTotal, 0, ',', '.') }} VNĐ</span>
                    </div>

                    @if(session('voucher') && session('voucher_selected_ids') && count(session('voucher_selected_ids')) > 0)
                    <div class="voucher-info-wrapper">
                        <div class="p-3 flex justify-between items-center bg-gray-50 text-green-600">
                            <div>
                                <h5 class="font-semibold">Mã giảm giá</h5>
                                <p class="text-sm">{{ session('voucher')['code'] }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <form action="{{ route('cart.remove-voucher') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-lg">✕</button>
                                </form>
                            </div>
                        </div>
                        <div class="flex justify-between text-red-600 mt-2">
                            <span>Giảm giá</span>
                            <span id="discount-display">-{{ number_format($voucherDiscount, 0, ',', '.') }}₫</span>
                            <span id="discount-value" data-discount="{{ $voucherDiscount }}" class="hidden"></span>
                        </div>
                        <span id="voucher-active-flag" data-has-voucher="true" class="hidden"></span>
                    </div>
                    @endif


                    <div class="flex justify-between font-bold text-lg text-black dark:text-white py-2 border-t border-gray-200 mt-2">
                        <span>Tổng cộng</span>
                        <span id="total-value">{{ number_format(max($finalTotal, 0), 0, ',', '.') }} VNĐ</span>
                    </div>

                    <div class="mt-6">
                        <form id="voucher-form" class="relative" action="{{ route('cart.apply-voucher') }}" method="POST">
                            @csrf
                            <input type="hidden" name="selected_ids" id="selected_ids">
                            <input type="text" name="voucher_code"
                                class="py-3 pe-40 ps-6 w-full h-[50px] rounded-full bg-white border shadow-sm"
                                placeholder="Mã giảm giá">
                            <button type="submit"
                                class="py-2 px-5 absolute top-[2px] end-[3px] h-[46px] bg-orange-500 text-white rounded-full">
                                Áp dụng
                            </button>
                        </form>
                    </div>

                    <form id="cart-actions-form" method="POST" action="{{ route('cart.selected') }}" class="mt-4">
                        @csrf
                        <input type="hidden" name="selected_ids" id="selected_ids">
                        <button type="submit"
                            class="py-3 px-6 w-full rounded-full bg-orange-500 text-white text-center text-sm font-semibold hover:bg-orange-600 transition">
                            Tiến hành thanh toán
                        </button>
                    </form>

                </div>
            </div>
        </div>
        @else
        <div id="empty-cart" class="flex flex-col items-center justify-center py-32 bg-gray-50 dark:bg-slate-800 rounded-md mt-12">
            <p class="mb-6 text-lg font-medium text-gray-800 dark:text-white">Chưa có sản phẩm trong giỏ hàng.</p>
            <a href="{{ route('home') }}">
                <button class="px-4 py-2 inline-flex items-center justify-center gap-2 tracking-wide align-middle duration-500 text-sm text-center rounded-full bg-orange-500 hover:bg-orange-600 border border-orange-500 text-white hover:scale-105 transition-all">
                    Trang chủ
                </button>
            </a>
        </div>
        @endif
    </div>
</section>
<style>
    @media (min-width: 1024px) {
        .cart-grid {
            display: flex;
            gap: 2.5rem;
            align-items: flex-start;
            justify-content: center;
        }

        .cart-left {
            flex: 0 0 100%;
        }

        .cart-summary-wrapper {
            flex: 0 0 35%;
        }
    }

    .cart-summary-wrapper {
        display: flex;
        flex-direction: column;
    }

    .cart-summary {
        background: white;
        padding: 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
    }

    .cart-summary h4 {
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 0.75rem;
        color: #1f2937;
    }

    .discount-input-wrapper {
        display: flex;
        align-items: center;
        border: 1px solid #d1d5db;
        border-radius: 9999px;
        overflow: hidden;
        background-color: #fff;
    }

    .discount-input-wrapper input {
        flex: 1;
        padding: 0.625rem 1rem;
        border: none;
        font-size: 0.875rem;
        outline: none;
        background: transparent;
    }

    .discount-input-wrapper input::placeholder {
        color: #9ca3af;
    }

    .discount-input-wrapper button {
        background-color: #f97316;
        color: white;
        font-weight: 600;
        padding: 0.5rem 1.25rem;
        font-size: 0.875rem;
        transition: background-color 0.3s;
    }

    .discount-input-wrapper button:hover {
        background-color: #ea580c;
    }

    #cart-actions-form button {
        width: 100%;
        padding: 0.75rem 1.5rem;
        border-radius: 9999px;
        font-size: 1rem;
        font-weight: 600;
        color: white;
        background: linear-gradient(to right, #f97316, #fb923c);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
        transition: filter 0.3s;
    }

    #cart-actions-form button:hover {
        filter: brightness(1.1);
    }

    .custom-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        font-weight: 600;
        color: white;
        border-radius: 9999px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
        transition: filter 0.3s;
        background: linear-gradient(to right, #f97316, #fb923c);
        text-decoration: none;
    }

    .custom-btn:hover {
        filter: brightness(1.1);
    }

    .full-width {
        width: 30%;
    }

    .back-btn {
        margin-top: 1rem;
    }

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
        background-color: #16a34a;
        /* xanh lá đậm */
        color: #fff;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        animation: slideIn 0.3s ease-out;
        font-size: 14px;
        line-height: 1.4;
    }

    .toast-icon {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
        stroke: #fff;
    }

    .toast-message {
        flex: 1;
        font-weight: 600;
        word-break: break-word;
    }

    .toast-close {
        background: transparent;
        border: none;
        color: #fff;
        cursor: pointer;
        transition: opacity 0.2s;
        padding: 0;
    }

    .toast-close:hover {
        opacity: 0.7;
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
        background-color: #a3e635;
        /* lime-400 */
        animation: progressBar 4s linear forwards;
        width: 100%;
        border-bottom-left-radius: 6px;
        border-bottom-right-radius: 6px;
    }
    #toast-error {
    background-color: #dc2626; /* đỏ */
    }

    #toast-error .toast-progress {
        background-color: #f87171; /* đỏ nhạt */
    }
    /* Animations */
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

    .tr-out-of-stock {
        opacity: 0.5;
        pointer-events: none;
        position: relative;
        background-color: #f9fafb;
    }

    .tr-out-of-stock td {
        pointer-events: none;
    }

    .tr-out-of-stock td:last-child {
        pointer-events: all;
        /* Cho phép bấm nút XÓA */
    }

    .row-disabled {
        opacity: 0.6;
        background-color: #f9fafb;
        /* light gray */
        pointer-events: none;
    }

    .row-disabled * {
        pointer-events: none;
    }

    .row-disabled form,
    .row-disabled button[type="submit"] {
        pointer-events: auto;
        opacity: 1;
    }
</style>

<script src="{{ asset('assets/user/js/shop-cart.js') }}"></script>
@endsection