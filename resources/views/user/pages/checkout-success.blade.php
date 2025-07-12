@extends('user.layouts.client')

@section('title', 'Thanh toán thành công')

@section('content')
<section class="py-20 bg-gray-50 dark:bg-slate-800">
    <div class="w-full max-w-2xl mx-auto bg-white dark:bg-slate-900 border-4 border-green-500 rounded-2xl shadow-lg p-10 text-center mt-20">

        <div class="flex justify-center mb-6">
            <img src="{{ asset('assets/user/images/order-success.svg') }}" width="200" alt="Đặt hàng thành công">
        </div>

        <h2 class="text-3xl font-extrabold text-green-600 mb-3">Cảm ơn bạn đã đặt hàng!</h2>

        <p class="text-gray-700 dark:text-gray-300 text-base leading-relaxed mb-6">
            Đơn hàng của bạn đã được ghi nhận. Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.
        </p>

        <a href="{{ route('home') }}"
            class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-3 min-w-[180px] text-center rounded-full transition duration-300">
            Về trang chủ
        </a>
    </div>
</section>
@endsection