@extends('admin.layouts.app')
@section('title', 'Danh sách sản phẩm')
@section('content')
<!-- Flash Messages -->
@if(session('success'))
    @php
        $isDeleteMessage = str_contains(session('success'), 'xóa') || str_contains(session('success'), 'Đã xóa');
    @endphp
    <div class="fixed top-0 left-0 right-0 z-50 {{ $isDeleteMessage ? 'bg-red-500' : 'bg-green-500' }} text-black px-6 py-3 shadow-lg transform transition-all duration-300 ease-in-out" id="flash-message">
        <div class="flex items-center justify-center max-w-7xl mx-auto">
            <i class="fas {{ $isDeleteMessage ? 'fa-trash' : 'fa-check-circle' }} mr-2"></i>
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-black hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

@if($errors->any())
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium">Có lỗi xảy ra:</h3>
                <div class="mt-2 text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <!-- Header -->
                <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex justify-between items-center">
                    <h6 class="dark:text-white text-lg font-semibold">Danh sách tin tức</h6>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.news.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                            + Thêm mới
                        </a>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="p-6 pb-4">
                    <form method="GET" action="{{ route('admin.news.index') }}" class="flex items-end gap-4">
                        <!-- Tìm kiếm theo tên tin tức -->
                        <div class="flex-1">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                            <input type="text" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Nhập tên tin tức..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Lọc theo tác giả -->
                        <div class="w-48">
                            <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Tác giả</label>
                            <select id="author" name="author" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Tất cả</option>
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Lọc theo trạng thái -->
                        <div class="w-40">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                            <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Tất cả</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                            </select>
                        </div>

                        <!-- Lọc theo ngày xuất bản -->
                        <div class="w-44">
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Ngày xuất bản</label>
                            <input type="date" 
                                   id="date" 
                                   name="date" 
                                   value="{{ request('date') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                                <i class="mdi mdi-magnify me-1"></i>
                                Tìm
                            </button>
                            <a href="{{ route('admin.news.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white text-sm font-bold py-2 px-4 rounded">
                                <i class="mdi mdi-refresh me-1"></i>
                                Làm mới
                            </a>
                        </div>

                        @if(request('search') || request('author') || request('status') || request('date'))
                            <div class="text-sm text-gray-600 flex items-center">
                                <i class="mdi mdi-filter me-1"></i>
                                {{ $news->total() }} kết quả
                            </div>
                        @endif
                    </form>
                </div>

                <!-- News List -->
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    TIN TỨC
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    TÁC GIẢ
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    TRẠNG THÁI
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    NGÀY XUẤT BẢN
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    THAO TÁC
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($news as $item)
                            <tr class="hover:bg-gray-50" style="transition: background 0.2s;">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if ($item->image)
                                                <img class="h-10 w-10 object-cover rounded cursor-pointer"
                                                     src="{{ $item->image_url }}"
                                                     alt="{{ $item->title }}"
                                                     onclick="toggleNewsDetail({{ $item->id }})">
                                            @else
                                                <div class="h-10 w-10 bg-gray-200 flex items-center justify-center rounded cursor-pointer"
                                                     onclick="toggleNewsDetail({{ $item->id }})">
                                                    <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 cursor-pointer"
                                                 onclick="toggleNewsDetail({{ $item->id }})">
                                                {{ Str::limit($item->title, 30) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->author->name ?? 'Chưa có tác giả' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->status === 'published')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Đã xuất bản
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Bản nháp
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->published_at ? $item->published_at->format('d/m/Y H:i') : 'Chưa xuất bản' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                    <div class="flex justify-start space-x-2">
                                        <a href="{{ route('admin.news.show', $item->id) }}" class="text-blue-600 hover:text-blue-900 mr-3" title="Xem chi tiết">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.news.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3" title="Chỉnh sửa">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.news.toggleStatus', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-900 mr-3" title="{{ $item->status === 'published' ? 'Ẩn tin tức' : 'Xuất bản tin tức' }}">
                                                @if($item->status === 'published')
                                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                                        <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                                    </svg>
                                                @else
                                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tin tức không?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Xóa">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <!-- Chi tiết tin tức (ẩn/hiện khi click) -->
                            <tr id="news-detail-{{ $item->id }}" class="hidden">
                                <td colspan="5" class="px-6 py-4 bg-gray-50">
                                    <div class="bg-white p-4 rounded-lg border">
                                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                            <!-- Nội dung chính -->
                                            <div>
                                                <h4 class="text-lg font-semibold mb-3">{{ $item->title }}</h4>
                                                @if($item->excerpt)
                                                    <div class="mb-3">
                                                        <h5 class="text-sm font-medium text-gray-700 mb-1">Tóm tắt:</h5>
                                                        <p class="text-sm text-gray-600">{{ $item->excerpt }}</p>
                                                    </div>
                                                @endif
                                                <div class="mb-3">
                                                    <h5 class="text-sm font-medium text-gray-700 mb-1">Nội dung:</h5>
                                                    <div class="text-sm text-gray-600 max-h-32 overflow-y-auto">
                                                        {!! nl2br(e(Str::limit($item->content, 300))) !!}
                                                        @if(strlen($item->content) > 300)
                                                            <span class="text-blue-600">...</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Thông tin bổ sung -->
                                            <div>
                                                <div class="space-y-3">
                                                    <div>
                                                        <h5 class="text-sm font-medium text-gray-700">Slug:</h5>
                                                        <p class="text-sm text-gray-600 font-mono">{{ $item->slug }}</p>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-sm font-medium text-gray-700">Ngày tạo:</h5>
                                                        <p class="text-sm text-gray-600">{{ $item->created_at->format('d/m/Y H:i') }}</p>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-sm font-medium text-gray-700">Cập nhật lần cuối:</h5>
                                                        <p class="text-sm text-gray-600">{{ $item->updated_at->format('d/m/Y H:i') }}</p>
                                                    </div>
                                                    @if($item->image)
                                                        <div>
                                                            <h5 class="text-sm font-medium text-gray-700 mb-2">Hình ảnh:</h5>
                                                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-32 h-24 object-cover rounded">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4 pt-4 border-t border-gray-200">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('admin.news.show', $item->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                                                    Xem chi tiết đầy đủ
                                                </a>
                                                <a href="{{ route('admin.news.edit', $item->id) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded">
                                                    Chỉnh sửa
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($news->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $news->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleNewsDetail(newsId) {
        const el = document.getElementById('news-detail-' + newsId);
        if (el) {
            el.classList.toggle('hidden');
        }
    }

    // Auto hide flash messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const flashMessages = document.querySelectorAll('#flash-message');
        flashMessages.forEach(function(message) {
            setTimeout(function() {
                message.style.transform = 'translateY(-100%)';
                setTimeout(function() {
                    message.remove();
                }, 300);
            }, 5000);
        });
    });
</script>
@endpush
@endsection 