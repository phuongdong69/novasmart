@extends('admin.layouts.app')

@section('title', 'Thêm Product Thumbnail')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 flex-0">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-slate-850 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center w-full max-w-full px-3 shrink-0">
                            <div class="w-full">
                                <h6 class="mb-1 font-semibold leading-normal dark:text-white">Thêm Product Thumbnail</h6>
                                <p class="mb-0 leading-normal text-sm dark:text-white dark:opacity-60">
                                    Thêm ảnh thumbnail cho sản phẩm
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-auto p-6">
                    <form action="{{ route('admin.product_thumbnail.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="product_id" class="block text-sm font-medium text-slate-700 dark:text-white mb-2">Sản phẩm</label>
                            <select id="product_id" name="product_id" 
                                    class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-600 dark:text-white @error('product_id') border-red-500 @enderror" required>
                                <option value="">-- Chọn sản phẩm --</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="product_variant_id" class="block text-sm font-medium text-slate-700 dark:text-white mb-2">Biến thể</label>
                            <select id="product_variant_id" name="product_variant_id"
                                    class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-600 dark:text-white @error('product_variant_id') border-red-500 @enderror" required>
                                <option value="">-- Chọn biến thể --</option>
                            </select>
                            @error('product_variant_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="url" class="block text-sm font-medium text-slate-700 dark:text-white mb-2">Ảnh</label>
                            <input type="file" 
                                   class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-600 dark:text-white @error('url') border-red-500 @enderror" 
                                   id="url" name="url" accept="image/*" required>
                            @error('url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Định dạng: JPEG, PNG, JPG, GIF. Kích thước tối đa: 2MB</p>
                        </div>

                        <div class="mb-4">
                            <label for="is_primary" class="block text-sm font-medium text-slate-700 dark:text-white mb-2">Ảnh chính</label>
                            <select class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-600 dark:text-white @error('is_primary') border-red-500 @enderror" 
                                    id="is_primary" name="is_primary" required>
                                <option value="1" {{ old('is_primary') == '1' ? 'selected' : '' }}>Có</option>
                                <option value="0" {{ old('is_primary') == '0' ? 'selected' : '' }}>Không</option>
                            </select>
                            @error('is_primary')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="sort_order" class="block text-sm font-medium text-slate-700 dark:text-white mb-2">Thứ tự</label>
                            <input type="number" 
                                   class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-600 dark:text-white @error('sort_order') border-red-500 @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                            @error('sort_order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-6 rounded">
                                Lưu
                            </button>
                            <a href="{{ route('admin.product_thumbnail.index') }}"
                                class="border border-slate-400 text-slate-700 hover:bg-slate-100 hover:text-slate-900 text-sm font-medium py-2 px-6 rounded transition-all duration-150">
                                Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            </div>
</div>

@push('scripts')
<script>
    const productsData = @json($products);
    const variantSelect = document.getElementById('product_variant_id');
    const productSelect = document.getElementById('product_id');

    function populateVariants(productId) {
        // reset
        variantSelect.innerHTML = '<option value="">-- Chọn biến thể --</option>';
        if (!productId) return;
        const product = productsData.find(p => p.id == productId);
        if (product && product.variants) {
            product.variants.forEach(v => {
                const opt = document.createElement('option');
                opt.value = v.id;
                opt.textContent = v.sku;
                variantSelect.appendChild(opt);
            });
        }
    }

    productSelect.addEventListener('change', (e) => {
        populateVariants(e.target.value);
    });

    // preselect if old value exists
    window.addEventListener('DOMContentLoaded', () => {
        const oldProduct = productSelect.value;
        if (oldProduct) populateVariants(oldProduct);
        const oldVariant = '{{ old('product_variant_id') }}';
        if (oldVariant) variantSelect.value = oldVariant;
    });
</script>
@endpush
@endsection 