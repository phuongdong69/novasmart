@extends('admin.layouts.app')
@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
      <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

        <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent">
{{--  tìm kiếm --}}
  <div class="flex justify-end mb-2">
    <form method="GET" action="{{ route('admin.origins.index') }}" class="flex items-center gap-2">
        <input
          type="search"
          name="keyword"
          class="form-control form-control-sm rounded border px-3 py-2 text-sm"
          placeholder="Tìm theo ID hoặc tên ..."
          value="{{ request('keyword') }}"
        >
        <button type="submit" class="text-sm px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
          Tìm
        </button>
      </form>
    </div>  
  {{-- Tiêu đề và nút thêm mới --}}
  <div class="flex items-center justify-between mb-4">
    <h6 class="dark:text-white text-lg font-semibold">Danh sách xuất xứ</h6>
    <a href="{{ route('admin.origins.create') }}"
       class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
      + Thêm mới
    </a>
  </div>

  

</div>

        {{-- Alert messages --}}
        @if (session('success'))
          <div class="alert alert-success mt-3 mx-6">{{ session('success') }}</div>
        @endif
        @if (session('error'))
          <div class="alert alert-danger mt-3 mx-6">{{ session('error') }}</div>
        @endif

        {{-- Table --}}
        <div class="flex-auto px-0 pt-0 pb-2">
          <div class="p-0 overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">ID</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Quốc gia</th>
                  <th class="px-6 py-3 text-center uppercase text-xs font-bold text-slate-400">Ngày tạo</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Thao tác</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($origins as $origin)
                  <tr class="border-b dark:border-white/40 hover:bg-gray-50 transition">
                    <td class="px-6 py-3 text-sm">{{ $origin->id }}</td>
                    <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $origin->country }}</td>
                    <td class="px-6 py-3 text-sm text-center text-slate-500">{{ $origin->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-3 text-sm">
                      <a href="{{ route('admin.origins.edit', $origin->id) }}" class="text-blue-600 hover:underline mr-2">Sửa</a>
                      <form action="{{ route('admin.origins.destroy', $origin->id) }}" method="POST" class="inline-block">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Xác nhận xoá?')" class="text-red-500 hover:underline">Xoá</button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center py-4 text-sm text-gray-500">Không có dữ liệu nào trùng hợp.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-4 px-6 flex justify-center">
              {{ $origins->links('pagination::bootstrap-4') }}
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

