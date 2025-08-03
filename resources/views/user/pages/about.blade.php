@extends('user.layouts.client')

@section('title', 'Về chúng tôi - NovaSmart')
@section('meta_description', 'Tìm hiểu về NovaSmart - Thương hiệu công nghệ uy tín với sứ mệnh mang đến những sản phẩm chất lượng cao và dịch vụ tốt nhất cho khách hàng.')

@section('content')
<!-- Hero Section -->
 
<section class="relative min-h-screen flex items-center bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-700 overflow-hidden pt-48">
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="space-y-8">
                <br>
                <br>
                <br>
                <div class="inline-flex items-center px-6 py-3 bg-white/80 backdrop-blur-sm border border-blue-200 text-blue-700 rounded-full text-sm font-semibold shadow-lg">
                    <i class="fas fa-star mr-3 text-yellow-500"></i>Thương hiệu uy tín hàng đầu
                </div>
                
                <h1 class="text-5xl lg:text-7xl font-bold text-slate-800 dark:text-white leading-tight">
                    NovaSmart
                    <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">NovaSmart</span>
                </h1>
                
                <p class="text-xl text-slate-600 dark:text-slate-300 leading-relaxed max-w-2xl">
                     là thương hiệu công nghệ hàng đầu, chuyên cung cấp các sản phẩm điện tử chất lượng cao với sứ mệnh mang đến trải nghiệm mua sắm tuyệt vời cho mọi khách hàng.
                </p>
                
                <div class="grid grid-cols-3 gap-8">
                    <div class="text-center p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-blue-100">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">Tận tâm</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400 font-medium">Chăm sóc khách hàng hài lòng</p>
                    </div>
                    
                    <div class="text-center p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-green-100">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-shipping-fast text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">24/7</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400 font-medium">Hỗ trợ khách hàng</p>
                    </div>
                    
                    <div class="text-center p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-purple-100">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-award text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">5+</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400 font-medium">Năm kinh nghiệm</p>
                    </div>
                </div>
            </div>
            
            <div class="relative">
                <div class="relative z-10">
                    <img src="{{ asset('assets/user/images/ab1.jpg') }}" alt="NovaSmart Team" class="rounded-3xl shadow-2xl transform rotate-3 hover:rotate-0 transition-transform duration-500">
                </div>
                <div class="absolute -bottom-8 -left-8 bg-white/90 backdrop-blur-sm p-8 rounded-2xl shadow-xl border border-blue-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-pink-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-heart text-white text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-800 dark:text-white">Cam kết chất lượng</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400 font-medium">100% chính hãng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Story Section -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20">
            <h2 class="text-4xl lg:text-5xl font-bold text-slate-800 dark:text-white mb-6">
                Câu chuyện của chúng tôi
            </h2>
            <p class="text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed">
                Từ một ý tưởng nhỏ đến một thương hiệu được tin tưởng bởi hàng nghìn khách hàng
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-3xl transform rotate-3 group-hover:rotate-0 transition-transform duration-500"></div>
                <div class="relative bg-white dark:bg-slate-800 p-10 rounded-3xl shadow-xl border border-blue-100 dark:border-slate-700">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-8">
                        <i class="fas fa-lightbulb text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-6 text-center">Khởi đầu</h3>
                    <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-center">
                        Năm 2020, chúng tôi bắt đầu với một ý tưởng đơn giản: mang đến những sản phẩm công nghệ chất lượng với giá cả hợp lý cho người Việt Nam.
                    </p>
                </div>
            </div>
            
            <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-green-600 rounded-3xl transform -rotate-3 group-hover:rotate-0 transition-transform duration-500"></div>
                <div class="relative bg-white dark:bg-slate-800 p-10 rounded-3xl shadow-xl border border-green-100 dark:border-slate-700">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-8">
                        <i class="fas fa-rocket text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-6 text-center">Phát triển</h3>
                    <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-center">
                        Với sự tin tưởng của khách hàng, chúng tôi đã mở rộng từ một cửa hàng nhỏ thành chuỗi bán lẻ công nghệ uy tín.
                    </p>
                </div>
            </div>
            
            <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-purple-600 rounded-3xl transform rotate-3 group-hover:rotate-0 transition-transform duration-500"></div>
                <div class="relative bg-white dark:bg-slate-800 p-10 rounded-3xl shadow-xl border border-purple-100 dark:border-slate-700">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-8">
                        <i class="fas fa-trophy text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-6 text-center">Thành công</h3>
                    <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-center">
                        Ngày nay, NovaSmart tự hào là đối tác tin cậy của hàng nghìn khách hàng và các thương hiệu công nghệ hàng đầu.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-24 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-800 dark:to-slate-700">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20">
            <h2 class="text-4xl lg:text-5xl font-bold text-slate-800 dark:text-white mb-6">
                Giá trị cốt lõi
            </h2>
            <p class="text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed">
                Những nguyên tắc định hướng mọi hoạt động của chúng tôi
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="group text-center p-8 bg-white dark:bg-slate-800 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-shield-alt text-white text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-6">Chất lượng</h3>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Cam kết cung cấp sản phẩm chính hãng với chất lượng tốt nhất
                </p>
            </div>
            
            <div class="group text-center p-8 bg-white dark:bg-slate-800 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-handshake text-white text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-6">Uy tín</h3>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Xây dựng niềm tin với khách hàng thông qua sự minh bạch và trách nhiệm
                </p>
            </div>
            
            <div class="group text-center p-8 bg-white dark:bg-slate-800 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-heart text-white text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-6">Tận tâm</h3>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Luôn đặt lợi ích của khách hàng lên hàng đầu trong mọi quyết định
                </p>
            </div>
            
            <div class="group text-center p-8 bg-white dark:bg-slate-800 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-24 h-24 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-lightbulb text-white text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-6">Sáng tạo</h3>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Không ngừng đổi mới để mang đến trải nghiệm tốt nhất cho khách hàng
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20">
            <h2 class="text-4xl lg:text-5xl font-bold text-slate-800 dark:text-white mb-6">
                Đội ngũ của chúng tôi
            </h2>
            <p class="text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed">
                Những con người tài năng và tâm huyết đằng sau thành công của NovaSmart
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            <div class="group text-center">
                <div class="relative mb-8">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full transform rotate-6 group-hover:rotate-0 transition-transform duration-500"></div>
                    <img src="{{ asset('assets/user/images/client/01.jpg') }}" alt="CEO" class="relative w-40 h-40 rounded-full mx-auto object-cover shadow-2xl group-hover:scale-105 transition-transform duration-500">
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-3">Nguyễn Văn A</h3>
                <p class="text-blue-600 dark:text-blue-400 font-semibold text-lg mb-4">CEO & Founder</p>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Với hơn 10 năm kinh nghiệm trong lĩnh vực công nghệ và kinh doanh
                </p>
            </div>
            
            <div class="group text-center">
                <div class="relative mb-8">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-blue-600 rounded-full transform -rotate-6 group-hover:rotate-0 transition-transform duration-500"></div>
                    <img src="{{ asset('assets/user/images/client/02.jpg') }}" alt="CTO" class="relative w-40 h-40 rounded-full mx-auto object-cover shadow-2xl group-hover:scale-105 transition-transform duration-500">
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-3">Trần Thị B</h3>
                <p class="text-green-600 dark:text-green-400 font-semibold text-lg mb-4">CTO</p>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Chuyên gia công nghệ với kiến thức sâu rộng về hệ thống thông tin
                </p>
            </div>
            
            <div class="group text-center">
                <div class="relative mb-8">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full transform rotate-6 group-hover:rotate-0 transition-transform duration-500"></div>
                    <img src="{{ asset('assets/user/images/client/03.jpg') }}" alt="Marketing Manager" class="relative w-40 h-40 rounded-full mx-auto object-cover shadow-2xl group-hover:scale-105 transition-transform duration-500">
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-3">Lê Văn C</h3>
                <p class="text-purple-600 dark:text-purple-400 font-semibold text-lg mb-4">Marketing Manager</p>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Chuyên gia marketing số với nhiều chiến dịch thành công
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-24 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-blue-600/20 to-purple-600/20"></div>
    </div>
    <div class="container mx-auto px-4 text-center relative z-10">
        <h2 class="text-4xl lg:text-6xl font-bold text-white mb-8">
            Sẵn sàng trải nghiệm NovaSmart?
        </h2>
        <p class="text-2xl text-blue-100 mb-12 max-w-3xl mx-auto leading-relaxed">
            Khám phá ngay những sản phẩm công nghệ chất lượng cao với giá cả hợp lý
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ route('user.pages.home') }}" class="group bg-white text-blue-600 px-10 py-4 rounded-2xl font-bold text-lg hover:bg-blue-50 transition duration-300 transform hover:scale-105 shadow-xl">
                <i class="fas fa-shopping-cart mr-3 group-hover:rotate-12 transition-transform duration-300"></i>Mua sắm ngay
            </a>
            <a href="{{ route('user.pages.product-list') }}" class="group border-2 border-white text-white px-10 py-4 rounded-2xl font-bold text-lg hover:bg-white hover:text-blue-600 transition duration-300 transform hover:scale-105">
                <i class="fas fa-eye mr-3 group-hover:rotate-12 transition-transform duration-300"></i>Xem sản phẩm
            </a>
        </div>
    </div>
</section>

<style>
@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}
.animate-blob {
    animation: blob 7s infinite;
}
.animation-delay-2000 {
    animation-delay: 2s;
}
.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
@endsection 