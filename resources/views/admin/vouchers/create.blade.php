@extends('admin.layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        {{-- Breadcrumb giả lập --}}
        <div class="mb-6 text-sm text-gray-500">
            <a href="{{ route('admin.vouchers.index') }}" class="hover:underline text-blue-600">Danh sách mã giảm giá</a>
            <span class="mx-2">/</span>
            <span>Tạo mới</span>
        </div>

        <div class="bg-white shadow-lg rounded-2xl p-8 border border-gray-200">
            <h2 class="text-3xl font-semibold mb-6 text-gray-800 flex items-center gap-2">
                🎟️ Tạo mã giảm giá mới
            </h2>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                    <div class="flex items-center gap-2 mb-2 font-medium">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M5.636 18.364A9 9 0 1118.364 5.636 9 9 0 015.636 18.364z" />
                        </svg>
                        Có lỗi xảy ra:
                    </div>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.vouchers.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="code" class="block font-medium text-gray-700">Mã giảm giá <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}"
                        class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Nhập mã giảm giá..." required>
                </div>

                <div>
                    <label for="description" class="block font-medium text-gray-700">Mô tả</label>
                    <textarea name="description" id="description" rows="2"
                        class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Mô tả về mã giảm giá...">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="discount_type" class="block font-medium text-gray-700">Loại giảm <span
                                class="text-red-500">*</span></label>
                        <select name="discount_type" id="discount_type"
                            class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            required>
                            <option value="">-- Chọn loại --</option>
                            <option value="percent" {{ old('discount_type') === 'percent' ? 'selected' : '' }}>Phần trăm
                            </option>
                            <option value="fixed" {{ old('discount_type') === 'fixed' ? 'selected' : '' }}>Cố định</option>
                        </select>
                    </div>

                    <div>
                        <label for="discount_value" class="block font-medium text-gray-700">Giá trị giảm <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="discount_value" id="discount_value" value="{{ old('discount_value') }}"
                            class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Ví dụ: 10, 50000..." required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="quantity" class="block font-medium text-gray-700">Số lượng <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}"
                            class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Ví dụ: 100" required>
                    </div>

                    <div>
                        <label for="expired_at" class="block font-medium text-gray-700">Ngày hết hạn <span
                                class="text-red-500">*</span></label>
                        <input type="datetime-local" name="expired_at" id="expired_at" value="{{ old('expired_at') }}"
                            class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            required>
                    </div>
                </div>

                <div>
                    <label for="status_id" class="block font-medium text-gray-700">Trạng thái <span
                            class="text-red-500">*</span></label>
                    <select name="status_id" id="status_id"
                        class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                        <option value="">-- Chọn trạng thái --</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="text-right pt-4">
                    <a href="{{ route('admin.vouchers.index') }}"
                        class="px-5 py-2 bg-blue-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">Huỷ</a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Lưu mã giảm giá
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
