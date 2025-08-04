@if (!Auth::check())
<div id="popup-login-required" class="fixed inset-0 z-[10000] bg-black bg-opacity-60 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-slate-900 p-6 rounded-md shadow-lg max-w-md w-full popup-box">
        <h2 class="text-lg font-semibold text-slate-800 dark:text-white mb-2">Yêu cầu đăng nhập</h2>
        <p class="text-slate-500 dark:text-slate-400 mb-4">Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.</p>
        <div class="flex justify-end space-x-2">
            <a href="{{ route('login') }}" class="px-4 py-2 rounded bg-orange-500 text-white font-semibold">Đăng nhập</a>
            <button onclick="document.getElementById('popup-login-required').classList.add('hidden')" class="px-4 py-2 rounded bg-gray-200 text-gray-800">Đóng</button>
        </div>
    </div>
</div>
@endif 