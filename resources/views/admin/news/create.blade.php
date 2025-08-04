@extends('admin.layouts.app')

@section('title', 'Thêm tin tức mới')

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
      <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

        {{-- Tiêu đề --}}
        <div class="p-6 pb-0 mb-0 border-b-0 rounded-t-2xl border-b-transparent">
          <h3 class="dark:text-white text-lg font-semibold">Thêm tin tức mới</h3>
        </div>

        {{-- Form --}}
        <div class="p-6">
          <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
              {{-- Cột chính --}}
              <div class="lg:col-span-2">
                <div class="space-y-6">
                  {{-- Tiêu đề --}}
                  <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                      Tiêu đề <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                           required>
                    @error('title')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                  </div>

                  {{-- Tóm tắt --}}
                  <div>
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                      Tóm tắt
                    </label>
                    <textarea id="excerpt" 
                              name="excerpt" 
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('excerpt') border-red-500 @enderror">{{ old('excerpt') }}</textarea>
                    @error('excerpt')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                  </div>

                  {{-- Nội dung --}}
                  <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                      Nội dung <span class="text-red-500">*</span>
                    </label>
                    <textarea id="content" 
                              name="content" 
                              rows="12"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content') border-red-500 @enderror"
                              required>{{ old('content') }}</textarea>
                    @error('content')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
              </div>

              {{-- Sidebar --}}
              <div class="lg:col-span-1">
                <div class="space-y-6">
                  {{-- Danh mục --}}
                  <div>
                    <label for="category_name" class="block text-sm font-medium text-gray-700 mb-2">
                      Danh mục
                    </label>
                    <input type="text" 
                           id="category_name" 
                           name="category_name" 
                           value="{{ old('category_name') }}"
                           list="category-suggestions"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category_name') border-red-500 @enderror"
                           placeholder="Nhập tên danh mục">
                    <datalist id="category-suggestions">
                      @foreach($categories as $category)
                        <option value="{{ $category->category_name }}">
                      @endforeach
                    </datalist>
                    @error('category_name')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                  </div>

                  {{-- Tags --}}
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                      Tags
                    </label>
                    <div class="space-y-2">
                      <div class="flex gap-2">
                        <input type="text" 
                               id="tag-input"
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Nhập tag và nhấn Enter">
                        <button type="button" 
                                onclick="addTag()"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                          Thêm
                        </button>
                      </div>
                      <div id="tags-list" class="flex flex-wrap gap-2">
                        <!-- Tags sẽ được hiển thị ở đây -->
                      </div>
                      <input type="hidden" name="tags" id="tags-hidden" value="{{ old('tags') }}">
                      <p class="text-xs text-gray-500">Nhấn Enter hoặc nút Thêm để thêm tag</p>
                    </div>
                  </div>

                  {{-- Ảnh đại diện --}}
                  <div>
                    <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                      Ảnh đại diện
                    </label>
                    <input type="file" 
                           id="featured_image" 
                           name="featured_image" 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('featured_image') border-red-500 @enderror">
                                         <p class="mt-1 text-xs text-gray-500">Chấp nhận: JPG, PNG, GIF, WebP, JFIF (Tối đa 2MB)</p>
                    @error('featured_image')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                  </div>

                  {{-- Trạng thái --}}
                  <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                      Trạng thái <span class="text-red-500">*</span>
                    </label>
                    <select id="status" 
                            name="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror"
                            required>
                      <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                      <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                    </select>
                    @error('status')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                  </div>

                  {{-- Ngày xuất bản --}}
                  <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">
                      Ngày xuất bản
                    </label>
                    <input type="datetime-local" 
                           id="published_at" 
                           name="published_at" 
                           value="{{ old('published_at') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('published_at') border-red-500 @enderror">
                    @error('published_at')
                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                  </div>

                  {{-- Tùy chọn --}}
                  <div class="space-y-3">
                    <div class="flex items-center">
                      <input type="checkbox" 
                             id="is_featured" 
                             name="is_featured" 
                             value="1"
                             {{ old('is_featured') ? 'checked' : '' }}
                             class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                      <label for="is_featured" class="ml-2 text-sm text-gray-700">
                        Bài viết nổi bật
                      </label>
                    </div>
                    
                    <div class="flex items-center">
                      <input type="checkbox" 
                             id="is_active" 
                             name="is_active" 
                             value="1"
                             {{ old('is_active', true) ? 'checked' : '' }}
                             class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                      <label for="is_active" class="ml-2 text-sm text-gray-700">
                        Kích hoạt
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- Nút hành động - Căn phải --}}
            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
              <a href="{{ route('admin.news.index') }}" 
                 class="text-gray-600 hover:text-gray-800 flex items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                <i class="fas fa-times mr-1"></i> Hủy
              </a>
              <button type="submit" 
                      class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded-lg">
                <i class="fas fa-save mr-1"></i> Lưu tin tức
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
let tags = [];

function addTag() {
  const input = document.getElementById('tag-input');
  const tag = input.value.trim();
  
  if (tag && !tags.includes(tag)) {
    tags.push(tag);
    updateTagsDisplay();
    input.value = '';
  }
}

function removeTag(index) {
  tags.splice(index, 1);
  updateTagsDisplay();
}

function updateTagsDisplay() {
  const container = document.getElementById('tags-list');
  const hiddenInput = document.getElementById('tags-hidden');
  
  container.innerHTML = '';
  tags.forEach((tag, index) => {
    const badge = document.createElement('span');
    badge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
    badge.innerHTML = `
      ${tag}
      <button type="button" class="ml-1 inline-flex items-center justify-center w-4 h-4 rounded-full text-blue-400 hover:bg-blue-200 hover:text-blue-500" onclick="removeTag(${index})">
        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
      </button>
    `;
    container.appendChild(badge);
  });
  
  hiddenInput.value = JSON.stringify(tags);
}

// Xử lý Enter key
document.getElementById('tag-input').addEventListener('keypress', function(e) {
  if (e.key === 'Enter') {
    e.preventDefault();
    addTag();
  }
});

// Khởi tạo tags từ old input nếu có
document.addEventListener('DOMContentLoaded', function() {
  const oldTags = document.getElementById('tags-hidden').value;
  if (oldTags) {
    try {
      tags = JSON.parse(oldTags);
      updateTagsDisplay();
    } catch (e) {
      console.error('Error parsing tags:', e);
    }
  }
});
</script>
@endsection 