@extends('admin.layouts.app')
@section('title')
Sửa biến thể sản phẩm
@endsection
@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex justify-between items-center">
                    <h6 class="dark:text-white text-lg font-semibold">Sửa biến thể sản phẩm</h6>
                    <a href="{{ route('admin.product_variants.index') }}" class="text-blue-500 hover:underline">← Quay lại danh sách</a>
                </div>
                <div class="flex-auto px-0 pt-4 pb-2">
                    <form action="{{ route('admin.product_variants.update', $productVariant->id) }}" method="POST" class="max-w-xl mx-auto">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-bold mb-2">Tên biến thể <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" class="border border-slate-300 rounded px-3 py-2 w-full text-sm focus:outline-none focus:ring focus:border-blue-300" value="{{ old('name', $productVariant->name) }}" required>
                            @error('name')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 font-bold mb-2">Mô tả</label>
                            <textarea name="description" id="description" rows="3" class="border border-slate-300 rounded px-3 py-2 w-full text-sm focus:outline-none focus:ring focus:border-blue-300">{{ old('description', $productVariant->description) }}</textarea>
                            @error('description')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Cập nhật
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
