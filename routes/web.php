<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\OriginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\VariantAttributeValueController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//Admin
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');

    // Categories
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
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

    
    //Product Variants
    Route::get('products/{product}/product-variants/create', [ProductVariantController::class, 'create'])->name('product-variants.create');
    Route::post('product-variants', [ProductVariantController::class, 'store'])->name('product-variants.store');
    Route::resource('product-variants', ProductVariantController::class)->except(['create', 'store']);
    Route::resource('products', ProductController::class)->names([
        'index'   => 'product-variants.index',
       'edit'    => 'product-variants.edit',
        'update'  => 'product-variants.update',
        'destroy' => 'product-variants.destroy',
    ]);
   //Product
     Route::get('products/create', [ProductController::class, 'create'])->name('admin.products.create');
     Route::resource('products', ProductController::class)->names([
        'index'   => 'products.index',
        'create'  => 'products.create',   
        'store'   => 'products.store',
        'edit'    => 'products.edit',
        'update'  => 'products.update',
        'destroy' => 'products.destroy',
    ]);
     // Routes for attributes
    Route::resource('attributes', AttributeController::class)->names([
        'index'   => 'attributes.index',
        'create'  => 'attributes.create',
        'store'   => 'attributes.store',
        'edit'    => 'attributes.edit',
        'update'  => 'attributes.update',
        'destroy' => 'attributes.destroy',
    ]);
    // CRUD cho Attribute Values
    Route::resource('attribute-values', AttributeValueController::class)->names([
        'index'   => 'attribute-values.index',
        'create'  => 'attribute-values.create',
        'store'   => 'attribute-values.store',
        'edit'    => 'attribute-values.edit',
        'update'  => 'attribute-values.update',
        'destroy' => 'attribute-values.destroy',
    ]);

    // CRUD cho Variant Attribute Values
    Route::resource('variant-attribute-values', VariantAttributeValueController::class)->names([
        'index'   => 'variant-attribute-values.index',
        'create'  => 'variant-attribute-values.create',
        'store'   => 'variant-attribute-values.store',
        'edit'    => 'variant-attribute-values.edit',
        'update'  => 'variant-attribute-values.update',
        'destroy' => 'variant-attribute-values.destroy',
    ]);
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
Route::resource('vouchers', VoucherController::class);