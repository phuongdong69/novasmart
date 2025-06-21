<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
</head>
<body>
    @include('admin.layouts.sidebar')
    <div class="main-content">
        @include('admin.layouts.header')

        <div class="content p-4">
            @yield('content')
        </div>

        @include('admin.layouts.footer')
    </div>
</body>
</html>