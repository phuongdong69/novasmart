<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\VariantAttributeValue;

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

            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string',

            // Validate mảng biến thể
            'variants' => 'nullable|array',
            'variants.*.sku' => 'required_with:variants|string|max:255|distinct|unique:product_variants,sku',
            'variants.*.price' => 'required_with:variants|numeric|min:0',
            'variants.*.quantity' => 'required_with:variants|integer|min:0',
            'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'variants.*.status' => 'nullable|string|max:50',

            // Validate thuộc tính cho từng biến thể (nếu có)
            'variants.*.attributes' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) {
                    $attributeIds = collect($value)->pluck('attribute_id')->toArray();
                    if (count($attributeIds) !== count(array_unique($attributeIds))) {
                        $fail('Mỗi biến thể không được có thuộc tính trùng lặp.');
                    }
                },
            ],
            'variants.*.attributes.*.attribute_id' => 'required_with:variants.*.attributes|exists:attributes,id',
            'variants.*.attributes.*.value' => 'required_with:variants.*.attributes|string|max:255',

            // Nếu muốn thêm thuộc tính cho sản phẩm (không phải cho biến thể)
            'attributes' => 'nullable|array',
            'attributes.*.attribute_id' => 'required_with:attributes|exists:attributes,id|distinct',
            'attributes.*.value' => 'required_with:attributes|string|max:255',

            // Validate ảnh
            'thumbnail_primary' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'thumbnails' => 'nullable|array',
            'thumbnails.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ];
    }

    /**
     * Custom validate: không cho phép biến thể có tập thuộc tính trùng với bất kỳ biến thể nào đã tồn tại trên hệ thống.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // 1. Check trùng thuộc tính sản phẩm (attributes) trên toàn hệ thống
            $attributes = $this->input('attributes', []);
            if (!empty($attributes)) {
                $attrPairs = collect($attributes)
                    ->map(function($item) { return $item['attribute_id'] . '-' . $item['value']; })
                    ->sort()
                    ->implode('|');
                // Tìm sản phẩm khác đã có cùng tổ hợp attribute_id+value này
                $exists = \DB::table('product_attributes')
                    ->select('product_id')
                    ->groupBy('product_id')
                    ->havingRaw('GROUP_CONCAT(CONCAT(attribute_id, "-", value) ORDER BY attribute_id SEPARATOR "|") = ?', [$attrPairs])
                    ->exists();
                if ($exists) {
                    $validator->errors()->add('attributes', 'Tổ hợp thuộc tính sản phẩm này đã tồn tại trên hệ thống!');
                }
            }
            $variants = $this->input('variants', []);
            if (empty($variants)) return;
            // Gom tất cả signature thuộc tính của các biến thể trong request
            $signatures = [];
            foreach ($variants as $variant) {
                $attrs = $variant['attributes'] ?? [];
                if (empty($attrs)) continue;
                // signature: attribute_id-value|attribute_id-value|...
                $sig = collect($attrs)
                    ->sortBy('attribute_id')
                    ->map(function($item) { return $item['attribute_id'] . '-' . $item['value']; })
                    ->implode('|');
                $signatures[] = $sig;
            }
            if (empty($signatures)) return;
            // Lấy tất cả các biến thể đã tồn tại có cùng signature
            $existing = VariantAttributeValue::select('product_variant_id')
                ->with('productVariant.variantAttributeValues')
                ->get()
                ->groupBy('product_variant_id')
                ->filter(function($group) use ($signatures) {
                    $sig = $group->sortBy('attribute_id')
                        ->map(function($item) { return $item->attribute_id . '-' . $item->value; })
                        ->implode('|');
                    return in_array($sig, $signatures);
                });
            // Nếu có signature trùng -> báo lỗi
            foreach ($variants as $variantIndex => $variant) {
                $attrs = $variant['attributes'] ?? [];
                if (empty($attrs)) continue;
                $sig = collect($attrs)
                    ->sortBy('attribute_id')
                    ->map(function($item) { return $item['attribute_id'] . '-' . $item['value']; })
                    ->implode('|');
                if ($existing->filter(function($group) use ($sig) {
                    $groupSig = $group->sortBy('attribute_id')
                        ->map(function($item) { return $item->attribute_id . '-' . $item->value; })
                        ->implode('|');
                    return $groupSig === $sig;
                })->isNotEmpty()) {
                    $validator->errors()->add(
                        "variants.$variantIndex.attributes",
                        "Tổ hợp thuộc tính của biến thể này đã tồn tại trên hệ thống!"
                    );
                }
            }
        });
    }
}
