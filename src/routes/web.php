<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
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


Route::get('/register', function() {
    return view('auth.register');
})->name('register');

Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/product_list', [ProductController::class, 'index'])->name('product.list');
});

Route::get('/products/recommend', [ProductController::class, 'recommend'])
    ->middleware('auth')
    ->name('products.recommend');

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

Route::get('/address/change', function () {
    return view('address_change');
})->name('address.change');



Route::get('/purchase/{product}/address', [PurchaseController::class, 'editAddress'])
    ->name('purchase.address.edit');

Route::post('/purchase/{product}/address', [PurchaseController::class, 'updateAddress'])
    ->name('purchase.address.update');

Route::get('/exhibition', [ProductController::class, 'create'])
    ->name('exhibition');

Route::post('/products', [ProductController::class, 'store'])
    ->middleware('auth')
    ->name('products.store');

