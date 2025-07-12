@extends('admin.layouts.app')
@section('title')
Danh sách giá trị biến thể
@endsection
@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                {{-- Tiêu đề + Nút thêm mới --}}
                <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex justify-between items-center">
                    <h6 class="dark:text-white text-lg font-semibold">Danh sách giá trị biến thể</h6>
                    <a href="{{ route('admin.variant_attribute_values.create') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                        + Thêm mới
                    </a>
                </div>

                {{-- Thanh tìm kiếm --}}
                <div class="px-6 mt-4">
                    <form method="GET" action="{{ route('admin.variant_attribute_values.index') }}" class="flex justify-end items-center gap-2">
                        <input
                            type="search"
                            name="keyword"
                            class="border border-slate-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300"
                            placeholder="Tìm theo ID hoặc tên..."
                            value="{{ request('keyword') }}"
                        >
                        <button type="submit" class="text-sm px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Tìm
                        </button>
                    </form>
                </div>

                {{-- Bảng giá trị biến thể --}}
                <div class="flex-auto px-0 pt-4 pb-2">
                    <div class="p-0 overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">#</th>
                                    <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Mã biến thể</th>
                                    <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Giá trị</th>
                                    <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($variantAttributeValues as $value)
                                    <tr class="border-b dark:border-white/40 hover:bg-gray-50 transition">
                                        <td class="px-6 py-3 text-sm">{{ $loop->index + 1 }}</td>
                                        <td class="px-6 py-3 text-sm">{{ $value->variant->sku }}</td>
                                        <td class="px-6 py-3 text-sm">{{ $value->value }}</td>
                                        <td class="px-6 py-3 text-sm">
                                            <a href="{{ route('admin.variant_attribute_values.edit', $value->id) }}" class="text-blue-600 hover:underline mr-2">Sửa</a>
                                            <form action="{{ route('admin.variant_attribute_values.destroy', $value->id) }}" method="post" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')" class="text-red-500 hover:underline">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">Không có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if ($variantAttributeValues->hasPages())
                            <div style="display: flex; justify-content: center; gap: 8px; margin: 20px 0;">
                                {{ $variantAttributeValues->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
