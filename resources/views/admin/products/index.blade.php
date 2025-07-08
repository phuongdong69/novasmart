@extends('admin.layouts.app')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                {{-- Header --}}
                <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex justify-between items-center">
                    <h6 class="dark:text-white text-lg font-semibold">Danh sách sản phẩm</h6>
                    <a href="{{ route('admin.products.create') }}"
                       class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                        + Thêm mới
                    </a>
                </div>
                
                <!-- Product List -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input type="checkbox" class="rounded border-gray-300">
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SẢN PHẨM</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">THƯƠNG HIỆU</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">XUẤT XỨ</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DANH MỤC</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TRẠNG THÁI</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($products as $product)
@php $thumbnail = $product->thumbnails->first(); @endphp
<tr class="hover:bg-gray-50 cursor-pointer" onclick="toggleVariants({{ $product->id }})" style="transition: background 0.2s;">
    <td class="px-6 py-4 whitespace-nowrap">
        <input type="checkbox" class="rounded border-gray-300">
    </td>
    <td class="px-6 py-4">
        <div class="flex items-center">
            <div class="flex-shrink-0 h-10 w-10">
                @if($thumbnail)
                    <img class="h-10 w-10 rounded-full" src="{{ asset($thumbnail->url) }}" alt="{{ $product->name }}">
                @else
                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                        <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.67 0 8.99 2.222 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                @endif
            </div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $product->brand->name ?? 'Chưa có thương hiệu' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $product->origin->country ?? 'Chưa có xuất xứ' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $product->category->name ?? 'Chưa phân loại' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        @php
            $isActive = $product->status == 1;
        @endphp
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ $isActive ? 'Đang bán' : 'Ngừng bán' }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
            </a>
            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
        </div>
    </td>
</tr>
                                <!-- Biến thể (ẩn/hiện khi click) -->
                                <tr id="variants-{{ $product->id }}" class="hidden">
                                    <td colspan="7" class="px-6 py-4 bg-gray-50">
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
                                                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $attrValue->attribute->name ?? '' }}</td>
                                                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $attrValue->attributeValue->value ?? '' }}</td>
                                                                    @if($i == 0)
                                                                        <td class="px-6 py-4 whitespace-nowrap" rowspan="{{ $attrCount }}">
                                                                            @if($variant->status == 1)
                                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                                    Đang bán
                                                                                </span>
                                                                            @else
                                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                                    Ngừng bán
                                                                                </span>
                                                                            @endif
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
                                                                    @if($variant->status == 1)
                                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                            Đang bán
                                                                        </span>
                                                                    @else
                                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                            Ngừng bán
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                                                Sản phẩm chưa có biến thể nào
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Biến thể (ẩn/hiện khi click) -->
                                <tr id="variants-{{ $product->id }}" class="hidden">
                                    <td colspan="7" class="px-6 py-4 bg-gray-50">
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200 mb-2">
                                                <thead>
                                                    <tr>
                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thuộc tính</th>
                                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá trị thuộc tính</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @forelse($product->variants as $variant)
                                                        <tr>
                                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $variant->sku }}</td>
                                                            <td class="px-4 py-2 text-sm">
                                                                @if($variant->status == 1)
                                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Đang bán</span>
                                                                @else
                                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ngừng bán</span>
                                                                @endif
                                                            </td>
                                                            <td class="px-4 py-2 text-sm">
                                                                @include('admin.products.partials.variant-attributes', ['variant' => $variant])
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="px-4 py-2 text-center text-gray-400">Sản phẩm chưa có biến thể nào</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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

{{-- Styling is handled by Tailwind CSS --}}

@endsection