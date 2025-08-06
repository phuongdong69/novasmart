@extends('user.layouts.client')

@section('title', 'Về chúng tôi - NovaSmart')
@section('meta_description', 'Tìm hiểu về NovaSmart - Thương hiệu công nghệ uy tín với sứ mệnh mang đến những sản phẩm chất lượng cao và dịch vụ tốt nhất cho khách hàng.')

@section('content')
<!-- Hero Section -->
<section class="relative py-24 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-700">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="space-y-8">
                <div class="inline-flex items-center px-6 py-3 bg-white/80 backdrop-blur-sm border border-blue-200 text-blue-700 rounded-full text-sm font-semibold shadow-lg">
                    <i class="fas fa-star mr-3 text-yellow-500"></i>Thương hiệu uy tín hàng đầu
                </div>
                
                <div class="space-y-6">
                    <h1 class="text-6xl lg:text-8xl font-bold text-slate-800 dark:text-white leading-tight">
                        NovaSmart
                    </h1>
                    
                    <p class="text-xl text-slate-600 dark:text-slate-300 leading-relaxed max-w-2xl">
                        NovaSmart là công ty chuyên cung cấp các sản phẩm và giải pháp công nghệ tiên tiến, giúp khách hàng tiếp cận nhanh nhất với những xu hướng công nghệ mới trên thị trường. Với phương châm "Công nghệ thông minh – Cuộc sống thông minh", chúng tôi không chỉ mang đến sản phẩm chất lượng mà còn chú trọng dịch vụ hỗ trợ tận tâm, đảm bảo trải nghiệm mua sắm và sử dụng hoàn hảo cho khách hàng.
                    </p>
                </div>
                
                <div class="grid grid-cols-3 gap-6">
                    <div class="text-center p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-blue-100">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">Tận tâm</h3>
                        <p class="text-base text-slate-600 dark:text-slate-400 font-medium">Chăm sóc khách hàng hài lòng</p>
                    </div>
                    
                    <div class="text-center p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-green-100">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-shipping-fast text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">24/7</h3>
                        <p class="text-base text-slate-600 dark:text-slate-400 font-medium">Hỗ trợ khách hàng</p>
                    </div>
                    
                    <div class="text-center p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-purple-100">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-award text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">5+</h3>
                        <p class="text-base text-slate-600 dark:text-slate-400 font-medium">Năm kinh nghiệm</p>
                    </div>
                </div>
            </div>
            
            <div class="relative">
                <div class="relative z-10">
                    <img src="{{ asset('assets/user/images/ab1.jpg') }}" alt="NovaSmart Team" class="rounded-3xl shadow-2xl">
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
@endsection 