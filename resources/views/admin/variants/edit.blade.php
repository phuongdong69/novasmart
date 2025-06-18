@extends('admin.layouts.body')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <h6 class="dark:text-white text-lg font-semibold">Chỉnh sửa biến thể sản phẩm: {{ $product->name }}</h6>

  <form action="{{ route('admin.product-variants.update', $productVariant->id) }}" method="POST" class="p-6">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="name" class="block text-sm font-medium text-gray-700">Tên biến thể</label>
      <input type="text" name="name" id="name" class="border border-gray-300 rounded-md shadow-sm w-full px-3 py-2 mt-0 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập tên biến thể" value="{{ old('name', $productVariant->name) }}">
      @error('name')
        <p class="text-red-600 text-sm mt-1 mb-1 font-semibold">{{ $message }}</p>
      @enderror
    </div>

    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
      Cập nhật biến thể
    </button>
  </form>

</div>
@endsection
