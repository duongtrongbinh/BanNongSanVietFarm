<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
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

Route::get('/', [HomeController::class, 'home']);
Route::get('/product/{id}', [HomeController::class, 'product'])->name('product');
Route::get('/category/{id}', [HomeController::class, 'category'])->name('category');

Route::get('/shop', [ShopController::class, 'shop'])->name('shop');

Route::get('/cart', function () {
    return view('client.cart');
})->name('cart');

Route::get('/check-out', function () {
    return view('client.check-out');
})->name('checkOut');

Route::get('media', function () {
    return view('admin.media.media');
})->name('media');

Route::view('admin/dashboard', 'admin.dashboard')->name('dashboard');
Route::get('login', [AuthController::class, 'index'])->name('form-login');
Route::post('login', [AuthController::class,'store'])->name('login');

Route::get('tinycme', function (){
    return view('admin.post.blog');
})->name('blog');

Route::get('xoa', function(){
    return view('admin.post.add');
});

Route::get('post/1', [PostController::class,'destroy'])->name('post.destroy');


Route::resource('admin/brands', BrandController::class);
Route::delete('admin/brands/{id}', [BrandController::class,'delete'])->name('brands.delete');

Route::resource('admin/categories', CategoryController::class);

Route::resource('admin/products', ProductController::class);
Route::delete('admin/products/{id}', [ProductController::class,'delete'])->name('products.delete');
Route::resource('admin/tags', TagController::class);
//
Route::resource('admin/post', \App\Http\Controllers\Admin\PostController::class);
Route::resource('admin/comment', \App\Http\Controllers\Admin\CommentController::class);
Route::delete('admin/products/{productId}/comments/{commentId}', [CommentController::class, 'destroy'])
    ->name('product.comment.destroy');
Route::resource('admin/user',\App\Http\Controllers\Admin\UserController::class);
