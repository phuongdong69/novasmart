@extends('admin.layouts.app')
@section('title')
Thêm biến thể sản phẩm
@endsection
@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex justify-between items-center">
                    <h6 class="dark:text-white text-lg font-semibold">Thêm biến thể sản phẩm</h6>
                    <a href="{{ route('admin.product_variants.index') }}" class="text-blue-500 hover:underline">← Quay lại danh sách</a>
                </div>
                <div class="flex-auto px-0 pt-4 pb-2">
                    <form action="{{ route('admin.product_variants.store') }}" method="POST" class="max-w-xl mx-auto">
                        @csrf
                        <div class="mb-4">
                            <label for="product_id" class="block text-gray-700 font-bold mb-2">Sản phẩm <span class="text-red-500">*</span></label>
                            <select name="product_id" id="product_id" class="border border-slate-300 rounded px-3 py-2 w-full text-sm focus:outline-none focus:ring focus:border-blue-300" required>
                                <option value="">-- Chọn sản phẩm --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="status_id" class="block text-gray-700 font-bold mb-2">Trạng thái</label>
                            <select name="status_id" id="status_id" class="border border-slate-300 rounded px-3 py-2 w-full text-sm focus:outline-none focus:ring focus:border-blue-300">
                                <option value="">-- Chọn trạng thái --</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                @endforeach
                            </select>
                            @error('status_id')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="sku" class="block text-gray-700 font-bold mb-2">SKU <span class="text-red-500">*</span></label>
                            <input type="text" name="sku" id="sku" class="border border-slate-300 rounded px-3 py-2 w-full text-sm focus:outline-none focus:ring focus:border-blue-300" value="{{ old('sku') }}" required>
                            @error('sku')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="price" class="block text-gray-700 font-bold mb-2">Giá <span class="text-red-500">*</span></label>
                            <input type="number" name="price" id="price" class="border border-slate-300 rounded px-3 py-2 w-full text-sm focus:outline-none focus:ring focus:border-blue-300" value="{{ old('price') }}" step="0.01" required>
                            @error('price')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="quantity" class="block text-gray-700 font-bold mb-2">Số lượng <span class="text-red-500">*</span></label>
                            <input type="number" name="quantity" id="quantity" class="border border-slate-300 rounded px-3 py-2 w-full text-sm focus:outline-none focus:ring focus:border-blue-300" value="{{ old('quantity') }}" required>
                            @error('quantity')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Lưu
                            </button>
                            <a href="{{ route('admin.product_variants.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
