@extends('user.layouts.client')

@section('title', 'Tin tức')

@section('content')
<div class="container mx-auto px-4 py-8">
  <div class="flex flex-col lg:flex-row gap-8">
    {{-- Main Content --}}
    <div class="lg:w-3/4">
      <h1 class="text-3xl font-bold text-gray-800 mb-8">Tin tức</h1>
      
      {{-- Search and Filter --}}
      <div class="mb-6">
        <form method="GET" action="{{ route('user.news.index') }}" class="flex flex-wrap gap-4">
          <input
            type="search"
            name="search"
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Tìm kiếm tin tức..."
            value="{{ request('search') }}"
          >
          <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Tất cả danh mục</option>
            @foreach($categories as $category)
              <option value="{{ $category->category_slug }}" {{ request('category') == $category->category_slug ? 'selected' : '' }}>
                {{ $category->category_name }}
              </option>
            @endforeach
          </select>
          <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
            Tìm kiếm
          </button>
        </form>
      </div>

      {{-- News Grid --}}
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($news as $item)
          <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
            <div class="aspect-w-16 aspect-h-9">
              @if($item->featured_image && file_exists(public_path($item->featured_image)))
                <img src="{{ $item->featured_image }}" 
                     alt="{{ $item->title }}" 
                     class="w-full h-48 object-cover">
              @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                  <i class="fas fa-image text-gray-400 text-4xl"></i>
                </div>
              @endif
            </div>
            <div class="p-4">
              <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                  {{ $item->category_name ?: 'Không phân loại' }}
                </span>
                @if($item->is_featured)
                  <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full">
                    Nổi bật
                  </span>
                @endif
              </div>
              <h2 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
                <a href="{{ route('user.news.show', $item->slug) }}" class="hover:text-blue-600">
                  {{ $item->title }}
                </a>
              </h2>
              <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                {{ $item->excerpt ?: Str::limit(strip_tags($item->content), 120) }}
              </p>
              <div class="flex items-center justify-between text-sm text-gray-500">
                <span>{{ $item->author->name ?? 'N/A' }}</span>
                <span>{{ $item->created_at->format('d/m/Y') }}</span>
              </div>
            </div>
          </article>
        @empty
          <div class="col-span-full text-center py-12">
            <div class="text-gray-500">
              <i class="fas fa-newspaper text-4xl mb-4"></i>
              <p>Không có tin tức nào</p>
            </div>
          </div>
        @endforelse
      </div>

      {{-- Pagination --}}
      @if($news->hasPages())
        <div class="mt-8">
          {{ $news->links() }}
        </div>
      @endif
    </div>

    {{-- Sidebar (Right) --}}
    <div class="lg:w-1/4 lg:order-last">
      <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Danh mục</h3>
        <ul class="space-y-2">
          <li>
            <a href="{{ route('user.news.index') }}" 
               class="text-gray-600 hover:text-blue-600 {{ !request('category') ? 'text-blue-600 font-medium' : '' }}">
              Tất cả
            </a>
          </li>
          @foreach($categories as $category)
            <li>
              <a href="{{ route('user.news.index', ['category' => $category->category_slug]) }}" 
                 class="text-gray-600 hover:text-blue-600 {{ request('category') == $category->category_slug ? 'text-blue-600 font-medium' : '' }}">
                {{ $category->category_name }}
              </a>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection 