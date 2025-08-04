@extends('admin.layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Thêm tài khoản mới</h1>

        <form action="{{ route('admin.users.store') }}" method="POST" autocomplete="off">
            @csrf

            <div>
                <label for="name" class="block font-medium text-gray-700 mb-1">Họ và tên</label>
                <input type="text"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none"
                    name="name" id="fullname"  value="{{ old('name') }}"
                    autocomplete="off" />
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>



            <div>
                <label for="email" class="block font-medium text-gray-700 mb-1">Email</label>
                <input type="email"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none"
                    name="email" id="email" value="{{ old('email') }}" autocomplete="off" />
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div>
               <label for="phoneNumber" class="block font-medium text-gray-700 mb-1">Số điện thoại</label>
                <input type="phoneNumber"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none"
                    name="phoneNumber" id="phoneNumber" value="{{ old('phoneNumber') }}" autocomplete="off" />
                @error('phoneNumber')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="role_id" class="block font-medium text-gray-700 mb-1">Vai trò</label>
                <select name="role_id" id="role_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block font-medium text-gray-700 mb-1">Mật khẩu</label>
                <input type="password" name="password" id="password  " autocomplete="new-password"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none"
                    autocomplete="off">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block font-medium text-gray-700 mb-1">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}"
                    class="px-5 py-2 bg-blue-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">Huỷ</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Lưu tài khoản
                </button>
            </div>
        </form>

    </div>
@endsection
