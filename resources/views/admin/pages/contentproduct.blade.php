<script src="https://cdn.tailwindcss.com"></script>
<div class="bg-gray-50">
<div class="container mx-auto p-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="p-6 border-b">
                <h1 class="text-2xl font-semibold text-gray-900">Danh Mục Sản Phẩm</h1>
                <p class="text-gray-600 mt-1">Quản lý và theo dõi tất cả sản phẩm điện tử</p>
            </div>
            
            <!-- Table Header -->
            <div class="grid grid-cols-12 gap-4 p-4 bg-gray-50 text-sm font-medium text-gray-700">
                <div class="col-span-1">
                    <input type="checkbox" class="rounded border-gray-300">
                </div>
                <div class="col-span-4">SẢN PHẨM</div>
                <div class="col-span-1">DANH MỤC</div>
                <div class="col-span-1">GIÁ CƠ BẢN</div>
                <div class="col-span-1">BIẾN THỂ</div>
                <div class="col-span-1">TỒN KHO</div>
                <div class="col-span-1">TRẠNG THÁI</div>
                <div class="col-span-2">THAO TÁC</div>
            </div>
        </div>

        <!-- Product List -->
        <div class="bg-white rounded-lg shadow-sm" id="productList">
            <!-- Products will be inserted here -->
        </div>

        <!-- Pagination -->
        <div class="bg-white rounded-lg shadow-sm mt-6 p-4">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Hiển thị <span class="font-medium" id="showingFrom">1</span> đến <span class="font-medium" id="showingTo">5</span> 
                    trong tổng số <span class="font-medium" id="totalItems">15</span> sản phẩm
                </div>
                <div class="flex items-center space-x-2">
                    <button id="prevBtn" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        Trước
                    </button>
                    <div class="flex space-x-1" id="pageNumbers">
                        <!-- Page numbers will be inserted here -->
                    </div>
                    <button id="nextBtn" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        Sau
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="{{ asset('assets/admin/js/adminproduct.js') }}" rel="stylesheet" />