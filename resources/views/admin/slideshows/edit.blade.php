@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa Slideshow')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 flex-0">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-slate-850 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center w-full max-w-full px-3 shrink-0">
                            <div class="w-full">
                                <h6 class="mb-1 font-semibold leading-normal dark:text-white">Chỉnh sửa Slideshow</h6>
                                <p class="mb-0 leading-normal text-sm dark:text-white dark:opacity-60">
                                    Cập nhật thông tin slideshow
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-auto p-6">
                    <form action="{{ route('admin.slideshows.update', $slideshow) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-slate-700 dark:text-white mb-2">Tiêu đề</label>
                            <input type="text" 
                                   class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-600 dark:text-white @error('title') border-red-500 @enderror" 
                                   id="title" name="title" value="{{ old('title', $slideshow->title) }}" placeholder="Nhập tiêu đề slideshow">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-slate-700 dark:text-white mb-2">Mô tả</label>
                            <textarea class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-600 dark:text-white @error('description') border-red-500 @enderror" 
                                      id="description" name="description" rows="3" placeholder="Nhập mô tả slideshow">{{ old('description', $slideshow->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-slate-700 dark:text-white mb-2">Ảnh</label>
                            @if($slideshow->image)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $slideshow->image) }}" 
                                         alt="{{ $slideshow->title }}" 
                                         class="w-48 h-28 object-cover border border-slate-300 rounded-lg">
                                </div>
                            @endif
                            <input type="file" 
                                   class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-600 dark:text-white @error('image') border-red-500 @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Định dạng: JPEG, PNG, JPG, GIF. Kích thước tối đa: 2MB. Để trống nếu không muốn thay đổi ảnh.</p>
                        </div>

                        <div class="mb-4">
                            <label for="link" class="block text-sm font-medium text-slate-700 dark:text-white mb-2">Link</label>
                            <input type="url" 
                                   class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-600 dark:text-white @error('link') border-red-500 @enderror" 
                                   id="link" name="link" value="{{ old('link', $slideshow->link) }}" placeholder="https://example.com">
                            @error('link')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="order" class="block text-sm font-medium text-slate-700 dark:text-white mb-2">Thứ tự</label>
                            <input type="number" 
                                   class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-600 dark:text-white @error('order') border-red-500 @enderror" 
                                   id="order" name="order" value="{{ old('order', $slideshow->order) }}" min="0">
                            @error('order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" 
                                       id="is_active" name="is_active" value="1" {{ old('is_active', $slideshow->is_active) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm font-medium text-slate-700 dark:text-white">Hoạt động</span>
                            </label>
                        </div>

                        <div class="flex justify-end gap-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-6 rounded">
                                Lưu thay đổi
                            </button>
                            <a href="{{ route('admin.slideshows.index') }}"
                                class="border border-slate-400 text-slate-700 hover:bg-slate-100 hover:text-slate-900 text-sm font-medium py-2 px-6 rounded transition-all duration-150">
                                Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 