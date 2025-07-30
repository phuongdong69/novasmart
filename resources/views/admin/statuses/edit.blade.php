@extends('admin.layouts.app')
@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Sửa trạng thái</h1>
    <form action="{{ route('admin.statuses.update', $status) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block">Tên trạng thái</label>
            <input type="text" name="name" class="border rounded w-full px-2 py-1" value="{{ $status->name }}" required>
        </div>
        <div>
            <label class="block">Mã trạng thái</label>
            <input type="text" name="code" class="border rounded w-full px-2 py-1" value="{{ $status->code }}" required>
        </div>
        <div>
            <label class="block">Loại trạng thái</label>
            <input type="text" name="type" class="border rounded w-full px-2 py-1" value="{{ $status->type }}" required>
        </div>
        <div>
            <label class="block">Màu hiển thị</label>
            <input type="color" name="color" class="border rounded px-2 py-1" value="{{ $status->color }}">
        </div>
        <div>
            <label class="block">Thứ tự ưu tiên</label>
            <input type="number" name="sort_order" class="border rounded w-full px-2 py-1" value="{{ $status->sort_order }}">
        </div>
        <div>
            <label class="block">Kích hoạt</label>
            <input type="checkbox" name="is_active" value="1" {{ $status->is_active ? 'checked' : '' }}>
        </div>
        <div>
            <label class="block">Mô tả</label>
            <textarea name="description" class="border rounded w-full px-2 py-1">{{ $status->description }}</textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Cập nhật</button>
        <a href="{{ route('admin.statuses.index') }}" class="ml-2 text-gray-600">Quay lại</a>
    </form>
</div>
@endsection 