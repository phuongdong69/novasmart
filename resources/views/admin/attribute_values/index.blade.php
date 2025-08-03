@extends('admin.layouts.app')
@section('title')
Danh sách giá trị thuộc tính
@endsection
@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                {{-- Tiêu đề + Nút thêm mới --}}
                <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex justify-between items-center">
                    <h3 class="dark:text-white text-lg font-semibold">Danh sách giá trị thuộc tính</h3>
                    <a href="{{ route('admin.attribute_values.create') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                        + Thêm mới
                    </a>
                </div>

                {{-- Thanh tìm kiếm --}}
                <div class="px-6 mt-4">
                    <form method="GET" action="{{ route('admin.attribute_values.index') }}" class="flex justify-end items-center gap-2">
                        <input
                            type="search"
                            name="keyword"
                            class="border border-slate-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300"
                            placeholder="Tìm theo ID hoặc tên..."
                            value="{{ request('keyword') }}"
                        >
                        <button type="submit" class="text-sm px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Tìm
                        </button>
                    </form>
                </div>

                {{-- Bảng giá trị thuộc tính --}}
                <div class="flex-auto px-0 pt-4 pb-2">
                    <div class="p-0 overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">#</th>
                                    <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Tên thuộc tính</th>
                                    <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Giá trị</th>
                                    <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($values as $value)
                                    <tr class="border-b dark:border-white/40 hover:bg-gray-50 transition">
                                        <td class="px-6 py-3 text-sm">{{ $loop->index + 1 }}</td>
                                        <td class="px-6 py-3 text-sm">{{ $value->attribute->name }}</td>
                                        <td class="px-6 py-3 text-sm">{{ $value->value }}</td>
                                        <td class="px-6 py-3 text-sm">
                                            <a href="{{ route('admin.attribute_values.edit', $value->id) }}" 
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-bold rounded-md text-white bg-blue-500 hover:bg-blue-700 transition-all duration-150 shadow-sm">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                </svg>
                                                Sửa
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-gray-500">Không có giá trị thuộc tính nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                 <div class="mt-4 px-6">
    @if ($values->hasPages())
        <div style="display: flex; justify-content: center; gap: 8px; margin: 20px 0;">
            @if ($values->onFirstPage())
                <span style="padding: 8px 16px; background: #f3f4f6; color: #9ca3af; border-radius: 8px; cursor: not-allowed;">Trước</span>
            @else
                <a href="{{ $values->previousPageUrl() }}" style="padding: 8px 16px; background: white; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; transition: all 0.2s;">Trước</a>
            @endif

            @for ($i = 1; $i <= $values->lastPage(); $i++)
                @if ($i == $values->currentPage())
                    <span style="padding: 8px 16px; background: #3b82f6; color: white; border-radius: 8px; font-weight: bold;">{{ $i }}</span>
                @else
                    <a href="{{ $values->url($i) }}" style="padding: 8px 16px; background: white; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; transition: all 0.2s;">{{ $i }}</a>
                @endif
            @endfor

            @if ($values->hasMorePages())
                <a href="{{ $values->nextPageUrl() }}" style="padding: 8px 16px; background: white; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; transition: all 0.2s;">Tiếp</a>
            @else
                <span style="padding: 8px 16px; background: #f3f4f6; color: #9ca3af; border-radius: 8px; cursor: not-allowed;">Tiếp</span>
            @endif
        </div>
    @endif
</div>
            </div>
        </div>
    </div>
</div>
@endsection
