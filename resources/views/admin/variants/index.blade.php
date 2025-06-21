@extends('admin.layouts.body')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex justify-between mb-4">
    <h6 class="dark:text-white text-lg font-semibold">Danh sách sản phẩm</h6>
    <a href="{{ route('admin.products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
      + Thêm mới sản phẩm
    </a>
  </div>

  <form method="GET" action="{{ route('admin.products.index') }}" class="flex justify-end mb-4 space-x-2">
    <input type="search" name="keyword" class="form-control form-control-sm rounded border px-3 py-2 text-sm" placeholder="Tìm theo tên sản phẩm..." value="{{ request('keyword') }}">
    <button type="submit" class="text-sm px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Tìm</button>
  </form>

  <table class="table table-bordered table-striped w-full text-sm">
    <thead>
      <tr>
        <th>ID</th>
        <th>Tên sản phẩm</th>
        <th>Ngày tạo</th>
        <th>Thao tác</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($products as $product)
        <tr>
          <td>{{ $product->id }}</td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->created_at->format('d/m/Y') }}</td>
          <td class="space-x-2">
            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:underline">Sửa</a>

            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block">
              @csrf
              @method('DELETE')
              <button type="submit" onclick="return confirm('Xác nhận xoá?')" class="text-red-500 hover:underline">Xoá</button>
            </form>

            <a href="{{ route('admin.product-variants.create', ['product' => $product->id]) }}" class="text-green-600 hover:underline">Thêm biến thể</a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="text-center text-gray-500">Không có sản phẩm nào.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-4">
    {{ $products->links('pagination::bootstrap-4') }}
  </div>
</div>
@endsection
