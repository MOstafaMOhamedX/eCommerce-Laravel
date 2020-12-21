<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\LandingPageController;
use App\http\Controllers\ShopController;
use App\http\Controllers\CartController;
use App\http\Controllers\SaveForLaterController;
use App\http\Controllers\CheckOutController;
use App\http\Controllers\ConfirmationController;
use App\http\Controllers\CouponController;
use App\http\Controllers\CommentController;
use App\http\Controllers\UsersController;
use App\http\Controllers\OrdersController;
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


Auth::routes();
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product}', [ShopController::class, 'show'])->name('shop.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('/cart/switchToSaveForLater/{rowId}', [CartController::class, 'switchToSaveForLater'])->name('cart.switchToSaveForLater');


Route::get('/Search', [ShopController::class, 'search'])->name('search');

Route::delete('/SaveForLater/destroy/{product}', [SaveForLaterController::class, 'destroy'])->name('SaveForLater.destroy');
Route::post('/SaveForLater/switchToSaveForLater/{rowId}', [SaveForLaterController::class, 'switchToCart'])->name('SaveForLater.switchToCart');
Route::get('clear', function ( ){ Cart::destroy(); return redirect('/'); });

Route::post('/coupon', [CouponController::class, 'store'])->name('coupon.store');
Route::delete('/coupon', [CouponController::class, 'destroy'])->name('coupon.destroy');



Route::get('/checkout', [CheckOutController::class, 'index'])->name('checkout.index')->middleware('checkout');
Route::post('/checkout', [CheckOutController::class, 'store'])->name('checkout.store')->middleware('checkout');

Route::get('/thankyou', [ConfirmationController::class, 'index'])->name('Confirmation.index');

Route::middleware('auth')->group(function () {
    Route::get('/my-profile', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/my-profile', [UsersController::class, 'update'])->name('users.update');

    Route::get('/my-orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
    
    Route::post('/Comment', [CommentController::class, 'store'])->name('comment.store');
});