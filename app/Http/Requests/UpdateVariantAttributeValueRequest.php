<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVariantAttributeValueRequest extends FormRequest
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
            'product_variant_id' => 'sometimes|exists:product_variants,id',
            'attribute_id' => 'sometimes|exists:attributes,id',
            'attribute_value_id' => 'sometimes|exists:attribute_values,id|unique:variant_attribute_values,attribute_value_id,' . $this->route('variant_attribute_value')->id . ',id,product_variant_id,' . $this->input('product_variant_id'),
        ];
    }
}
