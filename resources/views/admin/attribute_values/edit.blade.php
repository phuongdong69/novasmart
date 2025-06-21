@extends('admin.layouts.body')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <h6 class="dark:text-white text-lg font-semibold">Chỉnh sửa giá trị thuộc tính: {{ $attributeValue->value }}</h6>

  <form action="{{ route('admin.attribute-values.update', $attributeValue->id) }}" method="POST" class="p-6">
    @csrf
    @method('PUT')

    <!-- Chọn thuộc tính -->
    <div class="mb-4">
      <label for="attribute_id" class="block text-sm font-medium text-gray-700">Thuộc tính</label>
      <select name="attribute_id" id="attribute_id" class="form-control">
        @foreach ($attributes as $attribute)
          <option value="{{ $attribute->id }}" {{ $attribute->id == $attributeValue->attribute_id ? 'selected' : '' }}>{{ $attribute->name }}</option>
        @endforeach
      </select>
      @error('attribute_id')
        <p class="text-red-600 text-sm mt-1 mb-1 font-semibold">{{ $message }}</p>
      @enderror
    </div>

    <!-- Giá trị thuộc tính -->
    <div class="mb-4">
      <label for="value" class="block text-sm font-medium text-gray-700">Giá trị thuộc tính</label>
      <input type="text" name="value" id="value" class="border border-gray-300 rounded-md shadow-sm w-full px-3 py-2 mt-0 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập giá trị" value="{{ old('value', $attributeValue->value) }}">
      @error('value')
        <p class="text-red-600 text-sm mt-1 mb-1 font-semibold">{{ $message }}</p>
      @enderror
    </div>

    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">Cập nhật giá trị thuộc tính</button>
  </form>
</div>
@endsection
