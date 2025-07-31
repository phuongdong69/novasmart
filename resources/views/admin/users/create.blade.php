@extends('admin.layouts.app')

@section('title', 'Thêm người dùng mới')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div class="max-w-4xl mx-auto py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Thêm người dùng mới</h1>
        <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Quay lại
        </a>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white shadow rounded-lg p-6" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Thông tin cơ bản -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Thông tin cơ bản</h3>
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Họ tên</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Giới tính</label>
                    <select name="gender" id="gender" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Chọn giới tính</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                    @error('gender')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="birthday" class="block text-sm font-medium text-gray-700 mb-2">Ngày sinh</label>
                    <input type="date" name="birthday" id="birthday" value="{{ old('birthday') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('birthday')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Thông tin liên hệ -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Thông tin liên hệ</h3>
                
                <div>
                    <label for="phoneNumber" class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                    <input type="text" name="phoneNumber" id="phoneNumber" value="{{ old('phoneNumber') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('phoneNumber')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ</label>
                    <textarea name="address" id="address" rows="3" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image_user" class="block text-sm font-medium text-gray-700 mb-2">Ảnh đại diện</label>
                    <input type="file" name="image_user" id="image_user" accept="image/*" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('image_user')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Thông tin tài khoản -->
        <div class="mt-6 space-y-4">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Thông tin tài khoản</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu</label>
                    <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="role_id" class="block text-sm font-medium text-gray-700 mb-2">Vai trò</label>
                    <select name="role_id" id="role_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Chọn vai trò</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status_code" class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                    <select name="status_code" id="status_code" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Chọn trạng thái</option>
                        <option value="active" {{ old('status_code') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="pending_verification" {{ old('status_code') == 'pending_verification' ? 'selected' : '' }}>Chờ xác thực</option>
                        <option value="locked" {{ old('status_code') == 'locked' ? 'selected' : '' }}>Bị khóa</option>
                        <option value="suspended" {{ old('status_code') == 'suspended' ? 'selected' : '' }}>Tạm khóa</option>
                    </select>
                    @error('status_code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                Thêm người dùng
            </button>
        </div>
    </form>
</div>
@endsection 