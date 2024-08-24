<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DashboardOrderController;
use App\Http\Controllers\Admin\ReportController;

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


Route::middleware(['web'])->post('voucher/apply', [App\Http\Controllers\Api\VoucherController::class, 'apply'])->name('voucher.apply');

// AddressController
Route::get('/provinces', [AddressController::class, 'getProvinces'])->name('provinces.address');
Route::get('/districts/{provinceId}', [AddressController::class, 'getDistricts'])->name('districts.address');
Route::get('/wards/{districtId}', [AddressController::class, 'getWards'])->name('wards.address');

// dashboard
Route::get('/orders', [DashboardController::class, 'orders'])->name('dashboard.orders');
Route::get('/orders/total', [DashboardController::class, 'ordersTotal'])->name('dashboard.orders.total');
Route::get('/users', [DashboardController::class, 'users'])->name('dashboard.users');
Route::get('/purchasereceipt', [DashboardController::class, 'purchase_receipt'])->name('dashboard.purchase_receipt');
// dashboard Report
Route::get('report/orders',[ReportController::class,'report_orders'])->name('report.orders');
Route::get('report/users',[ReportController::class,'report_users'])->name('report.users');
Route::get('report/revenue',[ReportController::class,'report_revenue'])->name('report.revenue');
Route::get('report/purchase_receipt',[ReportController::class,'report_purchase_receipt'])->name('report.purchase_receipt');

Route::get('report/vouchers',[ReportController::class,'report_vouchers'])->name('report.vouchers');

// dashboard voucher
Route::get('vouchers', [DashboardController::class, 'voucher'])->name('dashboard.voucher');
