@extends('admin.layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Sửa Voucher</h2>
    <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST" class="bg-white shadow rounded-lg p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label for="code" class="block font-medium mb-1">Mã voucher</label>
            <input type="text" name="code" id="code" value="{{ $voucher->code }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
        </div>
        <div>
            <label for="discount_type" class="block font-medium mb-1">Loại giảm giá</label>
            <select name="discount_type" id="discount_type" class="w-full border rounded px-3 py-2" required>
                <option value="percentage" {{ $voucher->discount_type == 'percentage' ? 'selected' : '' }}>Phần trăm</option>
                <option value="fixed" {{ $voucher->discount_type == 'fixed' ? 'selected' : '' }}>Cố định</option>
            </select>
        </div>
        <div>
            <label for="discount_value" class="block font-medium mb-1">Giá trị giảm</label>
            <input type="number" name="discount_value" id="discount_value" value="{{ $voucher->discount_value }}" class="w-full border rounded px-3 py-2" required min="0">
        </div>
        <div>
            <label for="expiry_date" class="block font-medium mb-1">Ngày hết hạn</label>
            <input type="date" name="expiry_date" id="expiry_date" value="{{ $voucher->expiry_date }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label for="quantity" class="block font-medium mb-1">Số lượng</label>
            <input type="number" name="quantity" id="quantity" value="{{ $voucher->quantity }}" class="w-full border rounded px-3 py-2" required min="0">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Cập nhật</button>
            <a href="{{ route('admin.vouchers.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">Quay lại</a>
        </div>
    </form>
</div>
@endsection
