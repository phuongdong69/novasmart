@extends('admin.layouts.body')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
      <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

        <!-- Header -->
        <div class="p-6 pb-0 mb-0 border-b border-b-solid rounded-t-2xl border-b-slate-200 flex items-center justify-between">
          <h6 class="dark:text-white text-lg font-semibold">Danh sách sản phẩm</h6>
          <a href="{{ route('admin.products.create') }}"
       class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
      + Thêm mới
    </a>
        </div>

        <!-- Tìm kiếm -->
        <div class="flex justify-end mb-2 p-6">
          <form method="GET" action="{{ route('admin.products.index') }}" class="flex items-center gap-2">
            <input type="search" name="keyword" class="form-control form-control-sm rounded border px-3 py-2 text-sm" placeholder="Tìm theo tên sản phẩm..." value="{{ request('keyword') }}"/>
            <button type="submit" class="text-sm px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
              Tìm
            </button>
          </form>
        </div>

        <!-- Alert messages -->
        @if (session('success'))
          <div class="alert alert-success mt-3 mx-6">{{ session('success') }}</div>
        @endif
        @if (session('error'))
          <div class="alert alert-danger mt-3 mx-6">{{ session('error') }}</div>
        @endif

        <!-- Table -->
        <div class="flex-auto px-0 pt-0 pb-2">
          <div class="p-0 overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">ID</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Tên sản phẩm</th>
                  <th class="px-6 py-3 text-center uppercase text-xs font-bold text-slate-400">Ngày tạo</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Biến thể</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Thao tác</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($products as $product)
                  <tr class="border-b dark:border-white/40 hover:bg-gray-50 transition">
                    <td class="px-6 py-3 text-sm">{{ $product->id }}</td>
                    <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $product->name }}</td>
                    <td class="px-6 py-3 text-sm text-center text-slate-500">{{ $product->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-3 text-sm">
                      <!-- Thêm mới biến thể cho sản phẩm -->
<a href="{{ route('admin.product-variants.create', ['product' => $product->id]) }}" class="text-green-600 hover:underline mr-2">+ Thêm biến thể</a>
                    </td>
                    <td>
                        <!-- Sửa -->
                      <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:underline mr-2">Sửa</a>
                      <a href="{{ route('admin.products.show', $product->id) }}" class="text-blue-600 hover:underline mr-2">Xem</a>

                      <!-- Xóa -->
                      <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Xác nhận xoá?')" class="text-red-500 hover:underline">Xoá</button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center py-4 text-sm text-gray-500">Không có dữ liệu nào trùng hợp.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4 px-6 flex justify-center">
              @if (method_exists($products, 'links'))
    {{ $products->links('pagination::bootstrap-4') }}
@endif
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
