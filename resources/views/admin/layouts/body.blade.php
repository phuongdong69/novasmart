@include('admin.layouts.header')
<body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">
    @include('admin.layouts.sidebar')

    <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
        @include('admin.layouts.navbar')

            @yield('content')   

        @include('admin.layouts.footer')
    </main>

    @include('admin.layouts.scripts')
    @include('admin.layouts.assets')
</body>
