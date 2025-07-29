@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
    <form method="GET" class="mb-8 flex flex-wrap gap-4 items-end">
        <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700">Từ ngày</label>
            <input type="date" id="start_date" name="start_date" value="{{ request('start_date', \Carbon\Carbon::yesterday()->format('Y-m-d')) }}" class="border rounded px-3 py-2">
        </div>
        <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700">Đến ngày</label>
            <input type="date" id="end_date" name="end_date" value="{{ request('end_date', \Carbon\Carbon::today()->format('Y-m-d')) }}" class="border rounded px-3 py-2">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded font-semibold">Tìm</button>
    </form>
    <div class="w-full rounded-2xl mb-10 p-10 shadow-xl" style="background: linear-gradient(90deg, #4f8cff 0%, #38cfff 100%); color: #fff;">
        <h1 class="text-xl font-extrabold mb-2 text-white ml-2 text-left">Tổng quan hiệu suất kinh doanh</h1>
        <div class="flex flex-row flex-nowrap gap-16 items-center justify-start overflow-x-auto">
            <div class="rounded-2xl p-4 flex flex-col items-center shadow-lg bg-white/20 min-w-[180px]">
                <div class="w-12 h-12 flex items-center justify-center rounded-full mb-2" style="background: linear-gradient(135deg, #5a8dee 60%, #46c6ef 100%);">
                    <i class="fas fa-users text-xl text-white"></i>
                </div>
                <div class="text-2xl font-bold mb-1 text-white drop-shadow">{{ $newCustomers }}</div>
                <div class="text-xs text-blue-100">Khách hàng mới</div>
            </div>
            <div class="rounded-2xl p-4 flex flex-col items-center shadow-lg bg-white/20 min-w-[180px]">
                <div class="w-12 h-12 flex items-center justify-center rounded-full mb-2" style="background: linear-gradient(135deg, #38cfff 60%, #5a8dee 100%);">
                    <i class="fas fa-shopping-cart text-xl text-white"></i>
                </div>
                <div class="text-2xl font-bold mb-1 text-white drop-shadow">{{ $totalOrders }}</div>
                <div class="text-xs text-blue-100">Tổng đơn hàng</div>
            </div>
            <div class="rounded-2xl p-4 flex flex-col items-center shadow-lg bg-white/20 min-w-[180px]">
                <div class="w-12 h-12 flex items-center justify-center rounded-full mb-2" style="background: linear-gradient(135deg, #46c6ef 60%, #5a8dee 100%);">
                    <i class="fas fa-coins text-xl text-white"></i>
                </div>
                <div class="text-2xl font-bold mb-1 text-white drop-shadow">{{ number_format($revenue, 0, ',', '.') }} ₫</div>
                <div class="text-xs text-blue-100">Tổng doanh thu</div>
            </div>
        </div>
    </div>
        <!-- Biểu đồ -->
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-4">Thống kê trực quan</h2>
            <!-- Hàng 1 -->
            <div class="flex flex-wrap gap-x-8 mb-4">
                <div class="bg-white border rounded-xl p-4 shadow-sm flex flex-col w-full md:w-1/2">
                    <div class="w-full text-base font-semibold text-blue-700 mb-2 text-left">Top user</div>
                    <div class="flex flex-row items-center flex-1">
                        <div class="flex flex-col items-start flex-1 mr-4">
                            @foreach($topUserLabels as $i => $label)
                                <div class="flex items-center mb-1">
                                    <span class="inline-block w-4 h-4 rounded-full mr-2" style="background: {{ ['#2563eb', '#10b981', '#f59e42', '#f43f5e', '#6366f1'][$i % 5] }};"></span>
                                    <span class="text-sm text-gray-700">{{ $label }}: <span class="font-semibold">{{ number_format($topUserValues[$i] ?? 0, 0, ',', '.') }} ₫</span></span>
                                </div>
                            @endforeach
                        </div>
                        <canvas id="topUserPie" height="80" style="max-width: 250px; margin-right: 10%;"></canvas>
                    </div>
                </div>
                <div class="bg-white border rounded-xl p-4 shadow-sm flex flex-col w-full md:w-1/2">
                    <div class="w-full text-base font-semibold text-blue-700 mb-2 text-left">Top sản phẩm</div>
                    <div class="flex flex-row items-center flex-1">
                        <div class="flex flex-col items-start flex-1 mr-4">
                            @foreach($topProductLabels as $i => $label)
                                <div class="flex items-center mb-1">
                                    <span class="inline-block w-4 h-4 rounded-full mr-2" style="background: {{ ['#f59e42', '#2563eb', '#10b981', '#f43f5e', '#6366f1'][$i % 5] }};"></span>
                                    <span class="text-sm text-gray-700">{{ $label }}: <span class="font-semibold">{{ $topProductValues[$i] ?? 0 }}</span></span>
                                </div>
                            @endforeach
                        </div>
                        <canvas id="topProductPie" height="80" style="max-width: 250px; margin-right: 10%;"></canvas>
                    </div>
                </div>
            </div>
            <!-- Hàng 2 -->
            <div class="flex flex-wrap gap-x-8 mb-4">
                <div class="bg-white border rounded-xl p-4 shadow-sm flex flex-col w-full md:w-1/2">
                    <div class="w-full text-base font-semibold text-blue-700 mb-2 text-left">Trạng thái đơn hàng</div>
                    <div class="flex flex-row items-center flex-1">
                        <div class="flex flex-col items-start flex-1 mr-4">
                            @foreach($orderStatusLabels as $i => $label)
                                <div class="flex items-center mb-1">
                                    <span class="inline-block w-4 h-4 rounded-full mr-2" style="background: {{ ['#2563eb', '#10b981', '#f59e42', '#f43f5e', '#6366f1', '#a3e635', '#fbbf24'][$i % 7] }};"></span>
                                    <span class="text-sm text-gray-700">{{ $label }}: <span class="font-semibold">{{ $orderStatusValues[$i] ?? 0 }}</span></span>
                                </div>
                            @endforeach
                        </div>
                        <canvas id="orderStatusPie" height="80" style="max-width: 250px; margin-right: 10%;"></canvas>
                    </div>
                </div>
                <div class="bg-white border rounded-xl p-4 shadow-sm flex flex-col w-full md:w-1/2">
                    <div class="w-full text-base font-semibold text-blue-700 mb-2 text-left">Doanh thu theo ngày</div>
                    <div class="flex flex-row items-center flex-1">
                        <div class="flex flex-col items-start flex-1 mr-4">
                            @foreach($dateLabels as $i => $label)
                                @if($i < 5)
                                <div class="flex items-center mb-1">
                                    <span class="inline-block w-4 h-4 rounded-full mr-2" style="background: #2563eb;"></span>
                                    <span class="text-sm text-gray-700">{{ $label }}: <span class="font-semibold">{{ number_format($revenueByDay[$i] ?? 0, 0, ',', '.') }} ₫</span></span>
                                </div>
                                @endif
                            @endforeach
                            @if(count($dateLabels) > 5)
                                <div class="text-xs text-gray-400 mt-1">...</div>
                            @endif
                        </div>
                        <canvas id="revenueChart" height="120" style="max-width: 400px; margin-right: 10%;"></canvas>
                    </div>
                </div>
            </div>
            <!-- Hàng 3 -->
            <div class="flex flex-wrap gap-x-8 mt-4">
                <div class="bg-white border rounded-xl p-4 shadow-sm flex flex-col w-full md:w-1/2">
                    <div class="w-full text-base font-semibold text-blue-700 mb-2 text-left">Số lượng đơn hàng theo ngày</div>
                    <div class="flex flex-row items-center flex-1">
                        <div class="flex flex-col items-start flex-1 mr-4">
                            @foreach($dateLabels as $i => $label)
                                @if($i < 5)
                                <div class="flex items-center mb-1">
                                    <span class="inline-block w-4 h-4 rounded-full mr-2" style="background: #10b981;"></span>
                                    <span class="text-sm text-gray-700">{{ $label }}: <span class="font-semibold">{{ $orderCountByDay[$i] ?? 0 }}</span></span>
                                </div>
                                @endif
                            @endforeach
                            @if(count($dateLabels) > 5)
                                <div class="text-xs text-gray-400 mt-1">...</div>
                            @endif
                        </div>
                        <canvas id="orderCountChart" height="120" style="max-width: 400px; margin-right: 10%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h2 class="text-xl font-bold mb-4">Bảng thống kê chi tiết</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full">
        <div class="bg-white shadow rounded-lg p-6 flex flex-col items-center justify-center">
            <div class="text-lg font-semibold mb-2">Tổng doanh thu</div>
            <div class="text-3xl font-bold text-green-600">{{ number_format($revenue, 0, ',', '.') }} ₫</div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Top User Mua Nhiều Nhất</h2>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tên</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tổng chi tiêu</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($topUsers as $user)
                        <tr>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ number_format($user->total_spent, 0, ',', '.') }} ₫</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center py-2">Không có dữ liệu</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Top Sản Phẩm Bán Chạy</h2>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tên sản phẩm</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Số lượng bán</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($topProducts as $product)
                        <tr>
                            <td class="px-4 py-2">{{ $product->name }}</td>
                            <td class="px-4 py-2">{{ $product->sold_quantity ?? 0 }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center py-2">Không có dữ liệu</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Top Order Mới Nhất</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mã đơn</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Khách hàng</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tổng tiền</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ngày tạo</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($latestOrders as $order)
                    <tr>
                        <td class="px-4 py-2">{{ $order->order_code }}</td>
                        <td class="px-4 py-2">{{ $order->user->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ number_format($order->total_price, 0, ',', '.') }} ₫</td>
                        <td class="px-4 py-2">{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-2">Không có dữ liệu</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@push('scripts')
<script src="{{ asset('assets/admin/js/plugins/chartjs.min.js') }}"></script>
<script>
    // Pie top user
    const topUserPie = new Chart(document.getElementById('topUserPie').getContext('2d'), {
        type: 'pie',
        data: {
            labels: @json($topUserLabels),
            datasets: [{
                data: @json($topUserValues),
                backgroundColor: ['#2563eb', '#10b981', '#f59e42', '#f43f5e', '#6366f1']
            }]
        },
        options: {responsive: true, plugins: {legend: {display: false}}}
    });
    // Pie top sản phẩm
    const topProductPie = new Chart(document.getElementById('topProductPie').getContext('2d'), {
        type: 'pie',
        data: {
            labels: @json($topProductLabels),
            datasets: [{
                data: @json($topProductValues),
                backgroundColor: ['#f59e42', '#2563eb', '#10b981', '#f43f5e', '#6366f1']
            }]
        },
        options: {responsive: true, plugins: {legend: {display: false}}}
    });
    // Pie trạng thái đơn hàng
    const orderStatusPie = new Chart(document.getElementById('orderStatusPie').getContext('2d'), {
        type: 'pie',
        data: {
            labels: @json($orderStatusLabels),
            datasets: [{
                data: @json($orderStatusValues),
                backgroundColor: ['#2563eb', '#10b981', '#f59e42', '#f43f5e', '#6366f1', '#a3e635', '#fbbf24']
            }]
        },
        options: {responsive: true, plugins: {legend: {display: false}}}
    });
    // Bar doanh thu
    const revenueChart = new Chart(document.getElementById('revenueChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: @json($dateLabels),
            datasets: [{
                label: 'Doanh thu (₫)',
                data: @json($revenueByDay),
                backgroundColor: '#2563eb'
            }]
        },
        options: {responsive: true, plugins: {legend: {display: false}}}
    });
    // Bar số lượng đơn hàng
    const orderCountChart = new Chart(document.getElementById('orderCountChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: @json($dateLabels),
            datasets: [{
                label: 'Số đơn hàng',
                data: @json($orderCountByDay),
                backgroundColor: '#10b981'
            }]
        },
        options: {responsive: true, plugins: {legend: {display: false}}}
    });
</script>
@endpush
@endsection 