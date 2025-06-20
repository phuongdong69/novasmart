@extends('admin.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Danh sách Voucher</h2>
        <a href="{{ route('admin.vouchers.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Thêm Voucher mới</a>
    </div>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($vouchers as $voucher)
            <div class="bg-white shadow rounded-lg p-6 flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-semibold mb-2">{{ $voucher->code }}</h3>
                    <p><span class="font-medium">Loại giảm giá:</span> {{ $voucher->discount_type == 'percentage' ? 'Phần trăm' : 'Cố định' }}</p>
                    <p><span class="font-medium">Giá trị:</span> {{ $voucher->discount_type == 'percentage' ? $voucher->discount_value . '%' : number_format($voucher->discount_value) . ' VNĐ' }}</p>
                    <p><span class="font-medium">Hết hạn:</span> {{ $voucher->expiry_date }}</p>
                    <p><span class="font-medium">Số lượng:</span> {{ $voucher->quantity }}</p>
                    <p><span class="font-medium">Ngày tạo:</span> {{ $voucher->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <a href="{{ route('admin.vouchers.show', $voucher->id) }}" class="px-3 py-1 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">Xem</a>
                    <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition">Sửa</a>
                    <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xoá voucher này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">Xoá</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection