<?php
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Client\AuthClientController;
use App\Http\Controllers\Client\OrderController as OrderClientController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Client\ShopController;
use App\Http\Services\GHNService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\GoogleLoginController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\OrderController;
use \App\Http\Controllers\Admin\FlashSaleController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\PurchaseReceiptController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Admin\ProfileUserController;

use App\Http\Controllers\Admin\RelatedController;
use App\Http\Controllers\Client\ProfileUserController as ProfileUserClientController;
use App\Http\Controllers\Client\PostController as PostClientController;

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\client\ForgotPasswordController;
use App\Http\Controllers\client\CommentClientController;


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
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/users', [UserController::class, 'store'])->name('user.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    /* Route Login Admin */

    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('login', [AuthController::class, 'store'])->name('admin.login');

    /* Profile */
    Route::put('/profile/update', [ProfileUserController::class, 'update'])->name('admin.profile.update');
    Route::get('/profile', [ProfileUserController::class, 'profile'])->name('admin.profile');
    Route::get('/showChangePasswordForm', [ProfileUserController::class, 'showChangePasswordForm'])->name('admin.showChangePasswordForm');
    Route::post('/admin/change-password', [ProfileUserController::class, 'changePassword'])->name('admin.profile.change_password');

    /* Route Brand */
    Route::resource('brands', BrandController::class);
    Route::delete('brands/{id}', [BrandController::class, 'delete'])
        ->name('brands.delete');

    /* Route Category */
    Route::resource('categories', CategoryController::class);
    Route::delete('categories/{id}', [CategoryController::class, 'delete'])
        ->name('categories.delete');
    /* Route Banner */
    Route::resource('banners', BannerController::class);
    /* Route Product */
    Route::get('products/data', [ProductController::class, 'getData'])->name('products.data');
    Route::resource('products', ProductController::class);
    Route::delete('products/{id}', [ProductController::class, 'delete'])
        ->name('products.delete');
    Route::get('export', [ProductController::class, 'export'])
        ->name('products.export');
    Route::post('import', [ProductController::class, 'import'])
        ->name('products.import');

    /* Route Product Group */
    Route::resource('groups', GroupController::class);
    Route::get('/get-product', [GroupController::class, 'getProduct'])->name('getProduct');
    Route::delete('groups/{id}', [GroupController::class, 'delete'])
        ->name('groups.delete');
    
    /* Route Product Related */
    Route::resource('products/{$product}/related', RelatedController::class);
    Route::get('/get-product', [RelatedController::class, 'getProduct'])->name('getProduct');
    Route::delete('groups/{id}', [RelatedController::class, 'delete'])
        ->name('groups.delete');
    
    /* Route Tag */
    Route::resource('tags', TagController::class);
    Route::delete('tags/{id}', [TagController::class, 'delete'])
        ->name('tags.delete');

    /* Route Supplier */
    Route::resource('supplier', SupplierController::class);

    /* Route Purchase Receipt */
    Route::resource('purchase_receipt', PurchaseReceiptController::class);
    Route::post('purchases/import', [PurchaseReceiptController::class, 'import'])
        ->name('purchases.import');

    /* Route Voucher */
    Route::resource('vouchers',VoucherController::class);
    Route::get('adeleted/vouchers',[VoucherController::class,'deleted'])
        ->name('vouchers.deleted');
    Route::post('restore/vouchers/{id}',[VoucherController::class,'restore'])
        ->name('restore.vouchers');

    /* Route Flash Sale */
    Route::resource('flash-sales',FlashSaleController::class);

    /* Route Order */
    Route::get('orders/all', [OrderController::class, 'getAll'])
        ->name('orders.all');
    Route::get('orders/pending', [OrderController::class, 'getPending'])
        ->name('orders.pending');
    Route::get('orders/prepare', [OrderController::class, 'getPrepare'])
        ->name('orders.prepare');
    Route::get('orders/pending-payment', [OrderController::class, 'getPendingPayment'])
        ->name('orders.pendingPayment');
    Route::get('orders/success-payment', [OrderController::class, 'getSuccessPayment'])
        ->name('orders.successPayment');
    Route::get('orders/ready-to-pick', [OrderController::class, 'getReadyToPick'])
        ->name('orders.readyToPick');
    Route::get('orders/cancelled', [OrderController::class, 'getCancelled'])
        ->name('orders.cancelled');
    Route::post('/orders/update-status', [OrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');
    Route::resource('orders',OrderController::class);
    Route::post('orders/{order}/cancel', [OrderController::class, 'cancel'])
        ->name('orders.cancel');
    Route::delete('orders/{id}', [OrderController::class, 'delete'])
        ->name('orders.delete');
    Route::get('/bill/return', [GHNService::class,'pay_return'])
        ->name('bill.return');

    /* Route Post */
    Route::resource('post', PostController::class);
    Route::delete('post/{postId}/comment/{commentId}', [PostController::class, 'destroyComment'])->name('post.comment.destroy');

    /* Route Comment */
    Route::resource('comment', CommentController::class);
    Route::delete('products/{productId}/comments/{commentId}', [CommentController::class, 'destroy'])
        ->name('product.comment.destroy');

    /* Route Rate */
    Route::resource('rate', CommentController::class); // Demo - Nguyễn Tiến Hiếu

    //  Route::post('/orders/{order}/retry', 'OrderController@retryOrder')->name('orders.retry');
});

