<div class="flex flex-row flex-wrap gap-4 items-end mb-2">
    <div class="flex-1 min-w-[120px]">
        <label class="block text-sm font-medium text-slate-600 mb-2">SKU</label>
        <input type="text" name="variants[{{ isset($index) ? $index : 0 }}][sku]" class="w-full px-4 py-2 border border-gray-300 rounded-md">
    </div>
    <div class="flex-1 min-w-[100px]">
        <label class="block text-sm font-medium text-slate-600 mb-2">Giá</label>
        <input type="number" name="variants[{{ isset($index) ? $index : 0 }}][price]" class="w-full px-4 py-2 border border-gray-300 rounded-md">
    </div>
    <div class="flex-1 min-w-[100px]">
        <label class="block text-sm font-medium text-slate-600 mb-2">Số lượng</label>
        <input type="number" name="variants[{{ isset($index) ? $index : 0 }}][quantity]" class="w-full px-4 py-2 border border-gray-300 rounded-md">
    </div>
</div>
