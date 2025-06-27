<!-- Start Navbar -->
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
            <div class="px-4 py-2 inline-flex items-center justify-center gap-2 tracking-wide align-middle duration-500 text-sm text-center rounded-full bg-orange-500 hover:bg-orange-600 border border-orange-500 text-white hover:scale-105 transition-al">
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
                <div class="dropdown-menu absolute overflow-hidden end-0 m-0 mt-5 z-10 md:w-52 w-48 rounded-md bg-white dark:bg-slate-900 shadow-sm dark:shadow-gray-800 hidden" onclick="event.stopPropagation();">
                    <div class="relative">
                        <i data-feather="search" class="absolute size-4 top-[9px] end-3"></i>
                        <input type="text" class="h-9 px-3 pe-10 w-full border-0 focus:ring-0 outline-none bg-white dark:bg-slate-900 shadow-sm dark:shadow-gray-800" name="s" id="searchItem" placeholder="Search...">
                    </div>
                </div>
            </li>

            <li class="dropdown inline-block relative ps-0.5">
    <button data-dropdown-toggle="dropdown" class="dropdown-toggle size-9 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-base text-center rounded-full bg-orange-500 border border-orange-500 text-white" type="button">
        <i data-feather="shopping-cart" class="h-4 w-4"></i>
    </button>

    <!-- Dropdown menu -->
    <div class="dropdown-menu absolute end-0 mt-4 z-10 w-72 rounded-md bg-white dark:bg-slate-900 shadow-sm dark:shadow-gray-800 hidden" onclick="event.stopPropagation();">
        <ul class="py-3 text-start max-h-96 overflow-auto">
            @php
                $cartItems = $cart['items'] ?? [];
                $cartTotal = 0;
            @endphp

            @forelse ($cartItems as $item)
                @php
                    $isObject = is_object($item);
                    $variant = $isObject ? $item->productVariant : $item['variant'] ?? null;
                    $product = $isObject ? $item->productVariant->product : $item['product'] ?? null;
                    $quantity = $isObject ? $item->quantity : ($item['quantity'] ?? 1);
                    $price = $variant->price ?? $item['price'] ?? 0;
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
                            <img src="{{ $imageUrl }}"
                                alt="{{ $product->name }}"
                                class="w-12 h-12 object-center object-cover aspect-square rounded shadow-sm border border-gray-200 dark:border-gray-700 bg-white" />
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm truncate">{{ $product->name }}</p>
                                <p class="text-sm text-slate-400">{{ $quantity }} × {{ number_format($price, 0, ',', '.') }}₫  </p>
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
                <h6 class="font-semibold mb-0 text-sm">Tổng:</h6>
                <h6 class="font-semibold mb-0 text-sm">{{ number_format($cartTotal, 0, ',', '.') }}₫</h6>
            </li>

            <li class="py-1.5 px-4">
                <div class="text-center space-x-2">
                    <a href="{{ route('cart.show') }}" class="py-[5px] px-4 inline-block font-semibold text-sm rounded-md bg-orange-500 text-white">Xem giỏ hàng</a>
                    <a href="#" class="py-[5px] px-4 inline-block font-semibold text-sm rounded-md bg-orange-500 text-white">Thanh toán</a>
                </div>
                <p class="text-xs text-slate-400 mt-1 text-center">*T&C Apply</p>
            </li>
        </ul>
    </div>
