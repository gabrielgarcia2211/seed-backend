<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Product\ProductController;


Route::post('user/register', [UserController::class, 'register'])->name('user.register');
Route::post('user/login',[UserController::class,'login'])->name('user.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class);
    Route::post('user/logout',[UserController::class,'logout'])->name('user.logout');
});
