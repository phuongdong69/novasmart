@extends('admin.layouts.app')
@section('title', 'Trang Thương Hiệu')
@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
            <div class="border-b-0 px-6 py-6 dark:bg-slate-850/80">
                <div class="mb-8 flex items-center justify-between">
                    <h3 class="mb-0 dark:text-white">Danh sách nhãn hiệu</h3>
                    <a href="{{ route('admin.brands.create') }}" class="inline-block rounded-lg bg-blue-500 px-4 py-2.5 text-xs font-bold uppercase text-white shadow-md hover:bg-blue-600">
                        <i class="mr-1.5 fa fa-plus"></i> Thêm mới
                    </a>
                </div>
            </div>
            <div class="flex-auto px-6 py-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3">STT</th>
                                <th class="px-6 py-3">Tên nhãn hiệu</th>
                                <th class="px-6 py-3">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $brand)
                            <tr>
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">{{ $brand->name }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.brands.edit', $brand->id) }}" class="px-3 py-1 rounded bg-yellow-500 text-white hover:bg-yellow-600 text-xs font-semibold">Sửa</a>
                                        <a href="{{ route('admin.brands.show', $brand->id) }}" class="px-3 py-1 rounded bg-green-500 text-white hover:bg-green-600 text-xs font-semibold">Xem</a>
                                        <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 rounded bg-red-500 text-white hover:bg-red-600 text-xs font-semibold">Xóa</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection