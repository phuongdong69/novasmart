@extends('admin.layouts.app')

@section('title', 'Sửa trạng thái')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div class="max-w-4xl mx-auto py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Sửa trạng thái</h1>
        <a href="{{ route('admin.statuses.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Quay lại
        </a>
    </div>

    <form action="{{ route('admin.statuses.update', $status) }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Thông tin cơ bản -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Thông tin cơ bản</h3>
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Tên trạng thái</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $status->name) }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Mã trạng thái</label>
                    <input type="text" name="code" id="code" value="{{ old('code', $status->code) }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Loại trạng thái</label>
                    <select name="type" id="type" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Chọn loại trạng thái</option>
                        <option value="user" {{ old('type', $status->type) == 'user' ? 'selected' : '' }}>User</option>
                        <option value="voucher" {{ old('type', $status->type) == 'voucher' ? 'selected' : '' }}>Voucher</option>
                        <option value="order" {{ old('type', $status->type) == 'order' ? 'selected' : '' }}>Order</option>
                        <option value="product" {{ old('type', $status->type) == 'product' ? 'selected' : '' }}>Product</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Cài đặt hiển thị -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Cài đặt hiển thị</h3>
                
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Màu hiển thị</label>
                    <div class="flex items-center space-x-3">
                        <input type="color" name="color" id="color" value="{{ old('color', $status->color) }}" class="w-16 h-10 border border-gray-300 rounded cursor-pointer">
                        <span class="text-sm text-gray-500">Chọn màu cho trạng thái này</span>
                    </div>
                    @error('color')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Thứ tự ưu tiên</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $status->sort_order) }}" min="0" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-sm text-gray-500 mt-1">Số càng nhỏ, thứ tự càng cao</p>
                    @error('sort_order')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $status->is_active) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">Kích hoạt trạng thái này</label>
                </div>
            </div>
        </div>

        <!-- Mô tả -->
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Mô tả</h3>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Mô tả chi tiết</label>
                <textarea name="description" id="description" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập mô tả chi tiết về trạng thái này...">{{ old('description', $status->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Preview -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Xem trước</h3>
            <div class="flex items-center space-x-4">
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full text-white" style="background-color: {{ $status->color }};">
                    {{ $status->name }}
                </span>
                <span class="text-sm text-gray-600">Mã: {{ $status->code }}</span>
                <span class="text-sm text-gray-600">Loại: {{ $status->type }}</span>
            </div>
        </div>

        <div class="flex justify-end mt-6 space-x-4">
            <a href="{{ route('admin.statuses.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Hủy
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                Cập nhật trạng thái
            </button>
        </div>
    </form>
</div>

<script>
// Preview color change
document.getElementById('color').addEventListener('change', function() {
    const preview = document.querySelector('.inline-flex');
    preview.style.backgroundColor = this.value;
});
</script>
@endsection 