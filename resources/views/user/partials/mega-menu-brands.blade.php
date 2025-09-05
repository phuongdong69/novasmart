<li class="has-submenu parent-parent-menu-item">
    <a href="javascript:void(0)">Thương hiệu</a>
    
    <ul class="submenu megamenu">
        @foreach($topBrands as $brand)
        <li>
            <ul>
                <li class="megamenu-head">{{ $brand->name }}</li>
                @if($brand->products->count() > 0)
                    @foreach($brand->products->take(6) as $product)
                        @if($product->status && $product->status->code === 'active')
                        <li><a href="{{ route('products.show', $product->id) }}" class="sub-menu-item">{{ $product->name }}</a></li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </li>
        @endforeach

        
        <li>
            <ul>
                <li class="megamenu-head">
                    <img src="{{ asset('assets/user/images/Macbook-Pro-M4-2024-SpaceGray--removebg-preview.png') }}" alt="">
                </li>
                <li class="text-center">
                    <a href="{{ route('products.list') }}" 
                       class="py-2 px-5 inline-block font-medium tracking-wide align-middle duration-500 text-base text-center bg-orange-500/10 text-orange-500 rounded-md me-2 mt-2">
                        <i class="mdi mdi-cart-outline"></i> Xem tất cả
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</li>
