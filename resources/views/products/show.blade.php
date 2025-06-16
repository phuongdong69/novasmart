    <div class="container mx-auto my-8 px-4">
        <!-- Main Product Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg">
                <h4 class="text-lg font-semibold mb-0"></h4>
            </div>
            <div class="p-6">
                <p class="mb-3"><strong class="font-semibold">Mô tả:</strong> </p>
                <p><strong class="font-semibold">Số lượng tổng:</strong> </p>
            </div>
        </div>

        <!-- Product Variants Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
            <div class="bg-gray-600 text-white px-6 py-3 rounded-t-lg">
                <h5 class="text-base font-medium mb-0">Biến thể sản phẩm</h5>
            </div>
            <div class="p-0">
                <!-- If variants exist (change the condition as needed) -->
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">SKU</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Giá</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Trạng thái</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Số lượng</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Table rows would go here -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-200">SKU-001</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-200">100,000 VND</td>
                                <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Còn hàng
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">50</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- If no variants (uncomment this section when needed) -->
                <!-- 
                <div class="p-6">
                    <p class="text-gray-500">Không có biến thể nào cho sản phẩm này.</p>
                </div>
                -->
            </div>
        </div>
    </div>