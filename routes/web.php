<?php
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Client\AuthController as AuthClientController;
use App\Http\Controllers\Client\OrderController as OrderClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\GoogleLoginController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\OrderController;
use \App\Http\Controllers\Admin\FlashSaleController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseReceiptController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ShopController;

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

/* Route Admin */
Route::group(['prefix' => 'admin'], function () {
    /* Route Dashboard */
    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /* Route User */
    Route::resource('user', UserController::class);

    /* Route Brand */
    Route::resource('brands', BrandController::class);
    Route::delete('brands/{id}', [BrandController::class, 'delete'])
        ->name('brands.delete');

    /* Route Category */
    Route::resource('categories', CategoryController::class);
    
    /* Route Product */ 
    Route::resource('products', ProductController::class);
    Route::delete('products/{id}', [ProductController::class, 'delete'])
        ->name('products.delete');

    /* Route Tag */ 
    Route::resource('tags', TagController::class);

    /* Route Supplier */ 
    Route::resource('supplier', SupplierController::class);

    /* Route Purchase Receipt */ 
    Route::resource('purchase_receipt', PurchaseReceiptController::class);

    /* Route Voucher */ 
    Route::resource('vouchers',VoucherController::class);
    Route::get('adeleted/vouchers',[VoucherController::class,'deleted'])
        ->name('vouchers.deleted');
    Route::post('restore/vouchers/{id}',[VoucherController::class,'restore'])
        ->name('restore.vouchers');

    /* Route Flash Sale */ 
    Route::resource('flash-sales',FlashSaleController::class);

    /* Route Order */ 
    Route::resource('orders',OrderController::class);

    /* Route Post */ 
    Route::resource('post', PostController::class);

    /* Route Comment */ 
    Route::resource('comment', CommentController::class);
    Route::delete('products/{productId}/comments/{commentId}', [CommentController::class, 'destroy'])
        ->name('product.comment.destroy');

     /* Route Rate */ 
     Route::resource('rate', CommentController::class); // Demo - Nguyễn Tiến Hiếu
});

/* Route Client */
/* Route Home */
Route::group(['prefix' => ''], function (){
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'home')->name('home');
        Route::get('/product/{id}', 'product')->name('product');
        Route::get('/category/{id}', 'category')->name('category');
        Route::get('/post', 'post')->name('post');
        Route::post('/post', 'store')->name('post.store');
    });

    /* Route Rating */
    Route::post('/rating', [CommentController::class, 'rating'])->name('rating');

    /* Route Shop */
    Route::controller(ShopController::class)->group(function () {
        Route::get('/shop', 'shop')->name('shop');
    });

    /* Route Cart */
    Route::controller(CartController::class)->group(function () {
        Route::get('/cart', 'index')->name('cart.index');
        Route::post('/add', 'addToCart')->name('cart.add');
        Route::get('/get-cart', 'getCart')->name('cart.getCart');
        Route::delete('/remove', 'removeCart')->name('cart.remove');
        Route::post('/update', 'updateCart')->name('cart.update');
    });

    /* Route Order */
    Route::get('/check-out',[OrderClientController::class, 'create'])->name('checkout');

    /* Route Auth */
    Route::controller(AuthClientController::class)->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register.form');
        Route::post('register', 'register')->name('register');
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'login');   
        Route::post('logout', 'logout')->name('logout');
    }); 

    /* Route Auth Google */
    Route::controller(GoogleLoginController::class)->group(function () {
        Route::get('/auth/google', 'redirectToGoogle')->name('auth.google');
        Route::get('/auth/google/callback', 'handleGoogleCallback');
    }); 
});