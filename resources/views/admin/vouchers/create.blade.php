@extends('admin.layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div class="max-w-4xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Thêm Voucher mới</h2>
    
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('admin.vouchers.store') }}" method="POST" class="bg-white shadow rounded-lg p-6 space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="code" class="block font-medium mb-1">Mã voucher *</label>
                <input type="text" name="code" id="code" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
            </div>
            
            <div>
                <label for="type" class="block font-medium mb-1">Loại giảm giá *</label>
                <select name="type" id="type" class="w-full border rounded px-3 py-2" required>
                    <option value="percentage">Phần trăm (%)</option>
                    <option value="fixed">Cố định (VNĐ)</option>
                </select>
            </div>

            <div>
                <label for="value" class="block font-medium mb-1">Giá trị giảm *</label>
                <input type="number" name="value" id="value" class="w-full border rounded px-3 py-2" required min="0" step="0.01">
            </div>

            <div>
                <label for="max_discount" class="block font-medium mb-1">Mức giảm tối đa (VNĐ)</label>
                <input type="number" name="max_discount" id="max_discount" class="w-full border rounded px-3 py-2" min="0" step="0.01" placeholder="Để trống nếu không giới hạn">
                <small class="text-gray-500">Chỉ áp dụng cho giảm phần trăm</small>
            </div>

            <div>
                <label for="min_order_value" class="block font-medium mb-1">Giá trị đơn hàng tối thiểu (VNĐ) *</label>
                <input type="number" name="min_order_value" id="min_order_value" class="w-full border rounded px-3 py-2" required min="0" step="0.01">
            </div>

            <div>
                <label for="usage_limit" class="block font-medium mb-1">Số lần sử dụng tối đa *</label>
                <input type="number" name="usage_limit" id="usage_limit" class="w-full border rounded px-3 py-2" required min="1">
            </div>

            <div>
                <label for="start_date" class="block font-medium mb-1">Ngày bắt đầu *</label>
                <input type="date" name="start_date" id="start_date" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label for="end_date" class="block font-medium mb-1">Ngày kết thúc *</label>
                <input type="date" name="end_date" id="end_date" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label for="user_id" class="block font-medium mb-1">Gán cho user cụ thể</label>
                <select name="user_id" id="user_id" class="w-full border rounded px-3 py-2">
                    <option value="">Công khai cho tất cả</option>
                    @foreach(\App\Models\User::all() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status_code" class="block font-medium mb-1">Trạng thái *</label>
                <select name="status_code" id="status_code" class="w-full border rounded px-3 py-2" required>
                    @foreach($statuses as $status)
                        <option value="{{ $status->code }}">{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_public" id="is_public" class="mr-2" checked>
                <label for="is_public" class="font-medium">Voucher công khai</label>
            </div>
        </div>

        <div class="flex gap-2 pt-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Lưu</button>
            <a href="{{ route('admin.vouchers.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">Quay lại</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const maxDiscountDiv = document.getElementById('max_discount').parentElement;
    
    function toggleMaxDiscount() {
        if (typeSelect.value === 'percentage') {
            maxDiscountDiv.style.display = 'block';
        } else {
            maxDiscountDiv.style.display = 'none';
            document.getElementById('max_discount').value = '';
        }
    }
    
    typeSelect.addEventListener('change', toggleMaxDiscount);
    toggleMaxDiscount();
});
</script>
@endsection
