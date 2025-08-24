<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Http\Requests\StoreProductVariantRequest;
use App\Http\Requests\UpdateProductVariantRequest;
use App\Models\Product;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productVariants = ProductVariant::with(['product', 'status'])->latest()->paginate(10);
        return view('admin.product_variants.index', ['productVariants' => $productVariants]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $statuses = \App\Models\Status::where('type', 'product_variant')->get();
        return view('admin.product_variants.create', compact('products', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductVariantRequest $request)
    {
        $data = $request->validated();
        $product = \App\Models\Product::findOrFail($data['product_id']);
        // Check duplicate SKU for this product
        if (!empty($data['sku'])) {
            $exists = $product->variants()->where('sku', $data['sku'])->exists();
            if ($exists) {
                return back()->withErrors(['sku' => 'SKU biến thể đã tồn tại cho sản phẩm này!'])->withInput();
            }
        }
        // Tự động gán status_id theo quantity
        $inStockId = \App\Models\Status::where('type', 'product_variant')->where('code', 'in_stock')->value('id');
        $outOfStockId = \App\Models\Status::where('type', 'product_variant')->where('code', 'out_of_stock')->value('id');
        $data['status_id'] = (isset($data['quantity']) && $data['quantity'] > 0) ? $inStockId : $outOfStockId;
        // Lưu variant
        $attributes = $data['attributes'] ?? [];
        unset($data['attributes']);
        $productVariant = $product->variants()->create($data);
        // Lưu thuộc tính cho variant
        foreach ($attributes as $attr) {
            $attribute = $this->findOrCreateAttribute($attr);
            if (!$attribute) continue;
            $attributeValue = $this->findOrCreateAttributeValue($attr, $attribute->id);
            if (!$attributeValue) continue;
            \App\Models\VariantAttributeValue::create([
                'product_variant_id' => $productVariant->id,
                'attribute_value_id' => $attributeValue->id,
            ]);
        }
        return redirect()->route('admin.product_variants.index')->with('success', 'Thêm biến thể thành công.');
    }

    // Copy từ ProductController
    private function findOrCreateAttribute($attr) {
        if (!empty($attr['attribute_id']) && $attr['attribute_id'] !== '__new__') {
            return \App\Models\Attribute::find($attr['attribute_id']);
        } elseif (!empty($attr['new_name'])) {
            return \App\Models\Attribute::firstOrCreate(['name' => $attr['new_name']]);
        }
        return null;
    }

    private function findOrCreateAttributeValue($attr, $attributeId) {
        if (!empty($attr['value']) && $attr['value'] !== '__new__') {
            $attributeValue = \App\Models\AttributeValue::find($attr['value']);
            if (!$attributeValue && is_numeric($attr['value'])) {
                $attributeValue = \App\Models\AttributeValue::where('attribute_id', $attributeId)
                    ->where('id', $attr['value'])->first();
            }
            return $attributeValue;
        } elseif (!empty($attr['new_value'])) {
            return \App\Models\AttributeValue::firstOrCreate([
                'attribute_id' => $attributeId,
                'value' => $attr['new_value']
            ]);
        }
        return null;
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductVariant $productVariant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductVariant $productVariant)
    {
        $products = Product::all();
        $statuses = \App\Models\Status::where('type', 'product_variant')->get();
        return view('admin.product_variants.edit', compact('productVariant', 'products', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductVariantRequest $request, ProductVariant $productVariant)
    {
        $productVariant->update($request->validated());
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'status' => $productVariant->status]);
        }
        return redirect()->route('admin.product_variants.index')->with('success', 'Cập nhật biến thể thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariant $productVariant)
    {
        $productVariant->delete();
        return redirect()->route('admin.product_variants.index')->with('success', 'Xóa biến thể thành công.');
    }
}
