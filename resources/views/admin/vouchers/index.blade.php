@extends('admin.layouts.app')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                🎟️ Quản lý mã giảm giá
            </h2>
            <a href="{{ route('admin.vouchers.create') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl shadow-md hover:from-indigo-500 hover:to-blue-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4" />
                </svg>
                Thêm mới
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 border border-green-300 rounded-lg shadow">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-2xl shadow border border-gray-200 bg-white">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="p-4 text-left">Mã</th>
                        <th class="p-4 text-left">Loại</th>
                        <th class="p-4 text-left">Giá trị</th>
                        <th class="p-4 text-left">Số lượng</th>
                        <th class="p-4 text-left">Hết hạn</th>
                        <th class="p-4 text-left">Trạng thái</th>
                        <th class="p-4 text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($vouchers as $voucher)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-medium text-gray-900">{{ $voucher->code }}</td>
                            <td class="p-4 capitalize">
                                <span class="px-2 py-1 bg-gray-100 rounded-lg text-gray-800 text-xs font-medium">
                                    {{ $voucher->discount_type === 'percent' ? 'Giảm theo %' : 'Giảm cố định' }}
                                </span>
                            </td>
                            <td class="p-4">
                                @if ($voucher->discount_type === 'percent')
                                    <span class="text-blue-600 font-semibold">
                                        {{ rtrim(rtrim(number_format($voucher->discount_value, 2), '0'), '.') }}%
                                    </span>
                                @else
                                    <span class="text-green-600 font-semibold">
                                        {{ number_format($voucher->discount_value, 0, ',', '.') }}đ
                                    </span>
                                @endif
                            </td>
                            <td class="p-4">{{ $voucher->quantity }}</td>
                            <td class="p-4 text-gray-700">
                                {{ \Carbon\Carbon::parse($voucher->expired_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold"
                                    style="background-color: {{ $voucher->status->color ?? '#999' }}; color: #fff;">
                                    🟢 {{ $voucher->status->name ?? 'Không rõ' }}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('admin.vouchers.edit', $voucher) }}"
                                        class="text-blue-600 hover:underline font-medium">
                                        ✏️ Sửa
                                    </a>
                                    <form action="{{ route('admin.vouchers.destroy', $voucher) }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xoá voucher này?')">
                                        @csrf
                                        @method('DELETE')
                                        
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-gray-500">Không có mã giảm giá nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $vouchers->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
