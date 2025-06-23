<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class OriginRequest extends FormRequest
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
    $id = $this->route('origin') ?? $this->id; 

    return [
        'country' => [
            'required',
            'string',
            'max:255',
            'regex:/^[^\d]+$/', 
            Rule::unique('origins', 'country')->ignore($id),
        ],
    ];
}

public function messages()
{
    return [
        'country.required' => 'Vui lòng nhập tên quốc gia.',
        'country.string' => 'Tên quốc gia phải là chuỗi.',
        'country.max' => 'Tên quốc gia không được vượt quá 255 ký tự.',
        'country.regex' => 'Tên quốc gia không được chứa số.',
        'country.unique' => 'Tên quốc gia đã tồn tại.',
    ];
}
}
