@extends('admin.layouts.app')
@section('title', 'Danh sách danh mục')
@section('content')

<div class="w-full px-6 py-6 mx-auto">
  <div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
      <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

        {{-- Tiêu đề + Nút thêm mới --}}
        <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex justify-between items-center">
          <h3 class="dark:text-white text-lg font-semibold">Danh sách danh mục</h3>
          <a href="{{ route('admin.categories.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
            + Thêm mới
          </a>
        </div>

        {{-- Thanh tìm kiếm --}}
        <div class="px-6 mt-4">
          <form method="GET" action="{{ route('admin.categories.index') }}" class="flex justify-end items-center gap-2">
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

        {{-- Bảng danh mục --}}
        <div class="flex-auto px-0 pt-4 pb-2">
          <div class="p-0 overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">ID</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Tên danh mục</th>
                  <th class="px-6 py-3 text-center uppercase text-xs font-bold text-slate-400">Trạng thái</th>
                  <th class="px-6 py-3 text-center uppercase text-xs font-bold text-slate-400">Ngày tạo</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Thao tác</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($categories as $category)
                  <tr class="border-b dark:border-white/40 hover:bg-gray-50 transition">
                    <td class="px-6 py-3 text-sm">{{ $category->id }}</td>
                    <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $category->name }}</td>
                    <td class="px-6 py-3 text-sm text-center">
  <form action="{{ route('admin.categories.toggleStatus', $category->id) }}" method="POST">
    @csrf 
    @method('PUT')

    @php
      $statusCode = $category->status->code ?? 'inactive';
      $isActive = $statusCode === 'active';
    @endphp

    <button type="submit"
      class="px-2.5 py-1.4 text-xs rounded-1.8 font-bold uppercase leading-none text-white
      {{ $isActive ? 'bg-gradient-to-tl from-emerald-500 to-teal-400' : 'bg-gradient-to-tl from-slate-600 to-slate-300' }}">
      {{ $isActive ? 'Hiển thị' : 'Ẩn' }}
    </button>
  </form>
</td>
                    <td class="px-6 py-3 text-center text-sm text-slate-500">{{ $category->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-3 text-sm">
                      <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-blue-600 hover:underline mr-2">Sửa</a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center py-4 text-sm text-gray-500">Không có dữ liệu nào trùng khớp.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>

    <div class="mt-4 px-6">
    @if ($categories->hasPages())
        <div style="display: flex; justify-content: center; gap: 8px; margin: 20px 0;">
            @if ($categories->onFirstPage())
                <span style="padding: 8px 16px; background: #f3f4f6; color: #9ca3af; border-radius: 8px; cursor: not-allowed;">Trước</span>
            @else
                <a href="{{ $categories->previousPageUrl() }}" style="padding: 8px 16px; background: white; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; transition: all 0.2s;">Trước</a>
            @endif

            @for ($i = 1; $i <= $categories->lastPage(); $i++)
                @if ($i == $categories->currentPage())
                    <span style="padding: 8px 16px; background: #3b82f6; color: white; border-radius: 8px; font-weight: bold;">{{ $i }}</span>
                @else
                    <a href="{{ $categories->url($i) }}" style="padding: 8px 16px; background: white; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; transition: all 0.2s;">{{ $i }}</a>
                @endif
            @endfor

            @if ($categories->hasMorePages())
                <a href="{{ $categories->nextPageUrl() }}" style="padding: 8px 16px; background: white; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; transition: all 0.2s;">Tiếp</a>
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
  </div>
</div>
@endsection