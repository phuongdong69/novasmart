<li class="has-submenu parent-parent-menu-item">
    <a href="javascript:void(0)">Sản phẩm</a>
    
    <ul class="submenu megamenu">
        <li>
            <ul>
                <li class="megamenu-head">Laptop</li>
                <li><a href="{{ route('products.list') }}?brand=Apple" class="sub-menu-item">Apple</a></li>
                <li><a href="{{ route('products.list') }}?brand=Dell" class="sub-menu-item">Dell</a></li>
                <li><a href="{{ route('products.list') }}?brand=HP" class="sub-menu-item">HP</a></li>
                <li><a href="{{ route('products.list') }}?brand=Lenovo" class="sub-menu-item">Lenovo</a></li>
                <li><a href="{{ route('products.list') }}?brand=Asus" class="sub-menu-item">Asus</a></li>
                <li><a href="{{ route('products.list') }}?brand=Acer" class="sub-menu-item">Acer</a></li>
            </ul>
        </li>
        
        <li>
            <ul>
                <li class="megamenu-head">Điện thoại</li>
                <li><a href="{{ route('products.list') }}?brand=Apple" class="sub-menu-item">Apple (iPhone)</a></li>
                <li><a href="{{ route('products.list') }}?brand=Samsung" class="sub-menu-item">Samsung</a></li>
                <li><a href="{{ route('products.list') }}?brand=Xiaomi" class="sub-menu-item">Xiaomi</a></li>
                <li><a href="{{ route('products.list') }}?brand=OPPO" class="sub-menu-item">OPPO</a></li>
                <li><a href="{{ route('products.list') }}?brand=Vivo" class="sub-menu-item">Vivo</a></li>
            </ul>
        </li>
        
        <li>
            <ul>
                <li class="megamenu-head">Máy tính bảng</li>
                <li><a href="{{ route('products.list') }}?brand=Apple" class="sub-menu-item">Apple (iPad)</a></li>
                <li><a href="{{ route('products.list') }}?brand=Samsung" class="sub-menu-item">Samsung</a></li>
                <li><a href="{{ route('products.list') }}?brand=Xiaomi" class="sub-menu-item">Xiaomi</a></li>
            </ul>
        </li>

        <li>
            <ul>
                <li class="megamenu-head">Thương hiệu nổi bật</li>
                <li><a href="{{ route('products.list') }}?brand=Apple" class="sub-menu-item">Apple</a></li>
                <li><a href="{{ route('products.list') }}?brand=Samsung" class="sub-menu-item">Samsung</a></li>
                <li><a href="{{ route('products.list') }}?brand=Dell" class="sub-menu-item">Dell</a></li>
                <li><a href="{{ route('products.list') }}?brand=HP" class="sub-menu-item">HP</a></li>
                <li><a href="{{ route('products.list') }}?brand=Lenovo" class="sub-menu-item">Lenovo</a></li>
            </ul>
        </li>
        
        <li>
            <ul>
                <li class="megamenu-head">
                    <img src="{{ asset('assets/user/images/cta.png') }}" alt="">
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