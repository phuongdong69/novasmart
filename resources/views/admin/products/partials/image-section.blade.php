{{-- Ảnh sản phẩm hiện tại --}}
@if($product->thumbnails && $product->thumbnails->count())
<div class="form-group">
    <label class="form-label">Ảnh sản phẩm hiện tại</label>
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
        @foreach($product->thumbnails as $thumb)
        <div class="relative group">
            <img src="{{ asset($thumb->url) }}" 
                 alt="Thumbnail" 
                 class="w-full h-24 object-cover rounded-lg shadow-sm border">
            @if($thumb->is_primary)
            <div class="absolute top-1 left-1 bg-blue-500 text-white text-xs px-2 py-1 rounded">
                Chính
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Upload ảnh mới --}}
<div class="form-group">
    <label for="image" class="form-label">Ảnh sản phẩm mới</label>
    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors drop-zone">
        <div class="space-y-1 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <div class="flex text-sm text-gray-600">
                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                    <span>Tải ảnh lên</span>
                    <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                </label>
                <p class="pl-1">hoặc kéo thả</p>
            </div>
            <p class="text-xs text-gray-500">PNG, JPG, GIF tối đa 10MB</p>
        </div>
    </div>
    @error('image')
    <span class="form-error">{{ $message }}</span>
    @enderror
</div>

{{-- Ảnh chính hiện tại --}}
@if($product->image)
<div class="form-group">
    <label class="form-label">Ảnh chính hiện tại</label>
    <div class="relative inline-block">
        <img src="{{ asset('storage/' . $product->image) }}" 
             alt="Ảnh sản phẩm" 
             class="w-32 h-32 object-cover rounded-lg shadow-sm border">
    </div>
</div>
@endif 