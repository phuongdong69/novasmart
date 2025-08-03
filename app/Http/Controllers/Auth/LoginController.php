<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Hiển thị form đăng nhập
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        // Validate dữ liệu nhập vào
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        // Kiểm tra xem user có tồn tại không
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Nếu tài khoản bị tạm khóa
            if ($user->status_id == 13) {
                return back()->withErrors([
                    'login' => 'Tài khoản của bạn đang bị tạm khóa. Vui lòng liên hệ quản trị viên để được hỗ trợ.',
                ])->withInput($request->only('email'));
            }
        }

        // Nếu không bị khóa, thử đăng nhập
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Đăng nhập thành công, tạo session mới
            $request->session()->regenerate();

            $user = Auth::user();

            // Kiểm tra role_id để chuyển hướng
            if ($user->role_id == 1) {
                return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công! Chào mừng Admin!');
            } else {
                return redirect()->route('user.pages.home')->with('success', 'Đăng nhập thành công! Chào mừng bạn!');
            }
        }

        // Đăng nhập thất bại
        return back()->withErrors([
            'login' => 'Email hoặc mật khẩu không đúng.',
        ])->withInput($request->only('email'));
    }

    /**
     * Xử lý đăng xuất
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Bạn đã đăng xuất thành công!');
    }
}
