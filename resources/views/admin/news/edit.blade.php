@extends('admin.layouts.app')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <!-- Header -->
                <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent flex justify-between items-center">
                    <h6 class="dark:text-white text-lg font-semibold">Chỉnh sửa tin tức</h6>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.news.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white text-sm font-bold py-2 px-4 rounded">
                            <svg class="h-4 w-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Quay lại
                        </a>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-6">
                    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Main Content -->
                            <div class="lg:col-span-2">
                                <div class="space-y-6">
                                    <div>
                                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                            Tiêu đề <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror" 
                                               id="title" name="title" value="{{ old('title', $news->title) }}" required>
                                        @error('title')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                                            Slug
                                        </label>
                                        <input type="text" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('slug') border-red-500 @enderror" 
                                               id="slug" name="slug" value="{{ old('slug', $news->slug) }}" placeholder="Để trống để tự động tạo">
                                        @error('slug')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                                            Tóm tắt
                                        </label>
                                        <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('excerpt') border-red-500 @enderror" 
                                                  id="excerpt" name="excerpt" rows="3" placeholder="Tóm tắt ngắn gọn về tin tức">{{ old('excerpt', $news->excerpt) }}</textarea>
                                        @error('excerpt')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                            Nội dung <span class="text-red-500">*</span>
                                        </label>
                                        <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror" 
                                                  id="content" name="content" rows="12" required>{{ old('content', $news->content) }}</textarea>
                                        @error('content')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="lg:col-span-1">
                                <div class="space-y-6">
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h6 class="text-sm font-medium text-gray-700 mb-4">Hình ảnh</h6>
                                        @if($news->image)
                                            <div class="mb-4">
                                                <img src="{{ $news->image_url }}" alt="Current image" class="w-full h-32 object-cover rounded">
                                            </div>
                                        @endif
                                        <div>
                                            <input type="file" 
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('image') border-red-500 @enderror" 
                                                   id="image" name="image" accept="image/*">
                                            @error('image')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                            <p class="mt-2 text-xs text-gray-500">Định dạng: JPEG, PNG, JPG, GIF. Tối đa 2MB.</p>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h6 class="text-sm font-medium text-gray-700 mb-4">Cài đặt</h6>
                                        <div class="space-y-4">
                                            <div>
                                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Trạng thái <span class="text-red-500">*</span>
                                                </label>
                                                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror" 
                                                        id="status" name="status" required>
                                                    <option value="draft" {{ old('status', $news->status) == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                                                    <option value="published" {{ old('status', $news->status) == 'published' ? 'selected' : '' }}>Xuất bản</option>
                                                </select>
                                                @error('status')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Ngày xuất bản
                                                </label>
                                                <input type="datetime-local" 
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('published_at') border-red-500 @enderror" 
                                                       id="published_at" name="published_at" 
                                                       value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}">
                                                @error('published_at')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                                <p class="mt-2 text-xs text-gray-500">Để trống để xuất bản ngay lập tức.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-6 rounded">
                                    <svg class="h-4 w-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Cập nhật tin tức
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto generate slug from title
    document.getElementById('title').addEventListener('input', function() {
        const title = this.value;
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        document.getElementById('slug').value = slug;
    });
</script>
@endpush
@endsection 