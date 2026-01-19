<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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



Route::get('/product_list', [ProductController::class, 'index'])->name('product.list');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
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
    ->middleware('auth')
    ->name('purchase');

Route::get('/address/change', function () {
    return view('address_change');
})->name('address.change');



Route::get('/purchase/{product}/address', [PurchaseController::class, 'editAddress'])
    ->middleware('auth')
    ->name('purchase.address.edit');

Route::post('/purchase/{product}/address', [PurchaseController::class, 'updateAddress'])
    ->middleware('auth')
    ->name('purchase.address.update');

Route::get('/exhibition', [ProductController::class, 'create'])
    ->name('exhibition');

Route::post('/products', [ProductController::class, 'store'])
    ->middleware('auth')
    ->name('products.store');

Route::post('/products/{product}/purchase', [ProductController::class, 'purchase'])
    ->middleware('auth')
    ->name('products.purchase');

Route::post('/products/{product}/checkout', [ProductController::class, 'checkout'])
    ->name('products.checkout');

Route::get('/products/{product}/success', [ProductController::class, 'success'])
    ->name('products.success');


Route::middleware('auth')->group(function () {

    // メール認証通知送信（再送用）
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', '認証メールを再送しました。');
    })->name('verification.send');

    // メール認証リンク
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('profile.edit'); // 認証後にプロフィール作成へ
    })->middleware(['signed', 'throttle:6,1'])
      ->name('verification.verify');

    // 認証前のメール認証画面
    Route::get('/email/verify', function () {
        return view('auth.email_verification');
    })->name('verification.notice');
});