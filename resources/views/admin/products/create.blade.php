@extends('admin.layouts.app')
@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

                {{-- Header --}}
                <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex items-center justify-between">
                    <h6 class="dark:text-white text-lg font-semibold">Thêm sản phẩm mới</h6>
                    <a href="{{ route('admin.products.index') }}"
                        class="border border-slate-400 text-slate-700 hover:bg-slate-100 hover:text-slate-900 text-sm font-medium py-2 px-4 rounded transition-all duration-150">
                        ← Quay lại
                    </a>
                </div>

                {{-- Alerts --}}
                <div class="px-6 mt-4">
                    @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                    @endif
                </div>

                {{-- Form body --}}
                <form action="{{ route('admin.products.store') }}" method="POST" class="px-6 pt-4 pb-6">
                    @csrf

                    {{-- Tên sản phẩm --}}
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-slate-600 mb-2">Tên sản phẩm</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                            required
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nhãn hiệu --}}
                    <div class="mb-4">
                        <label for="brand_name" class="block text-sm font-medium text-slate-600 mb-2">Nhãn hiệu</label>
                        <input
                            type="text"
                            name="brand_name"
                            id="brand_name"
                            value="{{ old('brand_name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('brand_name') border-red-500 @enderror"
                            required
                        >
                        @error('brand_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Danh mục --}}
                    <div class="mb-4">
                        <label for="category_name" class="block text-sm font-medium text-slate-600 mb-2">Danh mục</label>
                        <input
                            type="text"
                            name="category_name"
                            id="category_name"
                            value="{{ old('category_name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category_name') border-red-500 @enderror"
                            required
                        >
                        @error('category_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Xuất xứ --}}
                    <div class="mb-4">
                        <label for="origin_name" class="block text-sm font-medium text-slate-600 mb-2">Xuất xứ</label>
                        <input
                            type="text"
                            name="origin_name"
                            id="origin_name"
                            value="{{ old('origin_name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('origin_name') border-red-500 @enderror"
                            required
                        >
                        @error('origin_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Giá cơ bản --}}
                    <div class="mb-4">
                        <label for="base_price" class="block text-sm font-medium text-slate-600 mb-2">Giá cơ bản</label>
                        <input
                            type="number"
                            name="base_price"
                            id="base_price"
                            value="{{ old('base_price') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('base_price') border-red-500 @enderror"
                            required
                        >
                        @error('base_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Biến thể --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-600 mb-2">Biến thể</label>
                        <div id="variants-container">
                            <div class="variant-item mb-4">
                                <div class="flex space-x-4">
                                    <div class="flex-1">
                                        <label for="variant_name_0" class="block text-sm font-medium text-slate-600 mb-2">Tên biến thể</label>
                                        <input
                                            type="text"
                                            name="variants[0][name]"
                                            id="variant_name_0"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('variants.0.name') border-red-500 @enderror"
                                        >
                                    </div>
                                    <div class="flex-1">
                                        <label for="variant_sku_0" class="block text-sm font-medium text-slate-600 mb-2">SKU</label>
                                        <input
                                            type="text"
                                            name="variants[0][sku]"
                                            id="variant_sku_0"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('variants.0.sku') border-red-500 @enderror"
                                        >
                                    </div>
                                    <div class="flex-1">
                                        <label for="variant_price_0" class="block text-sm font-medium text-slate-600 mb-2">Giá</label>
                                        <input
                                            type="number"
                                            name="variants[0][price]"
                                            id="variant_price_0"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('variants.0.price') border-red-500 @enderror"
                                        >
                                    </div>
                                    <div class="flex-1">
                                        <label for="variant_quantity_0" class="block text-sm font-medium text-slate-600 mb-2">Số lượng</label>
                                        <input
                                            type="number"
                                            name="variants[0][quantity]"
                                            id="variant_quantity_0"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('variants.0.quantity') border-red-500 @enderror"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="addVariant()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Thêm biến thể</button>
                    </div>

                    {{-- Trạng thái --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-600 mb-2">Trạng thái</label>
                        <select
                            name="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror"
                        >
                            <option value="1">Đang bán</option>
                            <option value="0">Ngừng bán</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="mt-6">
                        <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Lưu sản phẩm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let variantCount = 1;

function addVariant() {
    const container = document.getElementById('variants-container');
    const newVariant = document.createElement('div');
    newVariant.className = 'variant-item mb-4';
    newVariant.innerHTML = `
        <div class="flex space-x-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-slate-600 mb-2">Tên biến thể</label>
                <input
                    type="text"
                    name="variants[${variantCount}][name]"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-slate-600 mb-2">SKU</label>
                <input
                    type="text"
                    name="variants[${variantCount}][sku]"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-slate-600 mb-2">Giá</label>
                <input
                    type="number"
                    name="variants[${variantCount}][price]"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-slate-600 mb-2">Số lượng</label>
                <input
                    type="number"
                    name="variants[${variantCount}][quantity]"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
            </div>
        </div>
    `;
    container.appendChild(newVariant);
    variantCount++;
}
</script>
@endsection
