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
                        <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent">NovaSmart</span>
                    </h1>
                    
                    <p class="text-xl text-slate-600 dark:text-slate-300 leading-relaxed max-w-2xl">
                        NovaSmart là công ty chuyên cung cấp các sản phẩm và giải pháp công nghệ tiên tiến, giúp khách hàng tiếp cận nhanh nhất với những xu hướng công nghệ mới trên thị trường. Với phương châm <span class="font-semibold text-blue-600 dark:text-blue-400">"Công nghệ thông minh – Cuộc sống thông minh"</span>, chúng tôi không chỉ mang đến sản phẩm chất lượng mà còn chú trọng dịch vụ hỗ trợ tận tâm, đảm bảo trải nghiệm mua sắm và sử dụng hoàn hảo cho khách hàng.
                    </p>
                </div>
                
                <div class="grid grid-cols-3 gap-6">
                    <div class="group text-center p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-blue-100 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-500">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">50K+</h3>
                        <p class="text-base text-slate-600 dark:text-slate-400 font-medium">Khách hàng tin tưởng</p>
                    </div>
                    
                    <div class="group text-center p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-green-100 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-500">
                            <i class="fas fa-shipping-fast text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">24/7</h3>
                        <p class="text-base text-slate-600 dark:text-slate-400 font-medium">Hỗ trợ khách hàng</p>
                    </div>
                    
                    <div class="group text-center p-6 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-purple-100 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-500">
                            <i class="fas fa-award text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">8+</h3>
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

