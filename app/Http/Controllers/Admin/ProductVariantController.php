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
        if (empty($data['status_id'])) {
            $activeStatusId = \App\Models\Status::where('type', 'product_variant')->where('code', 'active')->value('id');
            $data['status_id'] = $activeStatusId;
        }
        ProductVariant::create($data);
        return redirect()->route('admin.product_variants.index')->with('success', 'Thêm biến thể thành công.');
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
