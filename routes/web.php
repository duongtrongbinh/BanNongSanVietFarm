<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\client\AuthController as AuthClientController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\client\GoogleLoginController;

use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\OrderController;
use \App\Http\Controllers\Admin\FlashSaleController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseReceiptController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Models\Order;


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

Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index')->name('cart.index');
    Route::post('/add', 'addToCart')->name('cart.add');
    Route::get('/get-cart', 'getCart')->name('cart.getCart');
    Route::delete('/remove', 'removeCart')->name('cart.remove');
    Route::post('/update', 'updateCart')->name('cart.update');
    Route::get('/check-out','checkout')->name('checkout');
});


Route::post('/check-out',[OrderController::class,'store']);

Route::get('media', function () {
    return view('admin.media.media');
})->name('media');

Route::view('admin/dashboard', 'admin.dashboard')->name('dashboard');
Route::get('login', [AuthController::class, 'index'])->name('form-login');
Route::post('login', [AuthController::class,'store'])->name('login');

Route::get('tinycme', function () {
    return view('admin.post.blog');
})->name('blog');

Route::get('xoa', function () {
    return view('admin.post.add');
});

Route::get('post/1', [PostController::class,'destroy'])->name('post.destroy');

Route::view('admin/dashboard', 'admin.dashboard')->name('dashboard');

Route::resource('admin/brands', BrandController::class);
Route::delete('admin/brands/{id}', [BrandController::class,'delete'])->name('brands.delete');

Route::resource('admin/categories', CategoryController::class);

Route::resource('admin/products', ProductController::class);
Route::delete('admin/products/{id}', [ProductController::class,'delete'])->name('products.delete');

Route::resource('admin/tags', TagController::class);

Route::resource('admin/vouchers',VoucherController::class);
Route::get('admin/deleted/vouchers',[VoucherController::class,'deleted'])->name('vouchers.deleted');
Route::post('admin/restore/vouchers/{id}',[VoucherController::class,'restore'])->name('restore.vouchers');

Route::resource('admin/flash-sales',FlashSaleController::class);

Route::resource('admin/supplier', SupplierController::class);
Route::resource('admin/purchase_receipt', PurchaseReceiptController::class);

Route::resource('admin/order',OrderController::class);

//Route::get('post/1', [PostController::class,'destroy'])->name('post.destroy');

Route::resource('admin/post', \App\Http\Controllers\Admin\PostController::class);

Route::resource('admin/comment', \App\Http\Controllers\Admin\CommentController::class);

Route::delete('admin/products/{productId}/comments/{commentId}', [CommentController::class, 'destroy'])
    ->name('product.comment.destroy');
Route::resource('admin/user',\App\Http\Controllers\Admin\UserController::class);
Route::resource('supplier', SupplierController::class);
//client
Route::get('login', [AuthClientController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthClientController::class, 'login']);
Route::get('/auth/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);
Route::post('logout', [AuthClientController::class, 'logout'])->name('logout');
Route::get('register', [AuthClientController::class, 'showRegistrationForm'])->name('register.form');
Route::post('register', [AuthClientController::class, 'register'])->name('register');
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/post', [HomeController::class, 'post'])->name('post');
Route::post('/post', [HomeController::class, 'store'])->name('post.store');
Route::post('/rating', [CommentController::class, 'rating'])->name('rating');



