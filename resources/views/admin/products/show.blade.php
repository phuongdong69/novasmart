@extends('admin.layouts.body')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  @if ($product)
    <div class="flex flex-wrap -mx-3">
      <div class="flex-none w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

          <div class="p-6 pb-0 mb-0 border-b border-b-solid rounded-t-2xl border-b-slate-200 flex items-center justify-between">
            <h6 class="dark:text-white text-lg font-semibold">Chi tiết sản phẩm: {{ $product->name }}</h6>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold py-2 px-4 rounded">
              ← Quay lại
            </a>
          </div>

          <!-- Thông tin sản phẩm -->
          <div class="p-6">
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Tên sản phẩm</label>
              <p class="text-gray-800">{{ $product->name }}</p>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Mô tả sản phẩm</label>
              <p class="text-gray-800">{{ $product->description }}</p>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Danh mục</label>
              <p class="text-gray-800">{{ $product->category->name ?? 'Chưa có danh mục' }}</p>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Thương hiệu</label>
              <p class="text-gray-800">{{ $product->brand->name ?? 'Chưa có thương hiệu' }}</p>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Xuất xứ</label>
              <p class="text-gray-800">{{ $product->origin->country ?? 'Chưa có xuất xứ' }}</p>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Ngày tạo</label>
              <p class="text-gray-800">{{ $product->created_at->format('d/m/Y') }}</p>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Ngày cập nhật</label>
              <p class="text-gray-800">{{ $product->updated_at->format('d/m/Y') }}</p>
            </div>

          </div>

        </div>
      </div>
    </div>
  @else
    <p class="text-red-600">Không tìm thấy thông tin sản phẩm.</p>
  @endif
</div>
@endsection
