@extends('admin.layouts.app')

@section('title', 'Danh sách chức vụ')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
      <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

        {{-- Tiêu đề + Nút thêm mới --}}
        <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex justify-between items-center">
          <h3 class="dark:text-white text-lg font-semibold">Danh sách chức vụ</h3>
          <a href="{{ route('admin.roles.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
            + Thêm mới
          </a>
        </div>

        {{-- Thanh tìm kiếm --}}
        <div class="px-6 mt-4">
          <form method="GET" action="{{ route('admin.roles.index') }}" class="flex justify-end items-center gap-2">
            <input
              type="search"
              name="keyword"
              class="border border-slate-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300"
              placeholder="Tìm theo tên chức vụ..."
              value="{{ request('keyword') }}"
            >
            <button type="submit" class="text-sm px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
              Tìm
            </button>
          </form>
        </div>

        {{-- Bảng chức vụ --}}
        <div class="flex-auto px-0 pt-4 pb-2">
          <div class="p-0 overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">ID</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Tên chức vụ</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Mô tả</th>
                  <th class="px-6 py-3 text-center uppercase text-xs font-bold text-slate-400">Số người dùng</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Thao tác</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($roles as $role)
                  <tr class="border-b dark:border-white/40 hover:bg-gray-50 transition">
                    <td class="px-6 py-3 text-sm">{{ $role->id }}</td>
                    <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $role->name }}</td>
                    <td class="px-6 py-3 text-sm">{{ $role->description ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm text-center text-slate-500">{{ $role->users_count ?? 0 }}</td>
                    <td class="px-6 py-3 text-sm">
                      <div class="flex items-center gap-2">
                        {{-- Không cho sửa chính role của mình --}}
                        @if (auth()->user()->role_id !== $role->id)
                          <a href="{{ route('admin.roles.edit', $role->id) }}" class="text-blue-600 hover:underline">Sửa</a>
                        @else
                          <span class="text-gray-400 text-sm italic">Không thể sửa</span>
                        @endif
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center py-4 text-sm text-gray-500">Không có dữ liệu nào trùng khớp.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-4 px-6">
              @if ($roles->hasPages())
                <div style="display: flex; justify-content: center; gap: 8px; margin: 20px 0;">
                  @if ($roles->onFirstPage())
                    <span style="padding: 8px 16px; background: #f3f4f6; color: #9ca3af; border-radius: 8px; cursor: not-allowed;">Trước</span>
                  @else
                    <a href="{{ $roles->previousPageUrl() }}" style="padding: 8px 16px; background: white; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; transition: all 0.2s;">Trước</a>
                  @endif

                  @for ($i = 1; $i <= $roles->lastPage(); $i++)
                    @if ($i == $roles->currentPage())
                      <span style="padding: 8px 16px; background: #3b82f6; color: white; border-radius: 8px; font-weight: bold;">{{ $i }}</span>
                    @else
                      <a href="{{ $roles->url($i) }}" style="padding: 8px 16px; background: white; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; transition: all 0.2s;">{{ $i }}</a>
                    @endif
                  @endfor

                  @if ($roles->hasMorePages())
                    <a href="{{ $roles->nextPageUrl() }}" style="padding: 8px 16px; background: white; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; transition: all 0.2s;">Tiếp</a>
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

@if (session('success'))
  <div id="toast-success" class="mb-4 p-3 bg-green-100 text-green-700 rounded shadow transition-all duration-300">{{ session('success') }}</div>
  <script>
    setTimeout(() => {
      const toast = document.getElementById('toast-success');
      if (toast) toast.style.display = 'none';
    }, 2500);
  </script>
@endif

@if (session('error'))
  <div id="toast-error" class="mb-4 p-3 bg-red-100 text-red-700 rounded shadow transition-all duration-300">{{ session('error') }}</div>
  <script>
    setTimeout(() => {
      const toast = document.getElementById('toast-error');
      if (toast) toast.style.display = 'none';
    }, 2500);
  </script>
@endif
@endsection
