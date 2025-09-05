@extends('admin.layouts.app')

@section('title', 'Thêm chức vụ mới')

@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-6">
            {{-- Header --}}
            <script src="https://cdn.tailwindcss.com"></script>

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Thêm chức vụ mới</h2>
                <a href="{{ route('admin.roles.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    ← Quay lại
                </a>
            </div>

            {{-- Hiển thị lỗi --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Tên chức vụ --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên chức vụ</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm
                                  focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 sm:text-sm">
                </div>

                {{-- Mô tả --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm
                                     focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 sm:text-sm">{{ old('description') }}</textarea>
                </div>

                {{-- Submit --}}
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-5 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
                        💾 Lưu lại
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
