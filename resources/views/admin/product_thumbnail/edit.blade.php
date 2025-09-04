@extends('admin.layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Sửa Product Thumbnail</h1>
    <form action="{{ route('admin.product_thumbnail.update', $thumbnail->id) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label for="product_id" class="block font-medium mb-1">Product ID</label>
            <input type="number" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" id="product_id" name="product_id" value="{{ $thumbnail->product_id }}" required>
        </div>
        <div>
            <label for="product_variant_id" class="block font-medium mb-1">Product Variant ID</label>
            <input type="number" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" id="product_variant_id" name="product_variant_id" value="{{ $thumbnail->product_variant_id }}" required>
        </div>
        <div>
            <label for="url" class="block font-medium mb-1">Ảnh mới (nếu muốn thay đổi)</label>
            <input type="file" class="w-full border rounded px-3 py-2" id="url" name="url" accept="image/*">
            @if($thumbnail->url)
                <div class="mt-2">
                    <label class="block text-sm text-gray-500">Ảnh hiện tại:</label>
                    <img src="{{ asset('storage/' . $thumbnail->url) }}" alt="Ảnh hiện tại" class="h-20 w-20 object-cover rounded border mt-1">
                </div>
            @endif
        </div>
        <div>
            <label for="is_primary" class="block font-medium mb-1">Ảnh chính</label>
            <select class="w-full border rounded px-3 py-2" id="is_primary" name="is_primary" required>
                <option value="1" {{ $thumbnail->is_primary ? 'selected' : '' }}>Có</option>
                <option value="0" {{ !$thumbnail->is_primary ? 'selected' : '' }}>Không</option>
            </select>
        </div>
        <div>
            <label for="sort_order" class="block font-medium mb-1">Thứ tự</label>
            <input type="number" class="w-full border rounded px-3 py-2" id="sort_order" name="sort_order" value="{{ $thumbnail->sort_order }}">
        </div>
        <div class="flex justify-end gap-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-6 rounded">
                Cập nhật
            </button>
            <a href="{{ route('admin.product_thumbnail.index') }}"
                class="border border-slate-400 text-slate-700 hover:bg-slate-100 hover:text-slate-900 text-sm font-medium py-2 px-6 rounded transition-all duration-150">
                Quay lại
            </a>
        </div>
    </form>
</div>
@endsection 