@extends('user.layouts.client')
@section('title', 'Chi tiết sản phẩm')
@section('meta_description', 'Đây là chi tiết sản phẩm của Nova Smart.')

@section('content')
<!-- Start Hero -->
<section class="relative table w-full py-20 lg:py-24 md:pt-28 bg-gray-50 dark:bg-slate-800">
    <div class="container relative">
        <div class="grid grid-cols-1 mt-14">
            <h3 class="text-3xl leading-normal font-semibold">Áo Khoác Nâu Nam</h3>
        </div>

        <div class="relative mt-3">
            <ul class="tracking-[0.5px] mb-0 inline-block">
                <li class="inline-block uppercase text-[13px] font-bold duration-500 ease-in-out hover:text-orange-500"><a href="index.html">Trang Chủ</a></li>
                <li class="inline-block text-base text-slate-950 dark:text-white mx-0.5"><i class="mdi mdi-chevron-right"></i></li>
                <li class="inline-block uppercase text-[13px] font-bold duration-500 ease-in-out hover:text-orange-500"><a href="shop-grid.html">Cửa Hàng</a></li>
                <li class="inline-block text-base text-slate-950 dark:text-white mx-0.5"><i class="mdi mdi-chevron-right"></i></li>
                <li class="inline-block uppercase text-[13px] font-bold text-orange-500" aria-current="page">Áo Khoác Nâu Nam</li>
            </ul>
        </div>
    </div>
</section>
<!-- End Hero -->

<!-- Start -->
<section class="relative md:py-24 py-16">
    <div class="container relative">
        <div class="grid md:grid-cols-2 grid-cols-1 gap-6 items-center">
            <!-- Bên trái: hình ảnh sản phẩm (không đổi) -->
            <!-- Bên phải -->
            <div class="">
                <h5 class="text-2xl font-semibold">Áo Khoác Nâu Nam</h5>
                <div class="mt-2">
                    <span class="text-slate-400 font-semibold me-1">$16USD <del class="text-red-600">$21USD</del></span>
                    <ul class="list-none inline-block text-orange-400">
                        <li class="inline"><i class="mdi mdi-star text-lg"></i></li>
                        <li class="inline"><i class="mdi mdi-star text-lg"></i></li>
                        <li class="inline"><i class="mdi mdi-star text-lg"></i></li>
                        <li class="inline"><i class="mdi mdi-star text-lg"></i></li>
                        <li class="inline"><i class="mdi mdi-star text-lg"></i></li>
                        <li class="inline text-slate-400 font-semibold">4.8 (45)</li>
                    </ul>
                </div>

                <div class="mt-4">
                    <h5 class="text-lg font-semibold">Tổng Quan :</h5>
                    <p class="text-slate-400 mt-2">Sản phẩm cao cấp, chất liệu bền đẹp, kiểu dáng hiện đại. Thích hợp cho mọi dịp sử dụng.</p>
                    <ul class="list-none text-slate-400 mt-4">
                        <li class="mb-1 flex"><i class="mdi mdi-check-circle-outline text-orange-500 text-xl me-2"></i> Giải pháp tiếp thị số cho tương lai</li>
                        <li class="mb-1 flex"><i class="mdi mdi-check-circle-outline text-orange-500 text-xl me-2"></i> Đội ngũ giàu kinh nghiệm và sáng tạo</li>
                        <li class="mb-1 flex"><i class="mdi mdi-check-circle-outline text-orange-500 text-xl me-2"></i> Tuỳ chỉnh giao diện theo thương hiệu</li>
                    </ul>
                </div>

                <div class="grid lg:grid-cols-2 grid-cols-1 gap-6 mt-4">
                    <div class="flex items-center">
                        <h5 class="text-lg font-semibold me-2">Kích cỡ:</h5>
                        <div class="space-x-1">
                            <a href="#" class="size-9 ...">S</a>
                            <a href="#" class="size-9 ...">M</a>
                            <a href="#" class="size-9 ...">L</a>
                            <a href="#" class="size-9 ...">XL</a>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <h5 class="text-lg font-semibold me-2">Số lượng:</h5>
                        <div class="qty-icons ms-3 space-x-0.5">
                            <button ...>-</button>
                            <input ...>
                            <button ...>+</button>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <h5 class="text-lg font-semibold me-2">Màu sắc:</h5>
                        <div class="space-x-2">
                            <a href="#" ... title="Đỏ"></a>
                            <a href="#" ... title="Cam"></a>
                            <a href="#" ... title="Đen"></a>
                            <a href="#" ... title="Xám"></a>
                        </div>
                    </div>
                </div>

                <div class="mt-4 space-x-1">
                    <a href="#" class="...">Mua Ngay</a>
                    <a href="#" class="...">Thêm Vào Giỏ</a>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-12 grid-cols-1 mt-6 gap-6">
            <div class="lg:col-span-3 md:col-span-5">
                <div class="sticky top-20">
                    <ul class="..." id="myTab" ...>
                        <li role="presentation">
                            <button ...>Mô Tả</button>
                        </li>
                        <li role="presentation">
                            <button ...>Thông Tin Bổ Sung</button>
                        </li>
                        <li role="presentation">
                            <button ...>Đánh Giá</button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="lg:col-span-9 md:col-span-7">
                <div id="myTabContent" class="...">
                    <div id="description" ...>
                        <p class="text-slate-400">Nội dung mô tả chi tiết sản phẩm sẽ hiển thị tại đây. Có thể bao gồm chất liệu, đặc điểm nổi bật, hướng dẫn sử dụng, v.v.</p>
                    </div>

                    <div class="hidden" id="addinfo" ...>
                        <table class="w-full text-start">
                            <tbody>
                                <tr>
                                    <td class="font-semibold pb-4">Màu sắc</td>
                                    <td class="text-slate-400 pb-4">Đỏ, Trắng, Đen, Cam</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold py-4">Chất liệu</td>
                                    <td class="text-slate-400 py-4">Cotton</td>
                                </tr>
                                <tr>
                                    <td class="font-semibold pt-4">Kích cỡ</td>
                                    <td class="text-slate-400 pt-4">S, M, L, XL, XXL</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="hidden" id="review" ...>
                        <!-- Giữ nguyên phần đánh giá nếu bạn chưa có nội dung tiếng Việt -->
                        <!-- Có thể chỉnh sửa tên, nội dung đánh giá, hoặc dịch đoạn trích dẫn thành: -->
                        <p class="text-slate-400 italic">" Có nhiều biến thể của văn bản Lorem Ipsum có sẵn, nhưng phần lớn đã bị thay đổi. "</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sản phẩm mới --}}
    @include('user.partials.newitem')
</section>
<!-- End -->
@endsection
