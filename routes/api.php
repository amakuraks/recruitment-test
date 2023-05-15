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
use App\Http\Controllers\Api\V1\AccessController;
use App\Http\Controllers\Api\V1\PelangganController;
use App\Http\Controllers\Api\V1\BarangController;
use App\Http\Controllers\Api\V1\PenjualanController;


Route::middleware(['api'])->group(function () {
    Route::prefix('v1')->group(function () {
        Route::post('/login', [AccessController::class, 'login'])->name('login');

        Route::middleware('auth:sanctum','checkuserstatus')->group(function () {
            Route::name('api.')->group(function () {
                Route::apiResource('pelanggan', PelangganController::class);
                Route::apiResource('barang', BarangController::class);
                Route::apiResource('penjualan', PenjualanController::class);
            });
        });
    });
});