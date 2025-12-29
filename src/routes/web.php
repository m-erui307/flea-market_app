<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::middleware('auth')->group(function () {
    Route::get('/profile/settings', [ProfileController::class, 'edit']);
    Route::post('/profile/settings', [ProfileController::class, 'update']);
    Route::get('/product_list', [ProductController::class, 'index']);
});

Route::get('/products/{id}', [ProductController::class, 'show'])
    ->name('products.show');

Route::post('/products/{product}/like', [LikeController::class, 'store'])
    ->name('products.like')
    ->middleware('auth');

Route::delete('/products/{product}/like', [LikeController::class, 'destroy'])
    ->name('products.unlike')
    ->middleware('auth');

Route::post('/products/{product}/comments', [CommentController::class, 'store']
)->name('comments.store')->middleware('auth');

Route::get('/purchase/{product}', [PurchaseController::class, 'show'])
    ->name('purchase');