@extends('admin.layouts.app')
@section('content')
    <div class="w-full px-6 py-6 mx-auto">
      <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
          <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">

            <!-- Header -->
            <div class="p-6 pb-0 mb-0 border-b border-b-solid rounded-t-2xl border-b-slate-200 flex items-center justify-between">
              <h6 class="dark:text-white text-lg font-semibold">Chỉnh sửa xuất xứ</h6>
              <a href="{{ route('admin.origins.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold py-2 px-4 rounded">
                ← Quay lại
              </a>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.origins.update', $origin->id) }}" method="POST" class="p-6">
              @csrf
              @method('PUT')

              <div class="mb-4">
                <label for="country" class="block text-sm font-medium text-gray-700">Tên quốc gia</label>

                

                <input type="text" name="country" id="country"
                       class="border border-gray-300 rounded-md shadow-sm w-full px-3 py-2 mt-0 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Nhập tên quốc gia"
                       value="{{ old('country', $origin->country) }}">
                        @error('country')
    <p class="text-red-600 text-sm mt-1 mb-1 font-semibold">{{ $message }}</p>
  @enderror
              </div>

              <button type="submit"
                      class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                Cập nhật
              </button>
            </form>

          </div>
        </div>
      </div>
    </div>
@endsection
