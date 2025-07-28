@extends('admin.layouts.app')

@section('title', 'Danh sách sản phẩm')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
      <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

        {{-- Tiêu đề + Nút thêm mới --}}
        <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex justify-between items-center">
          <h3 class="dark:text-white text-lg font-semibold">Danh sách sản phẩm</h3>
          <a href="{{ route('admin.products.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
            + Thêm mới
          </a>
        </div>

        {{-- Thanh tìm kiếm --}}
        <div class="px-6 mt-4">
          <form method="GET" action="{{ route('admin.products.index') }}" class="flex justify-end items-center gap-2">
            <input
              type="search"
              name="keyword"
              class="border border-slate-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300"
              placeholder="Tìm theo tên sản phẩm..."
              value="{{ request('keyword') }}"
            >
            <button type="submit" class="text-sm px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
              Tìm
            </button>
          </form>
        </div>

        {{-- Bảng sản phẩm --}}
        <div class="flex-auto px-0 pt-4 pb-2">
          <div class="p-0 overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">SẢN PHẨM</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">THƯƠNG HIỆU</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">XUẤT XỨ</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">DANH MỤC</th>
                  <th class="px-6 py-3 text-center uppercase text-xs font-bold text-slate-400">TRẠNG THÁI</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">THAO TÁC</th>
                </tr>
              </thead>
              <tbody>
                @forelse($products as $product)
                  @php $thumbnail = $product->thumbnails->first(); @endphp
                  <tr class="border-b dark:border-white/40 hover:bg-gray-50 transition">
                    <td class="px-6 py-3">
                      <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                          @if($thumbnail)
                            <img class="h-10 w-10 rounded-full object-contain border border-gray-300 bg-white cursor-pointer" src="{{ asset('storage/' . $thumbnail->url) }}" alt="{{ $product->name }}" onclick="event.stopPropagation(); toggleVariants({{ $product->id }})">
                          @else
                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center border border-gray-300 cursor-pointer" onclick="event.stopPropagation(); toggleVariants({{ $product->id }})">
                              <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.67 0 8.99 2.222 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                              </svg>
                            </div>
                          @endif
                        </div>
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900 cursor-pointer" onclick="event.stopPropagation(); toggleVariants({{ $product->id }})">{{ $product->name }}</div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-3 text-sm">{{ $product->brand->name ?? 'Chưa có thương hiệu' }}</td>
                    <td class="px-6 py-3 text-sm">{{ $product->origin->country ?? 'Chưa có xuất xứ' }}</td>
                    <td class="px-6 py-3 text-sm">{{ $product->category->name ?? 'Chưa phân loại' }}</td>
                    <td class="px-6 py-3 text-sm text-center">
                      @php
                        $status = $product->status;
                      @endphp
                      <span class="px-2.5 py-1.4 text-xs rounded-1.8 font-bold uppercase leading-none text-white"
                        style="background-color: {{ $status->color ?? '#888' }};">
                        {{ $status->name ?? 'Chưa rõ' }}
                      </span>
                    </td>
                    <td class="px-6 py-3 text-sm">
                      <div class="flex items-center gap-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:underline">Sửa</a>
                        <a href="{{ route('admin.products.status_logs', $product->id) }}" class="text-green-600 hover:underline">Lịch sử</a>
                        <form action="{{ route('admin.products.toggleStatus', $product->id) }}" method="POST" class="inline">
                          @csrf
                          @method('PUT')
                          <button type="submit" class="text-yellow-600 hover:underline" title="{{ $product->status && $product->status->code === 'active' ? 'Deactivate' : 'Activate' }}">
                            Toggle
                          </button>
                        </form>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="text-red-600 hover:underline">Xóa</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                  <!-- Biến thể (ẩn/hiện khi click) -->
                  <tr id="variants-{{ $product->id }}" class="hidden">
                    <td colspan="6" class="px-6 py-4 bg-gray-50">
                      <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                          <thead>
                            <tr>
                              <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                              <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá</th>
                              <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng</th>
                              <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thuộc tính</th>
                              <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá trị thuộc tính</th>
                              <th class="px-6 py-3 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                            </tr>
                          </thead>
                          <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($product->variants as $variant)
                              @php $attrCount = isset($variant->variantAttributeValues) ? count($variant->variantAttributeValues) : 0; @endphp
                              @if($attrCount > 0)
                                @foreach($variant->variantAttributeValues as $i => $attrValue)
                                  <tr class="hover:bg-gray-50">
                                    @if($i == 0)
                                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" rowspan="{{ $attrCount }}">{{ $variant->sku }}</td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium" rowspan="{{ $attrCount }}">{{ number_format($variant->price, 0, ',', '.') }} ₫</td>
                                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" rowspan="{{ $attrCount }}">{{ $variant->quantity }}</td>
                                    @endif
                                    <td>{{ $attrValue->attributeValue->attribute->name ?? '' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $attrValue->attributeValue->value ?? '' }}</td>
                                    @if($i == 0)
                                      <td class="px-6 py-4 whitespace-nowrap" rowspan="{{ $attrCount }}">
                                        <span class="px-2.5 py-1.4 text-xs rounded-1.8 font-bold uppercase leading-none text-white"
                                          style="background-color: {{ $variant->status->color ?? '#888' }};">
                                          {{ $variant->status->name ?? 'Chưa rõ' }}
                                        </span>
                                      </td>
                                    @endif
                                  </tr>
                                @endforeach
                              @else
                                <tr class="hover:bg-gray-50">
                                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $variant->sku }}</td>
                                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ number_format($variant->price, 0, ',', '.') }} ₫</td>
                                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $variant->quantity }}</td>
                                  <td class="px-6 py-4 text-gray-400">Không có thuộc tính</td>
                                  <td class="px-6 py-4 text-gray-400">Không có giá trị</td>
                                  <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1.4 text-xs rounded-1.8 font-bold uppercase leading-none text-white"
                                      style="background-color: {{ $variant->status->color ?? '#888' }};">
                                      {{ $variant->status->name ?? 'Chưa rõ' }}
                                    </span>
                                  </td>
                                </tr>
                              @endif
                            @empty
                              <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                  Sản phẩm chưa có biến thể nào
                                </td>
                              </tr>
                            @endforelse
                          </tbody>
                        </table>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center py-4 text-sm text-gray-500">Không có dữ liệu nào trùng khớp.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-4 px-6">
              @if ($products->hasPages())
                <div style="display: flex; justify-content: center; gap: 8px; margin: 20px 0;">
                  @if ($products->onFirstPage())
                    <span style="padding: 8px 16px; background: #f3f4f6; color: #9ca3af; border-radius: 8px; cursor: not-allowed;">Trước</span>
                  @else
                    <a href="{{ $products->previousPageUrl() }}" style="padding: 8px 16px; background: white; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; transition: all 0.2s;">Trước</a>
                  @endif

                  @for ($i = 1; $i <= $products->lastPage(); $i++)
                    @if ($i == $products->currentPage())
                      <span style="padding: 8px 16px; background: #3b82f6; color: white; border-radius: 8px; font-weight: bold;">{{ $i }}</span>
                    @else
                      <a href="{{ $products->url($i) }}" style="padding: 8px 16px; background: white; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; transition: all 0.2s;">{{ $i }}</a>
                    @endif
                  @endfor

                  @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" style="padding: 8px 16px; background: white; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; transition: all 0.2s;">Tiếp</a>
                  @else
                    <span style="padding: 8px 16px; background: #f3f4f6; color: #9ca3af; border-radius: 8px; cursor: not-allowed;">Tiếp</span>
                  @endif
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
function toggleVariants(productId) {
    const el = document.getElementById('variants-' + productId);
    if (el) {
        el.classList.toggle('hidden');
    }
}
</script>
@endpush

@endsection