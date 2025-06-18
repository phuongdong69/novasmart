<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
</head>
<body>
    @include('layouts.sidebar')
    <div class="main-content">
        @include('layouts.head')

        <div class="content p-4">
            @yield('content')
        </div>

        @include('layouts.footer')
    </div>
</body>
</html>