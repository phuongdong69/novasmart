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
          <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md mb-4">{{ session('success') }}</div>
          @endif
          @if (session('error'))
          <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md mb-4">{{ session('error') }}</div>
          @endif
        </div>
        {{-- Form --}}
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="px-6 pt-4 pb-6">
          @csrf
          @method('PATCH')
          {{-- Tên sản phẩm --}}
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-slate-600 mb-2">Tên sản phẩm</label>
            <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('name') border-red-500 @enderror" placeholder="Nhập tên sản phẩm" value="{{ old('name', $product->name) }}">
            @error('name')
            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          {{-- Thương hiệu --}}
          <div class="mb-4">
            <label for="brand_id" class="block text-sm font-medium text-slate-600 mb-2">Thương hiệu</label>
            <select name="brand_id" id="brand_id" class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('brand_id') border-red-500 @enderror">
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
            <select name="origin_id" id="origin_id" class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('origin_id') border-red-500 @enderror">
              @foreach($origins as $origin)
                <option value="{{ $origin->id }}" {{ $product->origin_id == $origin->id ? 'selected' : '' }}>
                    {{ $origin->name ?? $origin->country ?? 'Không rõ' }}
                </option>
              @endforeach
            </select>
            @error('origin_id')
            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          {{-- Danh mục --}}
          <div class="mb-4">
            <label for="category_id" class="block text-sm font-medium text-slate-600 mb-2">Danh mục</label>
            <select name="category_id" id="category_id" class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('category_id') border-red-500 @enderror">
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
            <textarea name="description" id="description" rows="4" class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('description') border-red-500 @enderror" placeholder="Nhập mô tả">{{ old('description', $product->description) }}</textarea>
            @error('description')
            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
          </div>
          {{-- Ảnh sản phẩm mới --}}
          <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-slate-600 mb-2">Ảnh sản phẩm mới</label>
            <input type="file" class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" id="image" name="image" accept="image/*">
            @php
              $primaryThumbnail = $product->thumbnails->where('is_primary', 1)->first();
            @endphp
            @if($primaryThumbnail)
              <div class="mt-2">
                <label class="block text-sm font-medium text-slate-600 mb-2">Ảnh chính hiện tại</label>
                <img src="{{ asset('storage/' . $primaryThumbnail->url) }}" alt="Ảnh sản phẩm" style="width: 80px; height: 80px; object-fit: cover; border-radius: 0.375rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div style="width: 80px; height: 80px; background-color: #f3f4f6; border-radius: 0.375rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); display: none; align-items: center; justify-content: center;">
                  <span style="color: #6b7280; font-size: 0.875rem;">Không có ảnh</span>
                </div>
              </div>
            @endif
          </div>
          {{-- Trạng thái --}}
          <div class="mb-4">
            <label class="block text-sm font-medium text-slate-600 mb-2">Trạng thái</label>
            <select name="status_code" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                @foreach($statuses as $status)
                    <option value="{{ $status->code }}" {{ $product->status_code == $status->code ? 'selected' : '' }}>{{ $status->name }}</option>
                @endforeach
            </select>
          </div>
          {{-- Buttons --}}
          <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 16px; border-top: 1px solid #e5e7eb;">
            <button type="submit" style="padding: 8px 24px; background-color: #2563eb; color: white; border-radius: 8px; font-weight: 600; border: none; cursor: pointer; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor='#2563eb'">Cập nhật</button>
            <a href="{{ route('admin.products.index') }}" style="padding: 8px 24px; background-color: #9ca3af; color: white; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-block; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#6b7280'" onmouseout="this.style.backgroundColor='#9ca3af'">Quay lại</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
