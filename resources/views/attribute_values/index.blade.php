@extends('admin.layouts.body')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <h6 class="dark:text-white text-lg font-semibold">Danh sách giá trị thuộc tính</h6>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Thuộc tính</th>
        <th>Giá trị</th>
        <th>Thao tác</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($attributeValues as $value)
        <tr>
          <td>{{ $value->id }}</td>
          <td>{{ $value->attribute->name }}</td>
          <td>{{ $value->value }}</td>
          <td>
            <a href="{{ route('admin.attribute-values.edit', $value->id) }}" class="text-blue-600">Sửa</a>
            <form action="{{ route('admin.attribute-values.destroy', $value->id) }}" method="POST" class="inline-block">
              @csrf @method('DELETE')
              <button type="submit" onclick="return confirm('Xác nhận xoá?')" class="text-red-500">Xoá</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  {{ $attributeValues->links('pagination::bootstrap-4') }}
</div>
@endsection
