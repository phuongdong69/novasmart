<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Đặt lại mật khẩu - Nova Smart</title>
</head>

<body>
    <div class="flex items-center justify-center min-h-screen bg-slate-100">
        <div class="w-full max-w-md bg-white rounded-xl shadow-xl p-8">
            <div class="text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/3064/3064197.png" alt="Logo"
                    class="w-16 h-16 mx-auto mb-4">
                <h2 class="text-2xl font-bold text-slate-800 mb-1">Đặt lại mật khẩu</h2>
                <p class="text-slate-500 text-sm">Nhập mật khẩu mới cho tài khoản của bạn.</p>
            </div>

            @if (session('status'))
                <div class="mt-4 p-3 bg-green-100 text-green-700 rounded border border-green-300 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-4 p-3 bg-red-100 text-red-600 rounded border border-red-300 text-sm">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ request()->route('token') }}">

                <div>
                    <label for="email" class="block text-sm text-slate-600 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', request()->email) }}"
                        class="w-full p-2 border border-slate-300 rounded-md focus:outline-none focus:border-blue-500"
                        required autofocus>
                </div>

                <div>
                    <label for="password" class="block text-sm text-slate-600 mb-1">Mật khẩu mới</label>
                    <input type="password" id="password" name="password"
                        class="w-full p-2 border border-slate-300 rounded-md focus:outline-none focus:border-blue-500"
                        required>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm text-slate-600 mb-1">Xác nhận mật
                        khẩu</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full p-2 border border-slate-300 rounded-md focus:outline-none focus:border-blue-500"
                        required>
                </div>

                <button type="submit"
                    class="w-full bg-slate-800 text-white py-2 rounded-md hover:bg-blue-600 transition-colors duration-300">
                    Đặt lại mật khẩu
                </button>

                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-blue-600 text-sm hover:underline">Quay lại đăng nhập</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
