@extends('user.layouts.client')

@section('title', 'Về Chúng Tôi - NovaSmart')

@section('meta_description', 'Tìm hiểu về NovaSmart - Thương hiệu công nghệ uy tín với các sản phẩm chất lượng cao và dịch vụ khách hàng tốt nhất.')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-slate-900 dark:to-slate-800">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-slate-800 dark:text-white mb-6">
                Về <span class="text-blue-600 dark:text-blue-400">NovaSmart</span>
            </h1>
            <p class="text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed">
                Chúng tôi là thương hiệu công nghệ hàng đầu, cam kết mang đến những sản phẩm chất lượng cao 
                và trải nghiệm mua sắm tuyệt vời cho khách hàng.
            </p>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="py-20 bg-white dark:bg-slate-900 mb-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 gap-12 items-center">
            <!-- Mission -->
            <div class="space-y-6">
                <div class="inline-flex items-center px-6 py-3 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-lg font-bold">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Sứ mệnh của chúng tôi
                </div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">
                    Mang công nghệ đến mọi người
                </h2>
                <p class="text-base text-slate-600 dark:text-slate-300 leading-relaxed text-justify">
                    NovaSmart cam kết cung cấp những sản phẩm công nghệ chất lượng cao với giá cả hợp lý, 
                    giúp mọi người tiếp cận được những tiến bộ công nghệ mới nhất một cách dễ dàng và thuận tiện. 
                    Chúng tôi luôn đặt chất lượng lên hàng đầu.
                </p>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-slate-700 dark:text-slate-300">Chất lượng đảm bảo</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-slate-700 dark:text-slate-300">Giá cả cạnh tranh</span>
                    </div>
                </div>
            </div>
            
            <!-- Vision -->
            <div class="space-y-6">
                <div class="inline-flex items-center px-6 py-3 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-full text-lg font-bold">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                    </svg>
                    Tầm nhìn của chúng tôi
                </div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">
                    Trở thành thương hiệu công nghệ hàng đầu
                </h2>
                <p class="text-base text-slate-600 dark:text-slate-300 leading-relaxed text-justify">
                    Chúng tôi mong muốn trở thành đối tác tin cậy của mọi khách hàng, 
                    là điểm đến đầu tiên khi họ cần những sản phẩm công nghệ chất lượng và dịch vụ tốt nhất. 
                    Đội ngũ chuyên nghiệp và tận tâm.
                </p>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-slate-700 dark:text-slate-300">Dịch vụ 24/7</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-slate-700 dark:text-slate-300">Hỗ trợ tận tâm</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-20 bg-slate-50 dark:bg-slate-800 mb-8">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-slate-800 dark:text-white mb-4">
                Giá trị cốt lõi
            </h2>
            <p class="text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto">
                Những nguyên tắc mà NovaSmart luôn tuân thủ để mang đến trải nghiệm tốt nhất cho khách hàng
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Value 1 -->
            <div class="bg-white dark:bg-slate-900 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Chất lượng</h3>
                <p class="text-sm text-slate-600 dark:text-slate-300">
                    Chúng tôi cam kết cung cấp những sản phẩm chất lượng cao nhất, được kiểm định nghiêm ngặt.
                </p>
            </div>
            
            <!-- Value 2 -->
            <div class="bg-white dark:bg-slate-900 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Sáng tạo</h3>
                <p class="text-sm text-slate-600 dark:text-slate-300">
                    Luôn tìm kiếm và áp dụng những công nghệ mới nhất để cải thiện sản phẩm và dịch vụ.
                </p>
            </div>
            
            <!-- Value 3 -->
            <div class="bg-white dark:bg-slate-900 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Khách hàng</h3>
                <p class="text-sm text-slate-600 dark:text-slate-300">
                    Đặt lợi ích của khách hàng lên hàng đầu, luôn lắng nghe và đáp ứng nhu cầu của họ.
                </p>
            </div>
            
            <!-- Value 4 -->
            <div class="bg-white dark:bg-slate-900 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Uy tín</h3>
                <p class="text-sm text-slate-600 dark:text-slate-300">
                    Xây dựng niềm tin với khách hàng thông qua sự minh bạch và trách nhiệm trong mọi hoạt động.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-20 bg-blue-600 dark:bg-blue-800 mb-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div class="space-y-4">
                <div class="text-4xl font-bold text-white">1000+</div>
                <div class="text-blue-100">Khách hàng hài lòng</div>
            </div>
            <div class="space-y-4">
                <div class="text-4xl font-bold text-white">500+</div>
                <div class="text-blue-100">Sản phẩm chất lượng</div>
            </div>
            <div class="space-y-4">
                <div class="text-4xl font-bold text-white">24/7</div>
                <div class="text-blue-100">Hỗ trợ khách hàng</div>
            </div>
            <div class="space-y-4">
                <div class="text-4xl font-bold text-white">5+</div>
                <div class="text-blue-100">Năm kinh nghiệm</div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-20 bg-white dark:bg-slate-900 mb-8">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-slate-800 dark:text-white mb-4">
                Đội ngũ NovaSmart
            </h2>
            <p class="text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto">
                Những con người tài năng và tâm huyết đang làm việc để mang đến những sản phẩm tốt nhất cho bạn
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Team Member 1 -->
            <div class="text-center">
                <div class="w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                    <img src="{{ asset('assets/user/images/CapyXGoku.png') }}" alt="Nguyễn Văn A - CEO" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20" style="display: none;">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2">Nguyễn Văn A</h3>
                <p class="text-blue-600 dark:text-blue-400 mb-4">Giám đốc điều hành</p>
                <p class="text-sm text-slate-600 dark:text-slate-300">
                    Với hơn 10 năm kinh nghiệm trong lĩnh vực công nghệ, anh A đã dẫn dắt NovaSmart từ một startup nhỏ trở thành thương hiệu uy tín.
                </p>
            </div>
            
            <!-- Team Member 2 -->
            <div class="text-center">
                <div class="w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden bg-gradient-to-br from-green-400 to-blue-500 flex items-center justify-center">
                    <img src="{{ asset('assets/user/images/dc0b1961-8be9-40d6-ba3e-06e2b38f2fd9.png') }}" alt="Trần Thị B - Head of Business" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20" style="display: none;">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2">Trần Thị B</h3>
                <p class="text-blue-600 dark:text-blue-400 mb-4">Trưởng phòng Kinh doanh</p>
                <p class="text-sm text-slate-600 dark:text-slate-300">
                    Chị B chịu trách nhiệm phát triển chiến lược kinh doanh và xây dựng mối quan hệ với đối tác, khách hàng.
                </p>
            </div>
            
            <!-- Team Member 3 -->
            <div class="text-center">
                <div class="w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center">
                    <img src="{{ asset('assets/user/images/FrezaXCapy.png') }}" alt="Lê Văn C - Head of Engineering" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20" style="display: none;">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2">Lê Văn C</h3>
                <p class="text-blue-600 dark:text-blue-400 mb-4">Trưởng phòng Kỹ thuật</p>
                <p class="text-sm text-slate-600 dark:text-slate-300">
                    Anh C đảm bảo chất lượng sản phẩm và phát triển các giải pháp công nghệ tiên tiến cho NovaSmart.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Contact CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-800 dark:to-purple-800">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-6">
            Hãy liên hệ với chúng tôi
        </h2>
        <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">
            Bạn có câu hỏi hoặc cần tư vấn? Đội ngũ NovaSmart luôn sẵn sàng hỗ trợ bạn 24/7.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="tel:+84123456789" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 rounded-lg font-semibold hover:bg-blue-50 transition-colors duration-300">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                </svg>
                Gọi ngay: 0123 456 789
            </a>
            <a href="{{ route('products.list') }}" class="inline-flex items-center justify-center px-8 py-4 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition-colors duration-300 shadow-lg">
                Mua ngay
            </a>
            <a href="mailto:info@novasmart.com" class="inline-flex items-center px-8 py-4 bg-transparent border-2 border-white text-white rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors duration-300">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                </svg>
                Email: info@novasmart.com
            </a>
        </div>
    </div>
</section>
@endsection