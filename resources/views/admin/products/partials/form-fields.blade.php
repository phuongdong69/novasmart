{{-- Tên sản phẩm --}}
<div class="form-group">
    <label for="name" class="form-label">Tên sản phẩm <span class="text-red-500">*</span></label>
    <input type="text" 
           name="name" 
           id="name" 
           class="form-input @error('name') border-red-500 @enderror" 
           placeholder="Nhập tên sản phẩm" 
           value="{{ old('name', $product->name) }}"
           required>
    @error('name')
    <span class="form-error">{{ $message }}</span>
    @enderror
</div>

{{-- Thương hiệu --}}
<div class="form-group">
    <label for="brand_id" class="form-label">Thương hiệu <span class="text-red-500">*</span></label>
    <select name="brand_id" 
            id="brand_id" 
            class="form-select @error('brand_id') border-red-500 @enderror"
            required>
        <option value="">Chọn thương hiệu</option>
        @foreach($brands as $brand)
        <option value="{{ $brand->id }}" 
                {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
            {{ $brand->name }}
        </option>
        @endforeach
    </select>
    @error('brand_id')
    <span class="form-error">{{ $message }}</span>
    @enderror
</div>

{{-- Xuất xứ --}}
<div class="form-group">
    <label for="origin_id" class="form-label">Xuất xứ <span class="text-red-500">*</span></label>
    <select name="origin_id" 
            id="origin_id" 
            class="form-select @error('origin_id') border-red-500 @enderror"
            required>
        <option value="">Chọn xuất xứ</option>
        @foreach($origins as $origin)
        <option value="{{ $origin->id }}" 
                {{ old('origin_id', $product->origin_id) == $origin->id ? 'selected' : '' }}>
            {{ $origin->name ?? $origin->country ?? 'Không rõ' }}
        </option>
        @endforeach
    </select>
    @error('origin_id')
    <span class="form-error">{{ $message }}</span>
    @enderror
</div>

{{-- Danh mục --}}
<div class="form-group">
    <label for="category_id" class="form-label">Danh mục <span class="text-red-500">*</span></label>
    <select name="category_id" 
            id="category_id" 
            class="form-select @error('category_id') border-red-500 @enderror"
            required>
        <option value="">Chọn danh mục</option>
        @foreach($categories as $category)
        <option value="{{ $category->id }}" 
                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
        </option>
        @endforeach
    </select>
    @error('category_id')
    <span class="form-error">{{ $message }}</span>
    @enderror
</div> 