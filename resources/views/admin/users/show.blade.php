@extends('admin.layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div class="max-w-xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Chi tiết người dùng</h1>
    <div class="bg-white shadow rounded-lg p-6 space-y-4">
        <div>
            <span class="font-medium">ID:</span> {{ $user->id }}
        </div>
        <div>
            <span class="font-medium">Họ tên:</span> {{ $user->name }}
        </div>
        <div>
            <span class="font-medium">Email:</span> {{ $user->email }}
        </div>
        <div>
            <span class="font-medium">Số điện thoại:</span> {{ $user->phone }}
        </div>
        <div>
            <span class="font-medium">Trạng thái:</span>
            <span class="inline-block px-2 py-1 rounded {{ $user->status ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                {{ $user->status ? 'Hoạt động' : 'Tạm khóa' }}
            </span>
        </div>
        <div>
            <span class="font-medium">Ngày tạo:</span> {{ $user->created_at->format('d/m/Y H:i') }}
        </div>
        {{-- Thêm form đổi vai trò cho user --}}
        @if(isset($roles))
        <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="mt-4">
            @csrf
            <label for="role_id" class="block font-medium mb-1">Vai trò</label>
            <select name="role_id" id="role_id" class="w-full border rounded px-3 py-2" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Cập nhật vai trò</button>
        </form>
        @endif
    </div>
</div>
@endsection 