/* Route Client */
/* Route Home */
Route::group(['prefix' => ''], function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'home')->name('home');

        Route::get('/product/{slug}', 'product')->name('product');
        Route::get('/category/{slug}', 'category')->name('category');
        Route::get('/post', 'post')->name('post');
        Route::post('/post', 'store')->name('post.store');
    });
    /* Route Rating */
    Route::post('/rating', [CommentClientController::class, 'rating'])->name('rating');
    /* Route Shop */
    Route::controller(ShopController::class)->group(function () {
        Route::get('/shop', 'shop')->name('shop');
    });
    /* Route Post */
    Route::resource('postclient', PostClientController::class);
    Route::post('/ratingpost', [PostClientController::class, 'ratingpost'])->name('ratingpost');
    
    /* Route Cart */
    Route::controller(CartController::class)->group(function () {
        Route::get('/cart', 'index')->name('cart.index');
        Route::post('/add', 'addToCart')->name('cart.add');
        Route::get('/get-cart', 'getCart')->name('cart.getCart');
        Route::delete('/remove', 'removeCart')->name('cart.remove');
        Route::post('/update', 'updateCart')->name('cart.update');
    });
    /* Profile */
    Route::put('/profile/update', [ProfileUserClientController::class, 'update'])->name('user.profile.update');
    Route::get('/profile', [ProfileUserClientController::class, 'profile'])->name('user.profile');
    Route::get('/showChangePasswordForm', [ProfileUserClientController::class, 'showChangePasswordForm'])->name('user.showChangePasswordForm');
    Route::post('/user/change-password', [ProfileUserClientController::class, 'changePassword'])->name('user.profile.change_password');

    /* Route Order */
    Route::get('/order',[OrderClientController::class,'index'])->name('order.index');
    Route::get('/check-out',[OrderClientController::class,'create'])->name('checkout');
    Route::post('/check-out',[GHNService::class,'store'])->name('checkout.store');

    /* Route Auth */
    Route::controller(AuthClientController::class)->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
      
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('register', 'register');
        Route::post('login', 'login')->name('clientlogin');
      
        Route::post('logout', 'logout')->name('logout');
        Route::get('actived/{user}/{token}', 'activated')->name('user.activated');
    });

    /*  Route ForgotPasswordController*/
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
        Route::get('reset-password/{user}/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('reset-password/{user}/{token}', [ForgotPasswordController::class, 'reset']);
    });
    /* Route Auth Google */
    Route::controller(GoogleLoginController::class)->group(function () {
        Route::get('/auth/google', 'redirectToGoogle')->name('auth.google');
        Route::get('/auth/google/callback', 'handleGoogleCallback');
    });
});

    /* Route 404 */
    Route::get('404', function () {
        return view('client.layouts.404');
    })->name('404');

