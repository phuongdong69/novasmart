@extends('admin.layouts.app')
@section('title')
Thêm Mới Thuộc Tính
@endsection
@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

                {{-- Header --}}
                <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex items-center justify-between">
                    <h3 class="dark:text-white text-lg font-semibold">Thêm thuộc tính mới</h3>
                    <a href="{{ route('admin.attributes.index') }}"
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
                <form action="{{ route('admin.attributes.store') }}" method="POST" class="px-6 pt-4 pb-6">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-slate-600 mb-2">Tên thuộc tính</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-input w-full border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('name') border-red-500 @enderror"
                            placeholder="Nhập tên thuộc tính"
                            value="{{ old('name') }}">
                        @error('name')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-slate-600 mb-2">Mô tả</label>
                        <textarea
                            name="description"
                            id="description"
                            class="form-input w-full border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('description') border-red-500 @enderror"
                            rows="3"
                            placeholder="Nhập mô tả cho thuộc tính">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>



                <div class="mb-3 row">
                    <label for="is_filterable" class="col-sm-3 col-form-label">Lọc Sản Phẩm</label>
                    <div class="col-sm-9">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_filterable" id="is_filterable">
                            <label class="form-check-label" for="is_filterable">
                                Cho phép lọc sản phẩm theo thuộc tính này
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="flex justify-end gap-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-6 rounded">
                            Lưu
                        </button>
                        <a href="{{ route('admin.attributes.index') }}"
                            class="border border-slate-400 text-slate-700 hover:bg-slate-100 hover:text-slate-900 text-sm font-medium py-2 px-6 rounded transition-all duration-150">
                            Quay lại
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection