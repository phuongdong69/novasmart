<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\OriginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\CartController;

// ✅ Trang chủ
Route::get('/', function () {
    return view('user.pages.home');
});

// ✅ Auth - Đăng nhập / Đăng ký 
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// ✅ Đăng xuất 
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ✅ Admin routes
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');

    Route::put('categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])
        ->name('categories.toggleStatus');
    Route::resource('categories', CategoryController::class);

    Route::resource('origins', OriginController::class);

    // Roles dùng tạm làm brands nếu chưa có BrandController
    Route::resource('roles', RoleController::class);
    Route::resource('brands', RoleController::class);

    // Product Thumbnails
    Route::resource('product-thumbnails', App\Http\Controllers\Admin\ProductThumbnailController::class)
        ->only(['index', 'create', 'store', 'edit', 'update'])
        ->names([
            'index' => 'product_thumbnail.index',
            'create' => 'product_thumbnail.create',
            'store' => 'product_thumbnail.store',
            'edit' => 'product_thumbnail.edit',
            'update' => 'product_thumbnail.update',
        ]);

    Route::resource('vouchers', VoucherController::class);

    // Product Variants
    Route::get('/products/{product}/variants/create', [ProductVariantController::class, 'create'])
        ->name('product-variants.create');
    Route::post('/products/{product}/variants', [ProductVariantController::class, 'store'])
        ->name('product-variants.store');
    Route::resource('product-variants', ProductVariantController::class)->except(['create', 'store']);

    Route::resource('products', AdminProductController::class);
});

// ✅ Dashboard người dùng
Route::middleware('auth')->group(function () {
    Route::get('/user/homepage', function () {
        return view('user.homepage');
    })->name('user.homepage');
});

// ✅ Sản phẩm người dùng
Route::get('/user/products', [UserProductController::class, 'index'])->name('user.products.index');
Route::get('/user/products/{product}', [UserProductController::class, 'show'])->name('products.show');

// ✅ Giỏ hàng (dùng được cả khi chưa đăng nhập)
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{itemId}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::delete('/cart/remove/{itemId}', [CartController::class, 'remove'])->name('cart.remove');
