@extends('layouts.body')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <h6 class="dark:text-white text-lg font-semibold">Chỉnh sửa sản phẩm: {{ $product->name }}</h6>

  <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Thông tin sản phẩm -->
    <div class="mb-3">
      <label>Tên sản phẩm</label>
      <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
    </div>

    <div class="mb-3">
      <label>Mô tả sản phẩm</label>
      <textarea name="description" class="form-control">{{ $product->description }}</textarea>
    </div>

    <div class="mb-3">
      <label>Danh mục</label>
      <select name="category_id" class="form-control">
        @foreach ($categories as $category)
          <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label>Thương hiệu</label>
      <select name="brand_id" class="form-control">
        @foreach ($brands as $brand)
          <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label>Xuất xứ</label>
      <select name="origin_id" class="form-control">
        @foreach ($origins as $origin)
          <option value="{{ $origin->id }}" {{ $product->origin_id == $origin->id ? 'selected' : '' }}>{{ $origin->country }}</option>
        @endforeach
      </select>
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
        <!-- Các trường thông tin sản phẩm đã điền ở trên -->
      </div>

      <!-- Tab: Biến thể sản phẩm -->
      <div class="tab-pane fade" id="variants" role="tabpanel" aria-labelledby="variants-tab">
        <h5 class="mb-3">Biến thể sản phẩm</h5>
        <div id="variants">
          @foreach ($product->variants as $i => $variant)
            @include('admin.products.variant_form', ['i' => $i, 'variant' => $variant])
          @endforeach
        </div>
        <button type="button" id="add-variant-btn" class="btn btn-outline-primary btn-sm">+ Thêm biến thể</button>
      </div>

      <!-- Tab: Thuộc tính biến thể -->
      <div class="tab-pane fade" id="attributes" role="tabpanel" aria-labelledby="attributes-tab">
        <h5 class="mb-3">Thuộc tính biến thể</h5>
        @foreach ($attributes as $attribute)
          <div class="mb-2">
            <label>{{ $attribute->name }}</label>
            <select name="attributes[{{ $attribute->id }}]" class="form-control">
              @foreach ($attribute->values as $value)
                <option value="{{ $value->id }}"
                  @if ($product->variantAttributes->contains('attribute_value_id', $value->id)) selected @endif>
                  {{ $value->value }}
                </option>
              @endforeach
            </select>
          </div>
        @endforeach
      </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Cập nhật sản phẩm</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
  </form>
</div>



@endsection
