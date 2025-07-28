<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Lấy dữ liệu cho menu dropdown
     */
    public function getMenuData()
    {
        // Lấy tất cả brands có sản phẩm
        $brands = Brand::whereHas('products')->get();
        
        // Nhóm brands theo category
        $categories = Category::whereHas('products')->get()->map(function($category) use ($brands) {
            $categoryBrands = $brands->where('category_id', $category->id);
            return [
                'id' => $category->id,
                'name' => $category->name,
                'brands' => $categoryBrands
            ];
        });

        return response()->json([
            'categories' => $categories
        ]);
    }

    /**
     * Hiển thị sản phẩm theo brand
     */
    public function productsByBrand($brandSlug)
    {
        $brand = Brand::where('name', 'like', '%' . $brandSlug . '%')->first();
        
        if (!$brand) {
            abort(404);
        }

        $products = Product::with(['brand', 'category', 'thumbnails'])
            ->where('brand_id', $brand->id)
            ->whereHas('status', function($query) {
                $query->where('code', 'active');
            })
            ->paginate(12);

        return view('user.pages.products', compact('products', 'brand'));
    }

    /**
     * Hiển thị sản phẩm theo category
     */
    public function productsByCategory($categorySlug)
    {
        $category = Category::where('name', 'like', '%' . $categorySlug . '%')->first();
        
        if (!$category) {
            abort(404);
        }

        $products = Product::with(['brand', 'category', 'thumbnails'])
            ->where('category_id', $category->id)
            ->whereHas('status', function($query) {
                $query->where('code', 'active');
            })
            ->paginate(12);

        return view('user.pages.products', compact('products', 'category'));
    }

    /**
     * Hiển thị tất cả sản phẩm
     */
    public function allProducts(Request $request)
    {
        $query = Product::with(['brand', 'category', 'thumbnails'])
            ->whereHas('status', function($query) {
                $query->where('code', 'active');
            });

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->category . '%');
            });
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $query->whereHas('brand', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->brand . '%');
            });
        }

        $products = $query->paginate(12);

        return view('user.pages.products', compact('products'));
    }
} 