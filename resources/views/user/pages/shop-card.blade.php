    <!-- Start Hero -->
@extends('user.layouts.client')
@section('title', 'Shopcart')
@section('content')
        <section class="relative table w-full py-20 lg:py-24 bg-gray-50 dark:bg-slate-800">
            <div class="container relative">
                <div class="grid grid-cols-1 mt-14">
                    <h3 class="text-3xl leading-normal font-semibold">Shopcart</h3>
                </div><!--end grid-->

                <div class="relative mt-3">
                    <ul class="tracking-[0.5px] mb-0 inline-block">
                        <li class="inline-block uppercase text-[13px] font-bold duration-500 ease-in-out hover:text-orange-500"><a href="index.html">Cartzio</a></li>
                        <li class="inline-block text-base text-slate-950 dark:text-white mx-0.5 ltr:rotate-0 rtl:rotate-180"><i class="mdi mdi-chevron-right"></i></li>
                        <li class="inline-block uppercase text-[13px] font-bold text-orange-500" aria-current="page">Shopcart</li>
                    </ul>
                </div>
            </div><!--end container-->
        </section><!--end section-->
        <!-- End Hero -->

        <!-- Start -->
        <section class="relative md:py-24 py-16">
            <div class="container relative">
                <div class="grid lg:grid-cols-1">
                    <div class="relative overflow-x-auto shadow-sm dark:shadow-gray-800 rounded-md">
                        <table class="w-full text-start">
                            <thead class="text-sm uppercase bg-slate-50 dark:bg-slate-800">
                                <tr>
                                    <th scope="col" class="p-4 w-4"></th>
                                    <th scope="col" class="text-start p-4 min-w-[220px]">Product</th>
                                    <th scope="col" class="p-4 w-24 min-w-[100px]">Price</th>
                                    <th scope="col" class="p-4 w-56 min-w-[220px]">Qty</th>
                                    <th scope="col" class="p-4 w-24 min-w-[100px]">Total($)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white dark:bg-slate-900">
                                    <td class="p-4"><a href="#"><i class="mdi mdi-window-close text-red-600"></i></a></td>
                                    <td class="p-4">
                                        <span class="flex items-center">
                                            <img src="assets/images/shop/black-print-t-shirt.jpg" class="rounded shadow-sm dark:shadow-gray-800 w-12" alt="">
                                            <span class="ms-3">
                                                <span class="block font-semibold">T-shirt (M)</span>
                                            </span>
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">$ 280</td>
                                    <td class="p-4 text-center">
                                        <div class="qty-icons">
                                            <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="size-9 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white minus">-</button>
                                            <input min="0" name="quantity" value="3" type="number" class="h-9 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white pointer-events-none w-16 ps-4 quantity">
                                            <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="size-9 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white plus">+</button>
                                        </div>
                                    </td>
                                    <td class="p-4  text-end">$ 840</td>
                                </tr>

                                <tr class="bg-white dark:bg-slate-900 border-t border-gray-100 dark:border-gray-800">
                                    <td class="p-4"><a href="#"><i class="mdi mdi-window-close text-red-600"></i></a></td>
                                    <td class="p-4">
                                        <span class="flex items-center">
                                            <img src="assets/images/shop/fashion-shoes-sneaker.jpg" class="rounded shadow-sm dark:shadow-gray-800 w-12" alt="">
                                            <span class="ms-3">
                                                <span class="block font-semibold">Sneaker Shoes</span>
                                            </span>
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">$ 160</td>
                                    <td class="p-4 text-center">
                                        <div class="qty-icons">
                                            <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="size-9 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white minus">-</button>
                                            <input min="0" name="quantity" value="1" type="number" class="h-9 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white pointer-events-none w-16 ps-4 quantity">
                                            <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="size-9 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white plus">+</button>
                                        </div>
                                    </td>
                                    <td class="p-4  text-end">$ 160</td>
                                </tr>

                                <tr class="bg-white dark:bg-slate-900 border-t border-gray-100 dark:border-gray-800">
                                    <td class="p-4"><a href="#"><i class="mdi mdi-window-close text-red-600"></i></a></td>
                                    <td class="p-4">
                                        <span class="flex items-center">
                                            <img src="assets/images/shop/ladies-skirt-pair.jpg" class="rounded shadow-sm dark:shadow-gray-800 w-12" alt="">
                                            <span class="ms-3">
                                                <span class="block font-semibold">Ladies Skirt</span>
                                            </span>
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">$ 500</td>
                                    <td class="p-4 text-center">
                                        <div class="qty-icons">
                                            <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="size-9 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white minus">-</button>
                                            <input min="0" name="quantity" value="1" type="number" class="h-9 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white pointer-events-none w-16 ps-4 quantity">
                                            <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="size-9 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md bg-orange-500/5 hover:bg-orange-500 text-orange-500 hover:text-white plus">+</button>
                                        </div>
                                    </td>
                                    <td class="p-4  text-end">$ 500</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>