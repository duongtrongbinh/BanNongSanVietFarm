<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ShopController;
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

Route::get('/', [HomeController::class, 'home']);
Route::get('/product/{id}', [HomeController::class, 'product'])->name('product');
Route::get('/category/{id}', [HomeController::class, 'category'])->name('category');

Route::get('/shop', [ShopController::class, 'shop'])->name('shop');

Route::get('/cart', function () {
    return view('client.cart');
})->name('cart');

Route::get('/check-out',[OrderController::class,'create'])->name('checkOut');

Route::post('/check-out',[OrderController::class,'store']);


Route::get('media', function () {
    return view('admin.media.media');
})->name('media');


Route::view('admin/dashboard', 'admin.dashboard')->name('dashboard');
Route::get('login', [AuthController::class, 'index'])->name('form-login');
Route::post('login', [AuthController::class,'store'])->name('login');


Route::view('dashboard', 'admin.dashboard')->name('dashboard');

Route::get('login', [AuthController::class, 'index'])->name('form-login');

Route::post('login', [AuthController::class, 'store'])->name('login');

Route::get('tinycme', function () {
    return view('admin.post.blog');
})->name('blog');

Route::get('xoa', function () {
    return view('admin.post.add');
});

Route::get('post/1', [PostController::class,'destroy'])->name('post.destroy');