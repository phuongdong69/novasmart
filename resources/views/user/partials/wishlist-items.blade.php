@forelse($wishlists as $wishlist)
    @php
        $product = $wishlist->productVariant->product;
        $variant = $wishlist->productVariant;
        $thumbnail = $product->thumbnails->where('is_primary', true)->first();
        $imageUrl = $thumbnail
            ? asset('storage/' . $thumbnail->url)
            : asset('images/default-product.jpg');
    @endphp
    <li class="wishlist-item">
        <a href="{{ route('products.show', $variant->id) }}" class="flex items-center justify-between py-1.5 px-4">
            <div class="flex items-center gap-3 overflow-hidden w-full">
                <img src="{{ $imageUrl }}" alt="{{ $product->name }}"
                    class="w-12 h-12 object-center object-cover aspect-square rounded shadow-sm border border-gray-200 dark:border-gray-700 bg-white" />
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm truncate">{{ $product->name }}</p>
                    <p class="text-sm text-slate-400">{{ number_format($variant->price, 0, ',', '.') }}₫</p>
                </div>
            </div>
                         <button onclick="toggleWishlist({{ $variant->id }}, this)" 
                 class="wishlist-btn ms-2 text-red-500 hover:text-red-700 liked cursor-pointer"
                 data-product-variant-id="{{ $variant->id }}">
                 <i data-feather="heart" class="size-4"></i>
             </button>
        </a>
    </li>
@empty
    <li class="px-4 py-2 text-center text-sm text-gray-500">Danh sách yêu thích đang trống.</li>
@endforelse 