<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Origin;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

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
            // 'variants.variantAttributeValues.attribute',
            // 'variants.variantAttributeValues.attributeValue',
            'status',
        ])->orderBy('id', 'desc')->paginate(10)->withQueryString();
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
        // Lấy status_id mặc định nếu chưa có
        if (empty($data['status_id'])) {
            $activeStatusId = \App\Models\Status::where('code', 'active')->value('id');
            $data['status_id'] = $activeStatusId;
        }
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
        // Xử lý ảnh chính (thumbnail_primary)
        if ($request->hasFile('thumbnail_primary')) {
            $path = $request->file('thumbnail_primary')->store('uploads/products/thumbnails', 'public');
            $product->thumbnails()->create([
                'url' => $path,
                'is_primary' => 1,
                'sort_order' => 0,
            ]);
        }
        // Xử lý ảnh phụ (thumbnails[])
        if ($request->hasFile('thumbnails')) {
            foreach ($request->file('thumbnails') as $file) {
                $path = $file->store('uploads/products/thumbnails', 'public');
                $product->thumbnails()->create([
                    'url' => $path,
                    'is_primary' => 0,
                    'sort_order' => 0,
                ]);
            }
        }
        // Thêm biến thể nếu có
        if ($request->has('variants')) {
            $existingSkus = $product->variants()->pluck('sku')->toArray();
            foreach ($request->input('variants') as $variant) {
                if (!empty($variant['sku']) && in_array($variant['sku'], $existingSkus)) {
                    return back()->withErrors(['variants' => 'SKU biến thể ' . $variant['sku'] . ' đã tồn tại cho sản phẩm này!'])->withInput();
                }
                $existingSkus[] = $variant['sku'] ?? null;
                $attributes = isset($variant['attributes']) && is_array($variant['attributes']) ? $variant['attributes'] : [];
                unset($variant['attributes']);
                $productVariant = $product->variants()->create($variant);
                if (!$productVariant) {
                    \Log::error('Không tạo được biến thể', [$variant]);
                    continue;
                }
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
                        'attribute_value_id' => $attributeValue->id,
                    ]);
                    if (!$created) {
                        \Log::error('Không lưu được VariantAttributeValue', [
                            'variant_id' => $productVariant->id,
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

    /**
     * Hiển thị lịch sử thay đổi trạng thái của product
     */
    public function statusLogs($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $logs = $product->statusLogs()->with('status', 'loggable')->orderByDesc('created_at')->get();
        return view('admin.products.status_logs', compact('product', 'logs'));
    }

    /**
     * Cập nhật trạng thái cho product và ghi log
     */
    public function updateStatus(Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $request->validate([
            'status_id' => 'required|exists:statuses,id',
            'note' => 'nullable|string',
        ]);
        $product->updateStatus($request->status_id, auth()->id(), $request->note);
        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }
}
