<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products for users.
     */
    public function index(Request $request)
    {
        // Eager load thumbnails, brand, origin, and category
        $products = Product::with([
            'brand',
            'origin',
            'category',
            'thumbnails' // Assuming relation exists
        ])->latest()->paginate(12);

        return view('user.pages.product-list', compact('products'));
    }
}
