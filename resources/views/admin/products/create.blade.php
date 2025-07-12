@extends('admin.layouts.app')
@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

                {{-- Header --}}
                <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex items-center justify-between">
                    <h6 class="dark:text-white text-lg font-semibold">Thêm sản phẩm mới</h6>
                    <a href="{{ route('admin.products.index') }}"
                        class="border border-slate-400 text-slate-700 hover:bg-slate-100 hover:text-slate-900 text-sm font-medium py-2 px-4 rounded transition-all duration-150">
                        ← Quay lại
                    </a>
                </div>

                {{-- Alerts --}}
                <div class="px-6 mt-4">
                    @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                    @endif
                </div>

                {{-- Form body --}}
                @if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('admin.products.store') }}" method="POST" class="px-6 pt-4 pb-6" enctype="multipart/form-data">
                    @csrf

                    {{-- Tên sản phẩm --}}
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-slate-600 mb-2">Tên sản phẩm</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                            required
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nhãn hiệu --}}
                    <div class="mb-4">
                        <label for="brand_id" class="block text-sm font-medium text-slate-600 mb-2">Nhãn hiệu</label>
                        <select name="brand_id" id="brand_id" class="w-full px-4 py-2 border border-gray-300 rounded-md mb-2" required>
                            <option value="">-- Chọn nhãn hiệu --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" @if(old('brand_id') == $brand->id) selected @endif>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Danh mục --}}
                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-slate-600 mb-2">Danh mục</label>
                        <select name="category_id" id="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-md mb-2" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @if(old('category_id') == $cat->id) selected @endif>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Xuất xứ --}}
                    <div class="mb-4">
                        <label for="origin_id" class="block text-sm font-medium text-slate-600 mb-2">Xuất xứ</label>
                        <select name="origin_id" id="origin_id" class="w-full px-4 py-2 border border-gray-300 rounded-md mb-2" required>
                            <option value="">-- Chọn xuất xứ --</option>
                            @foreach($origins as $origin)
                                <option value="{{ $origin->id }}" @if(old('origin_id') == $origin->id) selected @endif>{{ $origin->country }}</option>
                            @endforeach
                        </select>
                        @error('origin_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Ảnh chính (is_primary) --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-600 mb-2">Ảnh chính (hiển thị đại diện)</label>
                        <input type="file" name="thumbnail_primary" id="thumbnail_primary" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                        @error('thumbnail_primary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <div id="preview-thumbnail-primary" class="flex gap-2 mt-2"></div>
                    </div>

                    {{-- Ảnh phụ (gallery) --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-600 mb-2">Ảnh phụ</label>
                        <input type="file" name="thumbnails[]" id="thumbnails" multiple accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                        @error('thumbnails')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <div id="preview-thumbnails" class="flex flex-wrap gap-2 mt-2"></div>
                    </div>

                    {{-- Biến thể --}}

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-600 mb-2">Biến thể</label>
                        <div id="variants-container">
                            <div class="variant-item mb-4">
                                <div class="flex flex-row flex-wrap gap-4 items-end mb-2">
                                    <div class="flex-1 min-w-[120px]">
                                        <label class="block text-sm font-medium text-slate-600 mb-2">SKU</label>
                                        <input type="text" name="variants[0][sku]" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                                    </div>
                                    <div class="flex-1 min-w-[100px]">
                                        <label class="block text-sm font-medium text-slate-600 mb-2">Giá</label>
                                        <input type="number" name="variants[0][price]" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                                    </div>
                                    <div class="flex-1 min-w-[100px]">
                                        <label class="block text-sm font-medium text-slate-600 mb-2">Số lượng</label>
                                        <input type="number" name="variants[0][quantity]" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                                    </div>
                                </div>
                                <div class="attribute-container">
                                    <div class="attribute-item">
                                        <div class="flex flex-row flex-wrap gap-4 items-end mb-2">
                                            <div class="flex-1 min-w-[130px]">
                                                <label class="block text-sm font-medium text-slate-600 mb-2">Tên thuộc tính</label>
                                                <select name="variants[0][attributes][0][attribute_id]" class="w-full px-4 py-2 border border-gray-300 rounded-md attribute-select" onchange="handleAttributeSelect(this, 0, 0)">
                                                <option value="">-- Chọn thuộc tính --</option>
                                                @foreach($attributes as $attribute)
                                                    <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                                @endforeach
                                                <option value="__new__">+ Thêm mới thuộc tính</option>
                                            </select>
                                            <input type="text" name="variants[0][attributes][0][new_name]" class="w-full px-4 py-2 border border-blue-400 rounded-md mt-2 hidden" placeholder="Nhập tên thuộc tính mới...">
                                            </div>
                                            <div class="flex-1 min-w-[130px]">
                                                <label class="block text-sm font-medium text-slate-600 mb-2">Giá trị</label>
                                                <select name="variants[0][attributes][0][value]" class="w-full px-4 py-2 border border-gray-300 rounded-md value-select" data-attribute-index="0" onchange="handleValueSelect(this, 0, 0)">
                                                    <option value="">-- Chọn giá trị --</option>
                                                    <option value="__new__">+ Thêm mới giá trị</option>
                                                </select>
                                                <input type="text" name="variants[0][attributes][0][new_value]" class="w-full px-4 py-2 border border-blue-400 rounded-md mt-2 hidden value-new-input" placeholder="Nhập giá trị mới...">
                                            </div>
                                            <button type="button" class="px-2 py-1 bg-red-500 text-white rounded remove-attribute-btn" onclick="removeAttributeRow(this)">Xóa</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 add-attribute-btn" onclick="addAttribute(0)">Thêm thuộc tính</button>
                            </div>
                        </div>
                        <button type="button" onclick="addVariant()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Thêm biến thể</button>
                    </div>

                    {{-- Trạng thái --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-600 mb-2">Trạng thái</label>
                        <select
                            name="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror"
                        >
                            <option value="1">Đang bán</option>
                            <option value="0">Ngừng bán</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="mt-6">
                        <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Lưu sản phẩm
                        </button>
                    </div>
                <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Preview cho ảnh phụ
        const input = document.getElementById('thumbnails');
        const preview = document.getElementById('preview-thumbnails');
        if(input) {
            input.addEventListener('change', function (e) {
                preview.innerHTML = '';
                Array.from(e.target.files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function (ev) {
                            const img = document.createElement('img');
                            img.src = ev.target.result;
                            img.className = 'w-20 h-20 object-cover rounded border border-gray-300';
                            preview.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
        }
        // Preview cho ảnh chính
        const inputPrimary = document.getElementById('thumbnail_primary');
        const previewPrimary = document.getElementById('preview-thumbnail-primary');
        if(inputPrimary) {
            inputPrimary.addEventListener('change', function (e) {
                previewPrimary.innerHTML = '';
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (ev) {
                        const img = document.createElement('img');
                        img.src = ev.target.result;
                        img.className = 'w-24 h-24 object-cover rounded border border-blue-500 shadow';
                        previewPrimary.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
</form>
            </div>
        </div>

@push('scripts')
<script>
window.attributeValues = {};
@foreach($attributes as $attribute)
    window.attributeValues['{{ $attribute->id }}'] = [
        @foreach($attribute->values as $value)
            { id: {{ $value->id }}, value: @json($value->value) },
        @endforeach
    ];
@endforeach

function addAttribute(variantIndex) {
    const variant = document.querySelectorAll('.variant-item')[variantIndex];
    const attributeContainer = variant.querySelector('.attribute-container');
    const attributeItems = attributeContainer.querySelectorAll('.attribute-item');
    const newIndex = attributeItems.length;
    const html = `
    <div class="attribute-item">
      <div class="flex flex-row flex-wrap gap-4 items-end mb-2">
        <div class="flex-1 min-w-[130px]">
          <select name="variants[${variantIndex}][attributes][${newIndex}][attribute_id]" class="w-full px-4 py-2 border border-gray-300 rounded-md attribute-select" onchange="handleAttributeSelect(this, ${variantIndex}, ${newIndex})">
            <option value="">-- Chọn thuộc tính --</option>
            @foreach($attributes as $attribute)
                            <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                            @endforeach
            <option value="__new__">+ Thêm mới thuộc tính</option>
          </select>
          <input type="text" name="variants[${variantIndex}][attributes][${newIndex}][new_name]" class="w-full px-4 py-2 border border-blue-400 rounded-md mt-2 hidden" placeholder="Nhập tên thuộc tính mới...">
        </div>
        <div class="flex-1 min-w-[130px]">
          <select name="variants[${variantIndex}][attributes][${newIndex}][value]" class="w-full px-4 py-2 border border-gray-300 rounded-md value-select" data-attribute-index="${newIndex}" onchange="handleValueSelect(this, ${variantIndex}, ${newIndex})">
            <option value="">-- Chọn giá trị --</option>
            <option value="__new__">+ Thêm mới giá trị</option>
          </select>
          <input type="text" name="variants[${variantIndex}][attributes][${newIndex}][new_value]" class="w-full px-4 py-2 border border-blue-400 rounded-md mt-2 hidden value-new-input" placeholder="Nhập giá trị mới...">
        </div>
        <button type="button" class="px-2 py-1 bg-red-500 text-white rounded remove-attribute-btn" onclick="removeAttributeRow(this)">Xóa</button>
      </div>
    </div>`;
    attributeContainer.insertAdjacentHTML('beforeend', html);
}

function addVariant() {
    const container = document.getElementById('variants-container');
    const variantCount = container.querySelectorAll('.variant-item').length;
    const html = `
    <div class="variant-item mb-4">
        <div class="flex flex-row flex-wrap gap-4 items-end mb-2">
            <div class="flex-1 min-w-[120px]">
                <label class="block text-sm font-medium text-slate-600 mb-2">SKU</label>
                <input type="text" name="variants[${variantCount}][sku]" class="w-full px-4 py-2 border border-gray-300 rounded-md">
            </div>
            <div class="flex-1 min-w-[100px]">
                <label class="block text-sm font-medium text-slate-600 mb-2">Giá</label>
                <input type="number" name="variants[${variantCount}][price]" class="w-full px-4 py-2 border border-gray-300 rounded-md">
            </div>
            <div class="flex-1 min-w-[100px]">
                <label class="block text-sm font-medium text-slate-600 mb-2">Số lượng</label>
                <input type="number" name="variants[${variantCount}][quantity]" class="w-full px-4 py-2 border border-gray-300 rounded-md">
            </div>
        </div>
        <div class="attribute-container">
            <div class="attribute-item">
                <div class="flex flex-row flex-wrap gap-4 items-end mb-2">
                    <div class="flex-1 min-w-[130px]">
                        <label class="block text-sm font-medium text-slate-600 mb-2">Tên thuộc tính</label>
                        <select name="variants[${variantCount}][attributes][0][attribute_id]" class="w-full px-4 py-2 border border-gray-300 rounded-md attribute-select" onchange="handleAttributeSelect(this, ${variantCount}, 0)">
                            <option value="">-- Chọn thuộc tính --</option>
                            @foreach($attributes as $attribute)
                                <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                            @endforeach
                            <option value="__new__">+ Thêm mới thuộc tính</option>
                        </select>
                        <input type="text" name="variants[${variantCount}][attributes][0][new_name]" class="w-full px-4 py-2 border border-blue-400 rounded-md mt-2 hidden" placeholder="Nhập tên thuộc tính mới...">
                    </div>
                    <div class="flex-1 min-w-[130px]">
                        <label class="block text-sm font-medium text-slate-600 mb-2">Giá trị</label>
                        <select name="variants[${variantCount}][attributes][0][value]" class="w-full px-4 py-2 border border-gray-300 rounded-md value-select" data-attribute-index="0" onchange="handleValueSelect(this, ${variantCount}, 0)">
                            <option value="">-- Chọn giá trị --</option>
                            <option value="__new__">+ Thêm mới giá trị</option>
                        </select>
                        <input type="text" name="variants[${variantCount}][attributes][0][new_value]" class="w-full px-4 py-2 border border-blue-400 rounded-md mt-2 hidden value-new-input" placeholder="Nhập giá trị mới...">
                    </div>
                    <button type="button" class="px-2 py-1 bg-red-500 text-white rounded remove-attribute-btn" onclick="removeAttributeRow(this)">Xóa</button>
                </div>
            </div>
        </div>
        <button type="button" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 add-attribute-btn" onclick="addAttribute(${variantCount})">Thêm thuộc tính</button>
    </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
}

function removeAttributeRow(btn) {
    const row = btn.closest('.attribute-item');
    row.remove();
}

function handleAttributeSelect(select, variantIndex, attributeIndex) {
    var attributeId = select.value + '';
    // Xác định đúng attribute-item hiện tại
    var attributeItem = select.closest('.attribute-item');
    var valueSelect = attributeItem.querySelector('.value-select');
    var valueInput = attributeItem.querySelector('.value-new-input');

    if (attributeId === "__new__") {
        valueSelect.classList.add('hidden');
        valueInput.classList.remove('hidden');
        valueInput.name = select.name.replace('[name]', '[new_value]');
        return;
    } else {
        valueSelect.classList.remove('hidden');
        valueInput.classList.add('hidden');
    }

    // Lưu lại giá trị đang chọn trước khi reset option
    var previousValue = valueSelect.value;

    valueSelect.innerHTML = '<option value="">-- Chọn giá trị --</option>';
    if (window.attributeValues[attributeId]) {
        window.attributeValues[attributeId].forEach(function(val) {
            valueSelect.innerHTML += '<option value="' + val.id + '">' + val.value + '</option>';
        });
    }
    valueSelect.innerHTML += '<option value="__new__">+ Thêm mới giá trị</option>';

    // Set lại giá trị đã chọn nếu còn tồn tại trong option mới
    if ([...valueSelect.options].some(opt => opt.value === previousValue)) {
        valueSelect.value = previousValue;
    } else {
        valueSelect.value = '';
    }
}

function handleValueSelect(select, variantIndex) {
    var variantItem = select.closest('.variant-item');
    var valueInput = variantItem.querySelector('.value-new-input');
    if (select.value === '__new__') {
        valueInput.classList.remove('hidden');
    } else {
        valueInput.classList.add('hidden');
    }
}

function initAttributeValueDropdowns() {
    document.querySelectorAll('.attribute-select').forEach(function(select, idx) {
        if (select.value && select.value !== "__new__") {
            handleAttributeSelect(select, idx);
        }
    });
}
document.addEventListener('DOMContentLoaded', initAttributeValueDropdowns);

// Hiện input nhập mới khi chọn 'Thêm mới...' cho brand, category, origin
function toggleNewInput(selectId, inputId) {
    const select = document.getElementById(selectId);
    const input = document.getElementById(inputId);
    if (!select || !input) return;
    if (select.value === "__new__") {
        input.classList.remove('hidden');
        input.required = true;
    } else {
        input.classList.add('hidden');
        input.required = false;
        input.value = '';
    }
}

// Gán event listener an toàn
['brand', 'category', 'origin'].forEach(function(type) {
    const select = document.getElementById(type + '_select');
    if (select) {
        select.addEventListener('change', function() {
            toggleNewInput(type + '_select', type + '_name');
        });
    }
});

// Nếu reload lại trang mà có giá trị nhập mới thì tự động hiện input
window.addEventListener('DOMContentLoaded', function() {
    ['brand', 'category', 'origin'].forEach(function(type) {
        const select = document.getElementById(type + '_select');
        const input = document.getElementById(type + '_name');
        if (input && input.value) {
            input.classList.remove('hidden');
            input.required = true;
            if (select) select.value = "__new__";
        }
    });
});

// Đảm bảo các hàm luôn có trên window để gọi từ HTML
window.addAttribute = addAttribute;
window.addVariant = addVariant;
window.handleAttributeSelect = handleAttributeSelect;
window.handleValueSelect = handleValueSelect;
window.removeAttributeRow = removeAttributeRow;
</script>
@endpush

@endsection