<!-- Story Section -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="space-y-8">
                <div class="inline-flex items-center px-6 py-3 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 text-blue-700 dark:text-blue-300 rounded-full text-sm font-semibold">
                    <i class="fas fa-history mr-3"></i>Câu chuyện của chúng tôi
                </div>
                
                <h2 class="text-4xl lg:text-5xl font-bold text-slate-800 dark:text-white">
                    Hành trình <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">8 năm</span> phát triển
                </h2>
                
                <div class="space-y-6 text-lg text-slate-600 dark:text-slate-300 leading-relaxed">
                    <p>
                        NovaSmart được thành lập vào năm 2016 với khát khao mang công nghệ tiên tiến đến gần hơn với người dân Việt Nam. Từ một cửa hàng nhỏ tại Hà Nội, chúng tôi đã phát triển thành một trong những đơn vị phân phối công nghệ hàng đầu.
                    </p>
                    
                    <p>
                        Những năm đầu tiên, chúng tôi tập trung vào việc xây dựng niềm tin với khách hàng thông qua chất lượng sản phẩm và dịch vụ. Đến năm 2019, NovaSmart đã mở rộng ra 5 chi nhánh tại các thành phố lớn và bắt đầu phát triển thương mại điện tử.
                    </p>
                    
                    <p>
                        Năm 2022 đánh dấu bước ngoặt quan trọng khi chúng tôi trở thành đối tác chính thức của nhiều thương hiệu công nghệ lớn như Apple, Samsung, Dell, và Lenovo. Hiện tại, NovaSmart tự hào phục vụ hơn 50,000 khách hàng trên toàn quốc.
                    </p>
                </div>
                
                <div class="grid grid-cols-2 gap-6">
                    <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-2xl">
                        <h4 class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">2016</h4>
                        <p class="text-slate-600 dark:text-slate-300">Thành lập công ty</p>
                    </div>
                    <div class="text-center p-6 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 rounded-2xl">
                        <h4 class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">2019</h4>
                        <p class="text-slate-600 dark:text-slate-300">Mở rộng 5 chi nhánh</p>
                    </div>
                    <div class="text-center p-6 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 rounded-2xl">
                        <h4 class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-2">2022</h4>
                        <p class="text-slate-600 dark:text-slate-300">Đối tác chính thức</p>
                    </div>
                    <div class="text-center p-6 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/30 dark:to-orange-800/30 rounded-2xl">
                        <h4 class="text-3xl font-bold text-orange-600 dark:text-orange-400 mb-2">2024</h4>
                        <p class="text-slate-600 dark:text-slate-300">50K+ khách hàng</p>
                    </div>
                </div>
            </div>
            
            <div class="relative">
                <img src="{{ asset('assets/user/images/ab2.jpg') }}" alt="NovaSmart History" class="rounded-3xl shadow-2xl">
                <div class="absolute -bottom-8 -right-8 bg-white/90 backdrop-blur-sm p-8 rounded-2xl shadow-xl border border-green-100">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-800 dark:text-white">Tăng trưởng</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400 font-medium">300% mỗi năm</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="py-24 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-800 dark:to-slate-700">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20">
            <h2 class="text-4xl lg:text-5xl font-bold text-slate-800 dark:text-white mb-6">
                <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Sứ mệnh & Tầm nhìn</span>
            </h2>
            <p class="text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed">
                Định hướng phát triển và mục tiêu tương lai của NovaSmart.
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <div class="group p-10 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mb-8 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-bullseye text-white text-3xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-slate-800 dark:text-white mb-6">Sứ mệnh</h3>
                <div class="space-y-4 text-lg text-slate-600 dark:text-slate-300 leading-relaxed">
                    <p>
                        NovaSmart cam kết mang đến cho khách hàng những sản phẩm công nghệ chất lượng cao với giá cả hợp lý, cùng dịch vụ chăm sóc khách hàng tận tâm và chuyên nghiệp.
                    </p>
                    <p>
                        Chúng tôi không chỉ bán sản phẩm mà còn đồng hành cùng khách hàng trong hành trình khám phá và ứng dụng công nghệ vào cuộc sống hàng ngày.
                    </p>
                </div>
            </div>
            
            <div class="group p-10 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mb-8 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-eye text-white text-3xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-slate-800 dark:text-white mb-6">Tầm nhìn</h3>
                <div class="space-y-4 text-lg text-slate-600 dark:text-slate-300 leading-relaxed">
                    <p>
                        Trở thành đơn vị tiên phong trong việc phổ cập công nghệ thông minh tại Việt Nam, góp phần xây dựng một xã hội số hiện đại và phát triển.
                    </p>
                    <p>
                        Đến năm 2030, NovaSmart sẽ mở rộng ra các nước Đông Nam Á và trở thành thương hiệu công nghệ được tin tưởng hàng đầu trong khu vực.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20">
            <h2 class="text-4xl lg:text-5xl font-bold text-slate-800 dark:text-white mb-6">
                <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Giá trị cốt lõi</span>
            </h2>
            <p class="text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed">
                Những nguyên tắc định hướng mọi hoạt động của chúng tôi
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="group text-center p-8 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-shield-alt text-white text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-6">Chất lượng</h3>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Cam kết cung cấp sản phẩm chính hãng với chất lượng tốt nhất, đảm bảo an toàn và hiệu suất cao cho người dùng.
                </p>
            </div>
            
            <div class="group text-center p-8 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-handshake text-white text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-6">Uy tín</h3>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Xây dựng niềm tin với khách hàng thông qua sự minh bạch, trách nhiệm và cam kết thực hiện đúng những gì đã hứa.
                </p>
            </div>
            
            <div class="group text-center p-8 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-heart text-white text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-6">Tận tâm</h3>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Luôn đặt lợi ích của khách hàng lên hàng đầu, cung cấp dịch vụ chăm sóc tận tình và hỗ trợ 24/7.
                </p>
            </div>
            
            <div class="group text-center p-8 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/30 dark:to-orange-800/30 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-24 h-24 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-lightbulb text-white text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-6">Sáng tạo</h3>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Không ngừng đổi mới và sáng tạo để mang đến trải nghiệm tốt nhất và giải pháp tối ưu cho khách hàng.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-24 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-800 dark:to-slate-700">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20">
            <h2 class="text-4xl lg:text-5xl font-bold text-slate-800 dark:text-white mb-6">
                <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Đội ngũ của chúng tôi</span>
            </h2>
            <p class="text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed">
                Những con người tài năng và tâm huyết đằng sau thành công của NovaSmart
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="group text-center p-8 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-32 h-32 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-user-tie text-white text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">Nguyễn Văn An</h3>
                <p class="text-blue-600 dark:text-blue-400 font-semibold mb-4">Giám đốc điều hành</p>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Với 15 năm kinh nghiệm trong lĩnh vực công nghệ, anh An đã dẫn dắt NovaSmart từ một cửa hàng nhỏ trở thành thương hiệu uy tín hàng đầu.
                </p>
            </div>
            
            <div class="group text-center p-8 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-32 h-32 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-user-cog text-white text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">Trần Thị Bình</h3>
                <p class="text-green-600 dark:text-green-400 font-semibold mb-4">Giám đốc kỹ thuật</p>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Chị Bình chuyên về công nghệ thông tin và đảm bảo tất cả sản phẩm đều đáp ứng tiêu chuẩn chất lượng cao nhất.
                </p>
            </div>
            
            <div class="group text-center p-8 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-32 h-32 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-user-headset text-white text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">Lê Văn Cường</h3>
                <p class="text-purple-600 dark:text-purple-400 font-semibold mb-4">Trưởng phòng CSKH</p>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Anh Cường và đội ngũ 20 nhân viên chăm sóc khách hàng luôn sẵn sàng hỗ trợ khách hàng 24/7 với tinh thần tận tâm.
                </p>
            </div>
        </div>
        
        <div class="text-center mt-16">
            <div class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-full text-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-users mr-3"></i>
                Hơn 100 nhân viên tài năng và tâm huyết
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-24 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20">
            <h2 class="text-4xl lg:text-5xl font-bold text-slate-800 dark:text-white mb-6">
                <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Dịch vụ của chúng tôi</span>
            </h2>
            <p class="text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed">
                Cung cấp đầy đủ các dịch vụ công nghệ từ mua sắm đến bảo hành
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="group p-8 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-shopping-cart text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-4">Mua sắm trực tuyến</h3>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed mb-6">
                    Website thân thiện, dễ sử dụng với hàng nghìn sản phẩm công nghệ chính hãng. Giao hàng nhanh chóng trong 2-4 giờ tại Hà Nội và TP.HCM.
                </p>
                <ul class="space-y-2 text-slate-600 dark:text-slate-300">
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Thanh toán an toàn</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Giao hàng miễn phí</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Đổi trả dễ dàng</li>
                </ul>
            </div>
            
            <div class="group p-8 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-tools text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-4">Bảo hành & Sửa chữa</h3>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed mb-6">
                    Hệ thống bảo hành chính hãng với 8 trung tâm bảo hành trên toàn quốc. Đội ngũ kỹ thuật viên chuyên nghiệp, giàu kinh nghiệm.
                </p>
                <ul class="space-y-2 text-slate-600 dark:text-slate-300">
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Bảo hành chính hãng</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Sửa chữa nhanh chóng</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>8 trung tâm bảo hành</li>
                </ul>
            </div>
            
            <div class="group p-8 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-headset text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-4">Tư vấn & Hỗ trợ</h3>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed mb-6">
                    Đội ngũ tư vấn chuyên nghiệp sẵn sàng hỗ trợ khách hàng 24/7. Tư vấn chọn sản phẩm phù hợp với nhu cầu và ngân sách.
                </p>
                <ul class="space-y-2 text-slate-600 dark:text-slate-300">
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Hỗ trợ 24/7</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Tư vấn chuyên nghiệp</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Giải pháp tối ưu</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Achievements Section -->
<section class="py-24 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-800 dark:to-slate-700">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20">
            <h2 class="text-4xl lg:text-5xl font-bold text-slate-800 dark:text-white mb-6">
                <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Thành tựu & Giải thưởng</span>
            </h2>
            <p class="text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed">
                Những cột mốc quan trọng và sự ghi nhận của cộng đồng
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center p-8 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl shadow-lg">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-trophy text-white text-3xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">Top 10</h3>
                <p class="text-lg text-slate-600 dark:text-slate-300 font-semibold">Công ty CNTT Việt Nam</p>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">2023</p>
            </div>
            
            <div class="text-center p-8 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl shadow-lg">
                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-award text-white text-3xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-green-600 dark:text-green-400 mb-2">Giải vàng</h3>
                <p class="text-lg text-slate-600 dark:text-slate-300 font-semibold">Thương hiệu uy tín</p>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">2022</p>
            </div>
            
            <div class="text-center p-8 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl shadow-lg">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-star text-white text-3xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-purple-600 dark:text-purple-400 mb-2">4.9/5</h3>
                <p class="text-lg text-slate-600 dark:text-slate-300 font-semibold">Đánh giá khách hàng</p>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">50K+ đánh giá</p>
            </div>
            
            <div class="text-center p-8 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl shadow-lg">
                <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-medal text-white text-3xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-orange-600 dark:text-orange-400 mb-2">ISO 9001</h3>
                <p class="text-lg text-slate-600 dark:text-slate-300 font-semibold">Chứng nhận chất lượng</p>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">2021</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact CTA Section -->
