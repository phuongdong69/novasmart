@extends('admin.layouts.body')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex justify-between mb-4">
    <h6 class="dark:text-white text-lg font-semibold">Danh sách sản phẩm</h6>
    <a href="{{ route('admin.products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">+ Thêm mới sản phẩm</a>
  </div>

  <form method="GET" action="{{ route('admin.products.index') }}" class="flex justify-end mb-2">
    <input type="search" name="keyword" class="form-control form-control-sm rounded border px-3 py-2 text-sm" placeholder="Tìm theo tên sản phẩm..." value="{{ request('keyword') }}">
    <button type="submit" class="text-sm px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Tìm</button>
  </form>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Tên sản phẩm</th>
        <th>Ngày tạo</th>
        <th>Thao tác</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($products as $product)
        <tr>
          <td>{{ $product->id }}</td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->created_at->format('d/m/Y') }}</td>
          <td>
            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600">Sửa</a>
            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block">
              @csrf @method('DELETE')
              <button type="submit" onclick="return confirm('Xác nhận xoá?')" class="text-red-500">Xoá</button>
            </form>
            <a href="{{ route('admin.product-variants.create', $product->id) }}" class="text-green-600">Thêm biến thể</a> <!-- Nút thêm biến thể -->
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  {{ $products->links('pagination::bootstrap-4') }}
</div>
@endsection
