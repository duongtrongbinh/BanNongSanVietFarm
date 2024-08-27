<?php

use App\Enums\NotificationSystem;
use App\Events\SystemNotificationEvent;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DashboardOrderController;
use App\Http\Controllers\Client\AuthClientController;
use App\Http\Controllers\Client\OrderController as OrderClientController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Client\ShopController;
use App\Http\Services\GHNService;
use App\Jobs\SendOrderConfirmation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\GoogleLoginController;
use App\Http\Controllers\client\FaceBookLoginController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\OrderController;
use \App\Http\Controllers\Admin\FlashSaleController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\PurchaseReceiptController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Admin\ProfileUserController;
use App\Http\Controllers\Client\ProfileUserController as ProfileUserClientController;
use App\Http\Controllers\Client\PostController as PostClientController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Client\ForgotPasswordController;
use App\Http\Controllers\Client\CommentClientController;
use App\Http\Controllers\client\ContactController;
use App\Http\Controllers\client\PolicyController;

use \App\Http\Controllers\Admin\PermissionController;
use \App\Http\Controllers\Admin\RoleController;
use \App\Enums\Roles;

use \App\Http\Controllers\Admin\SystemNotificationController;

use App\Notifications\SystemNotification;
use \Illuminate\Support\Facades\Notification;
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
/* Route Login Admin */
Route::group(['prefix' => 'admin'], function () {
    Route::get('login', [AuthController::class, 'index'])->name('admin.login.form');
    Route::post('login', [AuthController::class, 'store'])->name('admin.login');
});

