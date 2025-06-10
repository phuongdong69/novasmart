<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\CategoryController;

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


Route::prefix('admin')-> group(function (){
Route::get('/',[DashBoardController::class, 'index']) -> name('user.index');
Route::get('categories',[CategoryController::class, 'index']) -> name('user.index');
Route::put('admin/categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('admin.categories.toggleStatus');
    Route::resource('categories', CategoryController::class);
    Route::get('/create', [CategoryController::class, 'create'])->name('create'); 
    Route::post('/', [CategoryController::class, 'store'])->name('store');
     Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');

});