<div class="absolute w-full bg-blue-500 dark:hidden min-h-75"></div>
<!-- sidenav  -->
<aside
    class="fixed inset-y-0 left-0 flex flex-col w-full h-full min-h-screen p-0 overflow-y-auto antialiased transition-transform duration-200 bg-white border-0 shadow-xl dark:shadow-none dark:bg-slate-850 max-w-64 ease-nav-brand z-990 xl:ml-6 xl:left-0 xl:translate-x-0 items-center justify-center"
    aria-expanded="false">
    <div class="h-19">
        <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times dark:text-white text-slate-400 xl:hidden"
            sidenav-close></i>
        <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap dark:text-white text-slate-700"
            href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('assets/admin/img/logo-ct-dark.png') }}"
                class="inline h-full max-w-full transition-all duration-200 dark:hidden ease-nav-brand max-h-8"
                alt="main_logo" />
            <img src="{{ asset('assets/admin/img/logo-ct.png') }}"
                class="hidden h-full max-w-full transition-all duration-200 dark:inline ease-nav-brand max-h-8"
                alt="main_logo" />
            <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Quản lý</span>
        </a>
    </div>

    <hr
        class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent" />

    @php
        // Helper function để xác định trang hiện tại
        function isCurrentRoute($routeName)
        {
            return request()->routeIs($routeName);
        }
    @endphp

    <div class="items-center block w-auto h-full overflow-auto grow basis-full">
        <ul class="flex flex-col pl-0 mb-0 items-center">
            <li class="mt-0.5 w-full">
                <a class="py-2.7 {{ isCurrentRoute('admin.dashboard') ? 'bg-blue-500/13 dark:text-white dark:opacity-80' : 'dark:text-white dark:opacity-80' }} text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold text-slate-700 transition-colors"
                    href="{{ route('admin.dashboard') }}">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-tv-2"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Trang chủ</span>
                </a>
            </li>

            <li class="mt-0.5 w-full">
                <a class="py-2.7 {{ isCurrentRoute('admin.categories.*') ? 'bg-blue-500/13 dark:text-white dark:opacity-80' : 'dark:text-white dark:opacity-80' }} text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors"
                    href="{{ route('admin.categories.index') }}">

                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-orange-500 ni ni-calendar-grid-58"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Danh mục</span>
                </a>
            </li>

            <li class="mt-0.5 w-full">
                <a class="py-2.7 {{ isCurrentRoute('admin.attributes.*') ? 'bg-blue-500/13 dark:text-white dark:opacity-80' : 'dark:text-white dark:opacity-80' }} text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors"
                    href="{{ route('admin.attributes.index') }}">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-tag"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Thuộc tính</span>
                </a>
            </li>

            <li class="mt-0.5 w-full">
                <a class="py-2.7 {{ isCurrentRoute('admin.vouchers.*') ? 'bg-blue-500/13 dark:text-white dark:opacity-80' : 'dark:text-white dark:opacity-80' }} text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors"
                    href="{{ route('admin.vouchers.index') }}">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-emerald-500 ni ni-credit-card"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Mã giảm giá</span>
                </a>
            </li>
            <li class="mt-0.5 w-full">
                <a class="py-2.7 {{ isCurrentRoute('admin.statuses.*') ? 'bg-blue-500/13 dark:text-white dark:opacity-80' : 'dark:text-white dark:opacity-80' }} text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors"
                    href="{{ route('admin.statuses.index') }}">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-green-500 ni ni-badge"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Trạng Thái</span>
                </a>
            </li>




            <li class="mt-0.5 w-full">
                <a class="py-2.7 {{ isCurrentRoute('admin.origins.*') ? 'bg-blue-500/13 dark:text-white dark:opacity-80' : 'dark:text-white dark:opacity-80' }} text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors"
                    href="{{ route('admin.origins.index') }}">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-red-600 ni ni-world-2"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Xuất xứ</span>
                </a>
            </li>

            <li class="mt-0.5 w-full">
                <a class="py-2.7 {{ isCurrentRoute('admin.products.*') ? 'bg-blue-500/13 dark:text-white dark:opacity-80' : 'dark:text-white dark:opacity-80' }} text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors"
                    href="{{ route('admin.products.index') }}">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-red-600 ni ni-world-2"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Sản phẩm</span>
                </a>
            </li>
            <li class="mt-0.5 w-full">
                <a class="py-2.7 {{ isCurrentRoute('admin.orders.*') ? 'bg-blue-500/13 dark:text-white dark:opacity-80' : 'dark:text-white dark:opacity-80' }} text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors"
                    href="{{ route('admin.orders.index') }}">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-purple-600 ni ni-archive-2"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Đơn hàng</span>
                </a>
            </li>
            <li class="mt-0.5 w-full">
                <a class="py-2.7 {{ isCurrentRoute('admin.brands.*') ? 'bg-blue-500/13 dark:text-white dark:opacity-80' : 'dark:text-white dark:opacity-80' }} text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors"
                    href="{{ route('admin.brands.index') }}">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-blue-600 ni ni-tag"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Nhãn hiệu</span>
                </a>
            </li>

            <li class="mt-0.5 w-full">
                <a class="py-2.7 {{ isCurrentRoute('admin.reviews.*') ? 'bg-blue-500/13 dark:text-white dark:opacity-80' : 'dark:text-white dark:opacity-80' }} text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors"
                    href="{{ route('admin.reviews.index') }}">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-yellow-500 ni ni-chat-round"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Đánh giá</span>
                </a>
            </li>


            <li class="mt-0.5 w-full">
                <a class="py-2.7 {{ isCurrentRoute('admin.product_thumbnail.*') ? 'bg-blue-500/13 dark:text-white dark:opacity-80' : 'dark:text-white dark:opacity-80' }} text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors"
                    href="{{ route('admin.product_thumbnail.index') }}">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-pink-500 ni ni-image"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Quản lý ảnh</span>
                </a>
            </li>

            <li class="mt-0.5 w-full">
                <a class="py-2.7 {{ isCurrentRoute('admin.slideshows.*') ? 'bg-blue-500/13 dark:text-white dark:opacity-80' : 'dark:text-white dark:opacity-80' }} text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors"
                    href="{{ route('admin.slideshows.index') }}">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-yellow-500 ni ni-chart-bar-32"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Slideshow</span>
                </a>
            </li>

            <li class="mt-0.5 w-full">
                <a class="py-2.7 {{ isCurrentRoute('admin.news.*') ? 'bg-blue-500/13 dark:text-white dark:opacity-80' : 'dark:text-white dark:opacity-80' }} text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors"
                    href="{{ route('admin.news.index') }}">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-indigo-500 ni ni-collection"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Tin tức</span>
                </a>
            </li>

            <li class="w-full mt-4">
                <h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase dark:text-white opacity-60">Trang tài
                    khoản
                </h6>
            </li>

            <li class="mt-0.5 w-full">
                <a class="py-2.7 {{ isCurrentRoute('admin.users.*') ? 'bg-blue-500/13 dark:text-white dark:opacity-80' : 'dark:text-white dark:opacity-80' }} text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors"
                    href="{{ route('admin.users.index') }}">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-slate-700 ni ni-single-02"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Quản lý người dùng</span>
                </a>
            <li class="mt-0.5 w-full">
                <a class="py-2.7 {{ isCurrentRoute('admin.roles.*') ? 'bg-blue-500/13 dark:text-white dark:opacity-80' : 'dark:text-white dark:opacity-80' }} text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors"
                    href="{{ route('admin.roles.index') }}">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-cyan-500 ni ni-app"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Chức vụ</span>
                </a>
            </li>
            </li>
        </ul>
    </div>
</aside>
