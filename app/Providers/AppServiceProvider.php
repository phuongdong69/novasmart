<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Brand;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
{
    View::composer('*', function ($view) {
        $cart = [
            'items' => [],
            'total_price' => 0,
        ];

        if (Auth::check()) {
            $cartModel = Auth::user()->cart()->with('items.productVariant.product.thumbnails')->first();
            if ($cartModel) {
                $cart['items'] = $cartModel->items;
                $cart['total_price'] = $cartModel->total_price;
            }
        } else {
            $cartItems = Session::get('cart', []);
            $variants = ProductVariant::with('product.thumbnails')
                ->whereIn('id', array_keys($cartItems))->get();

            $items = [];
            $total = 0;
            foreach ($variants as $variant) {
                $qty = $cartItems[$variant->id]['quantity'];
                $price = $cartItems[$variant->id]['price'];
                $items[] = [
                    'variant' => $variant,
                    'product' => $variant->product,
                    'quantity' => $qty,
                    'price' => $price,
                    'total' => $qty * $price
                ];
                $total += $qty * $price;
            }

            $cart['items'] = $items;
            $cart['total_price'] = $total;
        }

        // Lấy dữ liệu cho mega menu - hiển thị tất cả categories
        $menuCategories = Category::with(['brands' => function($query) {
                // Load tất cả brands, không cần điều kiện whereHas('products')
                $query->orderBy('name');
            }])
            ->orderBy('name')
            ->get();

        // Lấy top brands có nhiều sản phẩm nhất
        $topBrands = Brand::whereHas('products')
            ->withCount('products')
            ->orderByDesc('products_count')
            ->take(5)
            ->get();

        $view->with([
            'cart' => $cart,
            'menuCategories' => $menuCategories,
            'topBrands' => $topBrands
        ]);
    });
}
}
