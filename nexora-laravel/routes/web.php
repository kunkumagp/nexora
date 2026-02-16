<?php

use App\Http\Controllers\ProfileController;
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

    // Inventory UI pages (Inertia)
    Route::get('/products', function () {
        return Inertia::render('Inventory/Products/Index');
    })->name('products.index');

    Route::get('/products/create', function () {
        return Inertia::render('Inventory/Products/Create');
    })->name('products.create');

    // Inventory API endpoints (JSON) — use existing module controllers
    Route::prefix('api')->group(function () {
        Route::get('/products', [\App\Modules\Inventory\Presentation\Http\Controllers\ProductController::class, 'index']);
        Route::get('/products/{id}', [\App\Modules\Inventory\Presentation\Http\Controllers\ProductController::class, 'show']);
        Route::post('/products', [\App\Modules\Inventory\Presentation\Http\Controllers\ProductController::class, 'store']);
        Route::put('/products/{id}', [\App\Modules\Inventory\Presentation\Http\Controllers\ProductController::class, 'update']);
        Route::delete('/products/{id}', [\App\Modules\Inventory\Presentation\Http\Controllers\ProductController::class, 'destroy']);
    });
});

require __DIR__.'/auth.php';
