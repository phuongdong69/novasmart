<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\OriginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VoucherController;

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
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');

    // Categories
    Route::put('categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');
    Route::resource('categories', CategoryController::class)->names([
        'index'   => 'categories.index',
        'create'  => 'categories.create',
        'store'   => 'categories.store',
        'edit'    => 'categories.edit',
        'update'  => 'categories.update',
        'destroy' => 'categories.destroy',
    ]);

    // Products
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->names([
        'index'   => 'products.index',
        'create'  => 'products.create',
        'store'   => 'products.store',
        'show'    => 'products.show',
        'edit'    => 'products.edit',
        'update'  => 'products.update',
        'destroy' => 'products.destroy',
    ]);

    // Variants
    Route::prefix('products')->name('products.')->group(function () {
        Route::post('{product}/variants', [\App\Http\Controllers\Admin\ProductController::class, 'storeVariant'])->name('variants.store');
        Route::put('{product}/variants/{variant}', [\App\Http\Controllers\Admin\ProductController::class, 'updateVariant'])->name('variants.update');
        Route::delete('{product}/variants/{variant}', [\App\Http\Controllers\Admin\ProductController::class, 'destroyVariant'])->name('variants.destroy');
    });

    // Origins
    Route::resource('origins', OriginController::class)->names([
        'index'   => 'origins.index',
        'create'  => 'origins.create',
        'store'   => 'origins.store',
        'edit'    => 'origins.edit',
        'update'  => 'origins.update',
        'destroy' => 'origins.destroy',
    ]);

    // Roles
    Route::resource('roles', RoleController::class);

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

    // Vouchers
    Route::resource('vouchers', VoucherController::class)->names([
        'index' => 'vouchers.index',
        'create' => 'vouchers.create',
        'store' => 'vouchers.store',
        'show' => 'vouchers.show',
        'edit' => 'vouchers.edit',
        'update' => 'vouchers.update',
        'destroy' => 'vouchers.destroy',
    ]);

    // Brands
    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class)->names([
        'index'   => 'brands.index',
        'create'  => 'brands.create',
        'store'   => 'brands.store',
        'edit'    => 'brands.edit',
        'update'  => 'brands.update',
        'destroy' => 'brands.destroy',
    ]);

});

// Dashboard người dùng thường)
Route::middleware('auth')->group(function () {
Route::get('/user/homepage', function () {
        return view('user.homepage');
    })->name('user.homepage');
});
