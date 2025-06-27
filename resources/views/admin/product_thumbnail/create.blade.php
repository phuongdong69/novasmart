@extends('admin.layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Thêm Product Thumbnail</h1>
    <form action="{{ route('admin.product_thumbnail.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6 space-y-4">
        @csrf
        <div>
            <label for="product_id" class="block font-medium mb-1">Product ID</label>
            <input type="number" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" id="product_id" name="product_id" required>
        </div>
        <div>
            <label for="product_variant_id" class="block font-medium mb-1">Product Variant ID</label>
            <input type="number" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" id="product_variant_id" name="product_variant_id" required>
        </div>
        <div>
            <label for="url" class="block font-medium mb-1">Ảnh</label>
            <input type="file" class="w-full border rounded px-3 py-2" id="url" name="url" accept="image/*" required>
        </div>
        <div>
            <label for="is_primary" class="block font-medium mb-1">Ảnh chính</label>
            <select class="w-full border rounded px-3 py-2" id="is_primary" name="is_primary" required>
                <option value="1">Có</option>
                <option value="0">Không</option>
            </select>
        </div>
        <div>
            <label for="sort_order" class="block font-medium mb-1">Thứ tự</label>
            <input type="number" class="w-full border rounded px-3 py-2" id="sort_order" name="sort_order">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Lưu</button>
            <a href="{{ route('admin.product_thumbnail.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">Quay lại</a>
        </div>
    </form>
</div>
@endsection 