@extends('admin.layouts.app')
@section('title', 'Chi tiết tin tức')
@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <!-- Header -->
                <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex justify-between items-center">
                    <h6 class="dark:text-white text-lg font-semibold">Chi tiết tin tức</h6>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.news.edit', $news->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                            <svg class="h-4 w-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Chỉnh sửa
                        </a>
                        <a href="{{ route('admin.news.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white text-sm font-bold py-2 px-4 rounded">
                            <svg class="h-4 w-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Quay lại
                        </a>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Content -->
                        <div class="lg:col-span-2">
                            <div class="space-y-6">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $news->title }}</h2>
                                    
                                    <!-- Thông tin tác giả và thời gian -->
                                    <div class="flex items-center text-slate-400 text-sm mb-6">
                                        <span class="flex items-center">
                                            <i class="mdi mdi-account me-1"></i>
                                            {{ $news->author->name }}
                                        </span>
                                        <span class="mx-2">•</span>
                                        <span class="flex items-center">
                                            <i class="mdi mdi-clock me-1"></i>
                                            {{ $news->published_at ? $news->published_at->format('d/m/Y H:i') : $news->created_at->format('d/m/Y H:i') }}
                                        </span>
                                        <span class="mx-2">•</span>
                                        <span class="flex items-center">
                                            <i class="mdi mdi-eye me-1"></i>
                                            {{ $news->published_at ? $news->published_at->diffForHumans() : $news->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    
                                    @if($news->image)
                                        <div class="mb-6">
                                            <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="w-full h-64 object-cover rounded-lg">
                                        </div>
                                    @endif

                                    @if($news->excerpt)
                                        <div class="mb-6">
                                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Tóm tắt</h3>
                                            <p class="text-gray-600 leading-relaxed">{{ $news->excerpt }}</p>
                                        </div>
                                    @endif

                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-700 mb-3">Nội dung</h3>
                                        <div class="bg-gray-50 p-6 rounded-lg">
                                            <div class="prose max-w-none">
                                                {!! nl2br(e($news->content)) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="lg:col-span-1">
                            <div class="space-y-6">
                                <div class="bg-gray-50 p-6 rounded-lg">
                                    <h4 class="text-lg font-semibold text-gray-700 mb-4">Thông tin tin tức</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Trạng thái:</span>
                                            <div class="mt-1">
                                                @if($news->status === 'published')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Đã xuất bản
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Bản nháp
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Tác giả:</span>
                                            <p class="mt-1 text-sm text-gray-900">{{ $news->author->name }}</p>
                                        </div>

                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Ngày tạo:</span>
                                            <p class="mt-1 text-sm text-gray-900">{{ $news->created_at->format('d/m/Y H:i') }}</p>
                                        </div>

                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Cập nhật lần cuối:</span>
                                            <p class="mt-1 text-sm text-gray-900">{{ $news->updated_at->format('d/m/Y H:i') }}</p>
                                        </div>

                                        @if($news->published_at)
                                            <div>
                                                <span class="text-sm font-medium text-gray-500">Ngày xuất bản:</span>
                                                <p class="mt-1 text-sm text-gray-900">{{ $news->published_at->format('d/m/Y H:i') }}</p>
                                            </div>
                                        @endif

                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Slug:</span>
                                            <p class="mt-1 text-sm text-gray-900 font-mono bg-gray-100 p-2 rounded">{{ $news->slug }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-6 rounded-lg">
                                    <h4 class="text-lg font-semibold text-gray-700 mb-4">Thao tác</h4>
                                    <div class="space-y-3">
                                        <form action="{{ route('admin.news.toggleStatus', $news->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 {{ $news->status === 'published' ? 'text-yellow-600 hover:text-yellow-700' : 'text-green-600 hover:text-green-700' }} text-sm font-bold py-2 px-4 rounded transition-colors">
                                                @if($news->status === 'published')
                                                    <svg class="h-4 w-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                                        <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                                    </svg>
                                                    Ẩn tin tức
                                                @else
                                                    <svg class="h-4 w-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                    </svg>
                                                    Xuất bản tin tức
                                                @endif
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tin tức này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-red-600 hover:text-red-700 text-sm font-bold py-2 px-4 rounded transition-colors">
                                                <svg class="h-4 w-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                Xóa tin tức
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 