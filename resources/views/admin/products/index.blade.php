@extends('admin.layouts.app')

@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    {{-- Header --}}
                    <div
                        class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex justify-between items-center">
                        <h6 class="dark:text-white text-lg font-semibold">Danh sách sản phẩm</h6>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.products.create') }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                                + Thêm mới
                            </a>
                        </div>
                    </div>

                    <!-- Product List -->
                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <input type="checkbox" class="rounded border-gray-300">
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        SẢN PHẨM</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        THƯƠNG HIỆU</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        XUẤT XỨ</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        DANH MỤC</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        TRẠNG THÁI</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        THAO TÁC</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($products as $product)
                                    @php $thumbnail = $product->thumbnails->first(); @endphp
                                    <tr class="hover:bg-gray-50" style="transition: background 0.2s;">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox" class="rounded border-gray-300">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if ($thumbnail)
                                                        <img class="h-10 w-10 object-contain bg-white cursor-pointer"
                                                            src="{{ asset('storage/' . $thumbnail->url) }}"
                                                            alt="{{ $product->name }}"
                                                            onclick="event.stopPropagation(); toggleVariants({{ $product->id }})">
                                                    @else
                                                        <div class="h-10 w-10 bg-gray-200 flex items-center justify-center cursor-pointer"
                                                            onclick="event.stopPropagation(); toggleVariants({{ $product->id }})">
                                                            <svg class="h-6 w-6 text-gray-400" fill="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path
                                                                    d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.67 0 8.99 2.222 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 cursor-pointer"
                                                        onclick="event.stopPropagation(); toggleVariants({{ $product->id }})">
                                                        {{ $product->name }}</div>
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
                                                $status = $product->status;
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                style="background-color: {{ $status->color ?? '#888' }};">
                                                {{ $status->name ?? 'Chưa rõ' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                            <div class="flex justify-start space-x-2">
                                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('admin.products.status_logs', $product->id) }}"
                                                    class="text-blue-500 hover:text-blue-700 mr-2"
                                                    title="Lịch sử trạng thái">
                                                    <i class="fa fa-history"></i>
                                                </a>
                                                <form action="{{ route('admin.products.toggleStatus', $product->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="text-yellow-600 hover:text-yellow-900"
                                                        title="{{ $product->status && $product->status->code === 'active' ? 'Deactivate' : 'Activate' }}">
                                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd" />
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
                                                <table class="w-full divide-y divide-gray-200">
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                class="px-6 py-3 bg-gray-100 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                SKU</th>
                                                            <th
                                                                class="px-6 py-3 bg-gray-100 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Giá</th>
                                                            <th
                                                                class="px-6 py-3 bg-gray-100 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Số lượng</th>
                                                            <th
                                                                class="px-6 py-3 bg-gray-100 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Thuộc tính</th>
                                                            <th
                                                                class="px-6 py-3 bg-gray-100 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Giá trị thuộc tính</th>
                                                            <th
                                                                class="px-6 py-3 bg-gray-100 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Trạng thái</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        @forelse($product->variants as $variant)
                                                            @php $attrCount = isset($variant->variantAttributeValues) ? count($variant->variantAttributeValues) : 0; @endphp
                                                            @if ($attrCount > 0)
                                                                @foreach ($variant->variantAttributeValues as $i => $attrValue)
                                                                    <tr class="hover:bg-gray-50">
                                                                        @if ($i == 0)
                                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center"
                                                                                rowspan="{{ $attrCount }}">
                                                                                {{ $variant->sku }}</td>
                                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium text-center"
                                                                                rowspan="{{ $attrCount }}">
                                                                                {{ number_format($variant->price, 0, ',', '.') }}
                                                                                ₫</td>
                                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center"
                                                                                rowspan="{{ $attrCount }}">
                                                                                {{ $variant->quantity }}</td>
                                                                        @endif
                                                                        <td class="text-center">{{ $attrValue->attributeValue->attribute->name ?? '' }}
                                                                        </td>
                                                                        <td class="px-6 py-4 text-sm text-gray-500 text-center">
                                                                            {{ $attrValue->attributeValue->value ?? '' }}
                                                                        </td>
                                                                        @if ($i == 0)
                                                                            <td class="px-6 py-4 whitespace-nowrap text-center"
                                                                                rowspan="{{ $attrCount }}">
                                                                                @if ($variant->status && is_object($variant->status))
                                                                                    <span
                                                                                        class="inline-block px-2 py-1 rounded text-white text-xs font-semibold"
                                                                                        style="background-color: {{ $variant->status->color ?? '#888' }};">
                                                                                        {{ $variant->status->name }}
                                                                                    </span>
                                                                                @else
                                                                                    <span class="text-gray-400">Chưa
                                                                                        có</span>
                                                                                @endif
                                                                            </td>
                                                                        @endif
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr class="hover:bg-gray-50">
                                                                    <td
                                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                                                        {{ $variant->sku }}</td>
                                                                    <td
                                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium text-center">
                                                                        {{ number_format($variant->price, 0, ',', '.') }} ₫
                                                                    </td>
                                                                    <td
                                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                                        {{ $variant->quantity }}</td>
                                                                    <td class="px-6 py-4 text-gray-400 text-center">Không có thuộc tính
                                                                    </td>
                                                                    <td class="px-6 py-4 text-gray-400 text-center">Không có giá trị
                                                                    </td>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                                        @if ($variant->status && is_object($variant->status))
                                                                            <span
                                                                                class="inline-block px-2 py-1 rounded text-white text-xs font-semibold"
                                                                                style="background-color: {{ $variant->status->color ?? '#888' }};">
                                                                                {{ $variant->status->name }}
                                                                            </span>
                                                                        @else
                                                                            <span class="text-gray-400">Chưa có</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @empty
                                                            <tr>
                                                                <td colspan="5"
                                                                    class="px-6 py-4 text-center text-sm text-gray-500">
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
                                                            <th
                                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                SKU</th>
                                                            <th
                                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Trạng thái</th>
                                                            <th
                                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Thuộc tính</th>
                                                            <th
                                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Giá trị thuộc tính</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        @forelse($product->variants as $variant)
                                                            <tr>
                                                                <td class="px-4 py-2 text-sm text-gray-900">
                                                                    {{ $variant->sku }}</td>
                                                                <td class="px-4 py-2 text-sm">
                                                                    @if ($variant->status_id == 1)
                                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Đang bán</span>
                                                                @else
                                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ngừng bán</span>
                                                                @endif
                                                                </td>
                                                                <td class="px-4 py-2 text-sm">
                                                                    @include(
                                                                        'admin.products.partials.variant-attributes',
                                                                        ['variant' => $variant]
                                                                    )
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4"
                                                                    class="px-4 py-2 text-center text-gray-400">Sản phẩm
                                                                    chưa có biến thể nào</td>
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
            var PRODUCT_VARIANT_STATUSES = {!! json_encode(
                \App\Models\Status::where('type', 'product_variant')->orderBy('priority')->get(['id', 'name', 'color', 'priority']),
            ) !!};

            function toggleVariants(productId) {
                const el = document.getElementById('variants-' + productId);
                if (el) {
                    el.classList.toggle('hidden');
                }
            }

            function toggleStatusDropdown(el) {
                var select = el.parentElement.querySelector('.status-dropdown');
                if (select) {
                    select.classList.toggle('hidden');
                    select.focus();
                }
            }
            document.addEventListener('click', function(e) {
                document.querySelectorAll('.status-dropdown').forEach(function(drop) {
                    if (!drop.contains(e.target) && !drop.parentElement.querySelector('.status-badge').contains(
                            e.target)) {
                        drop.classList.add('hidden');
                    }
                });
            });
            document.querySelectorAll('.status-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var formData = new FormData(form);
                    var url = form.action;
                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                            },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success && data.status) {
                                var badge = form.querySelector('.status-badge');
                                badge.textContent = data.status.name;
                                badge.style.backgroundColor = data.status.color || '#888';
                                form.querySelector('.status-dropdown').classList.add('hidden');
                            }
                        });
                });
            });

            function changeVariantStatus(el, variantId) {
                var form = el.closest('form');
                var currentStatusId = parseInt(form.querySelector('input[name="status_id"]').value);
                var statuses = PRODUCT_VARIANT_STATUSES;
                var idx = statuses.findIndex(s => s.id === currentStatusId);
                var nextIdx = (idx >= 0 && idx < statuses.length - 1) ? idx + 1 : 0;
                var nextStatus = statuses[nextIdx];
                form.querySelector('input[name="status_id"]').value = nextStatus.id;
                var formData = new FormData(form);
                var url = form.action;
                console.log('Gửi đổi trạng thái:', {
                    variantId,
                    url,
                    nextStatusId: nextStatus.id
                });
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log('Kết quả trả về:', data);
                        if (data.success && data.status) {
                            el.textContent = data.status.name;
                            el.style.backgroundColor = data.status.color || '#888';
                            form.querySelector('input[name="status_id"]').value = data.status.id;
                        } else {
                            console.error('Lỗi đổi trạng thái:', data);
                        }
                    })
                    .catch(err => {
                        console.error('Lỗi fetch:', err);
                    });
            }
        </script>
    @endpush

    {{-- Styling is handled by Tailwind CSS --}}
@endsection
