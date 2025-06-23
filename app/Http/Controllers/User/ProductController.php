<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index()
    {
        // Lấy tất cả sản phẩm và bao gồm cả các biến thể của mỗi sản phẩm
        $products = Product::with('variants', 'thumbnails')->paginate(12);
        
        // Trả về view với các sản phẩm
        return view('user.pages.product-list', compact('products'));
    }

    // Hiển thị chi tiết sản phẩm
    public function show(Product $product)
    {
        // Lấy thông tin biến thể của sản phẩm
        $product->load('productVariants');
        
        // Trả về view với thông tin sản phẩm chi tiết
        return view('user.products.show', compact('product'));
    }
}
