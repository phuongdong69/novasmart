@extends('admin.layouts.app')

@section('title', 'Danh sách trạng thái')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div class="max-w-7xl mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Danh sách trạng thái</h1>
        <a href="{{ route('admin.statuses.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
            Thêm trạng thái
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" style="min-width: 1200px;">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Tên</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Loại</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Màu</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Kích hoạt</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-80">Mô tả</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Hành động</th>
            </tr>
        </thead>
                <tbody class="bg-white divide-y divide-gray-200">
            @foreach($statuses as $status)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $status->name }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @switch($status->type)
                                    @case('user')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            User
                                        </span>
                                        @break
                                    @case('voucher')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                            Voucher
                                        </span>
                                        @break
                                    @case('order')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Order
                                        </span>
                                        @break
                                    @case('product')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Product
                                        </span>
                                        @break
                                    @default
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ ucfirst($status->type) }}
                                        </span>
                                @endswitch
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-6 h-6 rounded border mr-2" style="background-color: {{ $status->color }};"></div>
                                <span class="text-sm text-gray-500">{{ $status->color }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            @if($status->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Kích hoạt
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    Không kích hoạt
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $status->description }}">
                                {{ $status->description ?: 'Không có mô tả' }}
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.statuses.show', $status->id) }}" class="text-blue-600 hover:text-blue-900">Xem chi tiết</a>
                            </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
        </div>
    </div>
</div>
@endsection 