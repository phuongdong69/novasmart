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
            'variants.variantAttributeValues.attribute'
        ])->with('status')->orderBy('id', 'desc')->paginate(10)->withQueryString();

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
        return view('admin.products.create', compact('brands', 'categories', 'origins'));
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
            foreach ($request->input('variants') as $variant) {
                $product->variants()->create($variant);
            }
        }

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm và biến thể thành công.');
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
        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công.');
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
