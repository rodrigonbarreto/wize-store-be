<?php

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('v1')->group(function () {

    // Public routes
    Route::apiResource('products', ProductController::class)->only(['index', 'show']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/products', [ProductController::class, 'store'])->name('products.store')->can('store', Product::class);
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update')->can('update', 'product');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->can('delete', 'product');

    });
});
