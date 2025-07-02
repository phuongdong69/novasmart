@extends('user.layouts.client')

@section('title', 'Thanh toán thành công')

@section('content')
<section class="py-20 bg-gray-50 dark:bg-slate-800">
    <div class="container text-center">
        <div class="max-w-xl mx-auto bg-white dark:bg-slate-900 rounded shadow p-10">
            <h2 class="text-3xl font-bold text-green-600 mb-4">Cảm ơn bạn đã đặt hàng!</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-6">Đơn hàng của bạn đã được ghi nhận. Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.</p>
            <a href="{{ route('home') }}" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded">
                Về trang chủ
            </a>
        </div>
    </div>
</section>
@endsection