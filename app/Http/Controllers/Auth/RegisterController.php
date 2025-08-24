<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // Giao diện form đăng ký
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'required|regex:/^[0-9]{10}$/|unique:users,phoneNumber',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted',
        ], [
            'fullname.required' => 'Họ và tên là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.unique' => 'Email đã được sử dụng.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.regex' => 'Số điện thoại phải gồm đúng 10 số.',
            'phone.unique' => 'Số điện thoại này đã được sử dụng.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'terms.accepted' => 'Bạn phải đồng ý với Điều khoản sử dụng và Chính sách bảo mật.',
        ]);

        $role = Role::where('name', 'user')->first();

        if (!$role) {
            $role = Role::create([
                'name' => 'user',
                'description' => 'Người dùng mặc định',
            ]);
        }

        User::create([
            'role_id' => $role->id,
            'name' => $validatedData['fullname'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'phoneNumber' => $validatedData['phone'],
             'status_id' => 12, 
            'image_user' => null,
            'address' => null,
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
}
