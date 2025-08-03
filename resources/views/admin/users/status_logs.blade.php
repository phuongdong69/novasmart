@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-md mt-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Lịch sử trạng thái: {{ $user->name }}</h2>
        <a href="{{ route('admin.users.index') }}" 
           class="inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
            ← Quay lại
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="px-4 py-3 font-semibold text-sm text-gray-600">Trạng thái</th>
                    <th class="px-4 py-3 font-semibold text-sm text-gray-600">Ghi chú</th>
                    <th class="px-4 py-3 font-semibold text-sm text-gray-600">Người cập nhật</th>
                    <th class="px-4 py-3 font-semibold text-sm text-gray-600">Thời gian</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y">
                @forelse ($logs as $log)
                    <tr>
                        <td class="px-4 py-2 text-gray-800">{{ $log->status->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ $log->note }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ $log->user->name ?? 'Hệ thống' }}</td>
                        <td class="px-4 py-2 text-gray-600">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">Chưa có lịch sử trạng thái.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
