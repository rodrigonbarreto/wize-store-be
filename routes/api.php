<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Supplier\AuthController;
use App\Http\Controllers\Supplier\RegisterController;
use App\Http\Controllers\Supplier\SupplierOrderController;
use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\RegisterController as UserRegisterController;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
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

    // Public Supplier routes
    Route::post('/supplier/register', [RegisterController::class, 'store']);
    Route::post('/supplier/login', [AuthController::class, 'store']);

    //Public User routes
    Route::post('/user/register', [UserRegisterController::class, 'store']);
    Route::post('/user/login', [UserAuthController::class, 'store']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/products', [ProductController::class, 'store'])->name('products.store')->can('store', Product::class);
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update')->can('update', 'product');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->can('delete', 'product');

        Route::get('/supplier/orders/users', [SupplierOrderController::class, 'index'])->can('viewBuyers', User::class);
        // Order routes
        Route::get('/user/orders', [OrderController::class, 'index'])->name('user.orders')->can('viewAny', Order::class);
        Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout')->can('viewAny', Order::class);

    });
});
