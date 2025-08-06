@extends('admin.layouts.app')

@section('title', 'Thêm trạng thái')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">➕ Thêm Trạng Thái</h2>

        <form action="{{ route('admin.statuses.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <!-- Tên -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên trạng thái <span
                        class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" required
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Mã -->
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Mã trạng thái <span
                        class="text-red-500">*</span></label>
                <input type="text" name="code" id="code" required
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Loại -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Loại trạng thái <span
                        class="text-red-500">*</span></label>
                <input type="text" name="type" id="type" required
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Màu -->
            <div>
                <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Màu hiển thị</label>
                <input type="color" name="color" id="color" value="#00ff00"
                    class="h-10 w-full border border-gray-300 rounded-md cursor-pointer">
            </div>

            <!-- Ưu tiên -->
            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Thứ tự ưu tiên</label>
                <input type="number" name="priority" id="priority" value="0"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Kích hoạt -->
            <div class="flex items-center space-x-3 mt-6">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked
                    class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="is_active" class="text-sm text-gray-700 font-medium">Kích hoạt</label>
            </div>

            <!-- Mô tả (full width) -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Ghi chú thêm về trạng thái..."></textarea>
            </div>

            <!-- Nút hành động -->
            <div class="md:col-span-2 flex justify-between pt-4">
                <button type="submit"
                    class="bg-indigo-600 text-white font-semibold px-6 py-2 rounded-md hover:bg-indigo-500 transition duration-200">
                    💾 Lưu trạng thái
                </button>
                <a href="{{ route('admin.statuses.index') }}"
                    class="text-gray-600 hover:text-indigo-600 text-sm font-medium underline">
                    ← Quay lại danh sách
                </a>
            </div>
        </form>
    </div>
@endsection
