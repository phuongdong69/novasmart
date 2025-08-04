@extends('admin.layouts.app')

@section('title', 'Chi tiết tin tức')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
      <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

        {{-- Header --}}
        <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent">
          <h3 class="dark:text-white text-lg font-semibold mb-4">Chi tiết tin tức</h3>
        </div>

        {{-- Content --}}
        <div class="p-6">
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Thông tin chính --}}
            <div class="lg:col-span-2">
              {{-- Ảnh đại diện --}}
              @if($news->featured_image)
                <div class="mb-6">
                  <img src="{{ $news->featured_image }}" 
                       alt="Ảnh đại diện" 
                       class="w-full h-64 object-cover rounded-lg">
                </div>
              @endif

              {{-- Tiêu đề --}}
              <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $news->title }}</h1>
                <div class="flex items-center gap-4 text-sm text-gray-500">
                  <span><i class="fas fa-user mr-1"></i> {{ $news->author->name }}</span>
                  <span><i class="fas fa-calendar mr-1"></i> {{ $news->created_at->format('d/m/Y H:i') }}</span>
                  <span><i class="fas fa-eye mr-1"></i> {{ number_format($news->views) }} lượt xem</span>
                </div>
              </div>

              {{-- Tóm tắt --}}
              @if($news->excerpt)
                <div class="mb-6">
                  <h3 class="text-lg font-semibold text-gray-900 mb-2">Tóm tắt</h3>
                  <p class="text-gray-700 leading-relaxed">{{ $news->excerpt }}</p>
                </div>
              @endif

              {{-- Nội dung --}}
              <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Nội dung</h3>
                <div class="prose max-w-none">
                  {!! nl2br(e($news->content)) !!}
                </div>
              </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
              <div class="space-y-6">
                {{-- Thông tin cơ bản --}}
                <div class="bg-gray-50 rounded-lg p-4">
                  <h4 class="text-lg font-semibold text-gray-900 mb-4">Thông tin cơ bản</h4>
                  <div class="space-y-3">
                    <div>
                      <span class="text-sm font-medium text-gray-500">Trạng thái:</span>
                      <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full
                        {{ $news->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $news->status == 'published' ? 'Đã xuất bản' : 'Bản nháp' }}
                      </span>
                    </div>
                    
                    @if($news->is_featured)
                      <div>
                        <span class="text-sm font-medium text-gray-500">Nổi bật:</span>
                        <span class="ml-2 px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full">
                          Có
                        </span>
                      </div>
                    @endif
                    
                    <div>
                      <span class="text-sm font-medium text-gray-500">Kích hoạt:</span>
                      <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full
                        {{ $news->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $news->is_active ? 'Có' : 'Không' }}
                      </span>
                    </div>
                    
                    @if($news->published_at)
                      <div>
                        <span class="text-sm font-medium text-gray-500">Ngày xuất bản:</span>
                        <span class="ml-2 text-sm text-gray-900">{{ $news->published_at->format('d/m/Y H:i') }}</span>
                      </div>
                    @endif
                    
                    <div>
                      <span class="text-sm font-medium text-gray-500">Lượt thích:</span>
                      <span class="ml-2 text-sm text-gray-900">{{ number_format($news->likes) }}</span>
                    </div>
                  </div>
                </div>

                {{-- Danh mục --}}
                @if($news->category_name)
                  <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Danh mục</h4>
                    <span class="px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 rounded-full">
                      {{ $news->category_name }}
                    </span>
                  </div>
                @endif

                {{-- Tags --}}
                @if($news->tags && count($news->tags) > 0)
                  <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Tags</h4>
                    <div class="flex flex-wrap gap-2">
                      @foreach($news->tags as $tag)
                        <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">
                          {{ $tag }}
                        </span>
                      @endforeach
                    </div>
                  </div>
                @endif

                {{-- Thống kê --}}
                <div class="bg-gray-50 rounded-lg p-4">
                  <h4 class="text-lg font-semibold text-gray-900 mb-4">Thống kê</h4>
                  <div class="space-y-3">
                    <div class="flex justify-between">
                      <span class="text-sm text-gray-500">Lượt xem:</span>
                      <span class="text-sm font-medium text-gray-900">{{ number_format($news->views) }}</span>
                    </div>
                    <div class="flex justify-between">
                      <span class="text-sm text-gray-500">Lượt thích:</span>
                      <span class="text-sm font-medium text-gray-900">{{ number_format($news->likes) }}</span>
                    </div>
                    <div class="flex justify-between">
                      <span class="text-sm text-gray-500">Ngày tạo:</span>
                      <span class="text-sm font-medium text-gray-900">{{ $news->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                      <span class="text-sm text-gray-500">Cập nhật:</span>
                      <span class="text-sm font-medium text-gray-900">{{ $news->updated_at->format('d/m/Y') }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Action Buttons at Bottom --}}
        <div class="p-6 pt-0">
          <div class="flex items-center justify-end gap-4">
            <a href="{{ route('admin.news.edit', $news->id) }}"
               class="text-blue-600 hover:text-blue-800 flex items-center px-4 py-2 border border-blue-300 rounded-lg hover:bg-blue-50">
              <i class="fas fa-edit mr-1"></i> Sửa
            </a>

            <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST" class="inline"
                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa tin tức này không?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:text-red-800 flex items-center px-4 py-2 border border-red-300 rounded-lg hover:bg-red-50">
                <i class="fas fa-trash mr-1"></i> Xóa
              </button>
            </form>
            
            <a href="{{ route('admin.news.index') }}"
               class="text-gray-600 hover:text-gray-800 flex items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
              <i class="fas fa-arrow-left mr-1"></i> Quay lại
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection 