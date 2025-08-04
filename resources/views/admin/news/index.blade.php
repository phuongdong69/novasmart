@extends('admin.layouts.app')

@section('title', 'Quản lý tin tức')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
      <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

        {{-- Tiêu đề + Nút thêm mới --}}
        <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex justify-between items-center">
          <h3 class="dark:text-white text-lg font-semibold">Quản lý tin tức</h3>
          <a href="{{ route('admin.news.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded-lg">
            + Thêm mới
          </a>
        </div>

        {{-- Thanh tìm kiếm và lọc --}}
        <div class="px-6 mt-4">
          <form method="GET" action="{{ route('admin.news.index') }}" class="flex flex-wrap justify-between items-center gap-4">
            <div class="flex items-center gap-2">
              <input
                type="search"
                name="search"
                class="border border-slate-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300"
                placeholder="Tìm kiếm tin tức..."
                value="{{ request('search') }}"
              >
              <select name="status" class="border border-slate-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300">
                <option value="">Tất cả trạng thái</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
              </select>
              <select name="category" class="border border-slate-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300">
                <option value="">Tất cả danh mục</option>
                @foreach($categories as $category)
                  <option value="{{ $category->category_slug }}" {{ request('category') == $category->category_slug ? 'selected' : '' }}>
                    {{ $category->category_name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="flex items-center gap-2">
              <button type="submit" class="text-sm px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Tìm kiếm
              </button>
              <a href="{{ route('admin.news.index') }}" class="text-sm px-3 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                Reset
              </a>
            </div>
          </form>
        </div>

        {{-- Bảng tin tức --}}
        <div class="flex-auto px-0 pt-4 pb-2">
          <div class="p-0 overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Tiêu đề</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Danh mục</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Tác giả</th>
                  <th class="px-6 py-3 text-center uppercase text-xs font-bold text-slate-400">Trạng thái</th>
                  <th class="px-6 py-3 text-center uppercase text-xs font-bold text-slate-400">Lượt xem</th>
                  <th class="px-6 py-3 text-center uppercase text-xs font-bold text-slate-400">Ngày tạo</th>
                  <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Thao tác</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($news as $item)
                  <tr class="border-b dark:border-white/40 hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                      <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg overflow-hidden mr-4">
                          @if($item->featured_image && file_exists(public_path($item->featured_image)))
                            <img src="{{ $item->featured_image }}" 
                                 alt="Ảnh đại diện" 
                                 class="w-full h-full object-cover">
                          @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                              <i class="fas fa-image text-gray-400 text-lg"></i>
                            </div>
                          @endif
                        </div>
                        <div>
                          <div class="text-sm font-medium text-gray-800">{{ $item->title }}</div>
                          <div class="text-sm text-gray-500">{{ Str::limit($item->excerpt, 60) }}</div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 text-sm">
                      <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                        {{ $item->category_name ?: 'Không phân loại' }}
                      </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $item->author->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-center">
                      <span class="px-2 py-1 text-xs font-medium rounded-full
                        {{ $item->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $item->status == 'published' ? 'Đã xuất bản' : 'Bản nháp' }}
                      </span>
                      @if($item->is_featured)
                        <div class="mt-1">
                          <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full">
                            Nổi bật
                          </span>
                        </div>
                      @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-center text-gray-600">{{ $item->views ?? 0 }}</td>
                    <td class="px-6 py-4 text-sm text-center text-gray-600">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 text-sm text-center">
                      <a href="{{ route('admin.news.show', $item->id) }}" 
                         class="text-blue-600 hover:text-blue-800 transition-colors"
                         title="Xem chi tiết">
                        <i class="fas fa-eye"></i>
                      </a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                      Không có tin tức nào
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        {{-- Phân trang --}}
        @if($news->hasPages())
          <div class="px-6 py-4 border-t border-gray-200">
            {{ $news->links() }}
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection 