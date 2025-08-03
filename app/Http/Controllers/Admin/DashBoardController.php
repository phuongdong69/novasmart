<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashBoardController extends Controller
{
    private function getDateRange($period, $customStart = null, $customEnd = null)
    {
        if ($period === 'custom' && $customStart && $customEnd) {
            return [
                Carbon::parse($customStart)->startOfDay(),
                Carbon::parse($customEnd)->endOfDay()
            ];
        }

        $now = Carbon::now();
        
        switch ($period) {
            case 'today':
                return [
                    $now->copy()->startOfDay(),
                    $now->copy()->endOfDay()
                ];
            case 'yesterday':
                return [
                    $now->copy()->subDay()->startOfDay(),
                    $now->copy()->subDay()->endOfDay()
                ];
            case 'week':
                return [
                    $now->copy()->startOfWeek(),
                    $now->copy()->endOfWeek()
                ];
            case 'last_week':
                return [
                    $now->copy()->subWeek()->startOfWeek(),
                    $now->copy()->subWeek()->endOfWeek()
                ];
            case 'month':
                return [
                    $now->copy()->startOfMonth(),
                    $now->copy()->endOfMonth()
                ];
            case 'last_month':
                return [
                    $now->copy()->subMonth()->startOfMonth(),
                    $now->copy()->subMonth()->endOfMonth()
                ];
            case 'quarter':
                return [
                    $now->copy()->startOfQuarter(),
                    $now->copy()->endOfQuarter()
                ];
            case 'year':
                return [
                    $now->copy()->startOfYear(),
                    $now->copy()->endOfYear()
                ];
            default: // mặc định là tuần này
                return [
                    $now->copy()->startOfWeek(),
                    $now->copy()->endOfWeek()
                ];
        }
    }

    public function index(Request $request) {
        // Lấy bộ lọc cho từng section
        $revenuePeriod = $request->input('revenue_period', 'week');
        $revenueStart = $request->input('revenue_start_date');
        $revenueEnd = $request->input('revenue_end_date');
        
        $usersPeriod = $request->input('users_period', 'week');
        $usersStart = $request->input('users_start_date');
        $usersEnd = $request->input('users_end_date');
        
        $productsPeriod = $request->input('products_period', 'week');
        $productsStart = $request->input('products_start_date');
        $productsEnd = $request->input('products_end_date');
        
        $ordersPeriod = $request->input('orders_period', 'week');
        $ordersStart = $request->input('orders_start_date');
        $ordersEnd = $request->input('orders_end_date');

        // Tính toán khoảng thời gian cho từng section
        list($revenueStartDate, $revenueEndDate) = $this->getDateRange($revenuePeriod, $revenueStart, $revenueEnd);
        list($usersStartDate, $usersEndDate) = $this->getDateRange($usersPeriod, $usersStart, $usersEnd);
        list($productsStartDate, $productsEndDate) = $this->getDateRange($productsPeriod, $productsStart, $productsEnd);
        list($ordersStartDate, $ordersEndDate) = $this->getDateRange($ordersPeriod, $ordersStart, $ordersEnd);

        // Tổng doanh thu (theo revenue filter)
        $revenue = Order::join('statuses', 'orders.status_id', '=', 'statuses.id')
            ->whereBetween('orders.created_at', [$revenueStartDate, $revenueEndDate])
            ->whereIn('statuses.code', ['confirmed', 'delivered', 'completed'])
            ->sum('orders.total_price');

        // Top user mua nhiều nhất (theo users filter)
        $topUsers = User::select('users.*', DB::raw('SUM(orders.total_price) as total_spent'))
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->join('statuses', 'orders.status_id', '=', 'statuses.id')
            ->whereBetween('orders.created_at', [$usersStartDate, $usersEndDate])
            ->whereIn('statuses.code', ['confirmed', 'delivered', 'completed'])
            ->groupBy('users.id', 'users.status_id', 'users.role_id', 'users.name', 'users.email', 'users.password', 'users.phoneNumber', 'users.address', 'users.created_at', 'users.updated_at', 'users.remember_token')
            ->orderByDesc('total_spent')
            ->take(5)
            ->get();

        // Top sản phẩm bán chạy nhất (theo products filter)
        $topProducts = Product::select('products.*', 
                DB::raw('SUM(order_details.quantity) as sold_quantity'),
                DB::raw('SUM(order_details.quantity * order_details.price) as total_revenue'))
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->join('order_details', 'product_variants.id', '=', 'order_details.product_variant_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('statuses', 'orders.status_id', '=', 'statuses.id')
            ->whereBetween('orders.created_at', [$productsStartDate, $productsEndDate])
            ->whereIn('statuses.code', ['confirmed', 'delivered', 'completed'])
            ->groupBy(
                'products.id', 'products.brand_id', 'products.origin_id', 'products.category_id',
                'products.status_id', 'products.name', 'products.description', 'products.created_at', 'products.updated_at'
            )
            ->orderByDesc('sold_quantity')
            ->take(5)
            ->get();

        // Top order mới nhất (theo orders filter)
        $latestOrders = Order::with(['user', 'orderStatus'])
            ->whereBetween('orders.created_at', [$ordersStartDate, $ordersEndDate])
            ->orderByDesc('orders.created_at')
            ->take(5)
            ->get();

        // Tổng số khách hàng mới trong khoảng ngày (theo revenue filter)
        $newCustomers = User::whereBetween('created_at', [$revenueStartDate, $revenueEndDate])->count();
        
        // Tổng số đơn hàng trong khoảng ngày (theo revenue filter)
        $totalOrders = Order::whereBetween('created_at', [$revenueStartDate, $revenueEndDate])->count();

        // Chuẩn bị dữ liệu cho biểu đồ cột Top Users
        $topUsersChartLabels = $topUsers->pluck('name')->toArray();
        $topUsersChartData = $topUsers->pluck('total_spent')->toArray();

        // Chuẩn bị dữ liệu cho biểu đồ cột Top Products
        $topProductsChartLabels = $topProducts->pluck('name')->toArray();
        $topProductsChartData = $topProducts->pluck('sold_quantity')->toArray();

        // Chuẩn bị dữ liệu cho biểu đồ cột Latest Orders
        $latestOrdersChartLabels = $latestOrders->pluck('order_code')->toArray();
        $latestOrdersChartData = $latestOrders->pluck('total_price')->toArray();

        // Chuẩn bị dữ liệu cho biểu đồ doanh thu theo ngày
        $revenueChartData = Order::join('statuses', 'orders.status_id', '=', 'statuses.id')
            ->whereBetween('orders.created_at', [$revenueStartDate, $revenueEndDate])
            ->whereIn('statuses.code', ['confirmed', 'delivered', 'completed'])
            ->selectRaw('DATE(orders.created_at) as date, SUM(orders.total_price) as daily_revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        $revenueChartLabels = $revenueChartData->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d/m');
        })->toArray();
        $revenueChartValues = $revenueChartData->pluck('daily_revenue')->toArray();

        return view('admin.dashboard', compact(
            'revenue', 'topUsers', 'topProducts', 'latestOrders', 'newCustomers', 'totalOrders',
            'revenuePeriod', 'revenueStart', 'revenueEnd',
            'usersPeriod', 'usersStart', 'usersEnd',
            'productsPeriod', 'productsStart', 'productsEnd',
            'ordersPeriod', 'ordersStart', 'ordersEnd',
            'topUsersChartLabels', 'topUsersChartData',
            'topProductsChartLabels', 'topProductsChartData',
            'latestOrdersChartLabels', 'latestOrdersChartData',
            'revenueChartLabels', 'revenueChartValues'
        ))->with('title', 'Dashboard');
    }
}


