<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Origin;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with([
            'brand',
            'origin',
            'category',
            'variants.variantAttributeValues.attribute'
        ])->latest()->paginate(5);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $origins = Origin::all();
        $attributes = \App\Models\Attribute::with('values')->get();
        return view('admin.products.create', compact('brands', 'categories', 'origins', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
{
    $data = $request->validated();

    // Tìm hoặc tạo Brand
    if (!empty($data['brand_name'])) {
        $brand = Brand::firstOrCreate(['name' => $data['brand_name']]);
        $data['brand_id'] = $brand->id;
    }

    // Tìm hoặc tạo Category
    if (!empty($data['category_name'])) {
        $category = Category::firstOrCreate(['name' => $data['category_name']]);
        $data['category_id'] = $category->id;
    }

    // Tìm hoặc tạo Origin
    if (!empty($data['origin_name'])) {
        $origin = Origin::firstOrCreate(['name' => $data['origin_name']]);
        $data['origin_id'] = $origin->id;
    }

        // Tạo sản phẩm
        $product = Product::create($data);

        // Thêm biến thể nếu có
        if ($request->has('variants')) {
            $existingSkus = $product->variants()->pluck('sku')->toArray();
            foreach ($request->input('variants') as $variant) {
                // Kiểm tra trùng SKU biến thể cho sản phẩm
                if (!empty($variant['sku']) && in_array($variant['sku'], $existingSkus)) {
                    return back()->withErrors(['variants' => 'SKU biến thể ' . $variant['sku'] . ' đã tồn tại cho sản phẩm này!'])->withInput();
                }
                $existingSkus[] = $variant['sku'] ?? null;
                // Đảm bảo luôn lấy attributes đúng từ từng biến thể
                $attributes = isset($variant['attributes']) && is_array($variant['attributes']) ? $variant['attributes'] : [];
                unset($variant['attributes']);
                $productVariant = $product->variants()->create($variant);
                if (!$productVariant) {
                    \Log::error('Không tạo được biến thể', [$variant]);
                    continue;
                }
                // Lưu thuộc tính động cho từng biến thể
                foreach ($attributes as $attr) {
                    $attribute = $this->findOrCreateAttribute($attr);
                    if (!$attribute) {
                        \Log::warning('Không tìm/tạo được attribute', [$attr]);
                        continue;
                    }
                    $attributeValue = $this->findOrCreateAttributeValue($attr, $attribute->id);
                    if (!$attributeValue) {
                        \Log::warning('Không tìm/tạo được attributeValue', [$attr]);
                        continue;
                    }
                    $created = \App\Models\VariantAttributeValue::create([
                        'product_variant_id' => $productVariant->id,
                        'attribute_id' => $attribute->id,
                        'attribute_value_id' => $attributeValue->id,
                    ]);
                    if (!$created) {
                        \Log::error('Không lưu được VariantAttributeValue', [
                            'variant_id' => $productVariant->id,
                            'attribute_id' => $attribute->id,
                            'attribute_value_id' => $attributeValue->id
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm và biến thể thành công.');
    }

    /**
     * Tìm hoặc tạo attribute từ dữ liệu đầu vào
     */
    private function findOrCreateAttribute($attr) {
        if (!empty($attr['attribute_id']) && $attr['attribute_id'] !== '__new__') {
            return \App\Models\Attribute::find($attr['attribute_id']);
        } elseif (!empty($attr['new_name'])) {
            return \App\Models\Attribute::firstOrCreate(['name' => $attr['new_name']]);
        }
        return null;
    }

    /**
     * Tìm hoặc tạo attribute value từ dữ liệu đầu vào
     */
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
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $brands = Brand::all();
        $categories = Category::all();
        $origins = Origin::all();
        return view('admin.products.edit', compact('product', 'brands', 'categories', 'origins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công.');
    }
}
