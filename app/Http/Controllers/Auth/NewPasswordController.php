<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class NewPasswordController extends Controller
{
    /**
     * Hiển thị form đặt lại mật khẩu với token.
     */
    public function create(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Lưu mật khẩu mới vào hệ thống.
     */
    public function store(Request $request)
    {
        // ✅ Validate với thông báo lỗi bằng tiếng Việt
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'token.required'    => 'Thiếu mã xác thực.',
            'email.required'    => 'Vui lòng nhập email.',
            'email.email'       => 'Email không đúng định dạng.',
            'email.exists'      => 'Email không tồn tại trong hệ thống.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min'      => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        // ✅ Tiến hành reset mật khẩu
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        // ✅ Trả kết quả
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập.')
            : back()->withErrors(['email' => 'Đặt lại mật khẩu thất bại. Vui lòng thử lại.']);
    }
}
