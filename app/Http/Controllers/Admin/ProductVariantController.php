<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Http\Requests\StoreProductVariantRequest;
use App\Http\Requests\UpdateProductVariantRequest;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource for a product.
     */
    public function index(Product $product)
    {
        // Lấy danh sách biến thể của sản phẩm
        $variants = $product->variants()->latest()->paginate(10);
        
        // Truyền $variants và $product vào view
        return view('admin.variants.index', compact('variants', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        // Truyền sản phẩm vào view
        return view('admin.variants.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductVariantRequest $request)
    {
        // Lấy product_id từ form
        $productId = $request->input('product_id');

        // Tạo mới một biến thể sản phẩm với thông tin được gửi lên
        $variant = new ProductVariant($request->validated());
        $variant->product_id = $productId; // Gán product_id vào biến thể
        $variant->save();

        return redirect()->route('admin.product-variants.index', ['product' => $productId])
                         ->with('success', 'Thêm biến thể thành công.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductVariant $productVariant)
    {
        $products = Product::all();  // Lấy tất cả sản phẩm
        return view('admin.variants.edit', compact('productVariant', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductVariantRequest $request, ProductVariant $productVariant)
    {
        // Cập nhật biến thể sản phẩm
        $productVariant->update($request->validated());
        return redirect()->route('admin.product-variants.index', ['product' => $productVariant->product_id])
                         ->with('success', 'Cập nhật biến thể thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariant $productVariant)
    {
        // Lấy product_id để điều hướng sau khi xóa
        $productId = $productVariant->product_id;

        // Xóa biến thể sản phẩm
        $productVariant->delete();
        return redirect()->route('admin.product-variants.index', ['product' => $productId])
                         ->with('success', 'Xóa biến thể thành công.');
    }
}

