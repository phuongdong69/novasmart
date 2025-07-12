@extends('admin.layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div class="max-w-xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Thêm người dùng mới</h1>
    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white shadow rounded-lg p-6 space-y-4">
        @csrf
        <div>
            <label for="name" class="block font-medium mb-1">Họ tên</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
            @error('name')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="email" class="block font-medium mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2" required>
            @error('email')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="phone" class="block font-medium mb-1">Số điện thoại</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="w-full border rounded px-3 py-2">
            @error('phone')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="password" class="block font-medium mb-1">Mật khẩu</label>
            <input type="password" name="password" id="password" class="w-full border rounded px-3 py-2" required>
            @error('password')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="password_confirmation" class="block font-medium mb-1">Nhập lại mật khẩu</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label for="status" class="block font-medium mb-1">Trạng thái</label>
            <select name="status" id="status" class="w-full border rounded px-3 py-2">
                <option value="1" {{ old('status', 1)==1 ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('status')==='0' ? 'selected' : '' }}>Tạm khóa</option>
            </select>
        </div>
        <div>
            <label for="role_id" class="block font-medium mb-1">Vai trò</label>
            <select name="role_id" id="role_id" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Chọn vai trò --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id')==$role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role_id')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Lưu</button>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">Quay lại</a>
        </div>
    </form>
</div>
@endsection 