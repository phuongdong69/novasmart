@extends('admin.layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow-lg border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">✏️ Chỉnh sửa tài khoản: {{ $user->name }}</h2>

        {{-- Hiển thị lỗi chung --}}
        @if ($errors->any())
            <div class="mb-4 rounded border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Họ tên --}}
            <div class="mb-5">
                <label class="block font-medium text-gray-700 mb-1">👤 Họ tên</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="mt-1 w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email (readonly) --}}
            <div class="mb-5">
                <label class="block font-medium text-gray-700 mb-1">📧 Email</label>
                <input type="email" name="email" value="{{ $user->email }}" readonly
                    class="bg-gray-100 cursor-not-allowed w-full p-3 border border-gray-300 rounded-lg">
            </div>

            {{-- Số điện thoại --}}
            <div class="mb-5">
                <label class="block font-medium text-gray-700 mb-1">📱 Số điện thoại</label>
                <input type="text" name="phoneNumber" value="{{ old('phoneNumber', $user->phoneNumber) }}"
                    class="mt-1 w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                @error('phoneNumber')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Trạng thái (chỉ cho admin) --}}
            @if (auth()->user()->role->name === 'admin')
                <div class="mb-5">
                    <label class="block font-medium text-gray-700 mb-1">📌 Trạng thái</label>
                    <select name="status_id"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                        @foreach ($statuses as $status)
                            @if ($status->type === 'user')
                                <option value="{{ $status->id }}" {{ old('status_id', $user->status_id) == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('status_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Vai trò (chỉ admin mới thấy) --}}
                <div class="mb-5">
                    <label class="block font-medium text-gray-700 mb-1">🛡️ Vai trò</label>
                    <select name="role_id"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            {{-- Nút hành động --}}
            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('admin.users.index') }}"
                    class="px-5 py-2 bg-blue-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">Huỷ</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Cập nhật
                </button>
            </div>
        </form>
    </div>
@endsection
