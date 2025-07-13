<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('user.pages.profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'gender'      => ['nullable', 'in:male,female,other'],
            'birthday'    => ['nullable', 'date'],
            'image_user'  => ['nullable', 'image', 'max:2048'], // 2MB
        ], [
            'name.required'      => 'Vui lòng nhập họ tên.',
            'image_user.image'   => 'Ảnh đại diện phải là hình ảnh.',
            'image_user.max'     => 'Ảnh đại diện không được vượt quá 2MB.',
        ]);

        // Cập nhật thông tin người dùng (chỉ các trường được phép sửa)
        $user->name     = $request->name;
        $user->gender   = $request->gender;
        $user->birthday = $request->birthday;

        // Nếu người dùng chọn ảnh đại diện mới
        if ($request->hasFile('image_user')) {
            if ($user->image_user && Storage::disk('public')->exists($user->image_user)) {
                Storage::disk('public')->delete($user->image_user);
            }
            $user->image_user = $request->file('image_user')->store('avatars', 'public');
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Cập nhật hồ sơ thành công!');
    }
}
