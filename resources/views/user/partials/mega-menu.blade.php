<li class="has-submenu parent-parent-menu-item">
    <a href="javascript:void(0)">Sản phẩm</a>
    
    <ul class="submenu megamenu">
        @foreach($menuCategories as $category)
        <li>
            <ul>
                <li class="megamenu-head">{{ $category->name }}</li>
                @if($category->brands->count() > 0)
                    @foreach($category->brands->take(6) as $brand)
                    <li><a href="{{ route('products.list') }}?brand={{ urlencode($brand->name) }}" class="sub-menu-item">{{ $brand->name }}</a></li>
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