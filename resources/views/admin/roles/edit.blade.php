@extends('admin.layouts.app')

@section('title', 'Cập nhật chức vụ')

@section('content')
    <div class="max-w-3xl mx-auto px-6 py-8">
        <script src="https://cdn.tailwindcss.com"></script>

        <div class="bg-white shadow-lg rounded-xl p-6">
            <div class="mb-6 border-b pb-4 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-800">Cập nhật chức vụ</h1>
                <a href="{{ route('admin.roles.index') }}" e
                    class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">

                    Quay lại
                </a>

            </div>

            {{-- Thông báo lỗi --}}
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded-md">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên chức vụ <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-400">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Ghi chú</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-400">{{ old('description', $role->description) }}</textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                        💾 Cập nhật
                    </button>
                    <a href="{{ route('admin.roles.index') }}"
                        class="bg-blue-500 hover:bg-red-700 text-white text-sm font-bold py-2 px-4 rounded">
                        ❌ Hủy
                    </a>

                </div>
            </form>
        </div>
    </div>
@endsection
