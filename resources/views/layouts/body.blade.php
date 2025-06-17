@include('layouts.header')

<body
    class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">

    @include('layouts.sidebar')

    <main class="relative pt-32 h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">

        @include('layouts.navbar')

        <div class="mt-6"> <!-- THÊM margin top -->
            @yield('content')
        </div>

        @include('layouts.footer')
    </main>


    @include('layouts.scripts')
    @include('layouts.assets')
</body>
