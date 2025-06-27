@extends('admin.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Bảng Sản phẩm -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Danh sách Sản phẩm</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tên</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Brand</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Origin</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Số lượng</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-2">1</td>
                            <td class="px-4 py-2">Áo thun nam</td>
                            <td class="px-4 py-2">Nike</td>
                            <td class="px-4 py-2">Việt Nam</td>
                            <td class="px-4 py-2">Thời trang</td>
                            <td class="px-4 py-2">100</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2">2</td>
                            <td class="px-4 py-2">Giày thể thao</td>
                            <td class="px-4 py-2">Adidas</td>
                            <td class="px-4 py-2">Mỹ</td>
                            <td class="px-4 py-2">Giày dép</td>
                            <td class="px-4 py-2">50</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Bảng Biến thể sản phẩm -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Biến thể sản phẩm</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Product ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Giá</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Số lượng</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-2">1</td>
                            <td class="px-4 py-2">1</td>
                            <td class="px-4 py-2">TSHIRT-BLACK-M</td>
                            <td class="px-4 py-2">250,000 VNĐ</td>
                            <td class="px-4 py-2"><span class="inline-block px-2 py-1 rounded bg-green-100 text-green-700">Còn hàng</span></td>
                            <td class="px-4 py-2">60</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2">2</td>
                            <td class="px-4 py-2">1</td>
                            <td class="px-4 py-2">TSHIRT-WHITE-L</td>
                            <td class="px-4 py-2">250,000 VNĐ</td>
                            <td class="px-4 py-2"><span class="inline-block px-2 py-1 rounded bg-gray-100 text-gray-700">Hết hàng</span></td>
                            <td class="px-4 py-2">0</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2">3</td>
                            <td class="px-4 py-2">2</td>
                            <td class="px-4 py-2">SHOES-ADIDAS-42</td>
                            <td class="px-4 py-2">1,200,000 VNĐ</td>
                            <td class="px-4 py-2"><span class="inline-block px-2 py-1 rounded bg-green-100 text-green-700">Còn hàng</span></td>
                            <td class="px-4 py-2">30</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 