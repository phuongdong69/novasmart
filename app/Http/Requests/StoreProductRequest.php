<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            // Cho phép nhập mới hoặc chọn sẵn brand, origin, category
            'brand_id' => 'nullable|exists:brands,id',
            'brand_name' => 'nullable|string|max:255',
            'origin_id' => 'nullable|exists:origins,id',
            'origin_name' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'category_name' => 'nullable|string|max:255',

            'name' => 'required|string|max:255',
            'description' => 'nullable|string',

            // Validate mảng biến thể
            'variants' => 'nullable|array',
            'variants.*.sku' => 'required_with:variants|string|max:255',
            'variants.*.price' => 'required_with:variants|numeric|min:0',
            'variants.*.quantity' => 'required_with:variants|integer|min:0',
            'variants.*.status' => 'nullable|string|max:50',

            // Validate thuộc tính cho từng biến thể (nếu có)
            'variants.*.attributes' => 'nullable|array',
            'variants.*.attributes.*.attribute_id' => 'required_with:variants.*.attributes|exists:attributes,id',
            'variants.*.attributes.*.value' => 'required_with:variants.*.attributes|string|max:255',

            // Nếu muốn thêm thuộc tính cho sản phẩm (không phải cho biến thể)
            'attributes' => 'nullable|array',
            'attributes.*.attribute_id' => 'required_with:attributes|exists:attributes,id',
            'attributes.*.value' => 'required_with:attributes|string|max:255',
        ];
    }
}
