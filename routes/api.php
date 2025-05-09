<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/product/{code}', [ProductController::class, 'show']);
Route::delete('product/{code}', [ProductController::class, 'destroy']);
Route::put('/product/{code}', [ProductController::class, 'update']);
