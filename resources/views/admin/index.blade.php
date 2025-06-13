
    <body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">
    <div class="absolute w-full bg-blue-500 dark:hidden min-h-75"></div>

    @include('admin.sidebar')

    <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
        @include('admin.navbar')
        @include('admin.contentwrapper')
        @yield('content')
        
        @include('admin.footer')
    </main>
    
    @include('layouts.scripts')
    @include('layouts.assets')
</body>
