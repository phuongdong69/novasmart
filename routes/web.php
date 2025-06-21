<?php

use App\Http\Controllers\Admin\AttributeValueController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\OriginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\VariantAttributeValueController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VoucherController;

// ✅ Trang chủ
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
});

// ✅ Dashboard người dùng thường)
Route::middleware('auth')->group(function () {
    Route::get('/user/homepage', function () {
        return view('user.homepage');
    })->name('user.homepage');
});


// User dashboard
Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->name('user.dashboard')->middleware('auth');


// Register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Route đăng nhập
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/dashboard', function () {
    return 'Bạn đã đăng nhập!';
})->middleware('auth');


// Route đăng xuất
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


//Route VOUCHER
Route::resource('vouchers', VoucherController::class)
