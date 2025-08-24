@extends('user.layouts.client')

@section('title', 'Hồ sơ người dùng')
@section('meta_description', 'Cập nhật thông tin cá nhân - Nova Smart')

@section('content')
    <section class="relative md:py-24 py-16 bg-white">
        <div class="container relative mx-auto max-w-5xl">
            <div class="grid grid-cols-1 justify-center text-center mb-6">
                <h5 class="font-semibold text-3xl leading-normal mb-4">Hồ sơ của tôi</h5>
                <p class="text-slate-400 max-w-xl mx-auto">Chỉnh sửa thông tin tài khoản của bạn</p>
            </div>

            {{-- Thông báo --}}
            @if (session('success'))
                <div class="mb-6">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative flex items-center justify-between"
                        role="alert">
                        <span class="block sm:inline font-medium">✅ {{ session('success') }}</span>
                        <button onclick="this.parentElement.remove();"
                            class="text-green-700 hover:text-green-900 font-bold text-xl leading-none">&times;</button>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">⚠️ Có lỗi xảy ra:</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Form --}}
            <div class="bg-white dark:bg-slate-900 shadow rounded-md p-6">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start mx-auto max-w-3xl">
                        {{-- Thông tin cá nhân --}}
                        <div class="md:col-span-2 space-y-4">
                            <div>
                                <label class="block font-medium mb-2">Họ và tên</label>
                                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                                    class="w-full border border-gray-300 dark:border-gray-700 rounded-md p-2">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block font-medium mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                    class="w-full border border-gray-300 dark:border-gray-700 rounded-md p-2 bg-gray-100 cursor-not-allowed"
                                    readonly>
                            </div>
                            <div>
                                <label class="block font-medium mb-2">Số điện thoại</label>
                                <input type="text" name="phoneNumber"
                                    value="{{ old('phoneNumber', Auth::user()->phoneNumber) }}"
                                    class="w-full border border-gray-300 dark:border-gray-700 rounded-md p-2">
                                @error('phoneNumber')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block font-medium mb-2">Địa chỉ</label>
                                <textarea name="address" rows="3" class="w-full border border-gray-300 dark:border-gray-700 rounded-md p-2"
                                    placeholder="Nhập địa chỉ của bạn">{{ old('address', Auth::user()->address) }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>



                            <div>
                                <label class="block font-medium mb-2">Giới tính</label>
                                <select name="gender"
                                    class="w-full border border-gray-300 dark:border-gray-700 rounded-md p-2">
                                    <option value="">-- Chọn giới tính --</option>
                                    <option value="male" {{ Auth::user()->gender == 'male' ? 'selected' : '' }}>Nam
                                    </option>
                                    <option value="female" {{ Auth::user()->gender == 'female' ? 'selected' : '' }}>Nữ
                                    </option>
                                    <option value="other" {{ Auth::user()->gender == 'other' ? 'selected' : '' }}>Khác
                                    </option>
                                </select>
                                @error('gender')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>


                            <div>
                                <label class="block font-medium mb-2">Ngày sinh</label>
                                <input type="date" name="birthday" value="{{ old('birthday', Auth::user()->birthday) }}"
                                    class="w-full border border-gray-300 dark:border-gray-700 rounded-md p-2">
                                @error('birthday')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        {{-- Avatar --}}
                        <div class="md:col-span-1">
                            <div>
                                <label class="block font-medium mb-2 text-center " style="margin-left: 20px">Ảnh đại
                                    diện</label>

                                <div class="flex justify-center">
                                    @if (Auth::user()->image_user)
                                        <img id="previewAvatar" src="{{ asset('storage/' . Auth::user()->image_user) }}"
                                            alt="Avatar" class="rounded-full object-cover shadow-md" width="120px"
                                            style="margin-left: 20px;">
                                    @else
                                        <img id="previewAvatar" src="#" alt="Avatar mới"
                                            class="rounded-full object-cover shadow-md" width="120px"
                                            style="margin-left: 20px; display: none;">
                                    @endif
                                </div>
                                <br>

                                <label for="image_user"
                                    class="cursor-pointer inline-block bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 text-sm text-center"
                                    style="width: 120px;margin-left: 217px;">
                                    📁 Chọn ảnh
                                </label>

                                <input type="file" name="image_user" id="image_user" class="hidden" accept="image/*"
                                    onchange="updateFileName()" />

                                @error('image_user')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('user.pages.home') }}"
                            class="px-6 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700">
                            ← Quay lại
                        </a>
                        <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700">
                            Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- Script hiển thị ảnh mới chọn --}}
    <script>
        function updateFileName() {
            const input = document.getElementById("image_user");
            const preview = document.getElementById("previewAvatar");

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
