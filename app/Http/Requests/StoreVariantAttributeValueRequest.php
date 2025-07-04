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
     */
    public function rules(): array
    {
        return [
            'product_variant_id' => 'required|exists:product_variants,id',
            'attribute_id' => 'required|exists:attributes,id',
            'attribute_value_id' => 'required|exists:attribute_values,id',
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
            'attribute_id.required' => 'Thuộc tính là bắt buộc',
            'attribute_id.exists' => 'Thuộc tính không tồn tại',
            'attribute_value_id.required' => 'Giá trị thuộc tính là bắt buộc',
            'attribute_value_id.exists' => 'Giá trị thuộc tính không tồn tại',
        ];
    }
}
