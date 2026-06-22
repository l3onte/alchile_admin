<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductsCategoriesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // RUTAS PRODUCTOS
    Route::resource('product', ProductController::class);
    Route::get('products-data', [ProductController::class, 'getData'])->name('products.data');

    // RUTAS CATEGORIAS
    Route::resource('products_categories', ProductsCategoriesController::class);
    Route::get('products_categories-data', [ProductsCategoriesController::class, 'getData'])->name('products_categories.data');
});

require __DIR__.'/auth.php';
