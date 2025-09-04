@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    <!-- Doanh thu -->
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-coins text-yellow-600"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Doanh Thu</h2>
            </div>
            <!-- Bộ lọc cho revenue -->
            <div class="flex flex-wrap items-center gap-2">
                <!-- Giữ các filter khác -->
                <form method="GET" action="{{ route('admin.dashboard') }}" class="hidden" id="revenue-form">
                    <input type="hidden" name="users_period" value="{{ $usersPeriod ?? 'week' }}">
                    <input type="hidden" name="users_start_date" value="{{ $usersStart }}">
                    <input type="hidden" name="users_end_date" value="{{ $usersEnd }}">
                    <input type="hidden" name="products_period" value="{{ $productsPeriod ?? 'week' }}">
                    <input type="hidden" name="products_start_date" value="{{ $productsStart }}">
                    <input type="hidden" name="products_end_date" value="{{ $productsEnd }}">
                    <input type="hidden" name="orders_period" value="{{ $ordersPeriod ?? 'week' }}">
                    <input type="hidden" name="orders_start_date" value="{{ $ordersStart }}">
                    <input type="hidden" name="orders_end_date" value="{{ $ordersEnd }}">
                    <input type="hidden" name="revenue_period" id="revenue-period-input" value="{{ $revenuePeriod ?? 'week' }}">
                    <input type="hidden" name="revenue_start_date" id="revenue-start-input" value="{{ $revenueStart }}">
                    <input type="hidden" name="revenue_end_date" id="revenue-end-input" value="{{ $revenueEnd }}">
                </form>
                
                <!-- Các nút lọc thời gian -->
                <div class="flex flex-wrap gap-2">
                    <button onclick="setRevenuePeriod('today')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($revenuePeriod ?? 'week') == 'today' ? 'background-color: #f59e0b; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #fde68a; color: #92400e; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Ngày
                    </button>
                    <button onclick="setRevenuePeriod('week')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($revenuePeriod ?? 'week') == 'week' ? 'background-color: #f59e0b; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #fde68a; color: #92400e; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Tuần
                    </button>
                    <button onclick="setRevenuePeriod('month')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($revenuePeriod ?? 'week') == 'month' ? 'background-color: #f59e0b; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #fde68a; color: #92400e; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Tháng
                    </button>
                    <button onclick="setRevenuePeriod('quarter')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($revenuePeriod ?? 'week') == 'quarter' ? 'background-color: #f59e0b; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #fde68a; color: #92400e; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Quý
                    </button>
                    <button onclick="setRevenuePeriod('year')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($revenuePeriod ?? 'week') == 'year' ? 'background-color: #f59e0b; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #fde68a; color: #92400e; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Năm
                    </button>
                </div>
                
                <!-- Chọn khoảng thời gian tùy chỉnh -->
                <div class="flex flex-wrap gap-3 items-center mt-3 p-3 bg-gray-50 rounded-lg border">
                    <div class="flex items-center gap-2">
                        <label class="text-sm font-medium text-gray-700">Từ ngày:</label>
                        <input type="date" id="revenue-start-date" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500" value="{{ $revenueStart }}">
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-sm font-medium text-gray-700">Đến ngày:</label>
                        <input type="date" id="revenue-end-date" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500" value="{{ $revenueEnd }}">
                    </div>
                    <button onclick="applyRevenueCustom()" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 flex items-center gap-2" style="background-color: #f59e0b; color: white; border: none;">
                        <i class="fas fa-search"></i>
                        Áp dụng
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Hiển thị doanh thu -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Tổng doanh thu -->
            <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Tổng Doanh Thu</h3>
                        <p class="text-3xl font-bold">{{ number_format($revenue, 0, ',', '.') }} ₫</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <!-- Biểu đồ doanh thu -->
            <div>
                <canvas id="revenueChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Phân cách màu vàng -->
    <div class="h-1 bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 rounded-full mb-8 shadow-sm"></div>
    
    <!-- Top User Mua Nhiều Nhất -->
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-users text-blue-600"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Top User Mua Nhiều Nhất</h2>
            </div>
            <!-- Bộ lọc cho users -->
            <div class="flex flex-wrap items-center gap-2">
                <!-- Giữ các filter khác -->
                <form method="GET" action="{{ route('admin.dashboard') }}" class="hidden" id="users-form">
                    <input type="hidden" name="revenue_period" value="{{ $revenuePeriod ?? 'week' }}">
                    <input type="hidden" name="revenue_start_date" value="{{ $revenueStart }}">
                    <input type="hidden" name="revenue_end_date" value="{{ $revenueEnd }}">
                    <input type="hidden" name="products_period" value="{{ $productsPeriod ?? 'week' }}">
                    <input type="hidden" name="products_start_date" value="{{ $productsStart }}">
                    <input type="hidden" name="products_end_date" value="{{ $productsEnd }}">
                    <input type="hidden" name="orders_period" value="{{ $ordersPeriod ?? 'week' }}">
                    <input type="hidden" name="orders_start_date" value="{{ $ordersStart }}">
                    <input type="hidden" name="orders_end_date" value="{{ $ordersEnd }}">
                    <input type="hidden" name="users_period" id="users-period-input" value="{{ $usersPeriod ?? 'week' }}">
                    <input type="hidden" name="users_start_date" id="users-start-input" value="{{ $usersStart }}">
                    <input type="hidden" name="users_end_date" id="users-end-input" value="{{ $usersEnd }}">
                </form>
                
                <!-- Các nút lọc thời gian -->
                <div class="flex flex-wrap gap-2">
                    <button onclick="setUsersPeriod('today')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($usersPeriod ?? 'week') == 'today' ? 'background-color: #3b82f6; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #bfdbfe; color: #1e40af; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Ngày
                    </button>
                    <button onclick="setUsersPeriod('week')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($usersPeriod ?? 'week') == 'week' ? 'background-color: #3b82f6; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #bfdbfe; color: #1e40af; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Tuần
                    </button>
                    <button onclick="setUsersPeriod('month')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($usersPeriod ?? 'week') == 'month' ? 'background-color: #3b82f6; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #bfdbfe; color: #1e40af; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Tháng
                    </button>
                    <button onclick="setUsersPeriod('quarter')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($usersPeriod ?? 'week') == 'quarter' ? 'background-color: #3b82f6; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #bfdbfe; color: #1e40af; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Quý
                    </button>
                    <button onclick="setUsersPeriod('year')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($usersPeriod ?? 'week') == 'year' ? 'background-color: #3b82f6; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #bfdbfe; color: #1e40af; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Năm
                    </button>
                </div>
                
                <!-- Chọn khoảng thời gian tùy chỉnh -->
                <div class="flex flex-wrap gap-3 items-center mt-3 p-3 bg-gray-50 rounded-lg border">
                    <div class="flex items-center gap-2">
                        <label class="text-sm font-medium text-gray-700">Từ ngày:</label>
                        <input type="date" id="users-start-date" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ $usersStart }}">
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-sm font-medium text-gray-700">Đến ngày:</label>
                        <input type="date" id="users-end-date" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ $usersEnd }}">
                    </div>
                    <button onclick="applyUsersCustom()" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 flex items-center gap-2" style="background-color: #3b82f6; color: white; border: none;">
                        <i class="fas fa-search"></i>
                        Áp dụng
                    </button>
                </div>
            </div>
        </div>
        <!-- Biểu đồ cột Top Users -->
        <div class="mb-6">
            <canvas id="topUsersChart" width="400" height="200"></canvas>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng chi tiêu</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($topUsers as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-green-600">{{ number_format($user->total_spent, 0, ',', '.') }} ₫</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-center text-sm text-gray-500">Không có dữ liệu</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Phân cách màu xanh lá -->
    <div class="h-1 bg-gradient-to-r from-green-400 via-green-500 to-green-600 rounded-full mb-8 shadow-sm"></div>

    <!-- Top Sản Phẩm Bán Chạy -->
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-box text-green-600"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Top Sản Phẩm Bán Chạy</h2>
            </div>
            <!-- Bộ lọc cho products -->
            <div class="flex flex-wrap items-center gap-2">
                <!-- Giữ các filter khác -->
                <form method="GET" action="{{ route('admin.dashboard') }}" class="hidden" id="products-form">
                    <input type="hidden" name="revenue_period" value="{{ $revenuePeriod ?? 'week' }}">
                    <input type="hidden" name="revenue_start_date" value="{{ $revenueStart }}">
                    <input type="hidden" name="revenue_end_date" value="{{ $revenueEnd }}">
                    <input type="hidden" name="users_period" value="{{ $usersPeriod ?? 'week' }}">
                    <input type="hidden" name="users_start_date" value="{{ $usersStart }}">
                    <input type="hidden" name="users_end_date" value="{{ $usersEnd }}">
                    <input type="hidden" name="orders_period" value="{{ $ordersPeriod ?? 'week' }}">
                    <input type="hidden" name="orders_start_date" value="{{ $ordersStart }}">
                    <input type="hidden" name="orders_end_date" value="{{ $ordersEnd }}">
                    <input type="hidden" name="products_period" id="products-period-input" value="{{ $productsPeriod ?? 'week' }}">
                    <input type="hidden" name="products_start_date" id="products-start-input" value="{{ $productsStart }}">
                    <input type="hidden" name="products_end_date" id="products-end-input" value="{{ $productsEnd }}">
                </form>
                
                <!-- Các nút lọc thời gian -->
                <div class="flex flex-wrap gap-2">
                    <button onclick="setProductsPeriod('today')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($productsPeriod ?? 'week') == 'today' ? 'background-color: #10b981; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #a7f3d0; color: #065f46; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Ngày
                    </button>
                    <button onclick="setProductsPeriod('week')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($productsPeriod ?? 'week') == 'week' ? 'background-color: #10b981; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #a7f3d0; color: #065f46; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Tuần
                    </button>
                    <button onclick="setProductsPeriod('month')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($productsPeriod ?? 'week') == 'month' ? 'background-color: #10b981; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #a7f3d0; color: #065f46; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Tháng
                    </button>
                    <button onclick="setProductsPeriod('quarter')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($productsPeriod ?? 'week') == 'quarter' ? 'background-color: #10b981; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #a7f3d0; color: #065f46; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Quý
                    </button>
                    <button onclick="setProductsPeriod('year')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($productsPeriod ?? 'week') == 'year' ? 'background-color: #10b981; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #a7f3d0; color: #065f46; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Năm
                    </button>
                </div>
                
                <!-- Chọn khoảng thời gian tùy chỉnh -->
                <div class="flex flex-wrap gap-3 items-center mt-3 p-3 bg-gray-50 rounded-lg border">
                    <div class="flex items-center gap-2">
                        <label class="text-sm font-medium text-gray-700">Từ ngày:</label>
                        <input type="date" id="products-start-date" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" value="{{ $productsStart }}">
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-sm font-medium text-gray-700">Đến ngày:</label>
                        <input type="date" id="products-end-date" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" value="{{ $productsEnd }}">
                    </div>
                    <button onclick="applyProductsCustom()" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 flex items-center gap-2" style="background-color: #10b981; color: white; border: none;">
                        <i class="fas fa-search"></i>
                        Áp dụng
                    </button>
                </div>
            </div>
        </div>
        <!-- Biểu đồ cột Top Products -->
        <div class="mb-6">
            <canvas id="topProductsChart" width="400" height="200"></canvas>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên sản phẩm</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng bán</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doanh thu</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($topProducts as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $product->sold_quantity ?? 0 }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-blue-600">{{ number_format($product->total_revenue ?? 0, 0, ',', '.') }} ₫</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-center text-sm text-gray-500">Không có dữ liệu</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Phân cách màu cam -->
    <div class="h-1 bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 rounded-full mb-8 shadow-sm"></div>

    <!-- Top Order Mới Nhất -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-shopping-cart text-purple-600"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">5 Đơn Hàng Mới Nhất</h2>
            </div>
            <!-- Bộ lọc cho orders (đã ẩn) -->
            <div class="flex flex-wrap items-center gap-2 hidden">
                <!-- Giữ các filter khác -->
                <form method="GET" action="{{ route('admin.dashboard') }}" class="hidden" id="orders-form">
                    <input type="hidden" name="revenue_period" value="{{ $revenuePeriod ?? 'week' }}">
                    <input type="hidden" name="revenue_start_date" value="{{ $revenueStart }}">
                    <input type="hidden" name="revenue_end_date" value="{{ $revenueEnd }}">
                    <input type="hidden" name="users_period" value="{{ $usersPeriod ?? 'week' }}">
                    <input type="hidden" name="users_start_date" value="{{ $usersStart }}">
                    <input type="hidden" name="users_end_date" value="{{ $usersEnd }}">
                    <input type="hidden" name="products_period" value="{{ $productsPeriod ?? 'week' }}">
                    <input type="hidden" name="products_start_date" value="{{ $productsStart }}">
                    <input type="hidden" name="products_end_date" value="{{ $productsEnd }}">
                    <input type="hidden" name="orders_period" id="orders-period-input" value="{{ $ordersPeriod ?? 'week' }}">
                    <input type="hidden" name="orders_start_date" id="orders-start-input" value="{{ $ordersStart }}">
                    <input type="hidden" name="orders_end_date" id="orders-end-input" value="{{ $ordersEnd }}">
                </form>
                
                <!-- Các nút lọc thời gian -->
                <div class="flex flex-wrap gap-2">
                    <button onclick="setOrdersPeriod('today')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($ordersPeriod ?? 'week') == 'today' ? 'background-color: #8b5cf6; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #ddd6fe; color: #5b21b6; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Ngày
                    </button>
                    <button onclick="setOrdersPeriod('week')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($ordersPeriod ?? 'week') == 'week' ? 'background-color: #8b5cf6; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #ddd6fe; color: #5b21b6; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Tuần
                    </button>
                    <button onclick="setOrdersPeriod('month')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($ordersPeriod ?? 'week') == 'month' ? 'background-color: #8b5cf6; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #ddd6fe; color: #5b21b6; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Tháng
                    </button>
                    <button onclick="setOrdersPeriod('quarter')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($ordersPeriod ?? 'week') == 'quarter' ? 'background-color: #8b5cf6; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #ddd6fe; color: #5b21b6; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Quý
                    </button>
                    <button onclick="setOrdersPeriod('year')" class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200" style="{{ ($ordersPeriod ?? 'week') == 'year' ? 'background-color: #8b5cf6; color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);' : 'background-color: #ddd6fe; color: #5b21b6; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);' }}">
                        Năm
                    </button>
                </div>
                
                <!-- Chọn khoảng thời gian tùy chỉnh -->
                <div class="flex flex-wrap gap-3 items-center mt-3 p-3 bg-gray-50 rounded-lg border">
                    <div class="flex items-center gap-2">
                        <label class="text-sm font-medium text-gray-700">Từ ngày:</label>
                        <input type="date" id="orders-start-date" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-violet-500 focus:border-violet-500" value="{{ $ordersStart }}">
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-sm font-medium text-gray-700">Đến ngày:</label>
                        <input type="date" id="orders-end-date" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-violet-500 focus:border-violet-500" value="{{ $ordersEnd }}">
                    </div>
                    <button onclick="applyOrdersCustom()" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 flex items-center gap-2" style="background-color: #8b5cf6; color: white; border: none;">
                        <i class="fas fa-search"></i>
                        Áp dụng
                    </button>
                </div>
            </div>
        </div>
        <!-- Biểu đồ cột Latest Orders (đã ẩn) -->
        <div class="mb-6">
            <canvas id="latestOrdersChart" class="hidden" width="400" height="200"></canvas>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã đơn</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách hàng</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng tiền</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tạo</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($latestOrders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium"><a href="{{ route('admin.orders.show', $order->id) }}" class="text-violet-600 hover:underline">{{ $order->order_code }}</a></td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $order->user->name ?? '-' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-green-600">{{ number_format($order->total_price, 0, ',', '.') }} ₫</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($order->orderStatus ->code === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->orderStatus ->code === 'confirmed') bg-blue-100 text-blue-800
                                    @elseif($order->orderStatus ->code === 'shipping') bg-purple-100 text-purple-800
                                    @elseif($order->orderStatus ->code === 'completed') bg-green-100 text-green-800
                                    @elseif($order->orderStatus ->code === 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $order->orderStatus ->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">Không có dữ liệu</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal chi tiết đơn hàng -->
<div id="orderDetailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[1000] opacity-0 pointer-events-none transition-opacity duration-200">
    <div class="bg-white w-full max-w-xl p-6 rounded-lg relative shadow-lg z-[1010]">
        <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700" onclick="closeOrderModal()">&times;</button>
        <div id="orderDetailContent" class="max-h-[70vh] overflow-y-auto"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue section functions
    function setRevenuePeriod(period) {
        document.getElementById('revenue-period-input').value = period;
        // Không reset ngày, cho phép kết hợp với bộ lọc thời gian tuỳ chỉnh
        document.getElementById('revenue-form').submit();
    }

    function applyRevenueCustom() {
        const startDate = document.getElementById('revenue-start-date').value;
        const endDate = document.getElementById('revenue-end-date').value;
        if (startDate && endDate) {
            // Giữ nguyên period hiện tại để dùng làm đơn vị gộp
            document.getElementById('revenue-start-input').value = startDate;
            document.getElementById('revenue-end-input').value = endDate;
            document.getElementById('revenue-form').submit();
        } else {
            alert('Vui lòng chọn cả ngày bắt đầu và ngày kết thúc');
        }
    }

    // Users section functions
    function setUsersPeriod(period) {
        document.getElementById('users-period-input').value = period;
        document.getElementById('users-form').submit();
    }

    function applyUsersCustom() {
        const startDate = document.getElementById('users-start-date').value;
        const endDate = document.getElementById('users-end-date').value;
        if (startDate && endDate) {
            document.getElementById('users-start-input').value = startDate;
            document.getElementById('users-end-input').value = endDate;
            document.getElementById('users-form').submit();
        } else {
            alert('Vui lòng chọn cả ngày bắt đầu và ngày kết thúc');
        }
    }

    // Products section functions
    function setProductsPeriod(period) {
        document.getElementById('products-period-input').value = period;
        document.getElementById('products-form').submit();
    }

    function applyProductsCustom() {
        const startDate = document.getElementById('products-start-date').value;
        const endDate = document.getElementById('products-end-date').value;
        if (startDate && endDate) {
            document.getElementById('products-start-input').value = startDate;
            document.getElementById('products-end-input').value = endDate;
            document.getElementById('products-form').submit();
        } else {
            alert('Vui lòng chọn cả ngày bắt đầu và ngày kết thúc');
        }
    }

    // Orders section functions
    function setOrdersPeriod(period) {
        document.getElementById('orders-period-input').value = period;
        document.getElementById('orders-form').submit();
    }

    function applyOrdersCustom() {
        const startDate = document.getElementById('orders-start-date').value;
        const endDate = document.getElementById('orders-end-date').value;
        if (startDate && endDate) {
            document.getElementById('orders-start-input').value = startDate;
            document.getElementById('orders-end-input').value = endDate;
            document.getElementById('orders-form').submit();
        } else {
            alert('Vui lòng chọn cả ngày bắt đầu và ngày kết thúc');
        }
    }
</script>
<script>
    // Dữ liệu cho biểu đồ doanh thu
    const revenueLabels = @json($revenueChartLabels ?? []);
    const revenueData = @json($revenueChartValues ?? []);

    // Biểu đồ cột doanh thu
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Doanh thu hàng ngày (₫)',
                data: revenueData,
                backgroundColor: 'rgba(251, 191, 36, 0.8)',
                borderColor: 'rgba(251, 191, 36, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Doanh Thu Hàng Ngày'
                },
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Doanh thu (₫)'
                    },
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN').format(value) + ' ₫';
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Doanh thu'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Doanh thu: ' + new Intl.NumberFormat('vi-VN').format(context.parsed.y) + ' ₫';
                        }
                    }
                }
            }
        }
    });

    // Dữ liệu cho biểu đồ Top Users
    const topUsersLabels = @json($topUsersChartLabels ?? []);
    const topUsersData = @json($topUsersChartData ?? []);

    // Dữ liệu cho biểu đồ Top Products
    const topProductsLabels = @json($topProductsChartLabels ?? []);
    const topProductsData = @json($topProductsChartData ?? []);

    // Dữ liệu cho biểu đồ Latest Orders
    const latestOrdersLabels = @json($latestOrdersChartLabels ?? []);
    const latestOrdersData = @json($latestOrdersChartData ?? []);
    const latestOrdersDetail = @json($latestOrdersJson ?? []);

    window.showOrderDetail = function(code) {
        const order = latestOrdersDetail.find(o => String(o.code) === String(code));
        console.log('showOrderDetail lookup result', order);
        if (!order) { alert('Không tìm thấy chi tiết đơn hàng'); return; }
        const modal = document.getElementById('orderDetailModal');
        const content = document.getElementById('orderDetailContent');
        let html = `<h3 class=\"text-lg font-semibold mb-4\">Chi tiết đơn ${code}</h3>`;
        html += `<p><strong>Khách hàng:</strong> ${order.customer}</p>`;
        html += `<p><strong>Tổng tiền:</strong> ${new Intl.NumberFormat('vi-VN').format(order.total)} ₫</p>`;
        html += `<p><strong>Trạng thái:</strong> ${order.status}</p>`;
        html += `<p><strong>Ngày tạo:</strong> ${order.created_at}</p>`;
        html += '<h4 class=\"font-semibold mt-4 mb-2\">Sản phẩm</h4>';
        html += '<ul class=\"list-disc pl-5 space-y-1\">';
        order.items.forEach(item => {
            const price = new Intl.NumberFormat('vi-VN').format(item.price);
            html += `<li>${item.product} - ${item.variant} (x${item.quantity}) - ${price} ₫</li>`;
        });
        html += '</ul>';
        content.innerHTML = html;
        if (!document.body.contains(modal)) document.body.appendChild(modal);
        modal.style.zIndex = '9999';
        modal.classList.remove('pointer-events-none');
        modal.style.opacity = '1';
        modal.style.visibility = 'visible';
        modal.style.opacity = '1';
        modal.style.display = 'flex';
    }
    // Delegated click listener for order code links
    document.addEventListener('click', function(e) {
        const target = e.target.closest('.order-code-link');
        if (target) {
            console.log('Clicked order code link', target.dataset.code);
            const code = target.dataset.code;
            showOrderDetail(code);
        }
    });

    window.closeOrderModal = function() {
        const modal = document.getElementById('orderDetailModal');
        modal.classList.add('pointer-events-none');
        modal.style.opacity = '0';
        modal.style.visibility = 'hidden';
        modal.style.opacity = '0';
        modal.style.display = 'none';
    }

    
    // Biểu đồ cột Top Users
    const topUsersCtx = document.getElementById('topUsersChart').getContext('2d');
    new Chart(topUsersCtx, {
        type: 'bar',
        data: {
            labels: topUsersLabels,
            datasets: [{
                label: 'Tổng chi tiêu (₫)',
                data: topUsersData,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 205, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Top 5 Khách Hàng Mua Nhiều Nhất'
                },
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Tổng chi tiêu (₫)'
                    },
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN').format(value) + ' ₫';
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Khách hàng'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Tổng chi tiêu: ' + new Intl.NumberFormat('vi-VN').format(context.parsed.y) + ' ₫';
                        }
                    }
                }
            }
        }
    });

    // Biểu đồ cột Top Products
    const topProductsCtx = document.getElementById('topProductsChart').getContext('2d');
    new Chart(topProductsCtx, {
        type: 'bar',
        data: {
            labels: topProductsLabels,
            datasets: [{
                label: 'Số lượng bán',
                data: topProductsData,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 205, 86, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(153, 102, 255, 0.8)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Top 5 Sản Phẩm Bán Chạy Nhất'
                },
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Số lượng bán'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Sản phẩm'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Đã bán: ' + context.parsed.y + ' sản phẩm';
                        }
                    }
                }
            }
        }
    });

    // Biểu đồ cột Latest Orders
    const latestOrdersCtx = document.getElementById('latestOrdersChart').getContext('2d');
    new Chart(latestOrdersCtx, {
        type: 'bar',
        data: {
            labels: latestOrdersLabels,
            datasets: [{
                label: 'Giá trị đơn hàng (₫)',
                data: latestOrdersData,
                backgroundColor: [
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 205, 86, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(75, 192, 192, 0.8)'
                ],
                borderColor: [
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Top 5 Đơn Hàng Mới Nhất'
                },
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Giá trị đơn hàng (₫)'
                    },
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN').format(value) + ' ₫';
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mã đơn hàng'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Giá trị: ' + new Intl.NumberFormat('vi-VN').format(context.parsed.y) + ' ₫';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection 