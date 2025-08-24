@extends('user.layouts.signup')

@section('title', 'Đăng ký')
@section('content') 
<section class="md:h-screen py-36 flex items-center bg-orange-500/10 dark:bg-orange-500/20 bg-[url('../../assets/images/hero/bg-shape.html')] bg-center bg-no-repeat bg-cover">
    <div class="container relative">
        <div class="grid grid-cols-1">
            <div class="relative overflow-hidden rounded-md shadow-sm dark:shadow-gray-700 bg-white dark:bg-slate-900">
                <div class="grid md:grid-cols-2 grid-cols-1 items-center">
                    <div class="relative md:shrink-0">
                        <img class="h-full w-full object-cover md:h-[44rem]" src="assets/images/signup.jpg" alt="">
                    </div>

                    <div class="p-8 lg:px-20">
                        <div class="text-center">
                            <a href="index.html">
                                <img src="{{ asset('assets/user/images/logonova.jpg') }}" class="mx-auto block" alt="NovaSmart Logo" style="max-height:48px; width:auto; border-radius:50%; object-fit:cover;"/>
                                <img src="assets/images/logo-light.png" class="mx-auto hidden dark:block" alt="">
                            </a>
                        </div>

                        <form class="text-start lg:py-20 py-8">
                            <div class="grid grid-cols-1">
                                <div class="mb-4">
                                    <label class="font-semibold" for="RegisterName">Họ tên:</label>
                                    <input id="RegisterName" type="text" class="mt-3 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-100 dark:border-gray-800 focus:ring-0" placeholder="Nguyễn Văn A">
                                </div>

                                <div class="mb-4">
                                    <label class="font-semibold" for="LoginEmail">Địa chỉ Email:</label>
                                    <input id="LoginEmail" type="email" class="mt-3 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-100 dark:border-gray-800 focus:ring-0" placeholder="ten@example.com">
                                </div>

                                <div class="mb-4">
                                    <label class="font-semibold" for="LoginPassword">Mật khẩu:</label>
                                    <input id="LoginPassword" type="password" class="mt-3 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-100 dark:border-gray-800 focus:ring-0" placeholder="Nhập mật khẩu">
                                </div>

                                <div class="mb-4">
                                    <div class="flex items-center w-full mb-0">
                                        <input class="form-checkbox size-4 appearance-none rounded border border-gray-200 dark:border-gray-800 accent-orange-600 checked:appearance-auto dark:accent-orange-600 focus:border-orange-300 focus:ring focus:ring-offset-0 focus:ring-orange-200 focus:ring-opacity-50 me-2" type="checkbox" value="" id="AcceptT&C">
                                        <label class="form-check-label text-slate-400" for="AcceptT&C">Tôi đồng ý với <a href="#" class="text-orange-500">Điều khoản & Điều kiện</a></label>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <input type="submit" class="py-2 px-5 inline-block tracking-wide align-middle duration-500 text-base text-center bg-orange-500 text-white rounded-md w-full" value="Đăng ký">
                                </div>

                                <div class="text-center">
                                    <span class="text-slate-400 me-2">Đã có tài khoản?</span> <a href="login.html" class="text-slate-900 dark:text-white font-bold inline-block">Đăng nhập</a>
                                </div>
                            </div>
                        </form>

                        <div class="text-center">
                            <p class="mb-0 text-slate-400">© <script>document.write(new Date().getFullYear())</script> Nova. Thiết kế với <i class="mdi mdi-heart text-red-600"></i> bởi <a class="text-reset">Nova Dev</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
