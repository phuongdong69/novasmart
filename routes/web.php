<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\OriginController;
use App\Http\Controllers\Admin\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {

    // Trang dashboard
    Route::get('/', [DashBoardController::class, 'index'])->name('dashboard');

   
    
    
    // ORIGINS
    
    Route::resource('origins', OriginController::class)->names([
        'index'   => 'origins.index',
        'create'  => 'origins.create',
        'store'   => 'origins.store',
        'edit'    => 'origins.edit',
        'update'  => 'origins.update',
        'destroy' => 'origins.destroy',
    ]);
});
