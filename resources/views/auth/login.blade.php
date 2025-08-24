<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Nova Smart - Đăng nhập</title>
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        @keyframes glow {
            from {
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3), 0 0 10px rgba(59, 130, 246, 0.3);
            }

            to {
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3), 0 0 20px rgba(59, 130, 246, 0.5);
            }
        }

        @keyframes pulse-custom {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .float {
            animation: float 6s ease-in-out infinite;
        }

        .float-delay-1 {
            animation-delay: 1s;
        }

        .float-delay-2 {
            animation-delay: 2s;
        }

        .float-delay-3 {
            animation-delay: 3s;
        }

        .float-delay-4 {
            animation-delay: 4s;
        }

        .float-delay-5 {
            animation-delay: 5s;
        }

        .glow {
            animation: glow 2s ease-in-out infinite alternate;
        }

        .pulse-custom {
            animation: pulse-custom 2s infinite;
        }
        .btn-orange, .bg-orange, .bg-orange-500, .hover\:bg-orange-600:hover {
            background: linear-gradient(to right, #ff8800, #ff6600) !important;
            color: #fff !important;
        }
        .text-orange, .text-orange-500, .hover\:text-orange-600:hover {
            color: #ff6600 !important;
        }
        .border-orange, .border-orange-500 {
            border-color: #ff6600 !important;
        }
    </style>
</head>

<body>
    <div class="flex items-center justify-center min-h-screen bg-slate-100">
        <div class="relative flex flex-col m-6 space-y-8 bg-white shadow-2xl rounded-2xl md:flex-row md:space-y-0">

            <!-- Left side - Login Form -->
            <div class="flex flex-col justify-center p-8 md:p-14">
                <span class="mb-3 text-4xl font-bold text-slate-800">Đăng nhập</span>
                <span class="font-light text-slate-500 mb-4">
                    Chào mừng đến với Nova Smart! Vui lòng nhập thông tin của bạn
                </span>

                <!-- Hiển thị lỗi -->
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-600 rounded border border-red-300 text-sm">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-3 bg-red-100 text-red-600 rounded border border-red-300 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="py-2">
                        <span class="mb-2 text-md text-slate-700">Email</span>
                        <input type="email"
                            class="w-full p-2 border border-slate-300 rounded-md placeholder:font-light placeholder:text-slate-400 focus:border-blue-500 focus:outline-none"
                            name="email" value="{{ old('email') }}" placeholder="Nhập email của bạn" required />
                    </div>

                    <div class="py-2">
                        <span class="mb-2 text-md text-slate-700">Mật khẩu</span>
                        <input type="password" name="password"
                            class="w-full p-2 border border-slate-300 rounded-md placeholder:font-light placeholder:text-slate-400 focus:border-blue-500 focus:outline-none"
                            placeholder="Nhập mật khẩu" required />
                    </div>

                    <div class="flex justify-between w-full py-2">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" class="mr-2" />
                            <span class="text-md text-slate-600">Nhớ đăng nhập</span>
                        </div>
                        <a href="{{ route('password.request') }}"
                            class="font-bold text-md text-orange-500 hover:text-orange-600">
                            Quên mật khẩu?
                        </a>

                    </div>

                    <button type="submit"
                        class="w-full bg-orange-500 text-white p-3 rounded-lg hover:bg-orange-600 transition-colors duration-300 font-medium">
                        Đăng nhập
                    </button>
                </form>

                <div class="text-center text-slate-500 mt-6">
                    Không có tài khoản?
                    <a href="{{ route('register') }}" class="font-bold text-orange-500 hover:text-orange-600 ml-1">Đăng
                        ký</a>
                </div>
            </div>

            <!-- Right side - Nova Smart Banner -->
            <div
                class="relative w-full md:w-96 h-64 md:h-auto bg-gradient-to-br from-orange-800 via-orange-500 to-orange-700 overflow-hidden flex flex-col justify-center items-center rounded-r-2xl">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="absolute top-8 left-8 text-white text-2xl opacity-10 float">📱</div>
                    <div class="absolute top-12 right-12 text-white text-2xl opacity-10 float float-delay-1">💻</div>
                    <div class="absolute top-32 left-4 text-white text-2xl opacity-10 float float-delay-2">🎧</div>
                    <div class="absolute top-40 right-8 text-white text-2xl opacity-10 float float-delay-3">⌚</div>
                    <div class="absolute bottom-20 left-12 text-white text-2xl opacity-10 float float-delay-4">📷</div>
                    <div class="absolute bottom-12 right-12 text-white text-2xl opacity-10 float float-delay-5">🔌</div>
                </div>
                <div class="absolute inset-0 bg-gradient-to-r from-white/5 via-transparent to-white/5"></div>
                <div class="text-center z-10 px-8">
                    <div class="text-4xl font-bold text-white mb-2 glow">NOVA SMART</div>
                    <div class="text-base text-white/90 mb-6 font-light">Công Nghệ Thông Minh</div>
                    <div class="text-sm text-white/80 leading-relaxed mb-6">
                        Khám phá thế giới đồ điện tử hiện đại<br>
                        Chất lượng cao - Giá cả hợp lý<br>
                        Dịch vụ tận tâm
                    </div>
                    <button
                        class="bg-gradient-to-r from-orange-400 to-orange-500 text-white px-6 py-2 rounded-full text-sm font-medium hover:from-orange-500 hover:to-orange-600 transform hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl pulse-custom">
                        Khám Phá Ngay
                    </button>
                </div>
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-3">
                    <div
                        class="w-8 h-8 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg flex items-center justify-center text-white text-sm">
                        📱</div>
                    <div
                        class="w-8 h-8 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg flex items-center justify-center text-white text-sm">
                        💻</div>
                    <div
                        class="w-8 h-8 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg flex items-center justify-center text-white text-sm">
                        🎧</div>
                    <div
                        class="w-8 h-8 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg flex items-center justify-center text-white text-sm">
                        ⌚</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
