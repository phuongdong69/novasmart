<div class="tagline bg-slate-900">
    <div class="container relative">
        <div class="grid grid-cols-1">
            <div class="text-center">
                <h6 class="text-white font-medium">Được làm bởi Dev Nova 🎉</h6>
            </div>
        </div>
    </div>
</div>
<nav id="topnav" class="defaultscroll is-sticky tagline-height">
    <div class="container relative flex items-center justify-between">
        <!-- Logo container-->
        <a class="logo flex items-center gap-3 hover:opacity-80 transition-opacity duration-300" href="/">
            <img src="{{ asset('assets/user/images/logonova.jpg') }}" alt="NovaSmart Logo" style="max-height:48px; width:auto; display:block; border-radius:50%; object-fit:cover;"/>
            <div class="flex flex-col">
                <span class="text-2xl font-bold text-slate-800 dark:text-white leading-tight">NovaSmart</span>
                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium -mt-1">Uy tín chất lượng</span>
            </div>
        </a>
        <!-- End Logo container-->
        <div class="flex-1 flex items-center justify-center">
            <div id="navigation" class="w-auto">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">

                    @include('user.partials.mega-menu')

                    @include('user.partials.mega-menu-brands')

                    <li><a href="{{ route('news.index') }}" class="sub-menu-item">Tin tức</a></li>

                    <li><a href="{{ route('about') }}" class="sub-menu-item">Về chúng tôi</a></li>
                </ul>
            </div>
        </div>
        <ul class="buy-button list-none mb-0 flex items-center space-x-2">
            <li class="dropdown inline-block relative pe-1">
                <!-- Dropdown menu -->
                <div class="dropdown-menu absolute overflow-hidden end-0 m-0 mt-5 z-10 md:w-52 w-48 rounded-md bg-white dark:bg-slate-900 shadow-sm dark:shadow-gray-800 hidden"
                    onclick="event.stopPropagation();">
                    <div class="relative">
                        <i data-feather="search" class="absolute size-4 top-[9px] end-3"></i>
                        <input type="text"
                            class="h-9 px-3 pe-10 w-full border-0 focus:ring-0 outline-none bg-white dark:bg-slate-900 shadow-sm dark:shadow-gray-800"
                            name="s" id="searchItem" placeholder="Search...">
                    </div>
                </div>
            </li>

            <li class="dropdown inline-block relative ps-2">
                <button data-dropdown-toggle="dropdown"
                    class="dropdown-toggle size-9 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-base text-center rounded-full bg-orange-500 border border-orange-500 text-white"
                    type="button">
                    <i data-feather="shopping-cart" class="h-4 w-4"></i>
                </button>
                <!-- Dropdown menu -->
                <div class="dropdown-menu absolute end-0 mt-4 z-10 w-72 rounded-md bg-white dark:bg-slate-900 shadow-sm dark:shadow-gray-800 hidden"
                    onclick="event.stopPropagation();">
                    <ul class="py-3 text-start" aria-labelledby="dropdownDefault">
                        @php
                            $cartItems = $cart['items'] ?? [];
                            $cartTotal = 0;
                        @endphp

                        @forelse ($cartItems as $item)
                            @php
                                $isObject = is_object($item);
                                $variant = $isObject ? $item->productVariant : $item['variant'] ?? null;
                                $product = $isObject ? $item->productVariant->product : $item['product'] ?? null;
                                $quantity = $isObject ? $item->quantity : $item['quantity'] ?? 1;
                                $price = $variant->price ?? ($item['price'] ?? 0);
                                $subtotal = $price * $quantity;
                                $cartTotal += $subtotal;

                                $thumbnail = $product->thumbnails->where('is_primary', true)->first();
                                $imageUrl = $thumbnail
                                    ? asset('storage/' . $thumbnail->url)
                                    : asset('images/default-product.jpg');
                            @endphp

                            <li>
                                <a href="#" class="flex items-center justify-between py-1.5 px-4">
                                    <div class="flex items-center gap-3 overflow-hidden w-full">
                                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}"
                                            class="w-12 h-12 object-center object-cover aspect-square rounded shadow-sm border border-gray-200 dark:border-gray-700 bg-white" />
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-sm truncate">{{ $product->name }}</p>
                                            <p class="text-sm text-slate-400">{{ $quantity }} ×
                                                {{ number_format($price, 0, ',', '.') }}₫ </p>
                                        </div>
                                    </div>
                                    <div class="ms-2 text-right font-semibold text-sm whitespace-nowrap">
                                        {{ number_format($subtotal, 0, ',', '.') }}₫
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="px-4 py-2 text-center text-sm text-gray-500">Giỏ hàng đang trống.</li>
                        @endforelse


                        <li class="border-t border-gray-100 dark:border-gray-800 my-2"></li>

                        <li class="flex items-center justify-between py-1.5 px-4">
                            <h6 class="font-semibold mb-0">Tổng:</h6>
                            <h6 class="font-semibold mb-0 text-sm">{{ number_format($cartTotal, 0, ',', '.') }}₫</h6>
                        </li>

                        <li class="py-1.5 px-4">
                            <div class="text-center space-x-2">
                                <a href="{{ route('cart.show') }}"
                                    class="btn-view-cart py-[5px] px-4 inline-block font-semibold text-sm rounded-md bg-orange-500 text-white">
                                    Xem giỏ hàng
                                </a>
                            </div>
                            <p class="text-xs text-slate-400 mt-1 text-center">*T&C Apply</p>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="dropdown inline-block relative ps-2">
                <button data-dropdown-toggle="wishlist-dropdown"
                    class="dropdown-toggle size-9 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-base text-center rounded-full bg-orange-500 text-white relative"
                    type="button">
                    <i data-feather="heart" class="h-4 w-4"></i>
                    @auth
                        <span id="wishlist-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold shadow-sm">0</span>
                    @endauth
                </button>
                <!-- Dropdown menu -->
                <div class="dropdown-menu absolute end-0 mt-4 z-10 w-72 rounded-md bg-white dark:bg-slate-900 shadow-sm dark:shadow-gray-800 hidden"
                    id="wishlist-dropdown" onclick="event.stopPropagation();">
                    <ul class="py-3 text-start" aria-labelledby="dropdownDefault">
                        @auth
                            <div id="wishlist-items">
                                <!-- Wishlist items will be loaded here -->
                            </div>
                            <li class="border-t border-gray-100 dark:border-gray-800 my-2"></li>
                            <li class="py-1.5 px-4">
                                <div class="text-center space-x-2">
                                    <a href="{{ route('wishlist.index') }}"
                                        class="btn-view-wishlist py-[5px] px-4 inline-block font-semibold text-sm rounded-md bg-orange-500 text-white">
                                        Xem danh sách yêu thích
                                    </a>
                                </div>
                            </li>
                        @else
                            <li class="px-4 py-2 text-center text-sm text-gray-500">
                                <a href="{{ route('login') }}" class="text-orange-500 hover:underline">Đăng nhập</a> để xem danh sách yêu thích
                            </li>
                        @endauth
                    </ul>
                </div>
            </li>

            <!-- Nếu đã đăng nhập thì hiển thị avatar -->
            @auth
                <li class="dropdown inline-block relative ps-2">
                    <button data-dropdown-toggle="dropdown" class="dropdown-toggle items-center" type="button">
                        <span
                            class="size-9 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-base text-center rounded-full border border-orange-500 bg-orange-500 text-white">
                            <img src="{{ Auth::user()->image_user ? asset('storage/' . Auth::user()->image_user) : asset('assets/user/images/client/16.jpg') }}"
                                class="rounded-full w-9 h-9 object-cover" alt="avatar">
                        </span>
                    </button>


                    <!-- Dropdown menu -->
                    <div class="dropdown-menu absolute end-0 m-0 mt-4 z-10 w-48 rounded-md overflow-hidden bg-white dark:bg-slate-900 shadow-sm dark:shadow-gray-700 hidden"
                        onclick="event.stopPropagation();">
                        <ul class="py-2 text-start">
                            <li>
                                <p class="text-slate-400 pt-2 px-4">Xin chào {{ Auth::user()->name }}!</p>
                            </li>
                            <li>
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center font-medium py-2 px-4 dark:text-white/70 hover:text-orange-500 dark:hover:text-white">
                                    <i data-feather="user" class="h-4 w-4 me-2"></i>Tài khoản
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.orders.index') }}"
                                    class="flex items-center font-medium py-2 px-4 dark:text-white/70 hover:text-orange-500 dark:hover:text-white">
                                    <i data-feather="shopping-bag" class="h-4 w-4 me-2"></i>Quản lý đơn hàng
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.reviews') }}"
                                    class="flex items-center font-medium py-2 px-4 dark:text-white/70 hover:text-orange-500 dark:hover:text-white">
                                    <i data-feather="star" class="h-4 w-4 me-2"></i>Đánh giá của tôi
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('settings') }}"
                                    class="flex items-center font-medium py-2 px-4 dark:text-white/70 hover:text-orange-500 dark:hover:text-white">
                                    <i data-feather="settings" class="h-4 w-4 me-2"></i>Cài đặt
                                </a>
                            </li>
                            <li class="border-t border-gray-100 dark:border-gray-800 my-2"></li>
                            <li>
                                <a href="{{ url('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="flex items-center font-medium py-2 px-4 dark:text-white/70 hover:text-orange-500 dark:hover:text-white">
                                    <i data-feather="log-out" class="h-4 w-4 me-2"></i>Đăng xuất
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            @endauth


            <!-- Nếu chưa đăng nhập thì hiển thị Sign in / Sign up -->
            @guest
                <li class="ml-2">
                    <button onclick="window.location.href='{{ route('login') }}'"
                        class="px-4 py-2 inline-flex items-center justify-center gap-2 tracking-wide align-middle duration-500 text-sm text-center rounded-full bg-orange-500 hover:bg-orange-600 border border-orange-500 text-white hover:scale-105 transition-all">
                        <i data-feather="log-in" class="h-4 w-4"></i>
                        Đăng nhập
                    </button>
                </li>
                <li class="ml-2">
                    <button onclick="window.location.href='{{ route('register') }}'"
                        class="px-4 py-2 inline-flex items-center justify-center gap-2 tracking-wide align-middle duration-500 text-sm text-center rounded-full bg-orange-500 hover:bg-orange-600 border border-orange-500 text-white hover:scale-105 transition-all">
                        <i data-feather="user-plus" class="h-4 w-4"></i>
                        Đăng ký
                    </button>
                </li>
            @endguest

        </ul>
    </div>
</nav>