<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\Status;
use App\Models\Brand;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy sản phẩm mới nhất có biến thể có sẵn
        $products = Product::with(['thumbnails', 'variants' => function($q) {
            $q->where('quantity', '>', 0);
        }, 'ratings'])
        ->whereHas('variants', function($q) {
            $q->where('quantity', '>', 0);
        })
        ->latest()
        ->take(8)
        ->get();
        
        // Lấy id các status đơn hàng hợp lệ
        $statusCodes = ['completed', 'delivered', 'confirmed'];
        $statusIds = Status::where('type', 'order')->whereIn('code', $statusCodes)->pluck('id');

        // Lấy top 5 variant bán chạy nhất
        $topVariantIds = OrderDetail::whereHas('order', function($q) use ($statusIds) {
            $q->whereIn('status_id', $statusIds);
        })
        ->selectRaw('product_variant_id, SUM(quantity) as total_sold')
        ->groupBy('product_variant_id')
        ->orderByDesc('total_sold')
        ->limit(5)
        ->pluck('product_variant_id');

        $popularProducts = Product::whereHas('variants', function($q) use ($topVariantIds) {
            $q->whereIn('id', $topVariantIds);
        })
        ->with(['thumbnails', 'variants' => function($q) use ($topVariantIds) {
            $q->whereIn('id', $topVariantIds);
        }])
        ->get();

        // Lấy top brands có nhiều sản phẩm nhất
        $topBrands = Brand::withCount('products')
            ->having('products_count', '>', 0)
            ->orderByDesc('products_count')
            ->take(5)
            ->get();

        // Lấy sản phẩm theo từng brand (10 sản phẩm mỗi brand)
        $productsByBrand = [];
        foreach ($topBrands as $brand) {
            $brandProducts = Product::with(['thumbnails', 'variants' => function($q) {
                $q->where('quantity', '>', 0);
            }, 'ratings'])
            ->where('brand_id', $brand->id)
            ->whereHas('variants', function($q) {
                $q->where('quantity', '>', 0);
            })
            ->latest()
            ->take(10)
            ->get();
            
            if ($brandProducts->count() > 0) {
                $productsByBrand[$brand->id] = [
                    'brand' => $brand,
                    'products' => $brandProducts
                ];
            }
        }

        return view('user.pages.home', compact('products', 'popularProducts', 'productsByBrand'));
    }
}
