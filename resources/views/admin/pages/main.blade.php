<main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl"> 

        <div class="w-full px-6 py-6 mx-auto">

            @include('admin.pages.navbar')

            @yield('content')
            
            @include('admin.pages.footer')
        </div>
        
    </main>