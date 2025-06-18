@extends('admin.layouts.body')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <h6 class="dark:text-white text-lg font-semibold">Chỉnh sửa giá trị thuộc tính cho biến thể sản phẩm</h6>

  <form action="{{ route('admin.variant-attribute-values.update', $variantAttributeValue->id) }}" method="POST" class="p-6">
    @csrf
    @method('PUT')

    <!-- Chọn biến thể sản phẩm -->
    <div class="mb-4">
      <label for="product_variant_id" class="block text-sm font-medium text-gray-700">Biến thể sản phẩm</label>
      <select name="product_variant_id" id="product_variant_id" class="form-control">
        @foreach ($productVariants as $variant)
          <option value="{{ $variant->id }}" {{ $variant->id == $variantAttributeValue->product_variant_id ? 'selected' : '' }}>{{ $variant->sku }}</option>
        @endforeach
      </select>
    </div>

    <!-- Chọn thuộc tính -->
    <div class="mb-4">
      <label for="attribute_id" class="block text-sm font-medium text-gray-700">Thuộc tính</label>
      <select name="attribute_id" id="attribute_id" class="form-control">
        @foreach ($attributes as $attribute)
          <option value="{{ $attribute->id }}" {{ $attribute->id == $variantAttributeValue->attribute_id ? 'selected' : '' }}>{{ $attribute->name }}</option>
        @endforeach
      </select>
    </div>

    <!-- Chọn giá trị thuộc tính -->
    <div class="mb-4">
      <label for="attribute_value_id" class="block text-sm font-medium text-gray-700">Giá trị thuộc tính</label>
      <select name="attribute_value_id" id="attribute_value_id" class="form-control">
        @foreach ($attributeValues as $value)
          <option value="{{ $value->id }}" {{ $value->id == $variantAttributeValue->attribute_value_id ? 'selected' : '' }}>{{ $value->value }}</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">Cập nhật giá trị thuộc tính cho biến thể</button>
  </form>
</div>
@endsection
