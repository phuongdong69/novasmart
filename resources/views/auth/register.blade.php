<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Nova Smart - Đăng ký</title>
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
    <div class="flex items-center justify-center min-h-screen bg-slate-100 py-8">
        <div
            class="relative flex flex-col m-6 space-y-8 bg-white shadow-2xl rounded-2xl md:flex-row md:space-y-0 max-w-5xl">

            <!-- Left side - Register Form -->
            <div class="flex flex-col justify-center p-8 md:p-14 md:w-150">
                <span class="mb-3 text-4xl font-bold text-slate-800">Đăng ký</span>
                <span class="font-light text-slate-500 mb-8">
                    Tạo tài khoản Nova Smart để trải nghiệm mua sắm tuyệt vời!
                </span>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    <div>
                        <span class="mb-2 text-md text-slate-700">Họ và tên</span>
                        <input type="text"
                            class="w-full p-2 border border-slate-300 rounded-md placeholder:font-light placeholder:text-slate-400 focus:border-blue-500 focus:outline-none @error('fullname') border-red-500 @enderror"
                            name="fullname" id="fullname" placeholder="Nhập họ và tên" value="{{ old('fullname') }}" />
                        @error('fullname')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <span class="mb-2 text-md text-slate-700">Email</span>
                        <input type="email"
                            class="w-full p-2 border border-slate-300 rounded-md placeholder:font-light placeholder:text-slate-400 focus:border-blue-500 focus:outline-none @error('email') border-red-500 @enderror"
                            name="email" id="email" placeholder="Nhập email của bạn"
                            value="{{ old('email') }}" />
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <span class="mb-2 text-md text-slate-700">Số điện thoại</span>
                        <input type="tel"
                            class="w-full p-2 border border-slate-300 rounded-md placeholder:font-light placeholder:text-slate-400 focus:border-blue-500 focus:outline-none @error('phone') border-red-500 @enderror"
                            name="phone" id="phone" placeholder="Nhập số điện thoại"
                            value="{{ old('phone') }}" />
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <span class="mb-2 text-md text-slate-700">Mật khẩu</span>
                        <input type="password" name="password" id="password"
                            class="w-full p-2 border border-slate-300 rounded-md placeholder:font-light placeholder:text-slate-400 focus:border-blue-500 focus:outline-none @error('password') border-red-500 @enderror"
                            placeholder="Nhập mật khẩu" />
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <span class="mb-2 text-md text-slate-700">Xác nhận mật khẩu</span>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full p-2 border border-slate-300 rounded-md placeholder:font-light placeholder:text-slate-400 focus:border-blue-500 focus:outline-none"
                            placeholder="Nhập lại mật khẩu" />
                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" name="terms" id="terms"
                            class="mr-3 mt-1 @error('terms') border-red-500 @enderror" />
                        <span class="text-sm text-slate-600">
                            Tôi đồng ý với
                            <span class="font-bold text-orange-500 hover:text-orange-600 cursor-pointer">Điều khoản sử
                                dụng</span>
                            và
                            <span class="font-bold text-orange-500 hover:text-orange-600 cursor-pointer">Chính sách bảo
                                mật</span>
                            của Nova Smart
                        </span>
                        @error('terms')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-orange-500 text-white p-3 rounded-lg mb-6 hover:bg-orange-600 transition-colors duration-300 font-medium">
                        Tạo tài khoản
                    </button>
                </form>


                <div class="text-center text-slate-400 mb-4">
                    <span>hoặc</span>
                </div>

                <button
                    class="w-full border border-slate-300 text-md p-3 rounded-lg mb-6 hover:bg-slate-50 transition-colors duration-300 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    Đăng ký với Google
                </button>

                <div class="text-center text-slate-500">
                    Đã có tài khoản?
                    <a href="{{ route('login') }}" class="font-bold text-orange-500 hover:text-orange-600 ml-1">Đăng nhập
                        ngay</a>
                </div>
            </div>

            <!-- Right side - Nova Smart Banner -->
            <div
                class="relative w-full md:w-96 h-64 md:h-auto bg-gradient-to-br from-orange-800 via-orange-500 to-orange-700 overflow-hidden flex flex-col justify-center items-center rounded-r-2xl">

                <!-- Background Tech Icons -->
                <div class="absolute inset-0 overflow-hidden">
                    <div class="absolute top-8 left-8 text-white text-2xl opacity-10 float">🛒</div>
                    <div class="absolute top-12 right-12 text-white text-2xl opacity-10 float float-delay-1">💳</div>
                    <div class="absolute top-32 left-4 text-white text-2xl opacity-10 float float-delay-2">🎁</div>
                    <div class="absolute top-40 right-8 text-white text-2xl opacity-10 float float-delay-3">⭐</div>
                    <div class="absolute bottom-20 left-12 text-white text-2xl opacity-10 float float-delay-4">🚚</div>
                    <div class="absolute bottom-12 right-12 text-white text-2xl opacity-10 float float-delay-5">🔒</div>
                </div>

                <!-- Glass Effect Overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-white/5 via-transparent to-white/5"></div>

                <!-- Main Content -->
                <div class="text-center z-10 px-8">
                    <div class="text-4xl font-bold text-white mb-2 glow">
                        NOVA SMART
                    </div>
                    <div class="text-base text-white/90 mb-6 font-light">
                        Gia nhập cộng đồng
                    </div>
                    <div class="text-sm text-white/80 leading-relaxed mb-6">
                        🎯 Ưu đãi độc quyền cho thành viên<br>
                        🚀 Giao hàng miễn phí toàn quốc<br>
                        💎 Tích điểm đổi quà hấp dẫn<br>
                        🛡️ Bảo hành chính hãng
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4 mb-4">
                        <div class="text-white/90 text-xs mb-2">Ưu đãi đăng ký mới</div>
                        <div class="text-white text-lg font-bold">GIẢM 15%</div>
                        <div class="text-white/80 text-xs">Cho đơn hàng đầu tiên</div>
                    </div>
                </div>

                <!-- Tech Icons Bottom -->
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
