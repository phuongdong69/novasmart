 <!doctype html>
<html lang="en">

<head>
    <title>Nova Smart</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
</head>

@include('layouts.assets')
    <body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">
    <div class="absolute w-full bg-blue-500 dark:hidden min-h-75"></div>

    @include('layouts.sidebar')

    <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
        @include('layouts.navbar')
        @include('layouts.contentwrapper')
        @yield('content')
        
        @include('layouts.footer')
    </main>
    
    @include('layouts.scripts')
</body>
</html>