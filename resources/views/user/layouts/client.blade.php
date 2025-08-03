<!DOCTYPE html>
<html lang="en" class="light scroll-smooth" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('meta_description')">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Shreethemes">
    @include('user.partials.assests')

    {{-- Thêm biến login cho JS --}}
    <script>
        window.isLoggedIn = @json(Auth::check());
    </script>
</head>

<body class="dark:bg-slate-900">

    @include('user.partials.header')

    <main>
        @yield('content')
    </main>

    @include('user.partials.footer')
    @include('user.partials.scroll')

    {{-- Thêm popup yêu cầu đăng nhập --}}
    {{-- @include('user.partials.popup') --}}

    {{-- Load JS (gồm cả popup-cart.js nếu đã thêm trong script.blade.php) --}}
    @include('user.partials.script')

</body>

</html>
