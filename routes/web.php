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
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\ProfileController;



/*
|--------------------------------------------------------------------------
| Trang chủ
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\User\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// User-facing product list
use App\Http\Controllers\User\ProductController as UserProductController;

Route::get('/products', [UserProductController::class, 'index'])->name('products.list');
Route::get('/products/{id}', [UserProductController::class, 'show'])->name('products.show');

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
    Route::resource('roles', RoleController::class)->names([
        'index' => 'roles.index',
        'create'  => 'roles.create',
        'store'   => 'roles.store',
        'edit'    => 'roles.edit',
        'update'  => 'roles.update',
    ]);

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
    Route::put('users/{id}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::post('users/{id}/update-role', [App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.updateRole');
    Route::get('status', function () {
        return view('admin.pages.status');
    })->name('status');
    Route::get('users/{user}/status-logs', [App\Http\Controllers\Admin\UserController::class, 'statusLogs'])->name('users.status_logs');
    Route::get('products/{product}/status-logs', [App\Http\Controllers\Admin\ProductController::class, 'statusLogs'])->name('products.status_logs');
    Route::get('orders/{order}/status-logs', [App\Http\Controllers\Admin\OrderController::class, 'statusLogs'])->name('orders.status_logs');
    // Cập nhật trạng thái user
    Route::post('users/{user}/update-status', [App\Http\Controllers\Admin\UserController::class, 'updateStatus'])->name('users.update_status');
    // Cập nhật trạng thái product
    Route::post('products/{product}/update-status', [App\Http\Controllers\Admin\ProductController::class, 'updateStatus'])->name('products.update_status');
    // Cập nhật trạng thái order
    Route::post('orders/{order}/update-status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update_status');
    Route::resource('statuses', App\Http\Controllers\Admin\StatusController::class);
    //brands
    Route::resource('brands', BrandController::class);
});

/*
|--------------------------------------------------------------------------
| Người dùng thường (đã đăng nhập)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/user/pages/home', [HomeController::class, 'index'])->name('user.pages.home');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
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
Route::post('/vnpay-checkout', [PaymentController::class, 'vnpayCheckout'])->name('payment.vnpay.checkout');
Route::get('/vnpay-return', [PaymentController::class, 'vnpayReturn'])->name('payment.vnpay.return');
