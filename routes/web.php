<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;
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

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'home');
    Route::get('/product/{id}', 'product')->name('product');
    Route::get('/category/{id}', 'category')->name('category');
});

Route::controller(ShopController::class)->group(function () {
    Route::get('/shop', 'shop')->name('shop');
});

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
Route::get('login', [AuthController::class, 'index'])->name('form-login');
Route::post('login', [AuthController::class, 'store'])->name('login');

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
