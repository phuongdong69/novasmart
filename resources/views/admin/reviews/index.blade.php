@extends('admin.layouts.app')
@section('title', 'Danh sách đánh giá')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
      <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

        {{-- Tiêu đề --}}
        <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex justify-between items-center">
          <h3 class="dark:text-white text-lg font-semibold">Danh sách đánh giá</h3>
        </div>

        {{-- Thanh tìm kiếm --}}
        <div class="px-6 mt-4">
          <form method="GET" action="{{ route('admin.reviews.index') }}" class="flex justify-end items-center gap-2">
            <input
              type="search"
              name="keyword"
              class="border border-slate-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300"
              placeholder="Tìm theo tên sản phẩm hoặc nội dung..."
              value="{{ request('keyword') }}"
            >
            <button type="submit" class="text-sm px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
              Tìm
            </button>
          </form>
        </div>

        {{-- Bảng đánh giá --}}
        <div class="flex-auto px-0 pt-4 pb-2">
          <div class="p-0 overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">ID</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Sản phẩm</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Người dùng</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Đánh giá</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Nội dung bình luận</th>
                  <th class="px-6 py-3 text-center uppercase text-xs font-bold text-slate-400">Trạng thái</th>
                  <th class="px-6 py-3 text-center uppercase text-xs font-bold text-slate-400">Ngày đánh giá</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($ratings as $rating)
                  @php
                    $product = $rating->productVariant->product ?? null;
                    $user = $rating->user ?? null;
                    $commentKey = $rating->user_id . '-' . $rating->order_detail_id;
                    $comment = $comments[$commentKey] ?? null;
                    $statusCode = $rating->status->code ?? 'inactive';
                    $isActive = $statusCode === 'active';
                  @endphp
                  <tr class="border-b dark:border-white/40 hover:bg-gray-50 transition">
                    <td class="px-6 py-3 text-sm">{{ $rating->id }}</td>

                    <td class="px-6 py-3 text-sm font-medium text-gray-800">
                      {{ $product?->name ?? 'Không tồn tại' }}
                    </td>

                    <td class="px-6 py-3 text-sm text-gray-800">
                      {{ $user?->name ?? 'Không rõ' }}
                    </td>

                    <td class="px-6 py-3 text-sm">
                      {{ $rating->rating }} ⭐
                    </td>

                    <td class="px-6 py-3 text-sm italic text-gray-700 max-w-xs truncate">
                    {{ $rating->comment?->content ?? 'Không có nội dung' }}
                    </td>

                    <td class="px-6 py-3 text-sm text-center">
                      <form action="{{ route('admin.reviews.toggleStatus', $rating->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                          class="px-2.5 py-1.4 text-xs rounded-1.8 font-bold uppercase leading-none text-white
                          {{ $isActive ? 'bg-gradient-to-tl from-emerald-500 to-teal-400' : 'bg-gradient-to-tl from-slate-600 to-slate-300' }}">
                          {{ $isActive ? 'Hoạt động' : 'Ngừng hoạt động' }}
                        </button>
                      </form>
                    </td>

                    <td class="px-6 py-3 text-center text-sm text-slate-500">
                      {{ $rating->created_at->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center py-4 text-sm text-gray-500">
                      Không có đánh giá nào.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-4 px-6">
              {{ $ratings->withQueryString()->links() }}
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
