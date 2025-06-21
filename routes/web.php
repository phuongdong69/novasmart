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

// Trang chủ
Route::get('/', function () {
    return view('welcome');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');

    // Categories
    Route::put('categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])
        ->name('categories.toggleStatus');
    Route::resource('categories', CategoryController::class);

    // Origins
    Route::resource('origins', OriginController::class);

    // Roles (tạm thời dùng cho brands nếu chưa có BrandController)
    Route::resource('roles', RoleController::class);
    Route::resource('brands', RoleController::class);

    // Product Variants
    Route::get('/products/{product}/variants/create', [ProductVariantController::class, 'create'])
        ->name('product-variants.create');
    Route::post('/products/{product}/variants', [ProductVariantController::class, 'store'])
        ->name('product-variants.store');
    Route::resource('product-variants', ProductVariantController::class)->except(['create', 'store']);

    // Products
    Route::resource('products', AdminProductController::class);
});

// Sản phẩm cho người dùng
Route::get('/user/products', [UserProductController::class, 'index'])
    ->name('user.products.index');
Route::get('/user/products/{product}', [UserProductController::class, 'show'])
    ->name('products.show');

// User Dashboard
Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->name('user.dashboard')->middleware('auth');

// Đăng ký
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Đăng nhập
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Đăng xuất
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard sau đăng nhập
Route::get('/dashboard', function () {
    return 'Bạn đã đăng nhập!';
})->middleware('auth');

// Vouchers
Route::resource('vouchers', VoucherController::class);

// Cart routes
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{itemId}', [CartController::class, 'updateQuantity'])->name('cart.update');

Route::delete('/cart/remove/{itemId}', [CartController::class, 'remove'])
    ->name('cart.remove');
