<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phoneNumber' => ['required', 'regex:/^(0|\+84)[0-9]{9,10}/'],
            'email' => 'required|email',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|in:cod,banking',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập họ tên',
            'phoneNumber.required' => 'Vui lòng nhập số điện thoại',
            'phoneNumber.regex' => 'Số điện thoại không hợp lệ',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
            'payment_method.in' => 'Phương thức thanh toán không hợp lệ',
            
        ];
    }
}
