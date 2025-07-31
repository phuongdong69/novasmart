<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductThumbnail;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductThumbnailController extends Controller
{
    public function index()
    {
        $thumbnails = ProductThumbnail::with('product')->orderBy('priority')->get();
        return view('admin.product_thumbnail.index', compact('thumbnails'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.product_thumbnail.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image_path' => 'required|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'priority' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        ProductThumbnail::create($request->all());

        return redirect()->route('admin.product-thumbnails.index')
            ->with('success', 'Product thumbnail created successfully.');
    }

    public function edit(ProductThumbnail $productThumbnail)
    {
        $products = Product::all();
        return view('admin.product_thumbnail.edit', compact('productThumbnail', 'products'));
    }

    public function update(Request $request, ProductThumbnail $productThumbnail)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image_path' => 'required|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'priority' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $productThumbnail->update($request->all());

        return redirect()->route('admin.product-thumbnails.index')
            ->with('success', 'Product thumbnail updated successfully.');
    }

    public function destroy(ProductThumbnail $productThumbnail)
    {
        $productThumbnail->delete();

        return redirect()->route('admin.product-thumbnails.index')
            ->with('success', 'Product thumbnail deleted successfully.');
    }
} 