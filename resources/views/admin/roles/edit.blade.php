@extends('admin.layouts.app')

@section('title', 'Cập nhật chức vụ')

@section('content')
<div class="px-6 py-6">
    <div class="max-w-xl mx-auto bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Cập nhật chức vụ</h2>

        {{-- Hiển thị lỗi --}}
        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Tên chức vụ</label>
                <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Ghi chú</label>
                <textarea name="description" id="description" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $role->description) }}</textarea>
            </div>

            <div class="flex items-center space-x-2">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Cập nhật
                </button>
                <a href="{{ route('admin.roles.index') }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                    Quay lại
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
