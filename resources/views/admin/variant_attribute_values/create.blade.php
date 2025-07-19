@extends('admin.layouts.app')
@section('title')
Thêm giá trị biến thể
@endsection
@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex justify-between items-center">
                    <h6 class="dark:text-white text-lg font-semibold">Thêm giá trị biến thể</h6>
                    <a href="{{ route('admin.variant_attribute_values.index') }}" class="text-blue-500 hover:underline">← Quay lại danh sách</a>
                </div>
                <div class="flex-auto px-0 pt-4 pb-2">
                    <form action="{{ route('admin.variant_attribute_values.store') }}" method="POST" class="max-w-xl mx-auto">
                        @csrf
                        <div class="mb-4">
                            <label for="product_variant_id" class="block text-gray-700 font-bold mb-2">Biến thể <span class="text-red-500">*</span></label>
                            <select name="product_variant_id" id="product_variant_id" class="border border-slate-300 rounded px-3 py-2 w-full text-sm focus:outline-none focus:ring focus:border-blue-300" required>
                                <option value="">-- Chọn biến thể --</option>
                                @foreach ($variants as $variant)
                                    <option value="{{ $variant->id }}" {{ old('product_variant_id') == $variant->id ? 'selected' : '' }}>{{ $variant->name }}</option>
                                @endforeach
                            </select>
                            @error('product_variant_id')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="attribute_value_id" class="block text-gray-700 font-bold mb-2">Giá trị thuộc tính <span class="text-red-500">*</span></label>
                            <select name="attribute_value_id" id="attribute_value_id" class="border border-slate-300 rounded px-3 py-2 w-full text-sm focus:outline-none focus:ring focus:border-blue-300" required>
                                <option value="">-- Chọn giá trị thuộc tính --</option>
                                @foreach ($attributeValues as $attrValue)
                                    <option value="{{ $attrValue->id }}" {{ old('attribute_value_id') == $attrValue->id ? 'selected' : '' }}>{{ $attrValue->value }}</option>
                                @endforeach
                            </select>
                            @error('attribute_value_id')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Lưu
                            </button>
                            <a href="{{ route('admin.variant_attribute_values.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
