@extends('admin.layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div class="max-w-4xl mx-auto py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Chi tiết người dùng</h1>
        <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Quay lại
        </a>
    </div>
    
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <!-- Header với ảnh đại diện -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-8 text-white">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    @if($user->image_user)
                        <img src="{{ asset('storage/' . $user->image_user) }}" alt="Ảnh đại diện" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                    @else
                        <div class="w-24 h-24 bg-white bg-opacity-20 rounded-full flex items-center justify-center border-4 border-white shadow-lg">
                            <span class="text-3xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
        </div>
        <div>
                    <h2 class="text-3xl font-bold">{{ $user->name }}</h2>
                    <p class="text-blue-100">{{ $user->email }}</p>
                    <p class="text-blue-100">ID: {{ $user->id }}</p>
                </div>
            </div>
        </div>

        <!-- Thông tin chi tiết -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Thông tin cơ bản -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Thông tin cơ bản</h3>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">Họ tên:</span>
                        <span class="text-gray-900">{{ $user->name }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">Email:</span>
                        <span class="text-gray-900">{{ $user->email }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">Giới tính:</span>
                        <span class="text-gray-900">
                            @if($user->gender === 'male') 
                                <span class="text-blue-600 font-medium">Nam</span>
                            @elseif($user->gender === 'female') 
                                <span class="text-pink-600 font-medium">Nữ</span>
                            @elseif($user->gender === 'other')
                                <span class="text-purple-600 font-medium">Khác</span>
                            @else 
                                <span class="text-gray-500">Chưa cập nhật</span>
                            @endif
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">Ngày sinh:</span>
                        <span class="text-gray-900">
                            {{ $user->birthday ? \Carbon\Carbon::parse($user->birthday)->format('d/m/Y') : 'Chưa cập nhật' }}
                        </span>
                    </div>
                </div>

                <!-- Thông tin liên hệ -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Thông tin liên hệ</h3>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">Số điện thoại:</span>
                        <span class="text-gray-900">{{ $user->phoneNumber ?? 'Chưa cập nhật' }}</span>
                    </div>
                    
                    <div class="flex justify-between items-start py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">Địa chỉ:</span>
                        <span class="text-gray-900 text-right max-w-xs">{{ $user->address ?? 'Chưa cập nhật' }}</span>
                    </div>
                </div>
            </div>

            <!-- Thông tin tài khoản -->
            <div class="mt-8 space-y-4">
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Thông tin tài khoản</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">Vai trò:</span>
                        <span class="text-gray-900">{{ $user->role->name ?? 'Chưa phân quyền' }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">Trạng thái:</span>
                        <span class="text-gray-900">
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
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">Ngày tạo:</span>
                        <span class="text-gray-900">
                            {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') : 'N/A' }}
                        </span>
        </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">Ngày cập nhật:</span>
                        <span class="text-gray-900">
                            {{ $user->updated_at ? \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i') : 'N/A' }}
                        </span>
        </div>
                    
                    @if($user->deleted_at)
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">Ngày xóa:</span>
                        <span class="text-red-600">
                            {{ \Carbon\Carbon::parse($user->deleted_at)->format('d/m/Y H:i') }}
            </span>
        </div>
                    @endif
                </div>
            </div>

            <!-- Hành động -->
            <div class="mt-8 flex space-x-4">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Sửa thông tin
                </a>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 