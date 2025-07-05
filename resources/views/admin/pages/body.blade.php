<body >
<div class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">
    @include('admin.pages.sidebar')
    @include('admin.pages.main')
    
    @include('admin.pages.scripts')
    @stack('scripts')
    </div> 
</body>