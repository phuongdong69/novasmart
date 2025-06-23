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
    @foreach($products as $product)
        <div class="grid grid-cols-12 gap-4 p-4 border-b hover:bg-gray-50 group">
            <div class="col-span-1">
                <input type="checkbox" class="rounded border-gray-300">
            </div>
            <div class="col-span-4 font-semibold text-gray-900 cursor-pointer" onclick="toggleVariants({{ $product->id }})">
                {{ $product->name }}
                <div class="text-xs text-gray-500">
                    Nhãn hiệu: {{ $product->brand->name ?? '' }} | Xuất xứ: {{ $product->origin->name ?? '' }}
                </div>
            </div>
            <div class="col-span-1">{{ $product->category->name ?? '' }}</div>
            <div class="col-span-1">
                {{ number_format($product->variants->first()->price ?? 0) }}₫
            </div>
            <div class="col-span-1">
                {{ $product->variants->count() }}
            </div>
            <div class="col-span-1">
                {{ $product->variants->sum('quantity') }}
            </div>
            <div class="col-span-1">
                {{ $product->variants->first()->status ?? 'N/A' }}
            </div>
            <div class="col-span-2">
                <a href="#" class="text-blue-600 hover:underline">Sửa</a> |
                <a href="#" class="text-red-600 hover:underline">Xóa</a>
            </div>
        </div>
        <!-- Biến thể (ẩn/hiện khi click) -->
        <div id="variants-{{ $product->id }}" class="hidden bg-gray-50 px-8 py-2">
            <table class="w-full text-sm mb-2">
                <thead>
                    <tr class="text-gray-700">
                        <th class="text-left">SKU</th>
                        <th class="text-left">Giá</th>
                        <th class="text-left">Số lượng</th>
                        <th class="text-left">Trạng thái</th>
                        <th class="text-left">Thuộc tính</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product->variants as $variant)
                        <tr>
                            <td>{{ $variant->sku }}</td>
                            <td>{{ number_format($variant->price) }}₫</td>
                            <td>{{ $variant->quantity }}</td>
                            <td>{{ $variant->status }}</td>
                            <td>
                                @foreach($variant->variantAttributeValues as $attrValue)
                                    <span class="inline-block bg-gray-200 rounded px-2 py-1 mr-1 mb-1">
                                        {{ $attrValue->attribute->name ?? '' }}: {{ $attrValue->value ?? '' }}
                                    </span>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>

<script>
function toggleVariants(productId) {
    const el = document.getElementById('variants-' + productId);
    if (el.classList.contains('hidden')) {
        el.classList.remove('hidden');
    } else {
        el.classList.add('hidden');
    }
}
</script>
    </div>
</div>

<link href="{{ asset('assets/admin/js/adminproduct.js') }}" rel="stylesheet" />