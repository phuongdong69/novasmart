@php
    // Lấy dữ liệu cho filter từ database
    $brands = \App\Models\Brand::all();
    $origins = \App\Models\Origin::all();
    $attributes = \App\Models\Attribute::with('values')->get();

    // Lấy các thuộc tính cụ thể
    $colorAttribute = $attributes->where('name', 'like', '%màu%')->first();
    $screenAttribute = $attributes->where('name', 'like', '%màn hình%')->first();
    $ramAttribute = $attributes->where('name', 'like', '%RAM%')->first();
    $storageAttribute = $attributes->where('name', 'like', '%lưu trữ%')->first();
@endphp

<div class="lg:col-span-3 md:col-span-4">
    <div class="sticky top-20">
        <h5
            class="text-lg font-semibold bg-gray-50 dark:bg-slate-800 shadow dark:shadow-gray-800 rounded-md p-2 text-center">
            Bộ lọc</h5>

        <form id="filterForm" method="GET" action="{{ request()->url() }}">
            <!-- Tìm kiếm -->
            <div class="mt-4">
                <h5 class="font-medium">Tìm kiếm:</h5>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    placeholder="Nhập tên sản phẩm..."
                    class="w-full mt-2 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Thương hiệu -->
            @if ($brands->count() > 0)
                <div class="mt-4">
                    <h5 class="font-medium">Thương hiệu:</h5>
                    <ul class="list-none mt-2 space-y-1">
                        @foreach ($brands as $brand)
                            <li>
                                <label class="flex items-center">
                                    <input type="checkbox" name="brand[]" value="{{ $brand->name }}"
                                        {{ (is_array(request('brand')) && in_array($brand->name, request('brand'))) || request('brand') == $brand->name ? 'checked' : '' }}
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 mr-2">
                                    {{ $brand->name }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Màu sắc -->
            @if ($colorAttribute && $colorAttribute->values->count() > 0)
                <div class="mt-4">
                    <h5 class="font-medium">Màu sắc:</h5>
                    <ul class="list-none mt-2 flex flex-wrap gap-2">
                        @foreach ($colorAttribute->values as $color)
                            <li>
                                <a href="#"
                                    class="size-6 rounded-full ring-2 ring-gray-200 dark:ring-slate-800 bg-{{ $color->value }}-600 inline-flex align-middle {{ request('color') == $color->value ? 'ring-blue-500' : '' }}"
                                    title="{{ $color->value }}" onclick="selectColor('{{ $color->value }}')"></a>
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="color" id="colorInput" value="{{ request('color') }}">
                </div>
            @endif

            <!-- Kích thước màn hình -->
            @if ($screenAttribute && $screenAttribute->values->count() > 0)
                <div class="mt-4">
                    <h5 class="font-medium">Kích thước màn hình:</h5>
                    <ul class="list-none mt-2 flex flex-wrap gap-2">
                        @foreach ($screenAttribute->values as $screen)
                            <li>
                                <a href="#"
                                    class="size-7 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-gray-50 hover:border-slate-900 dark:hover:border-gray-100 hover:text-white dark:hover:text-slate-900 hover:bg-slate-900 dark:hover:bg-slate-100 {{ request('screen_size') == $screen->value ? 'bg-slate-900 text-white' : '' }}"
                                    onclick="selectSize('{{ $screen->value }}')">{{ $screen->value }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="screen_size" id="screenSizeInput" value="{{ request('screen_size') }}">
                </div>
            @endif

            <!-- RAM -->
            @if ($ramAttribute && $ramAttribute->values->count() > 0)
                <div class="mt-4">
                    <h5 class="font-medium">RAM:</h5>
                    <ul class="list-none mt-2 flex flex-wrap gap-2">
                        @foreach ($ramAttribute->values as $ram)
                            <li>
                                <a href="#"
                                    class="px-3 py-1 inline-flex items-center justify-center tracking-wide align-middle text-sm text-center rounded-md border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-gray-50 hover:border-slate-900 dark:hover:border-gray-100 hover:text-white dark:hover:text-slate-900 hover:bg-slate-900 dark:hover:bg-slate-100 {{ request('ram') == $ram->value ? 'bg-slate-900 text-white' : '' }}"
                                    onclick="selectRam('{{ $ram->value }}')">{{ $ram->value }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="ram" id="ramInput" value="{{ request('ram') }}">
                </div>
            @endif

            <!-- Lưu trữ -->
            @if ($storageAttribute && $storageAttribute->values->count() > 0)
                <div class="mt-4">
                    <h5 class="font-medium">Lưu trữ:</h5>
                    <ul class="list-none mt-2 flex flex-wrap gap-2">
                        @foreach ($storageAttribute->values as $storage)
                            <li>
                                <a href="#"
                                    class="px-3 py-1 inline-flex items-center justify-center tracking-wide align-middle text-sm text-center rounded-md border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-gray-50 hover:border-slate-900 dark:hover:border-gray-100 hover:text-white dark:hover:text-slate-900 hover:bg-slate-900 dark:hover:bg-slate-100 {{ request('storage') == $storage->value ? 'bg-slate-900 text-white' : '' }}"
                                    onclick="selectStorage('{{ $storage->value }}')">{{ $storage->value }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="storage" id="storageInput" value="{{ request('storage') }}">
                </div>
            @endif

            <!-- Xuất xứ -->
            @if ($origins->count() > 0)
                <div class="mt-4">
                    <h5 class="font-medium">Xuất xứ:</h5>
                    <select name="origin"
                        class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-slate-900 border border-gray-100 dark:border-gray-800">
                        <option value="">Tất cả</option>
                        @foreach ($origins as $origin)
                            <option value="{{ $origin->country }}"
                                {{ request('origin') == $origin->country ? 'selected' : '' }}>
                                {{ $origin->country }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Khoảng giá -->
            <div class="mt-4">
                <h5 class="font-medium">Khoảng giá:</h5>
                <div class="mt-2 space-y-2">
                    <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Giá từ"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Giá đến"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Nút lọc và xóa -->
            <div class="mt-6 space-y-2">
                <button type="submit"
                    class="w-full py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Áp dụng bộ lọc
                </button>
                <button type="button" onclick="clearFilters()"
                    class="w-full py-2 px-4 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Xóa bộ lọc
                </button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('assets/user/js/filter.js') }}"></script>
