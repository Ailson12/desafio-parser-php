<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\StatusController;
use App\Http\Middleware\ApiKeyMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(ApiKeyMiddleware::class)->group(function () {
    Route::get('/', [StatusController::class, 'index']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{code}', [ProductController::class, 'show']);
    Route::delete('products/{code}', [ProductController::class, 'destroy']);
    Route::put('/products/{code}', [ProductController::class, 'update']);
});
