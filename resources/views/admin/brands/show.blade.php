@extends('admin.layouts.app')

@section('title', 'Chi Tiết Nhãn Hiệu')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
            <div class="border-b-0 px-6 py-6 dark:bg-slate-850/80">
                <h6 class="mb-0 dark:text-white">Chi tiết nhãn hiệu</h6>
            </div>
            <div class="flex-auto px-6 py-4">
                <div class="mb-8">
                    <div class="mb-6">
                        <label class="mb-2.5 block text-sm font-medium dark:text-white">Tên nhãn hiệu</label>
                        <p class="text-lg font-semibold dark:text-white">{{ $brand->name }}</p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('admin.brands.edit', $brand->id) }}" class="inline-block rounded-lg bg-blue-500 px-8 py-3 text-center align-middle font-sans text-sm font-medium uppercase text-white shadow-md transition-all hover:bg-blue-600 hover:shadow-lg hover:opacity-[0.95] active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none dark:bg-blue-500 dark:text-white">
                        Sửa
                    </a>
                    <a href="{{ route('admin.brands.index') }}" class="inline-block rounded-lg bg-gray-500 px-8 py-3 text-center align-middle font-sans text-sm font-medium uppercase text-white shadow-md transition-all hover:bg-gray-600 hover:shadow-lg hover:opacity-[0.95] active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none dark:bg-gray-500 dark:text-white">
                        Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection