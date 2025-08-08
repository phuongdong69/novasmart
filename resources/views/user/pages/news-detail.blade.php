@extends('user.layouts.client')

@section('title', $news->title)

@section('meta_description', $news->excerpt)

@section('content')
<!-- Start -->
<section class="relative md:py-24 py-16">
    <div class="container">
        <div class="grid lg:grid-cols-4 md:grid-cols-3 grid-cols-1 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-3 md:col-span-2">
                <div class="bg-white dark:bg-slate-900 rounded-md shadow-sm dark:shadow-gray-800 overflow-hidden">
                    @if($news->image)
                    <div class="relative">
                        <img src="{{ $news->image_url }}" class="w-full" alt="{{ $news->title }}">
                    </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-center text-slate-400 text-sm mb-4">
                            <span class="flex items-center">
                                <i class="mdi mdi-account me-1"></i>
                                {{ $news->author->name }}
                            </span>
                            <span class="mx-2">•</span>
                            <span class="flex items-center">
                                <i class="mdi mdi-clock me-1"></i>
                                {{ $news->published_at->format('d/m/Y H:i') }}
                            </span>
                            <span class="mx-2">•</span>
                            <span class="flex items-center">
                                <i class="mdi mdi-eye me-1"></i>
                                {{ $news->published_at->diffForHumans() }}
                            </span>
                        </div>

                        <h1 class="text-3xl font-bold mb-4">{{ $news->title }}</h1>
                        
                        @if($news->excerpt)
                        <div class="bg-slate-50 dark:bg-slate-800 rounded-md p-4 mb-6">
                            <p class="text-slate-600 dark:text-slate-300 italic">{{ $news->excerpt }}</p>
                        </div>
                        @endif

                        <div class="prose prose-lg max-w-none dark:prose-invert">
                            {!! nl2br(e($news->content)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 md:col-span-1">
                <!-- Related News -->
                @if($relatedNews->count() > 0)
                <div class="bg-white dark:bg-slate-900 rounded-md shadow-sm dark:shadow-gray-800 p-6 mb-6">
                    <h5 class="font-semibold text-lg mb-4">Tin tức liên quan</h5>
                    
                    <div class="space-y-4">
                        @foreach($relatedNews as $relatedItem)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <img src="{{ $relatedItem->image_url }}" alt="{{ $relatedItem->title }}" 
                                     class="w-16 h-16 object-cover rounded-md">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('news.show', $relatedItem->slug) }}" 
                                   class="text-sm font-medium text-gray-900 dark:text-white hover:text-red-500 duration-500 line-clamp-2">
                                    {{ $relatedItem->title }}
                                </a>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $relatedItem->published_at->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Quick Links -->
                <div class="bg-white dark:bg-slate-900 rounded-md shadow-sm dark:shadow-gray-800 p-6">
                    <h5 class="font-semibold text-lg mb-4">Liên kết nhanh</h5>
                    
                    <div class="space-y-2">
                        <a href="{{ route('home') }}" class="flex items-center text-sm text-gray-600 dark:text-gray-300 hover:text-red-500 duration-500">
                            <i class="mdi mdi-home me-2"></i>
                            Trang chủ
                        </a>
                        <a href="{{ route('products.list') }}" class="flex items-center text-sm text-gray-600 dark:text-gray-300 hover:text-red-500 duration-500">
                            <i class="mdi mdi-package-variant me-2"></i>
                            Sản phẩm
                        </a>
                        <a href="{{ route('about') }}" class="flex items-center text-sm text-gray-600 dark:text-gray-300 hover:text-red-500 duration-500">
                            <i class="mdi mdi-information me-2"></i>
                            Giới thiệu
                        </a>
                        <a href="{{ route('news.index') }}" class="flex items-center text-sm text-gray-600 dark:text-gray-300 hover:text-red-500 duration-500">
                            <i class="mdi mdi-newspaper me-2"></i>
                            Tin tức
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to News List -->
        <div class="mt-8 text-center">
            <a href="{{ route('news.index') }}" class="inline-flex items-center text-red-500 hover:text-red-600 duration-500">
                <i class="mdi mdi-arrow-left me-2"></i>
                Quay lại danh sách tin tức
            </a>
        </div>
    </div>
</section>
<!-- End -->
@endsection 