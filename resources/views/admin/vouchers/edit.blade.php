@extends('admin.layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-10 shadow-xl rounded-2xl mt-12">
        <h2 class="text-3xl font-bold mb-8 text-gray-800">✏️ Cập nhật mã giảm giá</h2>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-700 px-5 py-4 rounded mb-8">
                <strong class="block mb-2 text-lg font-semibold">Đã có lỗi xảy ra:</strong>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Mã voucher --}}
            <div>
                <label for="code" class="block text-gray-700 font-medium mb-2">🎫 Mã voucher</label>
                <input type="text" name="code" id="code" value="{{ old('code', $voucher->code) }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Loại giảm giá --}}
            <div>
                <label for="discount_type" class="block text-gray-700 font-medium mb-2">📌 Loại giảm giá</label>
                <select name="discount_type" id="discount_type"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="percent"
                        {{ old('discount_type', $voucher->discount_type) == 'percent' ? 'selected' : '' }}>
                        Giảm theo %
                    </option>
                    <option value="fixed" {{ old('discount_type', $voucher->discount_type) == 'fixed' ? 'selected' : '' }}>
                        Giảm cố định
                    </option>
                </select>
            </div>

            {{-- Giá trị giảm --}}
            <div>
                <label for="discount_value" class="block text-gray-700 font-medium mb-2">💸 Giá trị giảm</label>
                <input type="number" step="0.01" name="discount_value" id="discount_value"
                    value="{{ old('discount_value', $voucher->discount_value) }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Số lượng --}}
            <div>
                <label for="quantity" class="block text-gray-700 font-medium mb-2">📦 Số lượng còn lại</label>
                <input type="number" name="quantity" id="quantity" min="0"
                    value="{{ old('quantity', $voucher->quantity) }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Trạng thái --}}
            <div>
                <label for="status_id" class="block text-gray-700 font-medium mb-2">⚙️ Trạng thái</label>
                <select name="status_id" id="status_id"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}"
                            {{ old('status_id', $voucher->status_id) == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Ngày hết hạn --}}
            <div>
                <label for="expired_at" class="block text-gray-700 font-medium mb-2">⏰ Ngày hết hạn</label>
                <input type="datetime-local" name="expired_at" id="expired_at"
                    value="{{ old('expired_at', optional($voucher->expired_at)->format('Y-m-d\TH:i')) }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Nút --}}
            <div class="flex justify-end pt-4 space-x-4">
                <a href="{{ route('admin.vouchers.index') }}"
                    class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-all">Hủy</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Cập nhập
                </button>
            </div>
        </form>
    </div>
@endsection