</li>



            <li class="inline-block ps-0.5">
                <a href="javascript:void(0)" class="size-9 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-base text-center rounded-full bg-orange-500 text-white">
                    <i data-feather="heart" class="h-4 w-4"></i>
                </a>
            </li>

            <li class="dropdown inline-block relative ps-0.5">
                <button data-dropdown-toggle="dropdown" class="dropdown-toggle items-center" type="button">
                    <span class="size-9 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-base text-center rounded-full border border-orange-500 bg-orange-500 text-white"><img src="{{ asset('assets/user/images/client/16.jpg')}}" class="rounded-full" alt=""></span>
                </button>
                <!-- Dropdown menu -->
                <div class="dropdown-menu absolute end-0 m-0 mt-4 z-10 w-48 rounded-md overflow-hidden bg-white dark:bg-slate-900 shadow-sm dark:shadow-gray-700 hidden" onclick="event.stopPropagation();">
                    <ul class="py-2 text-start">
                        <li>
                            <p class="text-slate-400 pt-2 px-4">Welcome Jesus!</p>
                        </li>
                        <li>
                            <p class="flex items-center font-medium py-2 px-4"><i data-feather="dollar-sign" class="h-4 w-4 me-2"></i> Balance: <span class="text-orange-500 ms-2">$ 245.10</span></p>
                        </li>
                        <li>
                            <a href="user-account.html" class="flex items-center font-medium py-2 px-4 dark:text-white/70 hover:text-orange-500 dark:hover:text-white"><i data-feather="user" class="h-4 w-4 me-2"></i>Account</a>
                        </li>
                        <li>
                            <a href="helpcenter.html" class="flex items-center font-medium py-2 px-4 dark:text-white/70 hover:text-orange-500 dark:hover:text-white"><i data-feather="help-circle" class="h-4 w-4 me-2"></i>Helpcenter</a>
                        </li>
                        <li>
                            <a href="user-setting.html" class="flex items-center font-medium py-2 px-4 dark:text-white/70 hover:text-orange-500 dark:hover:text-white"><i data-feather="settings" class="h-4 w-4 me-2"></i>Settings</a>
                        </li>
                        <li class="border-t border-gray-100 dark:border-gray-800 my-2"></li>
                        <li>
                            <a href="login.html" class="flex items-center font-medium py-2 px-4 dark:text-white/70 hover:text-orange-500 dark:hover:text-white"><i data-feather="log-out" class="h-4 w-4 me-2"></i>Logout</a>
                        </li>
                    </ul>
                </div>
            </li><!--end dropdown-->
            <button class="px-4 py-2 inline-flex items-center justify-center gap-2 tracking-wide align-middle duration-500 text-sm text-center rounded-full bg-orange-500 hover:bg-orange-600 border border-orange-500 text-white hover:scale-105 transition-all">
                <i data-feather="log-in" class="h-4 w-4"></i>
                Sign in
            </button>
            <button class="px-4 py-2 inline-flex items-center justify-center gap-2 tracking-wide align-middle duration-500 text-sm text-center rounded-full bg-orange-500 hover:bg-orange-600 border border-orange-500 text-white hover:scale-105 transition-all">
                <i data-feather="user-plus" class="h-4 w-4"></i>
                Sign up
            </button>
        </ul>
        <!--Login button End-->

        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">

                <li class="has-submenu parent-parent-menu-item">
                    <a href="javascript:void(0)">Products</a><span class="menu-arrow"></span>

                    <ul class="submenu megamenu">
                        <li>
                            <ul>
                                <li class="megamenu-head">Product Features</li>
                                <li><a href="#!" class="sub-menu-item">Bundle - Upsell</a></li>
                                <li><a href="#!" class="sub-menu-item">Hot Stock</a></li>
                                <li><a href="#!" class="sub-menu-item">Sticky Add To Cart</a></li>
                                <li><a href="#!" class="sub-menu-item">Notify Me (Out Of Stock)</a></li>
                                <li><a href="#!" class="sub-menu-item">Ask An Expert</a></li>
                                <li><a href="#!" class="sub-menu-item">Variant Image Grouped</a></li>
                                <li><a href="#!" class="sub-menu-item">Wishlist</a></li>
                                <li><a href="#!" class="sub-menu-item">Trust Badge</a></li>
                                <li><a href="#!" class="sub-menu-item">Delivery Information</a></li>
                            </ul>
                        </li>

                        <li>
                            <ul>
                                <li class="megamenu-head">Product Features</li>
                                <li><a href="#!" class="sub-menu-item">Sold In Last</a></li>
                                <li><a href="#!" class="sub-menu-item">Color Comparison</a></li>
                                <li><a href="#!" class="sub-menu-item">Product Swatches</a></li>
                                <li><a href="#!" class="sub-menu-item">Product Select Options</a></li>
                                <li><a href="#!" class="sub-menu-item">Pre-Order</a></li>
                                <li><a href="#!" class="sub-menu-item">Product 3D, AR Models</a></li>
                                <li><a href="#!" class="sub-menu-item">Terms And Conditions Checkbox</a></li>
                                <li><a href="#!" class="sub-menu-item">Variant Metafield Description</a></li>
                                <li><a href="#!" class="sub-menu-item">Variant Metafield Property</a></li>
                            </ul>
                        </li>

                        <li>
                            <ul>
                                <li class="megamenu-head">Product Features</li>
                                <li><a href="#!" class="sub-menu-item">Product Video</a></li>
                                <li><a href="#!" class="sub-menu-item">Size Chart</a></li>
                                <li><a href="#!" class="sub-menu-item">Dynamic Checkout</a></li>
                                <li><a href="#!" class="sub-menu-item">Product Countdown</a></li>
                                <li><a href="#!" class="sub-menu-item">Custom Content</a></li>
                                <li><a href="#!" class="sub-menu-item">Custom Options</a></li>
                                <li><a href="#!" class="sub-menu-item">Product Combo</a></li>
                                <li><a href="#!" class="sub-menu-item">Product Complementary</a></li>
                                <li><a href="#!" class="sub-menu-item">Auto Discount</a></li>
                            </ul>
                        </li>

                        <li>
                            <ul>
                                <li class="megamenu-head">Product Features</li>
                                <li><a href="#!" class="sub-menu-item">Custom Product Tabs</a></li>
                                <li><a href="#!" class="sub-menu-item">Vertical Product Tab</a></li>
                                <li><a href="#!" class="sub-menu-item">Horizontal Product Tab</a></li>
                                <li><a href="#!" class="sub-menu-item">Social Share</a></li>
                                <li><a href="#!" class="sub-menu-item">Related Products</a></li>
                                <li><a href="#!" class="sub-menu-item">Recently Viewed Products</a></li>
                                <li><a href="#!" class="sub-menu-item">Custom Label</a></li>
                                <li><a href="#!" class="sub-menu-item">Local Pick Up</a></li>
                            </ul>
                        </li>

                        <li>
                            <ul>
                                <li class="megamenu-head"><img src="{{ asset('assets/user/images/cta.png')}}" alt=""></li>

                                <li class="text-center"> <a href="" class="py-2 px-5 inline-block font-medium tracking-wide align-middle duration-500 text-base text-center bg-orange-500/10 text-orange-500 rounded-md me-2 mt-2"> <i class="mdi mdi-cart-outline"></i> Shop Now </a> </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="has-submenu parent-parent-menu-item"><a href="javascript:void(0)"> Shop </a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li class="has-submenu parent-menu-item">
                            <a href="javascript:void(0)"> Shop Grid </a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="shop-grid.html" class="sub-menu-item">Shop Grid</a></li>
                                <li><a href="shop-grid-left-sidebar.html" class="sub-menu-item">Grid Left Sidebar</a></li>
                                <li><a href="shop-grid-right-sidebar.html" class="sub-menu-item">Grid Right Sidebar</a></li>
                            </ul>
                        </li>

                        <li class="has-submenu parent-menu-item">
                            <a href="javascript:void(0)"> Shop List </a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="shop-list.html" class="sub-menu-item">Shop List</a></li>
                                <li><a href="shop-list-left-sidebar.html" class="sub-menu-item">List Left Sidebar</a></li>
                                <li><a href="shop-list-right-sidebar.html" class="sub-menu-item">List Right Sidebar</a></li>
                            </ul>
                        </li>

                        <li class="has-submenu parent-menu-item">
                            <a href="javascript:void(0)"> Shop Detail </a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="product-detail-one.html" class="sub-menu-item">Product Detail One</a></li>
                                <li><a href="product-detail-two.html" class="sub-menu-item">Product Detail Two</a></li>
                                <li><a href="product-detail-three.html" class="sub-menu-item">Product Detail Three</a></li>
                            </ul>
                        </li>
                        <li><a href="shop-cart.html" class="sub-menu-item">Shop Cart</a></li>
                        <li><a href="shop-checkout.html" class="sub-menu-item">Checkout</a></li>
                        <li><a href="our-store.html" class="sub-menu-item">Our Store</a></li>
                        <li><a href="brands.html" class="sub-menu-item">Brands</a></li>
                        <li><a href="compare-product.html" class="sub-menu-item">Compare Product</a></li>
                        <li><a href="recently-viewed-product.html" class="sub-menu-item">Recently Viewed Products</a></li>
                    </ul>
                </li>

                <li class="has-submenu parent-parent-menu-item">
                    <a href="javascript:void(0)">Pages</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li><a href="aboutus.html" class="sub-menu-item">About Us</a></li>

                        <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> My Account</a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="user-account.html" class="sub-menu-item">User Account</a></li>
                                <li><a href="user-billing.html" class="sub-menu-item">Billing</a></li>
                                <li><a href="user-payment.html" class="sub-menu-item">Payment</a></li>
                                <li><a href="user-invoice.html" class="sub-menu-item">Invoice</a></li>
                                <li><a href="user-social.html" class="sub-menu-item">Social</a></li>
                                <li><a href="user-notification.html" class="sub-menu-item">Notification</a></li>
                                <li><a href="user-setting.html" class="sub-menu-item">Setting</a></li>
                            </ul>
                        </li>

                        <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Email Template </a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="email-confirmation.html" class="sub-menu-item"> Confirmation</a></li>
                                <li><a href="email-cart.html" class="sub-menu-item"> Cart</a></li>
                                <li><a href="email-offers.html" class="sub-menu-item"> Offers</a></li>
                                <li><a href="email-order-success.html" class="sub-menu-item"> Order Success</a></li>
                                <li><a href="email-gift-voucher.html" class="sub-menu-item"> Gift Voucher</a></li>
                                <li><a href="email-reset-password.html" class="sub-menu-item"> Reset Password</a></li>
                                <li><a href="email-item-review.html" class="sub-menu-item"> Item Review</a></li>
                            </ul>
                        </li>

                        <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Blog </a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="blogs.html" class="sub-menu-item"> Blogs</a></li>
                                <li><a href="blog-detail.html" class="sub-menu-item"> Blog Detail</a></li>
                            </ul>
                        </li>

                        <li><a href="career.html" class="sub-menu-item">Career </a></li>

                        <li class="has-submenu parent-menu-item">
                            <a href="javascript:void(0)"> Helpcenter </a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="helpcenter.html" class="sub-menu-item">Overview</a></li>
                                <li><a href="helpcenter-faqs.html" class="sub-menu-item">FAQs</a></li>
                                <li><a href="helpcenter-guides.html" class="sub-menu-item">Guides</a></li>
                                <li><a href="helpcenter-support.html" class="sub-menu-item">Support</a></li>
                            </ul>
                        </li>

                        <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Auth Pages </a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="login.html" class="sub-menu-item"> Login</a></li>
                                <li><a href="signup.html" class="sub-menu-item"> Signup</a></li>
                                <li><a href="forgot-password.html" class="sub-menu-item"> Forgot Password</a></li>
                                <li><a href="lock-screen.html" class="sub-menu-item"> Lock Screen</a></li>
                            </ul>
                        </li>

                        <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Utility </a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="terms.html" class="sub-menu-item">Terms of Services</a></li>
                                <li><a href="privacy.html" class="sub-menu-item">Privacy Policy</a></li>
                            </ul>
                        </li>

                        <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Special </a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="comingsoon.html" class="sub-menu-item"> Coming Soon</a></li>
                                <li><a href="maintenance.html" class="sub-menu-item"> Maintenance</a></li>
                                <li><a href="error.html" class="sub-menu-item"> 404!</a></li>
                            </ul>
                        </li>

                        <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Multi Level Menu</a><span class="submenu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="javascript:void(0)" class="sub-menu-item">Level 1.0</a></li>
                                <li class="has-submenu child-menu-item"><a href="javascript:void(0)"> Level 2.0 </a><span class="submenu-arrow"></span>
                                    <ul class="submenu">
                                        <li><a href="javascript:void(0)" class="sub-menu-item">Level 2.1</a></li>
                                        <li><a href="javascript:void(0)" class="sub-menu-item">Level 2.2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li><a href="sale.html" class="sub-menu-item">Sale</a></li>

                <li><a href="contact.html" class="sub-menu-item">Contact</a></li>
            </ul><!--end navigation menu-->
        </div><!--end navigation-->
    </div><!--end container-->
</nav><!--end header-->
<!-- End Navbar -->