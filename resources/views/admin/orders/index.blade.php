@extends('admin.layouts.app')

@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
      <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

        {{-- Tiêu đề + Nút thêm mới --}}
        <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex justify-between items-center">
          <h3 class="dark:text-white text-lg font-semibold">Quản lý đơn hàng</h3>
          {{-- <div class="flex items-center gap-2">
            <a href="{{ route('admin.orders.export') }}" 
               class="bg-green-500 hover:bg-green-700 text-white text-sm font-bold py-2 px-4 rounded">
              Xuất Excel
            </a>
          </div> --}}
        </div>

        {{-- Thanh tìm kiếm --}}
        <div class="px-6 mt-4">
          <form method="GET" action="{{ route('admin.orders.index') }}" class="flex justify-end items-center gap-2">
            <input
              type="search"
              name="keyword"
              class="border border-slate-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300"
              placeholder="Tìm theo mã đơn hàng hoặc tên khách hàng..."
              value="{{ request('keyword') }}"
            >
            <button type="submit" class="text-sm px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
              Tìm
            </button>
          </form>
        </div>

        {{-- Bảng đơn hàng --}}
        <div class="flex-auto px-0 pt-4 pb-2">
          <div class="p-0 overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">MÃ ĐƠN HÀNG</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">KHÁCH HÀNG</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">TỔNG TIỀN</th>
                  <th class="px-6 py-3 text-center uppercase text-xs font-bold text-slate-400">TRẠNG THÁI</th>
                  <th class="px-6 py-3 text-center uppercase text-xs font-bold text-slate-400">THANH TOÁN</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">NGÀY TẠO</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">THAO TÁC</th>
                </tr>
              </thead>
              <tbody>
                @forelse($orders as $order)
                  <tr class="border-b dark:border-white/40 hover:bg-gray-50 transition">
                    <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $order->order_code }}</td>
                    <td class="px-6 py-3 text-sm">{{ $order->user->name ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm font-medium text-gray-900">{{ number_format($order->total_price, 0, ',', '.') }} ₫</td>
                    
                    <td class="px-6 py-3 text-sm text-center">
                      {!! $order->getStatusDisplay() !!}
                    </td>

                    <td class="px-6 py-3 text-sm text-center">
                      @if($order->payment && $order->payment->status)
                        <span class="px-2.5 py-1.4 text-xs rounded-1.8 font-bold uppercase leading-none text-white"
                          style="background-color: {{ $order->payment->status->color ?? '#6b7280' }};">
                          {{ $order->payment->status->name ?? 'Không xác định' }}
                        </span>
                      @else
                        <span class="px-2.5 py-1.4 text-xs rounded-1.8 font-bold uppercase leading-none bg-gray-300 text-gray-700">
                          Chưa có
                        </span>
                      @endif
                    </td>

                    <td class="px-6 py-3 text-sm">{{ $order->created_at ? $order->created_at->format('d/m/Y') : '-' }}</td>

                    <td class="px-6 py-3 text-sm">
                      <div class="flex items-center gap-2">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:underline">Chi tiết</a>
                        <a href="{{ route('admin.orders.status_logs', $order) }}" class="text-green-600 hover:underline">Lịch sử</a>
                        
                        @php
                          $cancelStatus = \App\Models\Status::where('type', 'order')->where('code', 'cancelled')->first();
                          $allowCancel = $order->orderStatus && in_array($order->orderStatus->code, ['pending', 'confirmed']);
                        @endphp

                        @if ($cancelStatus && $allowCancel)
                          <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">
                            @csrf
                            <input type="hidden" name="status_id" value="{{ $cancelStatus->id }}">
                            <button type="submit" class="text-red-600 hover:underline">Hủy</button>
                          </form>
                        @endif
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center py-4 text-sm text-gray-500">Không có dữ liệu nào trùng khớp.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-4 px-6">
              @if ($orders->hasPages())
                <div style="display: flex; justify-content: center; gap: 8px; margin: 20px 0;">
                  @if ($orders->onFirstPage())
                    <span style="padding: 8px 16px; background: #f3f4f6; color: #9ca3af; border-radius: 8px; cursor: not-allowed;">Trước</span>
                  @else
                    <a href="{{ $orders->previousPageUrl() }}" style="padding: 8px 16px; background: white; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; transition: all 0.2s;">Trước</a>
                  @endif

                  @for ($i = 1; $i <= $orders->lastPage(); $i++)
                    @if ($i == $orders->currentPage())
                      <span style="padding: 8px 16px; background: #3b82f6; color: white; border-radius: 8px; font-weight: bold;">{{ $i }}</span>
                    @else
                      <a href="{{ $orders->url($i) }}" style="padding: 8px 16px; background: white; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; transition: all 0.2s;">{{ $i }}</a>
                    @endif
                  @endfor

                  @if ($orders->hasMorePages())
                    <a href="{{ $orders->nextPageUrl() }}" style="padding: 8px 16px; background: white; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; text-decoration: none; transition: all 0.2s;">Tiếp</a>
                  @else
                    <span style="padding: 8px 16px; background: #f3f4f6; color: #9ca3af; border-radius: 8px; cursor: not-allowed;">Tiếp</span>
                  @endif
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@if (session('success'))
  <div id="toast-success" class="mb-4 p-3 bg-green-100 text-green-700 rounded shadow transition-all duration-300">{{ session('success') }}</div>
  <script>
    setTimeout(() => {
      const toast = document.getElementById('toast-success');
      if (toast) toast.style.display = 'none';
    }, 2500);
  </script>
@endif

@if (session('error'))
  <div id="toast-error" class="mb-4 p-3 bg-red-100 text-red-700 rounded shadow transition-all duration-300">{{ session('error') }}</div>
  <script>
    setTimeout(() => {
      const toast = document.getElementById('toast-error');
      if (toast) toast.style.display = 'none';
    }, 2500);
  </script>
@endif
@endsection
