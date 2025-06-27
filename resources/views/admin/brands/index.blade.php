@extends('admin.pages.body')
@section('title', 'Trang Thương Hiệu')
@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
            <div class="border-b-0 px-6 py-6 dark:bg-slate-850/80">
                <div class="mb-8 flex items-center justify-between">
                    <h6 class="mb-0 dark:text-white">Danh sách nhãn hiệu</h6>
                    <a href="{{ route('admin.brands.create') }}" class="inline-block rounded-lg bg-blue-500 px-4 py-2.5 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md transition-all hover:bg-blue-600 hover:shadow-lg hover:opacity-[0.95] active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none dark:bg-blue-500 dark:text-white">
                        <i class="mr-1.5 fa fa-plus" aria-hidden="true"></i>
                        Thêm mới
                    </a>
                </div>
            </div>
            <div class="flex-auto px-6 py-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="align-bottom">
                            <tr>
                                <th class="border-b-2 px-6 py-3 font-bold uppercase text-slate-400 dark:text-white/80 bg-transparent border-b-solid border-b-slate-100 dark:border-b-slate-700 tracking-normal">
                                    STT
                                </th>
                                <th class="border-b-2 px-6 py-3 font-bold uppercase text-slate-400 dark:text-white/80 bg-transparent border-b-solid border-b-slate-100 dark:border-b-slate-700 tracking-normal">
                                    Tên nhãn hiệu
                                </th>
                                <th class="border-b-2 px-6 py-3 font-bold uppercase text-slate-400 dark:text-white/80 bg-transparent border-b-solid border-b-slate-100 dark:border-b-slate-700 tracking-normal">
                                    Hành động
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $brand)
                            <tr class="border-b border-slate-100 dark:border-slate-700">
                                <td class="border-b-0 px-6 py-4">
                                    {{ $loop->index + 1 }}
                                </td>
                                <td class="border-b-0 px-6 py-4">
                                    {{ $brand->name }}
                                </td>
                                <td class="border-b-0 px-6 py-4">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('admin.brands.edit', $brand->id) }}" class="inline-block rounded-lg bg-blue-500 px-4 py-2 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md transition-all hover:bg-blue-600 hover:shadow-lg hover:opacity-[0.95] active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none dark:bg-blue-500 dark:text-white">
                                            <i class="mr-1.5 fa fa-edit" aria-hidden="true"></i>
                                            Sửa
                                        </a>
                                        <a href="{{ route('admin.brands.show', $brand->id) }}" class="inline-block rounded-lg bg-green-500 px-4 py-2 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md transition-all hover:bg-green-600 hover:shadow-lg hover:opacity-[0.95] active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none dark:bg-green-500 dark:text-white">
                                            <i class="mr-1.5 fa fa-eye" aria-hidden="true"></i>
                                            Xem
                                        </a>
                                        <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="post" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-block rounded-lg bg-red-500 px-4 py-2 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md transition-all hover:bg-red-600 hover:shadow-lg hover:opacity-[0.95] active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none dark:bg-red-500 dark:text-white">
                                                <i class="mr-1.5 fa fa-trash" aria-hidden="true"></i>
                                                Xóa
                                            </button>
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
<a class="btn btn-primary mb-3" href="{{ route('admin.brands.create') }}">Thêm Mới</a>
<div class="table-responsive">
    <table class="table table-primary">
        <thead>
            <tr>
      
                <th scope="col">Name</th>
               
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $brand )
            <tr class="">
                <td scope="row">{{$loop->index+1}}</td>

                <td scope="row">{{$brand->name}}</td>
                <td>
                    <a class="btn btn-warning" href="{{ route('admin.brands.edit', $brand->id) }}">Sửa</a>
                     <a class="btn btn-success" href="{{ route('admin.brands.show', $brand->id) }}">Xem Chi Tiết</a>
                    <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="post" style="display:inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection