@extends('admin.layouts.app')
@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Danh sách trạng thái</h1>
        <a href="{{ route('admin.statuses.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Thêm trạng thái</a>
    </div>
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="border px-4 py-2">Tên</th>
                <th class="border px-4 py-2">Loại</th>
                <th class="border px-4 py-2">Màu</th>
                <th class="border px-4 py-2">Thứ tự</th>
                <th class="border px-4 py-2">Kích hoạt</th>
                <th class="border px-4 py-2">Mô tả</th>
                <th class="border px-4 py-2">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statuses as $status)
            <tr>
                <td class="border px-4 py-2">{{ $status->name }}</td>
                <td class="border px-4 py-2">{{ $status->type }}</td>
                <td class="border px-4 py-2"><span style="background:{{ $status->color }};color:#fff;padding:2px 8px;border-radius:4px">{{ $status->color }}</span></td>
                <td class="border px-4 py-2">{{ $status->sort_order }}</td>
                <td class="border px-4 py-2">{{ $status->is_active ? '✔' : '✖' }}</td>
                <td class="border px-4 py-2">{{ $status->description }}</td>
                <td class="border px-4 py-2 text-center">
                    <a href="{{ route('admin.statuses.edit', $status) }}" class="text-blue-500">Sửa</a>
                    <!--
                    <form action="{{ route('admin.statuses.destroy', $status) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 ml-2" onclick="return confirm('Xóa trạng thái này?')">Xóa</button>
                    </form>
                    -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 