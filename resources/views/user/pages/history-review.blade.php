@extends('user.layouts.client')

@section('title', 'Lịch sử đánh giá')
@section('meta_description', 'Đây là trang lịch sử đánh giá của Nova Smart.')

@section('content')
<section class="relative w-full py-20 lg:py-24 bg-gray-50 dark:bg-slate-800">
    <div class="container">
        <div class="grid grid-cols-1 mt-10">
            <h3 class="text-3xl font-semibold">Lịch sử đánh giá</h3>
        </div>

        <ul class="mt-4 tracking-[0.5px]">
            <li class="inline-block uppercase text-[13px] font-bold hover:text-orange-500">
                <a href="{{ route('home') }}">Trang chủ</a>
            </li>
            <li class="inline-block text-base text-slate-950 dark:text-white mx-1">
                <i class="mdi mdi-chevron-right"></i>
            </li>
            <li class="inline-block uppercase text-[13px] font-bold text-orange-500">Lịch sử đánh giá</li>
        </ul>
    </div>
</section>

<section class="relative py-10">
    <div class="container">
        {{-- Bộ lọc --}}
        <div class="bg-white p-6 rounded-lg shadow-md mb-10">
            <form method="GET" id="filterForm" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="content" placeholder="Nội dung"
                       value="{{ request('content') }}"
                       class="form-input border-gray-300 rounded h-10 px-3 col-span-2">

                <input type="date" name="from" value="{{ request('from') }}"
                       class="form-input border-gray-300 rounded h-10 px-3">

                <input type="date" name="to" value="{{ request('to') }}"
                       class="form-input border-gray-300 rounded h-10 px-3">

                <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded flex items-center justify-center gap-2 h-10 transition">
                    <i class="mdi mdi-filter-variant text-lg"></i> Lọc
                </button>
            </form>
        </div>

        {{-- Danh sách đánh giá --}}
        @if($ratings->isEmpty())
            <div class="bg-white p-6 rounded-md shadow text-center text-gray-600">
                @if(request()->hasAny(['content', 'from', 'to']))
                    Không có đánh giá nào phù hợp.
                @else
                    Bạn chưa có đánh giá nào.
                @endif
            </div>
        @else
            <div class="overflow-x-auto mb-6">
                <table class="min-w-full bg-white rounded-lg shadow-md text-sm">
                    <thead class="bg-gray-100 text-gray-700 font-semibold">
                        <tr>
                            <th class="px-5 py-3 text-left">Sản phẩm</th>
                            <th class="px-5 py-3 text-left">Đánh giá</th>
                            <th class="px-5 py-3 text-left">Nội dung</th>
                            <th class="px-5 py-3 text-left">Ngày đánh giá</th>
                            <th class="px-5 py-3 text-center">Xoá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ratings as $rating)
                            @php
                                $product = $rating->productVariant->product ?? null;
                                $thumbnail = $product?->thumbnails->where('is_primary', 1)->first();
                                $imagePath = $thumbnail
                                    ? asset('storage/' . $thumbnail->url)
                                    : asset('assets/images/no-image.jpg');
                                $commentKey = $rating->user_id . '-' . $rating->order_detail_id;
                                $comment = $comments[$commentKey] ?? null;
                            @endphp
                            <tr class="bg-gray-50 hover:bg-gray-100 transition">
                                <td class="px-5 py-4 align-middle">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $imagePath }}"
                                             alt="{{ $product->name ?? 'Ảnh sản phẩm' }}"
                                             class="w-12 h-12 object-cover rounded-md shadow-sm border">
                                        <a href="#"
                                           class="text-gray-800 font-medium hover:text-orange-600 truncate max-w-[150px]">
                                            {{ $product->name ?? 'Sản phẩm không tồn tại' }}
                                        </a>
                                    </div>
                                </td>

                                <td class="px-5 py-4 align-middle">
                                    <div class="flex items-center gap-1 text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="mdi mdi-star{{ $i <= $rating->rating ? '' : '-outline' }}"></i>
                                        @endfor
                                        <span class="text-xs text-gray-500 ml-1">({{ $rating->rating }})</span>
                                    </div>
                                </td>

                                <td class="px-5 py-4 align-middle italic text-gray-700 max-w-xs truncate">
                                    "{{ $comment->content ?? 'Không có bình luận' }}"
                                </td>

                                <td class="px-5 py-4 align-middle text-gray-500 text-xs whitespace-nowrap">
                                    {{ $rating->created_at->format('d/m/Y H:i') }}
                                </td>

                                <td class="px-5 py-4 align-middle text-center">
                                    <form action="{{ route('user.reviews.destroy', $rating->id) }}" method="POST"
                                          onsubmit="return confirm('Bạn có chắc muốn xoá đánh giá này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-500 hover:text-red-600 flex items-center justify-center gap-1 text-sm font-medium">
                                            <i class="mdi mdi-delete-outline text-xl"></i>
                                            <span class="hidden md:inline-block">Xoá</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $ratings->links() }}
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('filterForm');
        if (!form) return;

        // ⛔ Reset query khi F5 hoặc quay lại trang bằng back/forward cache
        const navigationType = performance.getEntriesByType("navigation")[0]?.type;
        if (navigationType === 'reload' || performance.navigation.type === 1) {
            const url = new URL(window.location.href);
            if (url.search.length > 0) {
                url.search = '';
                window.location.replace(url.toString());
            }
        }
    });
</script>
@endpush
