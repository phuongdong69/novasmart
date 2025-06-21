<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    /**
     * Hiển thị form quên mật khẩu.
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Gửi liên kết đặt lại mật khẩu.
     */
    public function store(Request $request)
    {
        // ✅ Validate với thông báo tiếng Việt
        $request->validate(
            [
                'email' => 'required|email|exists:users,email',
            ],
            [
                'email.required' => 'Vui lòng nhập email.',
                'email.email'    => 'Email không đúng định dạng.',
                'email.exists'   => 'Email này không tồn tại trong hệ thống.',
            ]
        );

        // ✅ Gửi link đặt lại mật khẩu
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with(['status' => 'Chúng tôi đã gửi liên kết đặt lại mật khẩu đến email của bạn.'])
            : back()->withErrors(['email' => 'Gửi liên kết thất bại. Vui lòng thử lại sau.']);
    }
}
