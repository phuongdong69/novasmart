<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function show($id)
    {
        $product = ProductVariant::with([
            'product.brand',
            'product.origin',
            'product.category', 
            'product.thumbnails',
            'variantAttributeValues.attribute',
            'variantAttributeValues.attributeValue'
        ])->findOrFail($id);

        // Lấy các biến thể khác của cùng sản phẩm
        $relatedVariants = ProductVariant::with([
            'product.thumbnails',
            'variantAttributeValues.attribute',
            'variantAttributeValues.attributeValue'
        ])
        ->where('product_id', $product->product_id)
        ->where('id', '!=', $id)
        ->where('quantity', '>', 0)
        ->get();

        return response()->json([
            'success' => true,
            'product' => $product,
            'relatedVariants' => $relatedVariants
        ]);
    }
} 