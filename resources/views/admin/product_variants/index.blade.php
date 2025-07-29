@extends('admin.layouts.app')
@section('title')
    Danh sách biến thể
@endsection
@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    {{-- Tiêu đề + Nút thêm mới --}}
                    <div
                        class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex justify-between items-center">
                        <div>
                            <h6 class="dark:text-white text-lg font-semibold">Danh sách biến thể</h6>
                            <p class="text-sm text-gray-500 mt-1">Quản lý các biến thể sản phẩm</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.product_variants.create') }}"
                                class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-semibold py-2.5 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2 group">
                                <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Thêm biến thể mới
                            </a>
                        </div>
                    </div>

                    {{-- Thanh tìm kiếm --}}
                    <div class="px-6 mt-4">
                        <form method="GET" action="{{ route('admin.product_variants.index') }}"
                            class="flex justify-end items-center gap-2">
                            <input type="search" name="keyword"
                                class="border border-slate-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300"
                                placeholder="Tìm theo ID hoặc tên..." value="{{ request('keyword') }}">
                            <button type="submit"
                                class="text-sm px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Tìm
                            </button>
                        </form>
                    </div>

                    {{-- Bảng biến thể --}}
                    <div class="flex-auto px-0 pt-4 pb-2">
                        <div class="p-0 overflow-x-auto">
                            <table
                                class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">#</th>
                                        <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Sản phẩm</th>
                                        <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">SKU</th>
                                        <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Giá</th>
                                        <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Số lượng</th>
                                        <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Trạng thái</th>
                                        <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($productVariants as $productVariant)
                                        <tr class="border-b dark:border-white/40 hover:bg-gray-50 transition">
                                            <td class="px-6 py-3 text-sm">{{ $loop->index + 1 }}</td>
                                            <td class="px-6 py-3 text-sm">{{ $productVariant->product && is_object($productVariant->product) ? $productVariant->product->name : '' }}</td>
                                            <td class="px-6 py-3 text-sm">{{ $productVariant->sku }}</td>
                                            <td class="px-6 py-3 text-sm">{{ number_format($productVariant->price, 0, ',', '.') }}₫</td>
                                            <td class="px-6 py-3 text-sm">{{ $productVariant->quantity }}</td>
                                            <td class="px-6 py-3 text-sm">
                                                @if($productVariant->status && is_object($productVariant->status))
                                                    <span class="inline-block px-2 py-1 rounded text-white text-xs font-semibold"
                                                        style="background-color: {{ $productVariant->status->color ?? '#888' }};">
                                                        {{ $productVariant->status->name }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">Chưa có</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-3 text-sm">
                                                <a href="{{ route('admin.product_variants.edit', $productVariant->id) }}"
                                                    class="text-blue-600 hover:underline mr-2">Sửa</a>
                                                <form
                                                    action="{{ route('admin.product_variants.destroy', $productVariant->id) }}"
                                                    method="post" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa không?')"
                                                        class="text-red-500 hover:underline">Xóa</button>
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
                            @if ($productVariants->hasPages())
                                <div style="display: flex; justify-content: center; gap: 8px; margin: 20px 0;">
                                    {{ $productVariants->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection