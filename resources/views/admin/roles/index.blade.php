@extends('admin.layouts.app')

@section('title', 'Danh sách chức vụ')

@section('content')
    <div class="px-6 py-8">
        <div class="bg-white shadow-xl rounded-xl overflow-hidden">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h2 class="text-2xl font-semibold text-gray-800">Danh sách chức vụ</h2>
                <a href="{{ route('admin.roles.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                    Thêm mới
                </a>
            </div>

            <!-- Flash Message -->
            @if (session('success'))
                <div class="flex items-center px-6 py-4 text-green-700 bg-green-100 text-sm">
                    <svg class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="flex items-center px-6 py-4 text-red-700 bg-red-100 text-sm">
                    <svg class="h-5 w-5 mr-2 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-gray-700">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                        <tr>
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">Tên chức vụ</th>
                            <th class="px-6 py-3 text-left">Mô tả</th>
                            <th class="px-6 py-3 text-left">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($roles as $index => $role)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-800">{{ $role->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $role->description }}</td>
                                <td class="px-6 py-4">
                                    {{-- Không cho sửa chính role của mình --}}
                                    @if (auth()->user()->role_id !== $role->id)
                                        <a href="{{ route('admin.roles.edit', $role->id) }}"
                                            class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                                            Sửa
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-400 italic">Không thể sửa</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Không có dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4">
                {{ $roles->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
@endsection
