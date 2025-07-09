<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVariantAttributeValueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cho phép người dùng thực hiện request này
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>     */
    public function rules(): array
    {
        return [
            'product_variant_id' => 'required|exists:product_variants,id',
            'attribute_value_id' => 'required|exists:attribute_values,id|unique:variant_attribute_values,attribute_value_id,NULL,id,product_variant_id,' . $this->input('product_variant_id'),
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'product_variant_id.required' => 'Biến thể sản phẩm là bắt buộc',
            'product_variant_id.exists' => 'Biến thể sản phẩm không tồn tại',
            'attribute_value_id.required' => 'Giá trị thuộc tính là bắt buộc',
            'attribute_value_id.exists' => 'Giá trị thuộc tính không tồn tại',
        ];
    }
}
