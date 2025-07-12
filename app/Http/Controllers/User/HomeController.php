<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(['thumbnails', 'variants'])->latest()->take(8)->get();
        return view('user.pages.home', compact('products'));
    }
}