/* Route Admin */
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    /* Route Dashboard */
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/orders', [DashboardOrderController::class, 'orders'])->name('dashboardorder.orders');
    // Quản hệ thống
    Route::group(['middleware' => ['role:' . Roles::SYSTEM_ADMINISTRATOR->name]], function () {
        /* Route User */
        Route::get('/users', [UserController::class, 'index'])->name('user.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/users', [UserController::class, 'store'])->name('user.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    /* Route Logout */
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

    /* Profile */
    Route::put('/profile/update', [ProfileUserController::class, 'update'])->name('admin.profile.update');
    Route::get('/profile', [ProfileUserController::class, 'profile'])->name('admin.profile');
    Route::get('/showChangePasswordForm', [ProfileUserController::class, 'showChangePasswordForm'])->name('admin.showChangePasswordForm');
    Route::post('/admin/change-password', [ProfileUserController::class, 'changePassword'])->name('admin.profile.change_password');

    // Quản lý sản phâm
    Route::group(['middleware' => ['role:' . Roles::SYSTEM_ADMINISTRATOR->name], ['role:' . Roles::PRODUCT_MANAGE->name]], function () {
        /* Route Brand */
        Route::resource('brands', BrandController::class);
        Route::delete('brands/{id}', [BrandController::class, 'delete'])
            ->name('brands.delete');

        /* Route Category */
        Route::resource('categories', CategoryController::class);

        /* Route Product */
        Route::get('products/data', [ProductController::class, 'getData'])->name('products.data');
        Route::get('/get-products-by-category', [ProductController::class, 'getProductsByCategory'])->name('products.category');
        Route::resource('products', ProductController::class);
        Route::get('/get-product', [ProductController::class, 'getProduct'])->name('getProduct');
        Route::post('export', [ProductController::class, 'export'])
            ->name('products.export');
        Route::post('import', [ProductController::class, 'import'])
            ->name('products.import');

        /* Route Product Group */
        Route::resource('groups', GroupController::class);
        Route::get('/get-product-group', [GroupController::class, 'getProduct'])->name('getProductGroup');
        Route::delete('groups/{id}', [GroupController::class, 'delete'])
            ->name('groups.delete');

        /* Route Tag */
        Route::resource('tags', TagController::class);

        /* Route Voucher */
        Route::resource('vouchers', VoucherController::class);
        Route::get('adeleted/vouchers', [VoucherController::class, 'deleted'])
            ->name('vouchers.deleted');
        Route::post('restore/vouchers/{id}', [VoucherController::class, 'restore'])
            ->name('restore.vouchers');

        /* Route Flash Sale */
        Route::resource('flash-sales', FlashSaleController::class);
    });

    // Quản lý kho
    Route::group(['middleware' => ['role:' . Roles::SYSTEM_ADMINISTRATOR->name], ['role:' . Roles::WAREHOUSE_STAFF->name]], function () {
        /* Route Supplier */
        Route::resource('supplier', SupplierController::class);

        /* Route Purchase Receipt */
        Route::resource('purchase_receipt', PurchaseReceiptController::class);
        Route::post('purchases/import', [PurchaseReceiptController::class, 'import'])
            ->name('purchases.import');
    });

    // Quản lý marketing
    Route::group(['middleware' => ['role:' . Roles::SYSTEM_ADMINISTRATOR->name], ['role:' . Roles::MARKETING->name]], function () {
        /* Route Banner */
        Route::resource('banners', BannerController::class);

        /* Route Post */
        Route::resource('post', PostController::class);
        Route::put('post/{postId}/comment/{commentId}/mark-as-spam', [PostController::class, 'markCommentAsSpam'])
            ->name('post.comment.markAsSpam');
        Route::put('post/{postId}/comment/{commentId}/unmark-as-spam', [PostController::class, 'unmarkCommentAsSpam'])
            ->name('post.comment.unmarkAsSpam');

        /* Route Comment */
        Route::resource('comment', CommentController::class);
        Route::delete('products/{productId}/comments/{commentId}', [CommentController::class, 'destroy'])
            ->name('product.comment.destroy');

        /* Route Rate */
        Route::resource('rate', CommentController::class); // Demo - Nguyễn Tiến Hiếu
    });


    // quản lý đơn hàng
    Route::group(['middleware' => ['role:' . Roles::SYSTEM_ADMINISTRATOR->name], ['role:' . Roles::ORDER_MANAGE->name]], function () {
        /* Route Order */
        Route::get('orders/all', [OrderController::class, 'getAll'])
            ->name('orders.all');
        Route::get('orders/pending', [OrderController::class, 'getPending'])
            ->name('orders.pending');
        Route::get('orders/processing', [OrderController::class, 'getProcessing'])
            ->name('orders.processing');
        Route::get('orders/shipping', [OrderController::class, 'getShipping'])
            ->name('orders.shipping');
        Route::get('orders/shipped', [OrderController::class, 'getShipped'])
            ->name('orders.shipped');
        Route::get('orders/delivered', [OrderController::class, 'getDelivered'])
            ->name('orders.delivered');
        Route::get('orders/completed', [OrderController::class, 'getCompleted'])
            ->name('orders.completed');
        Route::get('orders/cancelled', [OrderController::class, 'getCancelled'])
            ->name('orders.cancelled');
        Route::get('orders/returned', [OrderController::class, 'getReturned'])
            ->name('orders.returned');
        Route::post('/orders/update-status', [OrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');
        Route::get('orders/{order}/edit/{return?}', [OrderController::class, 'edit'])
            ->name('orders.edit');
        Route::put('orders/{order}/update/{return?}', [OrderController::class, 'update'])
            ->name('orders.update');
        Route::resource('orders', OrderController::class)->except(['edit', 'update']);
        Route::post('orders/{order}/cancel', [OrderController::class, 'cancel'])
            ->name('orders.cancel');
        Route::get('/bill/return', [GHNService::class, 'pay_return'])
            ->name('bill.return');
    });

    Route::group(['middleware' => ['role:' . Roles::SYSTEM_ADMINISTRATOR->name], ['role:' . Roles::ORDER_MANAGE->name]], function () {

        /* Route Post */
        Route::resource('post', PostController::class);
        Route::put('post/{postId}/comment/{commentId}/mark-as-spam', [PostController::class, 'markCommentAsSpam'])
            ->name('post.comment.markAsSpam');
        Route::put('post/{postId}/comment/{commentId}/unmark-as-spam', [PostController::class, 'unmarkCommentAsSpam'])
            ->name('post.comment.unmarkAsSpam');

        /* Route Comment */
        Route::resource('comment', CommentController::class);
        Route::delete('products/{productId}/comments/{commentId}', [CommentController::class, 'destroy'])
            ->name('product.comment.destroy');

        /* Route Rate */
        Route::resource('rate', CommentController::class); // Demo - Nguyễn Tiến Hiếu
    });


    //  Route::post('/orders/{order}/retry', 'OrderController@retryOrder')->name('orders.retry');

    /* Route nhân viên */
    Route::group(['middleware' => ['role:' . Roles::SYSTEM_ADMINISTRATOR->name]], function () {

        Route::get('permission', [PermissionController::class, 'index'])->name('permission.index');

        Route::get('permission/create/{role}', [PermissionController::class, 'create'])->name('permission.create');

        Route::post('permission/store/{role}', [PermissionController::class, 'store'])->name('permission.store');

        Route::post('roles/store/{user}', [RoleController::class, 'store'])->name('roles.store');

        Route::get('roles/create/{user}', [RoleController::class, 'create'])->name('roles.create');
    });

});


/* Route Client */
Route::group(['prefix' => ''], function () {
    /* Route Home */
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'home')->name('home');
        Route::get('/san-pham/{slug}', 'product')->name('product');
        Route::get('/danh-muc/{slug}', 'category')->name('category');
    });

    /* Route Rating */
    Route::post('/rating', [CommentClientController::class, 'rating'])->name('rating');

    /* Route Shop */
    Route::controller(ShopController::class)->group(function () {
        Route::get('/cua-hang', 'shop')->name('shop');
        Route::get('/thuong-hieu/{slug}', 'brand')->name('brand');
    });

    /* Route Post */
    Route::resource('bai-viet', PostClientController::class)->names('postclient');
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
    Route::get('/don-hang', [OrderClientController::class, 'index'])->name('order.index');
    Route::get('/fetch-orders', [OrderClientController::class, 'fetchOrders'])->name('fetch.orders');
    Route::get('/chi-tiet-don-hang/{order}',[OrderClientController::class,'detail'])->name('order.detail');
    Route::get('/check-out',[OrderClientController::class,'orderCheckOut'])->name('checkout');
    Route::post('/check-out',[GHNService::class,'store'])->name('checkout.store');
    Route::get('/check-out/success/{order}',[OrderClientController::class,'success'])->name('checkout.success');
    Route::post('orders/{order}/cancel', [OrderClientController::class, 'cancel'])
        ->name('ordersClient.cancel');
    Route::get('tra-cuu-don-hang', [OrderClientController::class, 'checking'])
        ->name('orders.checking');

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
    Route::controller(FaceBookLoginController::class)->group(function () {
        Route::get('/auth/facebook', 'redirectToFacebook')->name('auth.facebook');
        Route::get('/auth/facebook/callback', 'handleFacebookCallback');
    });
    Route::controller(ContactController::class)->group(function () {
        Route::get('lien-he', 'index')->name('contact.index');
    });
    Route::controller(PolicyController::class)->group(function () {
        Route::get('chinh-sach', 'index')->name('policy.index');
    });
});

    /* Route 404 */
    Route::get('404NotFound', function () {
        return view('client.layouts.404');
    })->name('404.client');

    /* Route 404 admin */
    Route::get('admin/404NotFound', function () {
    return view('admin.404');
    })->name('404.admin');


Route::get('/notify', function () {

    $order = \App\Models\Order::where('email','vcduy.intern@gmail.com')->first();

    dispatch(new SendOrderConfirmation($order,session('cart'),session('service_fee')));

//

//
//    Notification::send(Roles::admins(),new SystemNotification($order));
//
//    broadcast(new SystemNotificationEvent(NotificationSystem::adminNotificationNew()));
//
//    dd('done');

});