<section class="py-24 bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-600">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6">
            Sẵn sàng trải nghiệm <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">NovaSmart</span>?
        </h2>
        <p class="text-xl text-blue-100 mb-12 max-w-3xl mx-auto leading-relaxed">
            Hãy liên hệ với chúng tôi ngay hôm nay để được tư vấn và hỗ trợ tốt nhất. Đội ngũ NovaSmart luôn sẵn sàng đồng hành cùng bạn.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
            <a href="tel:19001234" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 rounded-full text-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-phone mr-3"></i>
                Liên hệ ngay
            </a>
            <a href="{{ route('shop.products') }}" class="inline-flex items-center px-8 py-4 bg-transparent border-2 border-white text-white rounded-full text-lg font-semibold hover:bg-white hover:text-blue-600 transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-shopping-bag mr-3"></i>
                Mua sắm ngay
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
            <div class="text-center">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-phone text-white text-2xl"></i>
                </div>
                <h4 class="text-xl font-bold text-white mb-2">Hotline</h4>
                <p class="text-blue-100">1900 1234</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope text-white text-2xl"></i>
                </div>
                <h4 class="text-xl font-bold text-white mb-2">Email</h4>
                <p class="text-blue-100">info@novasmart.vn</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                </div>
                <h4 class="text-xl font-bold text-white mb-2">Địa chỉ</h4>
                <p class="text-blue-100">123 Đường ABC, Hà Nội</p>
            </div>
        </div>
    </div>
</section>
@endsection 