<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MeasurementUnitController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UserController::class)->except(['create', 'edit', 'show']);

    Route::resource('branches', BranchController::class)->except(['create', 'edit', 'show']);

    Route::resource('suppliers', SupplierController::class)->except(['create', 'edit', 'show']);

    Route::resource('measurementunits', MeasurementUnitController::class)->except(['create', 'edit', 'show']);

    Route::resource('inventory', InventoryController::class)->except(['show']);

    Route::resource('supplies', SupplyController::class)->except(['edit', 'create']);

    Route::resource('products', ProductController::class)->except(['edit', 'create']);
});

require __DIR__.'/auth.php';
