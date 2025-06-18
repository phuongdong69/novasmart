@extends('layouts.body')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
      <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

        <!-- Header -->
        <div class="p-6 pb-0 mb-0 border-b border-b-solid rounded-t-2xl border-b-slate-200 flex items-center justify-between">
          <h6 class="dark:text-white text-lg font-semibold">Thêm mới sản phẩm</h6>
          <a href="{{ route('admin.products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold py-2 px-4 rounded">
            ← Quay lại
          </a>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.products.store') }}" method="POST" class="p-6">
          @csrf

          <!-- Tên sản phẩm -->
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Tên sản phẩm</label>
            <input type="text" name="name" id="name" class="border border-gray-300 rounded-md shadow-sm w-full px-3 py-2 mt-0 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập tên sản phẩm" value="{{ old('name') }}" required>
            @error('name')
              <p class="text-red-600 text-sm mt-1 mb-1 font-semibold">{{ $message }}</p>
            @enderror
          </div>

          <!-- Mô tả sản phẩm -->
          <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Mô tả sản phẩm</label>
            <textarea name="description" id="description" class="border border-gray-300 rounded-md shadow-sm w-full px-3 py-2 mt-0 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Mô tả chi tiết sản phẩm">{{ old('description') }}</textarea>
            @error('description')
              <p class="text-red-600 text-sm mt-1 mb-1 font-semibold">{{ $message }}</p>
            @enderror
          </div>

          <!-- Danh mục -->
          <div class="mb-4">
            <label for="category_id" class="block text-sm font-medium text-gray-700">Danh mục</label>
            <select name="category_id" id="category_id" class="border border-gray-300 rounded-md shadow-sm w-full px-3 py-2 mt-0 focus:outline-none focus:ring-2 focus:ring-blue-500">
              @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
              @endforeach
            </select>
            @error('category_id')
              <p class="text-red-600 text-sm mt-1 mb-1 font-semibold">{{ $message }}</p>
            @enderror
          </div>

          <!-- Thương hiệu -->
          <div class="mb-4">
            <label for="brand_id" class="block text-sm font-medium text-gray-700">Thương hiệu</label>
            <select name="brand_id" id="brand_id" class="border border-gray-300 rounded-md shadow-sm w-full px-3 py-2 mt-0 focus:outline-none focus:ring-2 focus:ring-blue-500">
              @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
              @endforeach
            </select>
            @error('brand_id')
              <p class="text-red-600 text-sm mt-1 mb-1 font-semibold">{{ $message }}</p>
            @enderror
          </div>

          <!-- Xuất xứ -->
          <div class="mb-4">
            <label for="origin_id" class="block text-sm font-medium text-gray-700">Xuất xứ</label>
            <select name="origin_id" id="origin_id" class="border border-gray-300 rounded-md shadow-sm w-full px-3 py-2 mt-0 focus:outline-none focus:ring-2 focus:ring-blue-500">
              @foreach ($origins as $origin)
                <option value="{{ $origin->id }}" {{ old('origin_id') == $origin->id ? 'selected' : '' }}>{{ $origin->country }}</option>
              @endforeach
            </select>
            @error('origin_id')
              <p class="text-red-600 text-sm mt-1 mb-1 font-semibold">{{ $message }}</p>
            @enderror
          </div>

          <!-- Tab Navigation -->
          <ul class="nav nav-tabs" id="productTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="info-tab" data-bs-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="true">Thông tin sản phẩm</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="variants-tab" data-bs-toggle="tab" href="#variants" role="tab" aria-controls="variants" aria-selected="false">Biến thể sản phẩm</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="attributes-tab" data-bs-toggle="tab" href="#attributes" role="tab" aria-controls="attributes" aria-selected="false">Thuộc tính biến thể</a>
            </li>
          </ul>

          <!-- Tab Content -->
          <div class="tab-content mt-3" id="productTabsContent">
            <!-- Tab: Thông tin sản phẩm -->
            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
              <h5 class="mb-3">Thông tin sản phẩm</h5>
            </div>

            <!-- Tab: Biến thể sản phẩm -->
            <div class="tab-pane fade" id="variants" role="tabpanel" aria-labelledby="variants-tab">
              <h5 class="mb-3">Biến thể sản phẩm</h5>
              <div id="variants">
                @include('admin.products.variant_form', ['i' => 0, 'variant' => null])
              </div>
              <button type="button" id="add-variant-btn" class="btn btn-outline-primary btn-sm">+ Thêm biến thể</button>
            </div>

            <!-- Tab: Thuộc tính biến thể -->
            <div class="tab-pane fade" id="attributes" role="tabpanel" aria-labelledby="attributes-tab">
              <h5 class="mb-3">Thuộc tính biến thể</h5>
            </div>
          </div>

          <!-- Nút lưu và quay lại -->
          <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded mt-3">Lưu sản phẩm</button>
          <a href="{{ route('admin.products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold py-2 px-4 rounded mt-3 ml-2">
            Quay lại
          </a>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection
