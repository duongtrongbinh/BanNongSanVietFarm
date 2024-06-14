<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Client\OrderController;
use \App\Http\Controllers\Admin\FlashSaleController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('client.home');
});
Route::get('/shop', function () {
    return view('client.shop');
})->name('shop');

Route::get('/product', function () {
    return view('client.product');
})->name('product');

Route::get('/cart', function () {
    return view('client.cart');
})->name('cart');

Route::get('/check-out',[OrderController::class,'create'])->name('checkOut');

Route::post('/check-out',[OrderController::class,'store']);


Route::get('media', function () {
    return view('admin.media.media');
})->name('media');

Route::view('dashboard', 'admin.dashboard')->name('dashboard');

Route::get('login', [AuthController::class, 'index'])->name('form-login');

Route::post('login', [AuthController::class, 'store'])->name('login');

Route::get('tinycme', function () {
    return view('admin.post.blog');
})->name('blog');

Route::get('xoa', function () {
    return view('admin.post.add');
});


Route::get('post/1', [PostController::class, 'destroy'])->name('post.destroy');

Route::resource('vouchers',VoucherController::class);
Route::get('deleted/vouchers',[VoucherController::class,'deleted']);
Route::post('restore/vouchers/{id}',[VoucherController::class,'restore'])->name('restore.vouchers');


Route::resource('flash-sales',FlashSaleController::class);
Route::get('orders', [App\Http\Controllers\Admin\OrderController::class,'index'])->name('orders');
Route::get('order/{id}/detail', [App\Http\Controllers\Admin\OrderController::class,'orderDetail'])->name('orderDetail');
