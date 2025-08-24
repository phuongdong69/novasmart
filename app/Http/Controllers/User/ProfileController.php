<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
            'phoneNumber' => [
                'nullable',
                'regex:/^\d{10}$/',
                Rule::unique('users', 'phoneNumber')->ignore($user->id),
            ],
            'address' => ['nullable', 'string', 'max:255'],

            'image_user'  => ['nullable', 'image', 'max:2048'], // 2MB
        ], [
            'name.required'        => 'Vui lòng nhập họ tên.',
            'phoneNumber.regex'    => 'Số điện thoại phải gồm đúng 10 chữ số.',
            'phoneNumber.unique'   => 'Số điện thoại này đã được sử dụng.',
            'image_user.image'     => 'Ảnh đại diện phải là hình ảnh.',
            'image_user.max'       => 'Ảnh đại diện không được vượt quá 2MB.',
        ]);

        // Cập nhật thông tin người dùng
        $user->name        = $request->name;
        $user->gender      = $request->gender;
        $user->birthday    = $request->birthday;
        $user->phoneNumber = $request->phoneNumber;
        $user->address = $request->address;


        // Nếu có ảnh mới thì xử lý thay thế ảnh cũ
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
