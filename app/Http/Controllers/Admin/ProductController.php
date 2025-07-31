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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
            'variants.status',
            'variants.variantAttributeValues.attributeValue.attribute',
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
        $statuses = \App\Models\Status::getByType('product');
        return view('admin.products.create', compact('brands', 'categories', 'origins', 'attributes', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        // Xử lý status_code
        if (!empty($data['status_code'])) {
            $status = \App\Models\Status::findByCodeAndType($data['status_code'], 'product');
            if ($status) {
                $data['status_id'] = $status->id;
            }
        } else {
            $status = \App\Models\Status::where('type', 'product')->where('code', 'active')->first();
            $data['status_id'] = $status?->id;
            $data['status_code'] = $status?->code;
        }
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
                if (empty($variant['status_id'])) {
                    $activeStatusId = \App\Models\Status::where('type', 'product_variant')->where('code', 'active')->value('id');
                    $variant['status_id'] = $activeStatusId;
                }
                $productVariant = $product->variants()->create($variant);
                if (!$productVariant) {
                    Log::error('Không tạo được biến thể', [$variant]);
                    continue;
                }
                foreach ($attributes as $attr) {
                    $attribute = $this->findOrCreateAttribute($attr);
                    if (!$attribute) {
                        Log::warning('Không tìm/tạo được attribute', [$attr]);
                        continue;
                    }
                    $attributeValue = $this->findOrCreateAttributeValue($attr, $attribute->id);
                    if (!$attributeValue) {
                        Log::warning('Không tìm/tạo được attributeValue', [$attr]);
                        continue;
                    }
                    $created = \App\Models\VariantAttributeValue::create([
                        'product_variant_id' => $productVariant->id,
                        'attribute_value_id' => $attributeValue->id,
                    ]);
                    if (!$created) {
                        Log::error('Không lưu được VariantAttributeValue', [
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
        $statuses = \App\Models\Status::getByType('product');
        return view('admin.products.edit', compact('product', 'brands', 'categories', 'origins', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        // Xử lý status_code
        if (!empty($data['status_code'])) {
            $status = \App\Models\Status::findByCodeAndType($data['status_code'], 'product');
            if ($status) {
                $data['status_id'] = $status->id;
            }
        }
        $oldData = $product->toArray();
        // Cập nhật thông tin sản phẩm
        $product->update($data);
        
        // Lưu lịch sử chỉnh sửa
        $newData = $product->fresh()->toArray();
        // Chỉ lấy các field cơ bản, bỏ qua relationships
        $basicFields = ['id', 'name', 'description', 'brand_id', 'origin_id', 'category_id', 'status_id', 'created_at', 'updated_at'];
        $filteredNewData = array_intersect_key($newData, array_flip($basicFields));
        $filteredOldData = array_intersect_key($oldData, array_flip($basicFields));
        $changes = array_diff_assoc($filteredNewData, $filteredOldData);
        if (!empty($changes) && auth()->check()) {
            // Lọc ra các key là string, bỏ qua array
            $changedFields = array_filter(array_keys($changes), function($key) {
                return is_string($key);
            });
            $note = 'Cập nhật thông tin sản phẩm: ' . implode(', ', $changedFields);
            $product->statusLogs()->create([
                'status_id' => $product->status_id ?? 1, // Default status_id nếu null
                'user_id' => auth()->id(),
                'note' => $note,
            ]);
        }
        
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

    /**
     * Toggle trạng thái active/inactive cho sản phẩm
     */
    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $currentStatus = $product->status;
        
        // Tìm status active và inactive
        $activeStatus = \App\Models\Status::where('code', 'active')->first();
        $inactiveStatus = \App\Models\Status::where('code', 'inactive')->first();
        
        if (!$activeStatus || !$inactiveStatus) {
            return redirect()->back()->with('error', 'Không tìm thấy trạng thái active/inactive!');
        }
        
        // Toggle trạng thái
        $newStatusId = $currentStatus && $currentStatus->code === 'active' ? $inactiveStatus->id : $activeStatus->id;
        $note = $currentStatus && $currentStatus->code === 'active' ? 'Deactivate sản phẩm' : 'Activate sản phẩm';
        
        $product->updateStatus($newStatusId, auth()->id(), $note);
        
        return redirect()->back()->with('success', 'Đã cập nhật trạng thái sản phẩm!');
    }
}
