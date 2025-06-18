@extends('admin.layouts.body')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
      <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

        <!-- Header -->
        <div class="p-6 pb-0 mb-0 border-b border-b-solid rounded-t-2xl border-b-slate-200 flex items-center justify-between">
          <h6 class="dark:text-white text-lg font-semibold">Thêm mới biến thể cho sản phẩm: {{ $product->name }}</h6>
          <a href="{{ route('admin.products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold py-2 px-4 rounded mt-3 ml-2"> ← Quay lại</a>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.product-variants.store') }}" method="POST" class="p-6">
          @csrf

          <!-- Truyền productId vào form -->
          <input type="hidden" name="product_id" value="{{ $product->id }}">

          <!-- SKU -->
          <div class="mb-4">
            <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
            <input type="text" name="sku" id="sku" class="border border-gray-300 rounded-md shadow-sm w-full px-3 py-2 mt-0 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập SKU" value="{{ old('sku') }}">
            @error('sku')
              <p class="text-red-600 text-sm mt-1 mb-1 font-semibold">{{ $message }}</p>
            @enderror
          </div>

          <!-- Price -->
          <div class="mb-4">
            <label for="price" class="block text-sm font-medium text-gray-700">Giá </label>
            <input type="number" name="price" id="price" class="border border-gray-300 rounded-md shadow-sm w-full px-3 py-2 mt-0 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập giá biến thể" value="{{ old('price') }}">
            @error('price')
              <p class="text-red-600 text-sm mt-1 mb-1 font-semibold">{{ $message }}</p>
            @enderror
          </div>

          <!-- Quantity -->
          <div class="mb-4">
            <label for="quantity" class="block text-sm font-medium text-gray-700">Số lượng</label>
            <input type="number" name="quantity" id="quantity" class="border border-gray-300 rounded-md shadow-sm w-full px-3 py-2 mt-0 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập số lượng" value="{{ old('quantity') }}">
            @error('quantity')
              <p class="text-red-600 text-sm mt-1 mb-1 font-semibold">{{ $message }}</p>
            @enderror
          </div>

          <!-- Status -->
          <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái</label>
            <select name="status" id="status" class="form-control">
              <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Kích hoạt</option>
              <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>Tắt</option>
            </select>
            @error('status')
              <p class="text-red-600 text-sm mt-1 mb-1 font-semibold">{{ $message }}</p>
            @enderror
          </div>

          <!-- Save and Go back buttons -->
          <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded mt-3">Lưu biến thể</button>
          
        </form>

      </div>
    </div>
  </div>
</div>
@endsection
