<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Danh sách sản phẩm')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    {{-- Navbar --}}
    <nav class="bg-blue-600 p-4 text-white">
        <a href="{{ route('user.products.index') }}" class="text-lg font-bold">Trang chủ</a>
    </nav>

    {{-- Content --}}
    <div class="container mx-auto py-6">
        @yield('content')
    </div>

</body>
</html>
