<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{code}', [ProductController::class, 'show']);
Route::delete('products/{code}', [ProductController::class, 'destroy']);
Route::put('/products/{code}', [ProductController::class, 'update']);
