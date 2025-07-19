@extends('admin.layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">
            Lịch sử thay đổi trạng thái: Đơn hàng #{{ $order->id }}
        </h1>




        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 border-b">Thời gian</th>
                        <th class="px-6 py-3 border-b">Trạng thái</th>
                        <th class="px-6 py-3 border-b">Người thay đổi</th>
                        <th class="px-6 py-3 border-b">Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 border-b whitespace-nowrap">{{ $log->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 border-b whitespace-nowrap">
                                <span class="inline-block px-3 py-1 rounded text-white text-xs font-medium"
                                    style="background:{{ $log->status->color }}">
                                    {{ $log->status->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 border-b whitespace-nowrap">{{ $log->user->name ?? 'Hệ thống' }}</td>
                            <td class="px-6 py-4 border-b">{{ $log->note }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Chưa có lịch sử thay đổi trạng
                                thái.</td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
            <div class="flex justify-end gap-3">
                
                <a href="{{ route('admin.orders.index') }}"
                    class="bg-blue-500 hover:bg-red-700 text-white text-sm font-bold py-2 px-4 rounded">
                    Quay lại
                </a>

            </div>

        </div>


    </div>
@endsection
