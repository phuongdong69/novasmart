@extends('admin.layouts.app')

@section('title', 'Quản lý người dùng')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Quản lý người dùng</h1>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Thêm mới
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('debug'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
            Debug: {{ session('debug') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-4 border-b">
            <form method="GET" class="flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm..." class="border rounded px-3 py-2">
                <select name="role_id" class="border rounded px-3 py-2">
                    <option value="">Tất cả vai trò</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" @if(request('role_id') == $role->id) selected @endif>{{ $role->name }}</option>
                    @endforeach
                </select>
                <select name="status_code" class="border rounded px-3 py-2">
                    <option value="">Tất cả trạng thái</option>
                    <option value="active" @if(request('status_code') == 'active') selected @endif>Hoạt động</option>
                    <option value="locked" @if(request('status_code') == 'locked') selected @endif>Bị khóa</option>
                    <option value="suspended" @if(request('status_code') == 'suspended') selected @endif>Tạm khóa</option>
                    <option value="pending_verification" @if(request('status_code') == 'pending_verification') selected @endif>Chờ xác thực</option>
                </select>
                <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Tìm kiếm
                </button>
                @if(request('search') || request('role_id') || request('status_code'))
                    <a href="{{ route('admin.users.index') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Xóa bộ lọc
                    </a>
                @endif
            </form>
        </div>

        <!-- Thêm scroll ngang cho bảng -->
        <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Tên</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Giới tính</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Ngày sinh</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-28">SĐT</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Email</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Ảnh</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Trạng thái</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Ngày tạo</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Ngày cập nhật</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Hành động</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-4 text-sm text-gray-900 font-medium">{{ $user->name }}</td>
                            <td class="px-3 py-4 text-sm text-gray-900">
                                @if($user->gender === 'male') 
                                    <span class="text-blue-600">Nam</span>
                                @elseif($user->gender === 'female') 
                                    <span class="text-pink-600">Nữ</span>
                                @else 
                                    {{ $user->gender ?? '-' }}
                                @endif
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-900">
                                {{ $user->birthday ? \Carbon\Carbon::parse($user->birthday)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-900">{{ $user->phoneNumber ?? '-' }}</td>
                            <td class="px-3 py-4 text-sm text-gray-900">{{ $user->email }}</td>
                            <td class="px-3 py-4 text-sm text-gray-900">
                                @if($user->image_user)
                                    <img src="{{ asset('storage/' . $user->image_user) }}" alt="Ảnh" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                        <span class="text-xs text-gray-500">?</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-3 py-4 text-sm">
                                @php
                                    $statusMap = [
                                        'active' => 'Hoạt động',
                                        'locked' => 'Bị khóa',
                                        'suspended' => 'Tạm khóa',
                                        'pending_verification' => 'Chờ xác thực',
                                    ];
                                    $statusColor = [
                                        'active' => 'bg-green-100 text-green-800',
                                        'locked' => 'bg-red-100 text-red-800',
                                        'suspended' => 'bg-yellow-100 text-yellow-800',
                                        'pending_verification' => 'bg-gray-100 text-gray-800',
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColor[$user->status_code ?? ''] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusMap[$user->status_code ?? ''] ?? $user->status_code }}
                            </span>
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-900">
                                {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-900">
                                {{ $user->updated_at ? \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-3 py-4 text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-600 hover:text-blue-900">Xem chi tiết</a>
                                </div>
                            </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>

        <div class="px-6 py-4">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection 