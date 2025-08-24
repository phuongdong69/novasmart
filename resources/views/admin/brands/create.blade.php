@extends('admin.layouts.app')
@section('title', 'Thêm Mới Nhãn Hiệu')
@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
            <div class="border-b-0 px-6 py-6 dark:bg-slate-850/80">
                <h3 class="mb-0 dark:text-white">Thêm mới nhãn hiệu</h3>
            </div>
            <div class="flex-auto px-6 py-4">
                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('admin.brands.store') }}">
                    @csrf
                    <div class="mb-6">
                        <label class="mb-2.5 block text-sm font-medium dark:text-white">Tên nhãn hiệu</label>
                        <input type="text" name="name" class="w-full rounded-lg border border-stroke bg-transparent py-3 px-4.5 text-black dark:border-form-strokedark dark:bg-form-input dark:text-white @error('name') border-red-500 @enderror" placeholder="Nhập tên nhãn hiệu" value="{{ old('name') }}" required />
                        @error('name')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="inline-block rounded-lg bg-blue-500 px-8 py-3 text-center align-middle font-sans text-sm font-medium uppercase text-white shadow-md transition-all hover:bg-blue-600 hover:shadow-lg hover:opacity-[0.95] active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none dark:bg-blue-500 dark:text-white">
                            Lưu
                        </button>
                        <a href="{{ route('admin.brands.index') }}" class="inline-block rounded-lg bg-gray-500 px-8 py-3 text-center align-middle font-sans text-sm font-medium uppercase text-white shadow-md transition-all hover:bg-gray-600 hover:shadow-lg hover:opacity-[0.95] active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none dark:bg-gray-500 dark:text-white">
                            Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection