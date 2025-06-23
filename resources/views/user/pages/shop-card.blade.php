{{-- layout file: shop-cart.blade.php --}}
@extends('user.layouts.client')

@section('title', 'Shopcart')

@section('content')
<!-- HERO SECTION -->
<section class="relative table w-full py-20 lg:py-24 bg-gray-50 dark:bg-slate-800">
    <!-- ... hero section giữ nguyên ... -->
</section>

<!-- CART TABLE -->
<section class="relative md:py-24 py-16">
    <div class="container relative">
        <div class="grid lg:grid-cols-1">
            <div class="relative overflow-x-auto shadow-sm dark:shadow-gray-800 rounded-md">
                <table class="w-full text-start">
                    <thead class="text-sm uppercase bg-slate-50 dark:bg-slate-800">
                        <tr>
                            <th class="p-4 w-4"></th>
                            <th class="text-start p-4 min-w-[220px]">Product</th>
                            <th class="p-4 w-24 text-center">Price</th>
                            <th class="p-4 w-56 text-center">Qty</th>
                            <th class="p-4 w-24 text-right">Total($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cart['items'] ?? [] as $item)
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
                        @endphp
                        <tr class="bg-white dark:bg-slate-900 border-t border-gray-100 dark:border-gray-800">
                            <td class="p-4 align-middle">
                                <form method="POST" action="{{ route('cart.remove', $id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="mdi mdi-window-close"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="p-4 align-middle">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}"
                                        class="w-20 h-20 rounded-md object-cover border border-gray-200 dark:border-gray-700 shadow-sm">
                                    <span class="font-semibold">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-center align-middle">
                                <span>${{ number_format($price, 2) }}</span>
                            </td>
                            <td class="p-4 text-center align-middle">
                                <div class="form-update-qty" data-id="{{ $id }}">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" class="btn-decrease size-9 flex items-center justify-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white">-</button>
                                        <input type="number" name="quantity" value="{{ $quantity }}" min="1" class="quantity-input h-9 text-center rounded-md bg-orange-500/5 text-orange-500 w-16">
                                        <button type="button" class="btn-increase size-9 flex items-center justify-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white">+</button>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-end align-middle">
                                <span class="item-total">${{ number_format($total, 2) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-6">Giỏ hàng của bạn đang trống.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.querySelectorAll('.form-update-qty').forEach(form => {
        const id = form.dataset.id;
        const input = form.querySelector('.quantity-input');
        const btnIncrease = form.querySelector('.btn-increase');
        const btnDecrease = form.querySelector('.btn-decrease');
        const totalCell = form.closest('tr').querySelector('.item-total');

        function updateQty(newQty) {
            fetch(`/cart/update/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ quantity: newQty })
            })
            .then(res => {
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    input.value = newQty;
                    totalCell.textContent = `$${data.item_total}`;
                }
            })
            .catch(err => {
                console.error('Update failed:', err);
            });
        }

        btnIncrease.addEventListener('click', () => {
            const currentQty = parseInt(input.value);
            const newQty = currentQty + 1;
            updateQty(newQty);
        });

        btnDecrease.addEventListener('click', () => {
            const currentQty = parseInt(input.value);
            if (currentQty > 1) {
                const newQty = currentQty - 1;
                updateQty(newQty);
            }
        });

        input.addEventListener('change', () => {
            const newQty = Math.max(1, parseInt(input.value));
            updateQty(newQty);
        });
    });
</script>
@endpush
@endsection
