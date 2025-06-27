
@extends('admin.layouts.app')

@section('title', 'Chỉnh Sửa Nhãn Hiệu')
@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
            <div class="border-b-0 px-6 py-6 dark:bg-slate-850/80">
                <h6 class="mb-0 dark:text-white">Chỉnh sửa nhãn hiệu</h6>
            </div>
            <div class="flex-auto px-6 py-4">
                <form method="POST" action="{{ route('admin.brands.update', $brand->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-6">
                        <label class="mb-2.5 block text-sm font-medium dark:text-white">Tên nhãn hiệu</label>
                        <input type="text" name="name" class="w-full rounded-lg border border-stroke bg-transparent py-3 px-4.5 text-black dark:border-form-strokedark dark:bg-form-input dark:text-white" placeholder="Nhập tên nhãn hiệu" value="{{ old('name', $brand->name) }}" required />
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="inline-block rounded-lg bg-blue-500 px-8 py-3 text-center align-middle font-sans text-sm font-medium uppercase text-white shadow-md transition-all hover:bg-blue-600 hover:shadow-lg hover:opacity-[0.95] active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none dark:bg-blue-500 dark:text-white">
                            Lưu thay đổi
                        </button>
                        <a href="{{ route('admin.brands.index') }}" class="inline-block rounded-lg bg-gray-500 px-8 py-3 text-center align-middle font-sans text-sm font-medium uppercase text-white shadow-md transition-all hover:bg-gray-600 hover:shadow-lg hover:opacity-[0.95] active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none dark:bg-gray-500 dark:text-white">
                            Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection