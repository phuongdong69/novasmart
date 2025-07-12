@extends('admin.layouts.app')
@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Lịch sử thay đổi trạng thái: Đơn hàng #{{ $order->id }}</h1>
    <a href="{{ route('admin.orders.index') }}" class="mb-4 inline-block text-blue-500">Quay lại danh sách đơn hàng</a>
    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="border px-4 py-2">Thời gian</th>
                <th class="border px-4 py-2">Trạng thái</th>
                <th class="border px-4 py-2">Người thay đổi</th>
                <th class="border px-4 py-2">Ghi chú</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td class="border px-4 py-2">{{ $log->created_at }}</td>
                <td class="border px-4 py-2">
                    <span style="background:{{ $log->status->color }};color:#fff;padding:2px 8px;border-radius:4px">
                        {{ $log->status->name }}
                    </span>
                </td>
                <td class="border px-4 py-2">{{ optional($log->user)->name ?? 'Hệ thống' }}</td>
                <td class="border px-4 py-2">{{ $log->note }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 