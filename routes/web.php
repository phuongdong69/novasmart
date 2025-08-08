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
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\SlideshowController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\User\OrderrController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\User\NewsController as UserNewsController;
use App\Http\Controllers\User\ReviewController;



/*
|--------------------------------------------------------------------------
| Trang chủ
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\User\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// About page
Route::get('/about', [AboutController::class, 'index'])->name('about');

// News routes
Route::get('/news', [UserNewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [UserNewsController::class, 'show'])->name('news.show');

// User-facing product list
use App\Http\Controllers\User\ProductController as UserProductController;

Route::get('/products', [UserProductController::class, 'index'])->name('products.list');
Route::get('/products/{id}', [UserProductController::class, 'show'])->name('products.show');

// Shop routes for menu dropdown
Route::get('/shop/menu-data', [ShopController::class, 'getMenuData'])->name('shop.menu-data');
Route::get('/shop/brand/{brand}', [ShopController::class, 'productsByBrand'])->name('shop.brand');
Route::get('/shop/category/{category}', [ShopController::class, 'productsByCategory'])->name('shop.category');
Route::get('/shop/products', [ShopController::class, 'allProducts'])->name('shop.products');

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
    Route::put('origins/{id}/toggle-status', [OriginController::class, 'toggleStatus'])->name('origins.toggleStatus');
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
    Route::resource('product-thumbnails', ProductThumbnailController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])->names([
        'index' => 'product_thumbnail.index',
        'create' => 'product_thumbnail.create',
        'store' => 'product_thumbnail.store',
        'edit' => 'product_thumbnail.edit',
        'update' => 'product_thumbnail.update',
        'destroy' => 'product_thumbnail.destroy',
    ]);

    // Vouchers

    Route::resource('vouchers', App\Http\Controllers\Admin\VoucherController::class);


    //productAdd commentMore actions
    Route::resource('products', ProductController::class);
    //attribute
    Route::get('attributes/{attribute}/values', [AttributeController::class, 'getValues'])->name('attributes.values');
    Route::post('attributes/{attribute}/values', [AttributeController::class, 'storeValue'])->name('attributes.values.store');
    Route::resource('attributes', AttributeController::class);
    //attribute_values
    Route::resource('attribute_values', AttributeValueController::class)->names([
        'index' => 'attribute_values.index',
        'create' => 'attribute_values.create',
        'store' => 'attribute_values.store',
        'edit' => 'attribute_values.edit',
        'update' => 'attribute_values.update',
        'destroy' => 'attribute_values.destroy',
    ]);
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
    Route::post('admin/orders/{order}/refund', [OrderController::class, 'refund'])->name('admin.orders.refund');

    //brands
    Route::resource('brands', BrandController::class);
    Route::resource('orders', OrderController::class);
    Route::put('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');

    // Thêm biến thể cho sản phẩm
    Route::post('products/{product}/variants', [ProductController::class, 'addVariant'])->name('products.addVariant');
    
    // Cập nhật biến thể sản phẩm
    Route::put('products/{product}/variants/{variant}', [ProductController::class, 'updateVariant'])->name('products.updateVariant');

    //slideshows
    Route::resource('slideshows', SlideshowController::class);
    
    // News
    Route::put('news/{id}/toggle-status', [NewsController::class, 'toggleStatus'])->name('news.toggleStatus');
    Route::resource('news', NewsController::class);
    // Reviews
    Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class)->only(['index']);
    Route::put('reviews/{id}/toggle-status', [\App\Http\Controllers\Admin\ReviewController::class, 'toggleStatus'])->name('reviews.toggleStatus');
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
    Route::get('/orders', [OrderrController::class, 'index'])->name('user.orders.index');
    Route::get('/orders/{order}', [OrderrController::class, 'show'])->name('user.orders.show');
    Route::post('/orders/{id}/cancel', [OrderrController::class, 'cancel'])->name('user.orders.cancel');
    Route::post('/orders/{id}/confirm-received', [OrderrController::class, 'confirmReceived'])->name('user.orders.confirm-received');

    // Wishlist routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/check', [WishlistController::class, 'check'])->name('wishlist.check');
    Route::get('/wishlist/count', [WishlistController::class, 'count'])->name('wishlist.count');

    // Đánh giá và bình luận
    Route::get('/history-reviews', [ReviewController::class, 'historyReviews'])->name('user.reviews');
    Route::get('/products/{product}', [ReviewController::class, 'show']);
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
    Route::post('/reviews/submit', [ReviewController::class, 'store'])->name('review.submit');
    Route::get('/api/product/{product}/rating-summary', [ReviewController::class, 'ratingSummary']);
    Route::delete('/reviews/{rating}', [ReviewController::class, 'destroy'])->name('user.reviews.destroy');

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
Route::post('/cart/selected', [CartController::class, 'checkoutSelected'])->name('cart.selected');
Route::post('/cart/remove-selected', [CartController::class, 'removeSelected'])->name('cart.removeselected');
Route::post('/cart/update-voucher', [CartController::class, 'updateVoucher']);
Route::delete('/cart/remove-voucher', [CartController::class, 'removeVoucher'])->name('cart.remove-voucher');
Route::post('/cart/remove-voucher', [CartController::class, 'removeVoucher'])->name('cart.remove-voucher');
Route::post('/cart/apply-voucher', [CartController::class, 'applyVoucher'])->name('cart.apply-voucher');
/*
|--------------------------------------------------------------------------
| Thanh toán
|--------------------------------------------------------------------------
*/
Route::post('/cart/checkout-selected', [CartController::class, 'checkoutSelected'])->name('cart.checkoutSelected');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.show');
Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success', fn() => view('user.pages.checkout-success'))->name('checkout.success');
Route::post('/vnpay-checkout', [PaymentController::class, 'vnpayCheckout'])->name('payment.vnpay.checkout');
Route::get('/vnpay-return', [PaymentController::class, 'vnpayReturn'])->name('payment.vnpay.return');
Route::get('/vnpay-redirect', function () {
    $data = session('vnpay_order_data');
    if (!$data) return redirect()->route('checkout.show')->with('error', 'Không tìm thấy dữ liệu thanh toán VNPay.');

    return view('user.checkout.vnpay_redirect', $data);
})->name('vnpay.redirect.view');
