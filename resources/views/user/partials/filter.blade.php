{{-- resources/views/user/filter.blade.php --}}
<div class="lg:col-span-3 md:col-span-4">
    <div class="rounded shadow-sm dark:shadow-gray-800 p-4 sticky top-20">
        <h5 class="text-xl font-medium">Bộ lọc</h5>

        <form method="GET" class="mt-4" id="filterForm">
            <!-- Tìm kiếm -->
            <div>
                <label for="search" class="font-medium">Tìm kiếm:</label>
                <div class="relative mt-2">
                    <i data-feather="search" class="absolute size-4 top-[9px] end-4"></i>
                    <input type="text" name="search" id="search" 
                        value="{{ request('search') }}"
                        class="h-9 pe-10 rounded px-3 bg-white dark:bg-slate-900 border border-gray-100 dark:border-gray-800 focus:ring-0 outline-none w-full" 
                        placeholder="Nhập tên sản phẩm...">
                </div>
            </div>

            <!-- Thương hiệu -->
            <div class="mt-4">
                <h5 class="font-medium">Thương hiệu:</h5>
                <ul class="list-none mt-2 space-y-1">
                    <li><label class="flex items-center"><input type="checkbox" name="brand[]" value="Apple" {{ in_array('Apple', request('brand', [])) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 mr-2"> Apple</label></li>
                    <li><label class="flex items-center"><input type="checkbox" name="brand[]" value="Samsung" {{ in_array('Samsung', request('brand', [])) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 mr-2"> Samsung</label></li>
                    <li><label class="flex items-center"><input type="checkbox" name="brand[]" value="Dell" {{ in_array('Dell', request('brand', [])) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 mr-2"> Dell</label></li>
                    <li><label class="flex items-center"><input type="checkbox" name="brand[]" value="HP" {{ in_array('HP', request('brand', [])) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 mr-2"> HP</label></li>
                    <li><label class="flex items-center"><input type="checkbox" name="brand[]" value="Lenovo" {{ in_array('Lenovo', request('brand', [])) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 mr-2"> Lenovo</label></li>
                    <li><label class="flex items-center"><input type="checkbox" name="brand[]" value="Asus" {{ in_array('Asus', request('brand', [])) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 mr-2"> Asus</label></li>
                </ul>
            </div>

            <!-- Màu sắc -->
            <div class="mt-4">
                <h5 class="font-medium">Màu sắc:</h5>
                <ul class="list-none mt-2 flex flex-wrap gap-2">
                    <li><a href="#" class="size-6 rounded-full ring-2 ring-gray-200 dark:ring-slate-800 bg-red-600 inline-flex align-middle {{ request('color') == 'red' ? 'ring-blue-500' : '' }}" title="Đỏ" onclick="selectColor('red')"></a></li>
                    <li><a href="#" class="size-6 rounded-full ring-2 ring-gray-200 dark:ring-slate-800 bg-indigo-600 inline-flex align-middle {{ request('color') == 'blue' ? 'ring-blue-500' : '' }}" title="Xanh dương" onclick="selectColor('blue')"></a></li>
                    <li><a href="#" class="size-6 rounded-full ring-2 ring-gray-200 dark:ring-slate-800 bg-emerald-600 inline-flex align-middle {{ request('color') == 'green' ? 'ring-blue-500' : '' }}" title="Xanh lá" onclick="selectColor('green')"></a></li>
                    <li><a href="#" class="size-6 rounded-full ring-2 ring-gray-200 dark:ring-slate-800 bg-slate-900 inline-flex align-middle {{ request('color') == 'black' ? 'ring-blue-500' : '' }}" title="Đen" onclick="selectColor('black')"></a></li>
                    <li><a href="#" class="size-6 rounded-full ring-2 ring-gray-200 dark:ring-slate-800 bg-gray-400 inline-flex align-middle {{ request('color') == 'gray' ? 'ring-blue-500' : '' }}" title="Xám" onclick="selectColor('gray')"></a></li>
                    <li><a href="#" class="size-6 rounded-full ring-2 ring-gray-200 dark:ring-slate-800 bg-orange-600 inline-flex align-middle {{ request('color') == 'orange' ? 'ring-blue-500' : '' }}" title="Cam" onclick="selectColor('orange')"></a></li>
                    <li><a href="#" class="size-6 rounded-full ring-2 ring-gray-200 dark:ring-slate-800 bg-violet-600 inline-flex align-middle {{ request('color') == 'purple' ? 'ring-blue-500' : '' }}" title="Tím" onclick="selectColor('purple')"></a></li>
                </ul>
                <input type="hidden" name="color" id="colorInput" value="{{ request('color') }}">
            </div>

            <!-- Kích thước màn hình -->
            <div class="mt-4">
                <h5 class="font-medium">Kích thước màn hình:</h5>
                <ul class="list-none mt-2 flex flex-wrap gap-2">
                    <li><a href="#" class="size-7 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-gray-50 hover:border-slate-900 dark:hover:border-gray-100 hover:text-white dark:hover:text-slate-900 hover:bg-slate-900 dark:hover:bg-slate-100 {{ request('screen_size') == '13' ? 'bg-slate-900 text-white' : '' }}" onclick="selectSize('13')">13"</a></li>
                    <li><a href="#" class="size-7 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-gray-50 hover:border-slate-900 dark:hover:border-gray-100 hover:text-white dark:hover:text-slate-900 hover:bg-slate-900 dark:hover:bg-slate-100 {{ request('screen_size') == '14' ? 'bg-slate-900 text-white' : '' }}" onclick="selectSize('14')">14"</a></li>
                    <li><a href="#" class="size-7 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-gray-50 hover:border-slate-900 dark:hover:border-gray-100 hover:text-white dark:hover:text-slate-900 hover:bg-slate-900 dark:hover:bg-slate-100 {{ request('screen_size') == '15' ? 'bg-slate-900 text-white' : '' }}" onclick="selectSize('15')">15"</a></li>
                    <li><a href="#" class="size-7 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-gray-50 hover:border-slate-900 dark:hover:border-gray-100 hover:text-white dark:hover:text-slate-900 hover:bg-slate-900 dark:hover:bg-slate-100 {{ request('screen_size') == '16' ? 'bg-slate-900 text-white' : '' }}" onclick="selectSize('16')">16"</a></li>
                    <li><a href="#" class="w-10 h-7 inline-flex items-center justify-center tracking-wide align-middle text-base text-center rounded-md border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-gray-50 hover:border-slate-900 dark:hover:border-gray-100 hover:text-white dark:hover:text-slate-900 hover:bg-slate-900 dark:hover:bg-slate-100 {{ request('screen_size') == '17' ? 'bg-slate-900 text-white' : '' }}" onclick="selectSize('17')">17"</a></li>
                </ul>
                <input type="hidden" name="screen_size" id="screenSizeInput" value="{{ request('screen_size') }}">
            </div>

            <!-- RAM -->
            <div class="mt-4">
                <h5 class="font-medium">RAM:</h5>
                <ul class="list-none mt-2 flex flex-wrap gap-2">
                    <li><a href="#" class="px-3 py-1 inline-flex items-center justify-center tracking-wide align-middle text-sm text-center rounded-md border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-gray-50 hover:border-slate-900 dark:hover:border-gray-100 hover:text-white dark:hover:text-slate-900 hover:bg-slate-900 dark:hover:bg-slate-100 {{ request('ram') == '8gb' ? 'bg-slate-900 text-white' : '' }}" onclick="selectRam('8gb')">8GB</a></li>
                    <li><a href="#" class="px-3 py-1 inline-flex items-center justify-center tracking-wide align-middle text-sm text-center rounded-md border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-gray-50 hover:border-slate-900 dark:hover:border-gray-100 hover:text-white dark:hover:text-slate-900 hover:bg-slate-900 dark:hover:bg-slate-100 {{ request('ram') == '16gb' ? 'bg-slate-900 text-white' : '' }}" onclick="selectRam('16gb')">16GB</a></li>
                    <li><a href="#" class="px-3 py-1 inline-flex items-center justify-center tracking-wide align-middle text-sm text-center rounded-md border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-gray-50 hover:border-slate-900 dark:hover:border-gray-100 hover:text-white dark:hover:text-slate-900 hover:bg-slate-900 dark:hover:bg-slate-100 {{ request('ram') == '32gb' ? 'bg-slate-900 text-white' : '' }}" onclick="selectRam('32gb')">32GB</a></li>
                    <li><a href="#" class="px-3 py-1 inline-flex items-center justify-center tracking-wide align-middle text-sm text-center rounded-md border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-gray-50 hover:border-slate-900 dark:hover:border-gray-100 hover:text-white dark:hover:text-slate-900 hover:bg-slate-900 dark:hover:bg-slate-100 {{ request('ram') == '64gb' ? 'bg-slate-900 text-white' : '' }}" onclick="selectRam('64gb')">64GB</a></li>
                </ul>
                <input type="hidden" name="ram" id="ramInput" value="{{ request('ram') }}">
            </div>

            <!-- Lưu trữ -->
            <div class="mt-4">
                <h5 class="font-medium">Lưu trữ:</h5>
                <ul class="list-none mt-2 flex flex-wrap gap-2">
                    <li><a href="#" class="px-3 py-1 inline-flex items-center justify-center tracking-wide align-middle text-sm text-center rounded-md border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-gray-50 hover:border-slate-900 dark:hover:border-gray-100 hover:text-white dark:hover:text-slate-900 hover:bg-slate-900 dark:hover:bg-slate-100 {{ request('storage') == '256gb' ? 'bg-slate-900 text-white' : '' }}" onclick="selectStorage('256gb')">256GB</a></li>
                    <li><a href="#" class="px-3 py-1 inline-flex items-center justify-center tracking-wide align-middle text-sm text-center rounded-md border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-gray-50 hover:border-slate-900 dark:hover:border-gray-100 hover:text-white dark:hover:text-slate-900 hover:bg-slate-900 dark:hover:bg-slate-100 {{ request('storage') == '512gb' ? 'bg-slate-900 text-white' : '' }}" onclick="selectStorage('512gb')">512GB</a></li>
                    <li><a href="#" class="px-3 py-1 inline-flex items-center justify-center tracking-wide align-middle text-sm text-center rounded-md border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-gray-50 hover:border-slate-900 dark:hover:border-gray-100 hover:text-white dark:hover:text-slate-900 hover:bg-slate-900 dark:hover:bg-slate-100 {{ request('storage') == '1tb' ? 'bg-slate-900 text-white' : '' }}" onclick="selectStorage('1tb')">1TB</a></li>
                    <li><a href="#" class="px-3 py-1 inline-flex items-center justify-center tracking-wide align-middle text-sm text-center rounded-md border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-gray-50 hover:border-slate-900 dark:hover:border-gray-100 hover:text-white dark:hover:text-slate-900 hover:bg-slate-900 dark:hover:bg-slate-100 {{ request('storage') == '2tb' ? 'bg-slate-900 text-white' : '' }}" onclick="selectStorage('2tb')">2TB</a></li>
                </ul>
                <input type="hidden" name="storage" id="storageInput" value="{{ request('storage') }}">
            </div>

            <!-- Xuất xứ -->
            <div class="mt-4">
                <h5 class="font-medium">Xuất xứ:</h5>
                <select name="origin" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-slate-900 border border-gray-100 dark:border-gray-800">
                    <option value="">Tất cả</option>
                    <option value="Trung Quốc" {{ request('origin') == 'Trung Quốc' ? 'selected' : '' }}>Trung Quốc</option>
                    <option value="Hàn Quốc" {{ request('origin') == 'Hàn Quốc' ? 'selected' : '' }}>Hàn Quốc</option>
                    <option value="Nhật Bản" {{ request('origin') == 'Nhật Bản' ? 'selected' : '' }}>Nhật Bản</option>
                    <option value="Mỹ" {{ request('origin') == 'Mỹ' ? 'selected' : '' }}>Mỹ</option>
                    <option value="Malaysia" {{ request('origin') == 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
                    <option value="Thái Lan" {{ request('origin') == 'Thái Lan' ? 'selected' : '' }}>Thái Lan</option>
                </select>
            </div>

            <!-- Khoảng giá -->
            <div class="mt-4">
                <h5 class="font-medium">Khoảng giá (VNĐ):</h5>
                <div class="space-y-2 mt-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Từ:</label>
                        <input type="number" name="price_min" value="{{ request('price_min') }}" 
                               placeholder="0" min="0" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-slate-900 border border-gray-100 dark:border-gray-800">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Đến:</label>
                        <input type="number" name="price_max" value="{{ request('price_max') }}" 
                               placeholder="100000000" min="0" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-slate-900 border border-gray-100 dark:border-gray-800">
                    </div>
                </div>
            </div>

            <!-- Nút hành động -->
            <div class="mt-6 space-y-2">
                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Áp dụng bộ lọc
                </button>
                <button type="button" onclick="clearFilters()" 
                        class="w-full bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Xóa bộ lọc
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function selectColor(color) {
    document.getElementById('colorInput').value = color;
    document.getElementById('filterForm').submit();
}

function selectSize(size) {
    document.getElementById('screenSizeInput').value = size;
    document.getElementById('filterForm').submit();
}

function selectRam(ram) {
    document.getElementById('ramInput').value = ram;
    document.getElementById('filterForm').submit();
}

function selectStorage(storage) {
    document.getElementById('storageInput').value = storage;
    document.getElementById('filterForm').submit();
}

function clearFilters() {
    // Clear all inputs
    document.getElementById('search').value = '';
    document.getElementById('colorInput').value = '';
    document.getElementById('screenSizeInput').value = '';
    document.getElementById('ramInput').value = '';
    document.getElementById('storageInput').value = '';
    
    // Clear checkboxes
    document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
    
    // Clear selects
    document.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
    
    // Clear price inputs
    document.querySelectorAll('input[type="number"]').forEach(input => input.value = '');
    
    // Submit form
    document.getElementById('filterForm').submit();
}

// Auto submit when dropdown changes
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('select[name="origin"]').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
    
    // Auto submit when checkboxes change
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
});
</script>