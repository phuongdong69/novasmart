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
    public function index(Request $request) {
        // Lấy ngày bắt đầu/kết thúc từ request hoặc mặc định là hôm qua đến hôm nay
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        if (!$start || !$end) {
            $start = \Carbon\Carbon::yesterday()->startOfDay()->toDateTimeString();
            $end = \Carbon\Carbon::today()->endOfDay()->toDateTimeString();
        } else {
            $start = \Carbon\Carbon::parse($start)->startOfDay()->toDateTimeString();
            $end = \Carbon\Carbon::parse($end)->endOfDay()->toDateTimeString();
        }

        // Tổng doanh thu
        $revenue = Order::join('statuses', 'orders.status_id', '=', 'statuses.id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->whereIn('statuses.code', ['confirmed', 'delivered', 'completed'])
            ->sum('orders.total_price');

        // Top user mua nhiều nhất
        $topUsers = User::select('users.*', DB::raw('SUM(orders.total_price) as total_spent'))
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->join('statuses', 'orders.status_id', '=', 'statuses.id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->whereIn('statuses.code', ['confirmed', 'delivered', 'completed'])
            ->groupBy('users.id', 'users.status_code', 'users.role_id', 'users.name', 'users.email', 'users.password', 'users.phoneNumber', 'users.address', 'users.created_at', 'users.updated_at')
            ->orderByDesc('total_spent')
            ->take(5)
            ->get();

        // Top sản phẩm bán chạy nhất
        $topProducts = Product::select('products.*', DB::raw('SUM(order_details.quantity) as sold_quantity'))
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->join('order_details', 'product_variants.id', '=', 'order_details.product_variant_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('statuses', 'orders.status_id', '=', 'statuses.id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->whereIn('statuses.code', ['confirmed', 'delivered', 'completed'])
            ->groupBy(
                'products.id', 'products.brand_id', 'products.origin_id', 'products.category_id',
                'products.status_id', 'products.name', 'products.description', 'products.created_at', 'products.updated_at'
            )
            ->orderByDesc('sold_quantity')
            ->take(5)
            ->get();

        // Top order mới nhất
        $latestOrders = Order::with('user')
            ->join('statuses', 'orders.status_id', '=', 'statuses.id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->whereIn('statuses.code', ['confirmed', 'delivered', 'completed'])
            ->orderByDesc('orders.created_at')
            ->select('orders.*')
            ->take(5)
            ->get();

        // Biểu đồ doanh thu theo ngày và số đơn theo ngày (7 ngày gần nhất hoặc theo filter)
        $period = \Carbon\CarbonPeriod::create(
            \Carbon\Carbon::parse($start)->startOfDay(),
            '1 day',
            \Carbon\Carbon::parse($end)->endOfDay()
        );
        $dateLabels = [];
        $revenueByDay = [];
        $orderCountByDay = [];
        foreach ($period as $date) {
            $label = $date->format('d/m');
            $dateLabels[] = $label;
            $from = $date->copy()->startOfDay();
            $to = $date->copy()->endOfDay();
            $revenueByDay[] = Order::join('statuses', 'orders.status_id', '=', 'statuses.id')
                ->whereBetween('orders.created_at', [$from, $to])
                ->whereIn('statuses.code', ['confirmed', 'delivered', 'completed'])
                ->sum('orders.total_price');
            $orderCountByDay[] = Order::join('statuses', 'orders.status_id', '=', 'statuses.id')
                ->whereBetween('orders.created_at', [$from, $to])
                ->whereIn('statuses.code', ['confirmed', 'delivered', 'completed'])
                ->count();
        }

        // Biểu đồ tròn tỉ lệ top user
        $topUserLabels = $topUsers->pluck('name');
        $topUserValues = $topUsers->pluck('total_spent');

        // Biểu đồ tròn tỉ lệ top sản phẩm
        $topProductLabels = $topProducts->pluck('name');
        $topProductValues = $topProducts->pluck('sold_quantity');

        // Biểu đồ tròn tỉ lệ trạng thái đơn hàng
        $statusCounts = Order::join('statuses', 'orders.status_id', '=', 'statuses.id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->select('statuses.name', DB::raw('COUNT(*) as count'))
            ->groupBy('statuses.name')
            ->get();
        $orderStatusLabels = $statusCounts->pluck('name');
        $orderStatusValues = $statusCounts->pluck('count');

        // Tổng số khách hàng mới trong khoảng ngày
        $newCustomers = \App\Models\User::whereBetween('created_at', [$start, $end])->count();
        // Tổng số đơn hàng trong khoảng ngày
        $totalOrders = \App\Models\Order::whereBetween('created_at', [$start, $end])->count();
        // Lợi nhuận (placeholder, nếu chưa có trường thì để 0)
        $profit = 0;

        return view('admin.dashboard', compact(
            'revenue', 'topUsers', 'topProducts', 'latestOrders', 'start', 'end',
            'dateLabels', 'revenueByDay', 'orderCountByDay',
            'topUserLabels', 'topUserValues',
            'topProductLabels', 'topProductValues',
            'orderStatusLabels', 'orderStatusValues',
            'newCustomers', 'totalOrders', 'profit'
        ))->with('title', 'Dashboard');
    }
}


