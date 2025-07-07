@extends('user.layouts.client')

@section('title', 'trang chủ')

@section('meta_description', 'Đây là trang chủ của nova smart.')
    
@section('content')
    <!-- Bắt đầu -->
        <section class="relative md:py-24 py-16">
            <div class="container relative">
                <div class="grid grid-cols-1 justify-center text-center mb-6">
                    <h5 class="font-semibold text-3xl leading-normal mb-4">Khám Phá Các Bộ Sưu Tập</h5>
                    <p class="text-slate-400 max-w-xl mx-auto">Mua sắm những sản phẩm mới nhất từ các bộ sưu tập được yêu thích nhất</p>
                </div><!--end grid-->

                <div class="grid lg:grid-cols-5 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 pt-6 gap-6">
                    <a href="#" class="text-center hover:text-orange-500">
                        <img src="{{ asset('assets/user/images/categories/mens-ware.jpg')}}" class="rounded-full shadow-sm dark:shadow-gray-800" alt="">
                        <span class="text-xl font-medium mt-3 block">Thời Trang Nam</span>
                    </a>

                    <a href="#" class="text-center hover:text-orange-500">
                        <img src="{{ asset('assets/user/images/categories/ladies-ware.jpg')}}" class="rounded-full shadow-sm dark:shadow-gray-800" alt="">
                        <span class="text-xl font-medium mt-3 block">Thời Trang Nữ</span>
                    </a>

                    <a href="#" class="text-center hover:text-orange-500">
                        <img src="{{ asset('assets/user/images/categories/kids-ware.jpg')}}" class="rounded-full shadow-sm dark:shadow-gray-800" alt="">
                        <span class="text-xl font-medium mt-3 block">Thời Trang Trẻ Em</span>
                    </a>

                    <a href="#" class="text-center hover:text-orange-500">
                        <img src="{{ asset('assets/user/images/categories/smart-watch.jpg')}}" class="rounded-full shadow-sm dark:shadow-gray-800" alt="">
                        <span class="text-xl font-medium mt-3 block">Đồng Hồ Thông Minh</span>
                    </a>

                    <a href="#" class="text-center hover:text-orange-500">
                        <img src="{{ asset('assets/user/images/categories/sunglasses.jpg')}}" class="rounded-full shadow-sm dark:shadow-gray-800" alt="">
                        <span class="text-xl font-medium mt-3 block">Kính Râm</span>
                    </a>
                </div><!--end grid-->
            </div><!--end container-->

            <div class="container relative md:mt-24 mt-16">
                <div class="grid grid-cols-1 justify-center text-center mb-6">
                    <h5 class="font-semibold text-3xl leading-normal mb-4">Sản Phẩm Mới </h5>
                    <p class="text-slate-400 max-w-xl mx-auto">Mua sắm những sản phẩm mới nhất từ các bộ sưu tập được yêu thích nhất</p>
                </div><!--end grid-->

                <div class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 pt-6 gap-6">
                    <div class="group">
                        <div class="relative overflow-hidden shadow-sm dark:shadow-gray-800 group-hover:shadow-lg group-hover:dark:shadow-gray-800 rounded-md duration-500">
                            <img src="{{ asset('assets/user/images/shop/black-print-t-shirt.jpg')}}" class="group-hover:scale-110 duration-500" alt="">
    
                            <div class="absolute -bottom-20 group-hover:bottom-3 start-3 end-3 duration-500">
                                <a href="shop-cart.html" class="py-2 px-5 inline-block font-semibold tracking-wide align-middle duration-500 text-base text-center bg-slate-900 text-white w-full rounded-md">Thêm Vào Giỏ</a>
                            </div>
    
                            <ul class="list-none absolute top-[10px] end-4 opacity-0 group-hover:opacity-100 duration-500 space-y-1">
                                <li><a href="javascript:void(0)" class="size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow"><i data-feather="heart" class="size-4"></i></a></li>
                                <li class="mt-1"><a href="shop-item-detail.html" class="size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow"><i data-feather="eye" class="size-4"></i></a></li>
                                <li class="mt-1"><a href="javascript:void(0)" class="size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow"><i data-feather="bookmark" class="size-4"></i></a></li>
                            </ul>

                            <ul class="list-none absolute top-[10px] start-4">
                                <li><a href="javascript:void(0)" class="bg-orange-600 text-white text-[10px] font-bold px-2.5 py-0.5 rounded h-5">-40% Giảm</a></li>
                            </ul>
                        </div>

                        <div class="mt-4">
                            <a href="product-detail-one.html" class="hover:text-orange-500 text-lg font-medium">Áo Thun In Đen</a>
                            <div class="flex justify-between items-center mt-1">
                                <p>$16.00 <del class="text-slate-400">$21.00</del></p>
                                 <ul class="font-medium text-amber-400 list-none">
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                </ul>
                            </div>
                        </div>
                    </div><!--end content-->

                </div><!--end grid-->
            </div><!--end container-->

            <div class="container-fluid relative md:mt-24 mt-16">
                <div class="grid grid-cols-1">
                    <div class="relative overflow-hidden py-24 px-4 md:px-10 bg-orange-600 bg-[url('../../assets/images/hero/bg3.html')] bg-center bg-no-repeat bg-cover">
                        <div class="absolute inset-0 bg-[url('../../assets/images/hero/bg-shape.html')] bg-center bg-no-repeat bg-cover"></div>
                        <div class="grid grid-cols-1 justify-center text-center relative z-1">
                            <h3 class="text-4xl leading-normal tracking-wide font-bold text-white">Khuyến Mãi Cuối Mùa <br> Giảm Giá Lên Đến 30%</h3>
                            <div id="countdown" class="mt-6">
                                <ul class="count-down list-none inline-block space-x-1">
                                    <li id="days" class="text-[28px] leading-[72px] h-[80px] w-[80px] font-medium rounded-md shadow-sm shadow-gray-100 inline-block text-center text-white"></li>
                                    <li id="hours" class="text-[28px] leading-[72px] h-[80px] w-[80px] font-medium rounded-md shadow-sm shadow-gray-100 inline-block text-center text-white"></li>
                                    <li id="mins" class="text-[28px] leading-[72px] h-[80px] w-[80px] font-medium rounded-md shadow-sm shadow-gray-100 inline-block text-center text-white"></li>
                                    <li id="secs" class="text-[28px] leading-[72px] h-[80px] w-[80px] font-medium rounded-md shadow-sm shadow-gray-100 inline-block text-center text-white"></li>
                                    <li id="end" class="h1"></li>
                                </ul>
                            </div>
                            <div class="mt-4">
                                <a href="sale.html" class="py-2 px-5 inline-block font-semibold tracking-wide align-middle text-center bg-white text-orange-500 rounded-md"><i class="mdi mdi-cart-outline"></i> Mua Ngay</a>
                            </div>
                        </div><!--end grid-->
                    </div>
                </div>
            </div><!--end container-->

            <div class="container relative md:mt-24 mt-16">
                <div class="grid items-end md:grid-cols-2 mb-6">
                    <div class="md:text-start text-center">
                        <h5 class="font-semibold text-3xl leading-normal mb-4">Sản Phẩm Phổ Biến</h5>
                        <p class="text-slate-400 max-w-xl">Những sản phẩm phổ biến trong tuần này</p>
                    </div>

                    <div class="md:text-end hidden md:block">
                        <a href="shop-grid.html" class="text-slate-400 hover:text-orange-500">Xem Thêm Sản Phẩm <i class="mdi mdi-arrow-right"></i></a>
                    </div>
                </div><!--end grid-->

                <div class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 pt-6 gap-6">
                    <div class="group">
                        <div class="relative overflow-hidden shadow-sm dark:shadow-gray-800 group-hover:shadow-lg group-hover:dark:shadow-gray-800 rounded-md duration-500">
                            <img src="{{ asset('assets/user/images/shop/luxurious-bag2.jpg')}}" class="group-hover:scale-110 duration-500" alt="">
    
                            <div class="absolute -bottom-20 group-hover:bottom-3 start-3 end-3 duration-500">
                                <a href="shop-cart.html" class="py-2 px-5 inline-block font-semibold tracking-wide align-middle duration-500 text-base text-center bg-slate-900 text-white w-full rounded-md">Thêm Vào Giỏ</a>
                            </div>
    
                            <ul class="list-none absolute top-[10px] end-4 opacity-0 group-hover:opacity-100 duration-500 space-y-1">
                                <li><a href="javascript:void(0)" class="size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow"><i data-feather="heart" class="size-4"></i></a></li>
                                <li class="mt-1"><a href="shop-item-detail.html" class="size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow"><i data-feather="eye" class="size-4"></i></a></li>
                                <li class="mt-1"><a href="javascript:void(0)" class="size-10 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow"><i data-feather="bookmark" class="size-4"></i></a></li>
                            </ul>

                            <ul class="list-none absolute top-[10px] start-4">
                                <li><a href="javascript:void(0)" class="bg-red-600 text-white text-[10px] font-bold px-2.5 py-0.5 rounded h-5">Mới</a></li>
                            </ul>
                        </div>

                        <div class="mt-4">
                            <a href="product-detail-one.html" class="hover:text-orange-500 text-lg font-medium">Túi Xách Sang Trọng Màu Cam</a>
                            <div class="flex justify-between items-center mt-1">
                                <p>$16.00 <del class="text-slate-400">$21.00</del></p>
                                <ul class="font-medium text-amber-400 list-none">
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                </ul>
                            </div>
                        </div>
                    </div><!--end content-->

                </div><!--end grid-->

                <div class="grid grid-cols-1 mt-6">
                    <div class="text-center md:hidden block">
                        <a href="shop-grid.html" class="text-slate-400 hover:text-orange-500">Xem Thêm Sản Phẩm <i class="mdi mdi-arrow-right"></i></a>
                    </div>
                </div>
            </div><!--end container-->
        </section><!--end section-->
@endsection