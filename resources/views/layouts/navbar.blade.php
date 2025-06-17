<nav class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-tr from-blue-600 to-indigo-500 text-white px-6 py-4 rounded-b-xl shadow-md">
    <div class="flex items-center justify-between">
        <!-- Breadcrumb -->
        <div>
            <ol class="flex space-x-2 text-sm opacity-80">
                <li><a href="javascript:;" class="hover:underline">Trang</a></li>
                <li class="before:content-['/'] before:px-2">Dashboard</li>
            </ol>
            <h6 class="text-lg font-bold mt-1">Dashboard</h6>
        </div>

        <!-- Search + Logout -->
        <div class="flex items-center gap-4">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fas fa-search text-slate-500"></i>
                </span>
                <input type="text" placeholder="Tìm kiếm..."
                    class="pl-10 pr-3 py-2 rounded-md text-sm bg-white border border-gray-300 text-gray-800 focus:outline-none focus:ring focus:border-blue-400">
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-md text-white text-sm">
                    Đăng xuất
                </button>
            </form>
        </div>
    </div>
</nav>
