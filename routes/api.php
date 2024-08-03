<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AddressController;

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


