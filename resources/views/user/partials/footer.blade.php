<!-- Footer Start -->
<footer class="footer bg-slate-900 dark:bg-slate-800 relative text-gray-200 dark:text-gray-200">    
    <div class="container relative">
        <div class="grid grid-cols-12">
            <div class="col-span-12">
                <div class="py-[60px] px-0">
                    <div class="grid md:grid-cols-12 grid-cols-1 gap-6">
                        <div class="lg:col-span-3 md:col-span-12">
                            <a class="logo flex items-center gap-3 hover:opacity-80 transition-opacity duration-300" href="/">
                                <img src="{{ asset('assets/user/images/logonova.jpg') }}" alt="NovaSmart Logo" style="max-height:48px; width:auto; display:block; border-radius:50%; object-fit:cover;"/>
                                <div class="flex flex-col">
                                    <span class="text-2xl font-bold text-white leading-tight">NovaSmart</span>
                                    <span class="text-xs text-gray-400 font-medium -mt-1">Uy tín chất lượng</span>
                                </div>
                            </a>
                            <p class="mt-6 text-gray-300">NovaSmart - Đối tác tin cậy của bạn trong lĩnh vực công nghệ. Chúng tôi cung cấp các sản phẩm điện tử chất lượng cao với giá cả hợp lý và dịch vụ hậu mãi tận tâm.</p>
                        </div>

                        <div class="lg:col-span-6 md:col-span-12">
                            <h5 class="tracking-[1px] text-gray-100 font-semibold">Danh mục sản phẩm</h5>

                            <div class="grid md:grid-cols-12 grid-cols-1">
                                <div class="md:col-span-4">
                                    <ul class="list-none footer-list mt-6">
                                        @foreach($menuCategories->take(6) as $category)
                                        <li class="{{ !$loop->first ? 'mt-[10px]' : '' }}">
                                            <a href="{{ route('products.list') }}?category={{ urlencode($category->name) }}" class="text-gray-300 hover:text-orange-500 transition-all duration-500">
                                                <i class="mdi mdi-chevron-right"></i> {{ $category->name }}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="md:col-span-4">
                                    <ul class="list-none footer-list mt-6">
                                        @foreach($topBrands as $brand)
                                        <li class="{{ !$loop->first ? 'mt-[10px]' : '' }}">
                                            <a href="{{ route('products.list') }}?brand={{ urlencode($brand->name) }}" class="text-gray-300 hover:text-orange-500 transition-all duration-500">
                                                <i class="mdi mdi-chevron-right"></i> {{ $brand->name }}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="md:col-span-4">
                                    <ul class="list-none footer-list mt-6">
                                        <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-orange-500 transition-all duration-500"><i class="mdi mdi-chevron-right"></i> Về chúng tôi</a></li>
                                        <li class="mt-[10px]"><a href="{{ route('profile.edit') }}" class="text-gray-300 hover:text-orange-500 transition-all duration-500"><i class="mdi mdi-chevron-right"></i> Tài khoản của tôi</a></li>
                                        <li class="mt-[10px]"><a href="{{ route('user.orders.index') }}" class="text-gray-300 hover:text-orange-500 transition-all duration-500"><i class="mdi mdi-chevron-right"></i> Đơn hàng của tôi</a></li>
                                        <li class="mt-[10px]"><a href="{{ route('wishlist.index') }}" class="text-gray-300 hover:text-orange-500 transition-all duration-500"><i class="mdi mdi-chevron-right"></i> Sản phẩm yêu thích</a></li>
                                        {{-- <li class="mt-[10px]"><a href="#" class="text-gray-300 hover:text-orange-500 transition-all duration-500"><i class="mdi mdi-chevron-right"></i> Bảo hành & Sửa chữa</a></li>
                                        <li class="mt-[10px]"><a href="#" class="text-gray-300 hover:text-orange-500 transition-all duration-500"><i class="mdi mdi-chevron-right"></i> Hướng dẫn sử dụng</a></li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-3 md:col-span-4">
                            <h5 class="tracking-[1px] text-gray-100 font-semibold">Liên hệ & Hỗ trợ</h5>
                            <div class="mt-6 space-y-4">
                                <div class="flex items-start">
                                    <i class="mdi mdi-map-marker text-orange-500 text-lg mt-1 me-3"></i>
                                    <div>
                                        <p class="text-gray-300 text-sm">13 P. Trịnh Văn Bô, Xuân Phương, Nam Từ Liêm, Hà Nội</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="mdi mdi-phone text-orange-500 text-lg mt-1 me-3"></i>
                                    <div>
                                        <p class="text-gray-300 text-sm">0583 12 2003</p>
                                        <p class="text-gray-300 text-sm">08:00 - 22:00 (T2-CN)</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="mdi mdi-email text-orange-500 text-lg mt-1 me-3"></i>
                                    <div>
                                        <p class="text-gray-300 text-sm">yepiamlong@gmail.com</p>
                                            <p class="text-gray-300 text-sm">yepiamlong@gmail.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chính sách -->
        <div class="grid grid-cols-1">
            <div class="py-[30px] px-0 border-t border-slate-800 dark:border-slate-700">
                <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-4">
                    <div class="flex items-center lg:justify-center">
                        <i class="mdi mdi-truck-check-outline align-middle text-lg mb-0 me-2 text-orange-500"></i>
                        <h6 class="mb-0 font-medium text-gray-200">Giao hàng miễn phí</h6>
                    </div>

                    <div class="flex items-center lg:justify-center">
                        <i class="mdi mdi-shield-check align-middle text-lg mb-0 me-2 text-orange-500"></i>
                        <h6 class="mb-0 font-medium text-gray-200">Bảo hành chính hãng</h6>
                    </div>

                    <div class="flex items-center lg:justify-center">
                        <i class="mdi mdi-cash-multiple align-middle text-lg mb-0 me-2 text-orange-500"></i>
                        <h6 class="mb-0 font-medium text-gray-200">Trả góp 0% lãi suất</h6>
                    </div>

                    <div class="flex items-center lg:justify-center">
                        <i class="mdi mdi-headset align-middle text-lg mb-0 me-2 text-orange-500"></i>
                        <h6 class="mb-0 font-medium text-gray-200">Hỗ trợ 24/7</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bản quyền -->
    <div class="py-[30px] px-0 border-t border-slate-800 dark:border-slate-700">
        <div class="container relative text-center">
            <div class="grid md:grid-cols-2 items-center">
                <div class="md:text-start text-center">
                    <p class="mb-0 text-gray-400">© <script>document.write(new Date().getFullYear())</script> NovaSmart. Tất cả quyền được bảo lưu.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
