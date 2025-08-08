@extends('user.layouts.client')

@section('title', 'Tin tức')

@section('meta_description', 'Cập nhật những tin tức mới nhất về sản phẩm và dịch vụ của chúng tôi.')

@section('content')
<!-- Start -->
<section class="relative md:py-24 py-16">
    <div class="container">
        <div class="grid grid-cols-1 justify-center text-center mb-6">
            <h5 class="font-semibold text-3xl leading-normal mb-4">Tin tức mới nhất</h5>
            <p class="text-slate-400 max-w-xl mx-auto">Cập nhật những tin tức mới nhất về sản phẩm, công nghệ và dịch vụ của chúng tôi</p>
        </div>

        <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6">
            @forelse($news as $item)
            <div class="group bg-white dark:bg-slate-900 rounded-lg shadow-sm dark:shadow-gray-800 overflow-hidden hover:shadow-lg hover:dark:shadow-gray-800 transition-all duration-500">
                <div class="relative overflow-hidden">
                    <img src="{{ $item->image_url }}" class="w-full h-48 object-cover group-hover:scale-110 duration-500" alt="{{ $item->title }}">
                    
                    <div class="absolute top-4 start-4">
                        <span class="bg-red-500 text-white text-xs font-bold px-2.5 py-0.5 rounded">
                            {{ $item->published_at->format('d/m/Y') }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <a href="{{ route('news.show', $item->slug) }}" class="title text-xl font-semibold hover:text-red-500 duration-500 line-clamp-2 block mb-3">
                        {{ Str::limit($item->title, 50) }}
                    </a>
                    
                    @if($item->excerpt)
                    <p class="text-slate-400 text-sm line-clamp-3 mb-4">{{ $item->excerpt }}</p>
                    @endif
                    
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-700">
                        <span class="text-slate-400 text-xs">
                            <i class="mdi mdi-account me-1"></i>
                            {{ $item->author->name }}
                        </span>
                        <span class="text-slate-400 text-xs">
                            <i class="mdi mdi-clock me-1"></i>
                            {{ $item->published_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="text-slate-400">
                    <i class="mdi mdi-newspaper text-6xl mb-4"></i>
                    <h4 class="text-xl font-semibold mb-2">Chưa có tin tức nào</h4>
                    <p>Hãy quay lại sau để xem những tin tức mới nhất!</p>
                </div>
            </div>
            @endforelse
        </div>

        @if($news->hasPages())
        <div class="grid grid-cols-1 mt-8">
            <div class="text-center">
                {{ $news->links() }}
            </div>
        </div>
        @endif
    </div>
</section>
<!-- End -->
@endsection 