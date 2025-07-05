<?php

use App\Http\Controllers\Admin\AttributeValueController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\OriginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\VariantAttributeValueController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\ProductThumbnailController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;

/*
|--------------------------------------------------------------------------
| Trang chủ
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('user.pages.home');
})->name('home');

/*
|--------------------------------------------------------------------------
| Auth: Đăng nhập, Đăng ký, Quên mật khẩu (dành cho khách chưa đăng nhập)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // ✅ Đăng nhập
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // ✅ Đăng ký
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // ✅ Quên mật khẩu - Gửi link
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    // ✅ Đặt lại mật khẩu
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Đăng xuất (chỉ người đã đăng nhập mới logout được)
|--------------------------------------------------------------------------
*/
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin: Quản trị hệ thống
|--------------------------------------------------------------------------
*/
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
    Route::resource('product-thumbnails', ProductThumbnailController::class)->only(['index', 'create', 'store', 'edit', 'update'])->names([
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
    //productAdd commentMore actions
    Route::resource('products', ProductController::class);
    //attribute
    Route::resource('attributes', AttributeController::class);
    //attribute_values
    Route::resource('attribute_values', AttributeValueController::class);
    //product_variant
    Route::resource('product_variants', ProductVariantController::class);
    //Variant_attribute_value
    Route::resource('variant_attribute_values', VariantAttributeValueController::class);
});

/*
|--------------------------------------------------------------------------
| Người dùng thường (đã đăng nhập)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/user/pages.home', function () {
        return view('user.pages.home');
    })->name('user.pages.home');
});

/*
|--------------------------------------------------------------------------
| Giỏ hàng (dùng được cả khi chưa đăng nhập)
|--------------------------------------------------------------------------
*/

// Giỏ hàng
Route::get('/shop-cart', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{itemId}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::delete('/cart/remove/{itemId}', [CartController::class, 'remove'])->name('cart.remove');
/*
|--------------------------------------------------------------------------
| Thanh toán
|--------------------------------------------------------------------------
*/
Route::delete('/checkout/remove-voucher', [CheckoutController::class, 'removeVoucher'])->name('checkout.remove-voucher');
Route::post('/checkout/apply-voucher', [CheckoutController::class, 'applyVoucher'])->name('checkout.apply-voucher');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.show');
Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success', fn() => view('user.pages.checkout-success'))->name('checkout.success');
