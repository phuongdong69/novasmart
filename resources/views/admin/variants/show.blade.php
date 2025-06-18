@extends('admin.layouts.body')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <h6 class="dark:text-white text-lg font-semibold">Thông tin biến thể sản phẩm: {{ $productVariant->name }}</h6>

  <div class="p-6">
    <div class="mb-3">
      <strong>Tên biến thể:</strong> {{ $productVariant->name }}
    </div>

    <a href="{{ route('admin.product-variants.index', $productVariant->product_id) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold py-2 px-4 rounded">
      ← Quay lại
    </a>
  </div>
</div>
@endsection
