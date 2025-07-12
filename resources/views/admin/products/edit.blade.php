@extends('admin.layouts.app')
@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
      <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
        {{-- Header --}}
        <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex items-center justify-between">
          <h6 class="dark:text-white text-lg font-semibold">Cập nhật sản phẩm</h6>
          <a href="{{ route('admin.products.index') }}" class="border border-slate-400 text-slate-700 hover:bg-slate-100 hover:text-slate-900 text-sm font-medium py-2 px-4 rounded transition-all duration-150">← Quay lại</a>
        </div>
        {{-- Alerts --}}
        <div class="px-6 mt-4">
          @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
          @endif
          @if (session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
          @endif
        </div>
        {{-- Form --}}
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="px-6 pt-4 pb-6">
          @csrf
          @method('PUT')
          {{-- Tên sản phẩm --}}
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-slate-600 mb-2">Tên sản phẩm</label>
            <input type="text" name="name" id="name" class="form-input w-full border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('name') border-red-500 @enderror" placeholder="Nhập tên sản phẩm" value="{{ old('name', $product->name) }}">
            @error('name')
            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          {{-- Ảnh sản phẩm --}}
          @if($product->thumbnails && $product->thumbnails->count())
            <div class="flex flex-wrap gap-4 mb-4">
              @foreach($product->thumbnails as $thumb)
                <div>
                  <img src="{{ asset($thumb->url) }}" alt="Thumbnail" class="w-24 h-24 object-cover rounded shadow">
                  @if($thumb->is_primary)
                    <div class="text-xs text-blue-600 text-center mt-1">Ảnh chính</div>
                  @endif
                </div>
              @endforeach
            </div>
          @endif
          {{-- Thương hiệu --}}
          <div class="mb-4">
            <label for="brand_id" class="block text-sm font-medium text-slate-600 mb-2">Thương hiệu</label>
            <select name="brand_id" id="brand_id" class="form-input w-full border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('brand_id') border-red-500 @enderror">
              @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
              @endforeach
            </select>
            @error('brand_id')
            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          {{-- Xuất xứ --}}
          <div class="mb-4">
            <label for="origin_id" class="block text-sm font-medium text-slate-600 mb-2">Xuất xứ</label>
            <select name="origin_id" id="origin_id" class="form-input w-full border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('origin_id') border-red-500 @enderror">
              @foreach($origins as $origin)
                <option value="{{ $origin->id }}" {{ $product->origin_id == $origin->id ? 'selected' : '' }}>{{ $origin->name }}</option>
              @endforeach
            </select>
            @error('origin_id')
            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          {{-- Danh mục --}}
          <div class="mb-4">
            <label for="category_id" class="block text-sm font-medium text-slate-600 mb-2">Danh mục</label>
            <select name="category_id" id="category_id" class="form-input w-full border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('category_id') border-red-500 @enderror">
              @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
              @endforeach
            </select>
            @error('category_id')
            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          {{-- Mô tả --}}
          <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-slate-600 mb-2">Mô tả</label>
            <textarea name="description" id="description" rows="4" class="form-input w-full border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('description') border-red-500 @enderror" placeholder="Nhập mô tả">{{ old('description', $product->description) }}</textarea>
            @error('description')
            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          {{-- Ảnh sản phẩm --}}
          <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-slate-600 mb-2">Ảnh sản phẩm</label>
                            <input type="file" class="form-control" id="image" name="image">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Ảnh sản phẩm" class="img-thumbnail mt-2" width="120">
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
