@extends('admin.layouts.app')

@section('title', 'Quản lý trạng thái')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="bg-white shadow-lg rounded-xl p-6 max-w-7xl mx-auto">

        {{-- Form lọc --}}
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="relative">
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="🔍 Tìm theo tên, mã..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-indigo-400 focus:border-indigo-500 transition" />
            </div>

            <div>
                <select name="type"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-indigo-400 focus:border-indigo-500 transition">
                    <option value="">-- Loại trạng thái --</option>
                    @foreach ($types as $type)
                        <option value="{{ $type }}" @selected(request('type') == $type)>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="is_active"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-indigo-400 focus:border-indigo-500 transition">
                    <option value="">-- Kích hoạt --</option>
                    <option value="1" @selected(request('is_active') === '1')>✔ Kích hoạt</option>
                    <option value="0" @selected(request('is_active') === '0')>✖ Không kích hoạt</option>
                </select>
            </div>

            <div class="md:col-span-3 flex justify-between gap-4">
                <button type="submit" style="display: block !important;"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition font-semibold w-full md:w-auto">
                    Tìm kiếm
                </button>
                <a href="{{ route('admin.statuses.create') }}" style="display: block !important;"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-500 transition font-semibold w-full md:w-auto text-center">
                    ➕ Thêm trạng thái
                </a>
            </div>
        </form>

        {{-- Toast thông báo --}}
        @if (session('success'))
            <div id="toast-success" class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 shadow">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => document.getElementById('toast-success')?.remove(), 2500);
            </script>
        @endif

        {{-- Bảng trạng thái --}}
        <div class="overflow-x-auto rounded-lg shadow-sm border border-gray-200">
            <table class="w-full table-auto text-sm text-left">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-5 py-3">Tên</th>
                        <th class="px-5 py-3">Mã</th>
                        <th class="px-5 py-3">Loại</th>
                        <th class="px-5 py-3">Màu</th>
                        <th class="px-5 py-3 text-center">Thứ tự</th>
                        <th class="px-5 py-3 text-center">Kích hoạt</th>
                        <th class="px-5 py-3">Mô tả</th>
                        <th class="px-5 py-3 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($statuses as $status)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-4 font-medium text-gray-800">{{ $status->name }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ $status->code }}</td>
                            <td class="px-5 py-4">
                                <span class="bg-gray-200 text-gray-700 text-xs font-medium px-2 py-1 rounded-full">
                                    {{ $status->type }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-xs font-semibold rounded-full px-3 py-1 text-white"
                                    style="background:{{ $status->color }}">
                                    {{ $status->color }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">{{ $status->priority }}</td>
                            <td class="px-5 py-4 text-center">
                                @if ($status->is_active)
                                    <span class="text-green-500 font-bold">✔</span>
                                @else
                                    <span class="text-red-500 font-bold">✖</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-gray-600">{{ $status->description }}</td>
                            <td class="px-5 py-4 text-center space-x-2">
                                <a href="{{ route('admin.statuses.edit', $status) }}"
                                    class="text-sm text-blue-600 hover:underline font-medium">Sửa</a>
                                <form action="{{ route('admin.statuses.destroy', $status) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Xóa trạng thái này?')"
                                        class="text-sm text-red-600 hover:underline font-medium">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-gray-500 py-4">Không có trạng thái nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Phân trang --}}
        <div class="mt-6">
            {{ $statuses->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection
