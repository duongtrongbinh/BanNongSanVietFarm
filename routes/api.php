<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DashboardOrderController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// address order api
Route::middleware(['web'])->post('/shipping-fee', [App\Http\Services\GHNService::class, 'shippingFee'])->name('shipping.check');

Route::post('districts', [App\Http\Controllers\Api\ShippingAddressController::class, 'districts'])->name('districts.address.client');

Route::post('wards', [App\Http\Controllers\Api\ShippingAddressController::class, 'wards'])->name('wards.address.client');

Route::post('nongsanvietfam/delivery-status', [App\Http\Services\GHNService::class, 'delivery'])->name('delivery.order');


Route::post('voucher/apply', [App\Http\Controllers\Api\VoucherController::class, 'apply'])->name('voucher.apply');


// AddressController
Route::get('/provinces', [AddressController::class, 'getProvinces'])->name('provinces.address');
Route::get('/districts/{provinceId}', [AddressController::class, 'getDistricts'])->name('districts.address');
Route::get('/wards/{districtId}', [AddressController::class, 'getWards'])->name('wards.address');

// dashboard
Route::get('orders', [DashboardController::class, 'orders'])->name('dashboard.orders');
Route::get('/orders/total', [DashboardController::class, 'ordersTotal'])->name('dashboard.orders.total');
Route::get('users', [DashboardController::class, 'users'])->name('dashboard.users');
// dashboard order
Route::get('orders/pending', [DashboardOrderController::class, 'orders_pending'])->name('dashboard.orders.pending');
Route::get('orders/processing', [DashboardOrderController::class, 'orders_processing'])->name('dashboard.orders.processing');
Route::get('orders/shipping', [DashboardOrderController::class, 'orders_shipping'])->name('dashboard.orders.shipping');
Route::get('orders/delivery', [DashboardOrderController::class, 'orders_delivery'])->name('dashboard.orders.delivery');
Route::get('orders/received', [DashboardOrderController::class, 'orders_received'])->name('dashboard.orders.received');
Route::get('orders/completed', [DashboardOrderController::class, 'orders_completed'])->name('dashboard.orders.completed');
Route::get('orders/cancellation', [DashboardOrderController::class, 'orders_cancellation'])->name('dashboard.orders.cancellation');
Route::get('orders/Returns', [DashboardOrderController::class, 'orders_Returns'])->name('dashboard.orders.Returns');
// dashboard user
