@extends('admin.layouts.app')

@section('title', 'Chỉnh Sửa Nhãn Hiệu')
@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
            <div class="border-b-0 px-6 py-6 dark:bg-slate-850/80">
                <h3 class="mb-0 dark:text-white">Chỉnh sửa nhãn hiệu</h3>
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
                <form method="POST" action="{{ route('admin.brands.update', $brand->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-6">
                        <label class="mb-2.5 block text-sm font-medium dark:text-white">Tên nhãn hiệu</label>
                        <input type="text" name="name" class="w-full rounded-lg border border-stroke bg-transparent py-3 px-4.5 text-black dark:border-form-strokedark dark:bg-form-input dark:text-white @error('name') border-red-500 @enderror" placeholder="Nhập tên nhãn hiệu" value="{{ old('name', $brand->name) }}" required />
                        @error('name')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end gap-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-6 rounded">
                            Lưu thay đổi
                        </button>
                        <a href="{{ route('admin.brands.index') }}"
                            class="border border-slate-400 text-slate-700 hover:bg-slate-100 hover:text-slate-900 text-sm font-medium py-2 px-6 rounded transition-all duration-150">
                            Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection