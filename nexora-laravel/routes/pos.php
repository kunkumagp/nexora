<?php
use Illuminate\Support\Facades\Route;
use App\Modules\POS\Presentation\Http\Controllers\PosController;

Route::prefix('pos')->middleware(['auth:sanctum'])->group(function () {
    Route::post('cart/add', [PosController::class, 'addToCart']);
    Route::post('cart/update', [PosController::class, 'updateCart']);
    Route::post('checkout', [PosController::class, 'checkout']);
    Route::post('refund', [PosController::class, 'refund']);
    Route::post('shift/open', [PosController::class, 'shiftOpen']);
    Route::post('shift/close', [PosController::class, 'shiftClose']);
});
