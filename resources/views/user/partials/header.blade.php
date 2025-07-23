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
    <div class="container relative">
        <!-- Logo container-->
        <a class="logo" href="index.html">
            <div
                class="px-4 py-2 inline-flex items-center justify-center gap-2 tracking-wide align-middle duration-500 text-sm text-center rounded-full bg-orange-500 hover:bg-orange-600 border border-orange-500 text-white hover:scale-105 transition-al">
                <h1>Nova Smart</h1>
            </div>
        </a>
        <!-- End Logo container-->

        <!-- Start Mobile Toggle -->
        <div class="menu-extras">
            <div class="menu-item">
                <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Mobile Toggle -->

        <!--Login button Start-->
        <ul class="buy-button list-none mb-0">
            <li class="dropdown inline-block relative pe-1">
                <button data-dropdown-toggle="dropdown" class="dropdown-toggle align-middle inline-flex" type="button">
                    <i data-feather="search" class="size-5"></i>
                </button>
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

            <li class="dropdown inline-block relative ps-0.5">
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
                                    class="py-[5px] px-4 inline-block font-semibold text-sm rounded-md bg-orange-500 text-white">Xem
                                    giỏ hàng</a>
                            </div>
                            <p class="text-xs text-slate-400 mt-1 text-center">*T&C Apply</p>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="inline-block ps-0.5">
                <a href="javascript:void(0)"
                    class="size-9 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-base text-center rounded-full bg-orange-500 text-white">
                    <i data-feather="heart" class="h-4 w-4"></i>
                </a>
            </li>

            <!-- Nếu đã đăng nhập thì hiển thị avatar -->
            @auth
                <li class="dropdown inline-block relative ps-0.5">
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
                <button onclick="window.location.href='{{ route('login') }}'"
                    class="px-4 py-2 inline-flex items-center justify-center gap-2 tracking-wide align-middle duration-500 text-sm text-center rounded-full bg-orange-500 hover:bg-orange-600 border border-orange-500 text-white hover:scale-105 transition-all">
                    <i data-feather="log-in" class="h-4 w-4"></i>
                    Đăng nhập
                </button>
                <button onclick="window.location.href='{{ route('register') }}'"
                    class="px-4 py-2 inline-flex items-center justify-center gap-2 tracking-wide align-middle duration-500 text-sm text-center rounded-full bg-orange-500 hover:bg-orange-600 border border-orange-500 text-white hover:scale-105 transition-all">
                    <i data-feather="user-plus" class="h-4 w-4"></i>
                    Đăng ký
                </button>
            @endguest

        </ul>
        <!--Login button End-->

        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">

                <li class="has-submenu parent-parent-menu-item">
                    <a href="javascript:void(0)">Sản phẩm</a><span class="menu-arrow"></span>

                    <ul class="submenu megamenu">
                        <li>
                            <ul>
                                <li class="megamenu-head">Tính năng sản phẩm</li>
                                <li><a href="#!" class="sub-menu-item">Gói sản phẩm - Bán kèm</a></li>
                                <li><a href="#!" class="sub-menu-item">Hàng hot</a></li>
                                <li><a href="#!" class="sub-menu-item">Ghim nút Mua ngay</a></li>
                                <li><a href="#!" class="sub-menu-item">Thông báo khi hết hàng</a></li>
                                <li><a href="#!" class="sub-menu-item">Hỏi chuyên gia</a></li>
                                <li><a href="#!" class="sub-menu-item">Ảnh biến thể theo nhóm</a></li>
                                <li><a href="#!" class="sub-menu-item">Danh sách yêu thích</a></li>
                                <li><a href="#!" class="sub-menu-item">Huy hiệu uy tín</a></li>
                                <li><a href="#!" class="sub-menu-item">Thông tin giao hàng</a></li>
                            </ul>
                        </li>

                        <li>
                            <ul>
                                <li><a href="#!" class="sub-menu-item">Đã bán gần đây</a></li>
                                <li><a href="#!" class="sub-menu-item">So sánh màu sắc</a></li>
                                <li><a href="#!" class="sub-menu-item">Mẫu hiển thị sản phẩm</a></li>
                                <li><a href="#!" class="sub-menu-item">Tùy chọn chọn sản phẩm</a></li>
                                <li><a href="#!" class="sub-menu-item">Đặt hàng trước</a></li>
                                <li><a href="#!" class="sub-menu-item">Mô hình 3D / AR</a></li>
                                <li><a href="#!" class="sub-menu-item">Chấp nhận điều khoản & điều kiện</a></li>
                                <li><a href="#!" class="sub-menu-item">Mô tả biến thể (Metafield)</a></li>
                                <li><a href="#!" class="sub-menu-item">Thuộc tính biến thể (Metafield)</a></li>
                            </ul>
                        </li>

                        <li>
                            <ul>
                                <li><a href="#!" class="sub-menu-item">Video sản phẩm</a></li>
                                <li><a href="#!" class="sub-menu-item">Bảng kích thước</a></li>
                                <li><a href="#!" class="sub-menu-item">Thanh toán linh hoạt</a></li>
                                <li><a href="#!" class="sub-menu-item">Đếm ngược ưu đãi</a></li>
                                <li><a href="#!" class="sub-menu-item">Nội dung tùy chỉnh</a></li>
                                <li><a href="#!" class="sub-menu-item">Tùy chọn tùy chỉnh</a></li>
                                <li><a href="#!" class="sub-menu-item">Combo sản phẩm</a></li>
                                <li><a href="#!" class="sub-menu-item">Sản phẩm bổ trợ</a></li>
                                <li><a href="#!" class="sub-menu-item">Giảm giá tự động</a></li>
                            </ul>
                        </li>

                        <li>
                            <ul>
                                <li class="megamenu-head">Product Features</li>
                                <li><a href="#!" class="sub-menu-item">Tab sản phẩm tùy chỉnh</a></li>
                                <li><a href="#!" class="sub-menu-item">Tab dọc</a></li>
                                <li><a href="#!" class="sub-menu-item">Tab ngang</a></li>
                                <li><a href="#!" class="sub-menu-item">Chia sẻ mạng xã hội</a></li>
                                <li><a href="#!" class="sub-menu-item">Sản phẩm liên quan</a></li>
                                <li><a href="#!" class="sub-menu-item">Sản phẩm đã xem gần đây</a></li>
                                <li><a href="#!" class="sub-menu-item">Nhãn tùy chỉnh</a></li>
                                <li><a href="#!" class="sub-menu-item">Nhận tại cửa hàng</a></li>
                            </ul>
                        </li>

                        <li>
                            <ul>
                                <li class="megamenu-head"><img src="{{ asset('assets/user/images/cta.png') }}"
                                        alt=""></li>

                                <li class="text-center"><a href="{{ route('products.list') }}"
                                        class="py-2 px-5 inline-block font-medium tracking-wide align-middle duration-500 text-base text-center bg-orange-500/10 text-orange-500 rounded-md me-2 mt-2"><i
                                            class="mdi mdi-cart-outline"></i> Shop Now</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="has-submenu parent-parent-menu-item"><a href="javascript:void(0)"> Cửa hàng </a><span
                        class="menu-arrow"></span>
                    <ul class="submenu">
                        <li><a href="shop-cart.html" class="sub-menu-item">Giỏ hàng</a></li>
                        <li><a href="shop-checkout.html" class="sub-menu-item">Thanh toán</a></li>
                        <li><a href="our-store.html" class="sub-menu-item">Cửa hàng của chúng tôi</a></li>
                        <li><a href="brands.html" class="sub-menu-item">Thương hiệu</a></li>
                        <li><a href="compare-product.html" class="sub-menu-item">So sánh sản phẩm</a></li>
                        <li><a href="recently-viewed-product.html" class="sub-menu-item">Sản phẩm đã xem</a></li>
                    </ul>
                </li>

                <li class="has-submenu parent-parent-menu-item">
                    <a href="javascript:void(0)">Thông tin</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li><a href="aboutus.html" class="sub-menu-item">Về chúng tôi</a></li>

                        <li class="has-submenu parent-menu-item">
                            <a href="javascript:void(0)">Tài khoản của tôi</a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="user-account.html" class="sub-menu-item">Tài khoản người dùng</a></li>
                                <li><a href="user-billing.html" class="sub-menu-item">Hóa đơn</a></li>
                                <li><a href="user-payment.html" class="sub-menu-item">Thanh toán</a></li>
                                <li><a href="user-invoice.html" class="sub-menu-item">Đơn hàng</a></li>
                                <li><a href="user-social.html" class="sub-menu-item">Mạng xã hội</a></li>
                                <li><a href="user-notification.html" class="sub-menu-item">Thông báo</a></li>
                                <li><a href="user-setting.html" class="sub-menu-item">Cài đặt</a></li>
                            </ul>
                        </li>

                        <li class="has-submenu parent-menu-item">
                            <a href="javascript:void(0)">Mẫu Email</a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="email-confirmation.html" class="sub-menu-item">Xác nhận</a></li>
                                <li><a href="email-cart.html" class="sub-menu-item">Giỏ hàng</a></li>
                                <li><a href="email-offers.html" class="sub-menu-item">Ưu đãi</a></li>
                                <li><a href="email-order-success.html" class="sub-menu-item">Đặt hàng thành công</a>
                                </li>
                                <li><a href="email-gift-voucher.html" class="sub-menu-item">Phiếu quà tặng</a></li>
                                <li><a href="email-reset-password.html" class="sub-menu-item">Đặt lại mật khẩu</a>
                                </li>
                                <li><a href="email-item-review.html" class="sub-menu-item">Đánh giá sản phẩm</a></li>
                            </ul>
                        </li>

                        <li class="has-submenu parent-menu-item">
                            <a href="javascript:void(0)">Blog</a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="blogs.html" class="sub-menu-item">Danh sách Blog</a></li>
                                <li><a href="blog-detail.html" class="sub-menu-item">Chi tiết Blog</a></li>
                            </ul>
                        </li>

                        <li><a href="career.html" class="sub-menu-item">Tuyển dụng</a></li>

                        <li class="has-submenu parent-menu-item">
                            <a href="javascript:void(0)">Trung tâm trợ giúp</a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="helpcenter.html" class="sub-menu-item">Tổng quan</a></li>
                                <li><a href="helpcenter-faqs.html" class="sub-menu-item">Câu hỏi thường gặp</a></li>
                                <li><a href="helpcenter-guides.html" class="sub-menu-item">Hướng dẫn</a></li>
                                <li><a href="helpcenter-support.html" class="sub-menu-item">Hỗ trợ</a></li>
                            </ul>
                        </li>

                        <li class="has-submenu parent-menu-item">
                            <a href="javascript:void(0)">Trang xác thực</a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="login.html" class="sub-menu-item">Đăng nhập</a></li>
                                <li><a href="signup.html" class="sub-menu-item">Đăng ký</a></li>
                                <li><a href="forgot-password.html" class="sub-menu-item">Quên mật khẩu</a></li>
                                <li><a href="lock-screen.html" class="sub-menu-item">Khóa màn hình</a></li>
                            </ul>
                        </li>

                        <li class="has-submenu parent-menu-item">
                            <a href="javascript:void(0)">Tiện ích</a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="terms.html" class="sub-menu-item">Điều khoản dịch vụ</a></li>
                                <li><a href="privacy.html" class="sub-menu-item">Chính sách bảo mật</a></li>
                            </ul>
                        </li>

                        <li class="has-submenu parent-menu-item">
                            <a href="javascript:void(0)">Trang đặc biệt</a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="comingsoon.html" class="sub-menu-item">Sắp ra mắt</a></li>
                                <li><a href="maintenance.html" class="sub-menu-item">Bảo trì</a></li>
                                <li><a href="error.html" class="sub-menu-item">Lỗi 404</a></li>
                            </ul>
                        </li>

                        <li class="has-submenu parent-menu-item">
                            <a href="javascript:void(0)">Menu đa cấp</a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="javascript:void(0)" class="sub-menu-item">Cấp 1.0</a></li>
                                <li class="has-submenu child-menu-item">
                                    <a href="javascript:void(0)">Cấp 2.0</a><span class="submenu-arrow"></span>
                                    <ul class="submenu">
                                        <li><a href="javascript:void(0)" class="sub-menu-item">Cấp 2.1</a></li>
                                        <li><a href="javascript:void(0)" class="sub-menu-item">Cấp 2.2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>


                <li><a href="sale.html" class="sub-menu-item">Bán</a></li>

                <li><a href="contact.html" class="sub-menu-item">Liên hệ</a></li>
            </ul>
        </div>
    </div>
</nav>
