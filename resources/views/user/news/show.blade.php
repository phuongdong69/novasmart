@extends('user.layouts.client')

@section('title', $news->title)

@section('content')
<div class="container mx-auto px-4 py-8">
  <div class="max-w-4xl mx-auto">
    {{-- Breadcrumb --}}
    <nav class="mb-8">
      <ol class="flex items-center space-x-2 text-sm text-gray-600">
        <li><a href="{{ route('user.news.index') }}" class="hover:text-blue-600">Tin tức</a></li>
        <li><span class="mx-2">/</span></li>
        <li><span class="text-gray-900">{{ $news->title }}</span></li>
      </ol>
    </nav>

    {{-- Article Header --}}
    <header class="mb-8">
      <div class="flex items-center gap-4 mb-4">
        <span class="px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 rounded-full">
          {{ $news->category_name ?: 'Không phân loại' }}
        </span>
        @if($news->is_featured)
          <span class="px-3 py-1 text-sm font-medium bg-orange-100 text-orange-800 rounded-full">
            Nổi bật
          </span>
        @endif
      </div>
      
      <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $news->title }}</h1>
      
      <div class="flex items-center gap-4 text-sm text-gray-600 mb-6">
        <span class="flex items-center">
          <i class="fas fa-user mr-2"></i>
          {{ $news->author->name ?? 'N/A' }}
        </span>
        <span class="flex items-center">
          <i class="fas fa-calendar mr-2"></i>
          {{ $news->created_at->format('d/m/Y H:i') }}
        </span>
        <span class="flex items-center">
          <i class="fas fa-eye mr-2"></i>
          {{ $news->views ?? 0 }} lượt xem
        </span>
      </div>

      @if($news->excerpt)
        <div class="text-lg text-gray-700 bg-gray-50 p-4 rounded-lg mb-6">
          {{ $news->excerpt }}
        </div>
      @endif
    </header>

    {{-- Featured Image --}}
    @if($news->featured_image && file_exists(public_path($news->featured_image)))
      <div class="mb-8">
        <img src="{{ $news->featured_image }}" 
             alt="{{ $news->title }}" 
             class="w-full h-64 md:h-96 object-cover rounded-lg">
      </div>
    @endif

    {{-- Article Content --}}
    <article class="prose prose-lg max-w-none mb-8">
      {!! $news->content !!}
    </article>

    {{-- Tags --}}
    @if($news->tags && count($news->tags) > 0)
      <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">Tags:</h3>
        <div class="flex flex-wrap gap-2">
          @foreach($news->tags as $tag)
            <span class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-full">
              #{{ $tag }}
            </span>
          @endforeach
        </div>
      </div>
    @endif

    {{-- Back to News --}}
    <div class="text-center">
      <a href="{{ route('user.news.index') }}" 
         class="inline-flex items-center px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
        <i class="fas fa-arrow-left mr-2"></i>
        Quay lại danh sách tin tức
      </a>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.prose {
    color: #374151;
    line-height: 1.75;
    font-size: 1.125rem;
}
.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    color: #111827;
    font-weight: 700;
    margin-top: 2.5rem;
    margin-bottom: 1.5rem;
}
.prose h2 {
    font-size: 1.875rem;
    border-bottom: 2px solid #e5e7eb;
    padding-bottom: 0.5rem;
}
.prose p {
    margin-bottom: 1.5rem;
    line-height: 1.8;
}
.prose img {
    border-radius: 0.75rem;
    margin: 2rem 0;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}
.prose blockquote {
    border-left: 4px solid #3b82f6;
    padding-left: 1.5rem;
    font-style: italic;
    margin: 2rem 0;
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 0.5rem;
}
.prose ul, .prose ol {
    margin: 1.5rem 0;
    padding-left: 2rem;
}
.prose li {
    margin-bottom: 0.75rem;
    line-height: 1.7;
}
.prose strong {
    font-weight: 700;
    color: #111827;
}
.prose a {
    color: #3b82f6;
    text-decoration: underline;
}
.prose a:hover {
    color: #2563eb;
}
</style>
@endpush 