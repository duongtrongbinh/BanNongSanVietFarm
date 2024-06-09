<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/check-out', function () {
    return view('client.check-out');
})->name('checkOut');