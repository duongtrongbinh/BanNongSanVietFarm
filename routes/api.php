<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// address order api
Route::post('provinces',[App\Http\Controllers\Client\OrderController::class,'provinces'])->name('provinces.find');

Route::post('district',[App\Http\Controllers\Client\OrderController::class,'district'])->name('district.find');