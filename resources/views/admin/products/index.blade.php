@extends('admin.pages.body')
@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

                {{-- Header --}}
                <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex items-center justify-between">
                    <h6 class="dark:text-white text-lg font-semibold">Danh Mục Sản Phẩm</h6>
                    <p class="text-gray-600">Quản lý và theo dõi tất cả sản phẩm điện tử</p>
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
                    Nhãn hiệu: {{ $product->brand->name ?? '' }} | Xuất xứ: {{ $product->origin->name ?? '' }} | Danh mục: {{ $product->category->name ?? '' }}
                </div>
            </div>
            <div class="col-span-1">
                {{ $product->category->name ?? '' }}
            </div>
            <div class="col-span-1">
                {{ number_format($product->base_price, 0, ',', '.') }} ₫
            </div>
            <div class="col-span-1">
                {{ $product->variants->count() }}
            </div>
            <div class="col-span-1">
                {{ $product->stock_quantity ?? 0 }}
            </div>
            <div class="col-span-1">
                {{ $product->status == 1 ? 'Đang bán' : 'Ngừng bán' }}
            </div>
            <div class="col-span-2">
                <div class="flex space-x-2">
                    <a href="{{ route('products.edit', $product->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Sửa</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')">Xóa</button>
                    </form>
                </div>
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
                            <td>{{ number_format($variant->price, 0, ',', '.') }} ₫</td>
                            <td>{{ $variant->quantity }}</td>
                            <td>{{ $variant->status == 1 ? 'Đang bán' : 'Ngừng bán' }}</td>
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