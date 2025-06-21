<!DOCTYPE html>
<html lang="en" class="light scroll-smooth" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Shreethemes">
    @include('user.partials.assests')


</head>

<body class="dark:bg-slate-900">

    @include('user.partials.header')
    <main>
        @yield('content')
    </main>


    @include('user.partials.footer')

    @include('user.partials.scroll')


    @include('user.partials.script')


</body>

</html>
