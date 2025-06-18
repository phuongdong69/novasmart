@extends('admin.layouts.body')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex justify-between mb-4">
    <h6 class="dark:text-white text-lg font-semibold">Danh sách thuộc tính</h6>
    <a href="{{ route('admin.attributes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">+ Thêm mới</a>
  </div>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Tên thuộc tính</th>
        <th>Mô tả</th>
        <th>Thao tác</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($attributes as $attribute)
        <tr>
          <td>{{ $attribute->id }}</td>
          <td>{{ $attribute->name }}</td>
          <td>{{ $attribute->description }}</td>
          <td>
            <a href="{{ route('admin.attributes.edit', $attribute->id) }}" class="text-blue-600">Sửa</a>
            <form action="{{ route('admin.attributes.destroy', $attribute->id) }}" method="POST" class="inline-block">
              @csrf @method('DELETE')
              <button type="submit" onclick="return confirm('Xác nhận xoá?')" class="text-red-500">Xoá</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  {{ $attributes->links('pagination::bootstrap-4') }}
</div>
@endsection