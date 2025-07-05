@extends('admin.layouts.app')
@section('title')
Thêm mới giá trị thuộc tính
@endsection
@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                {{-- Header --}}
                <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex items-center justify-between">
                    <h6 class="dark:text-white text-lg font-semibold">Thêm mới giá trị thuộc tính</h6>
                    <a href="{{ route('admin.attribute_values.index') }}"
                        class="border border-slate-400 text-slate-700 hover:bg-slate-100 hover:text-slate-900 text-sm font-medium py-2 px-4 rounded transition-all duration-150">
                        ← Quay lại
                    </a>
                </div>

                {{-- Alerts --}}
                <div class="px-6 mt-4">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                </div>

                {{-- Form body --}}
                <form action="{{ route('admin.attribute_values.store') }}" method="POST" class="px-6 pt-4 pb-6">
                    @csrf

                    <div class="mb-4">
                        <label for="attribute_id" class="block text-sm font-medium text-slate-600 mb-2">Thuộc tính</label>
                        <select
                            name="attribute_id"
                            id="attribute_id"
                            class="form-input w-full border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('attribute_id') border-red-500 @enderror"
                            required>
                            <option value="">Chọn thuộc tính</option>
                            @foreach ($attributes as $attribute)
                                <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                            @endforeach
                        </select>
                        @error('attribute_id')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="value" class="block text-sm font-medium text-slate-600 mb-2">Giá trị</label>
                        <input
                            type="text"
                            name="value"
                            id="value"
                            class="form-input w-full border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('value') border-red-500 @enderror"
                            placeholder="Nhập giá trị"
                            required
                        >
                        @error('value')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-6 rounded">
                            Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
