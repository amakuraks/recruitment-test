<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('home');
});

Route::middleware('web')->group(function () {
    Route::GET('/', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::GET('/login', function(){
        return redirect()->route('login');
    });

    Route::POST('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('loginpost');
    Route::GET('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::POST('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::GET('/password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::POST('/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware(['auth','checkuserstatus'])->group(function () {
    Route::POST('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::GET('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::GET('/token', [App\Http\Controllers\TokenController::class, 'index'])->name('token.index');
    Route::middleware(['OnlyAjax'])->group(function () {
        Route::GET('/token/table', [App\Http\Controllers\TokenController::class, 'tableIndex'])->name('token.table.index');
        Route::GET('/token/new', [App\Http\Controllers\TokenController::class, 'create'])->name('token.create');
        Route::POST('/token', [App\Http\Controllers\TokenController::class, 'store'])->name('token.store');
        Route::DELETE('/token/{id}', [App\Http\Controllers\TokenController::class, 'destroy'])->name('token.destroy');
    });

    Route::GET('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::middleware(['OnlyAjax'])->group(function () {
        Route::GET('/users/table', [App\Http\Controllers\UserController::class, 'tableIndex'])->name('users.table.index');
        Route::GET('/users/new', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::POST('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::GET('/users/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::PUT('/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::DELETE('/users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::GET('/barang', [App\Http\Controllers\BarangController::class, 'index'])->name('barang.index');
    Route::middleware(['OnlyAjax'])->group(function () {
        Route::GET('/barang/table', [App\Http\Controllers\BarangController::class, 'tableIndex'])->name('barang.table.index');
        Route::GET('/barang/new', [App\Http\Controllers\BarangController::class, 'create'])->name('barang.create');
        Route::POST('/barang', [App\Http\Controllers\BarangController::class, 'store'])->name('barang.store');
        Route::GET('/barang/{id}/edit', [App\Http\Controllers\BarangController::class, 'edit'])->name('barang.edit');
        Route::PUT('/barang/{id}', [App\Http\Controllers\BarangController::class, 'update'])->name('barang.update');
        Route::DELETE('/barang/{id}', [App\Http\Controllers\BarangController::class, 'destroy'])->name('barang.destroy');
    });

    Route::GET('/pelanggan', [App\Http\Controllers\PelangganController::class, 'index'])->name('pelanggan.index');
    Route::middleware(['OnlyAjax'])->group(function () {
        Route::GET('/pelanggan/table', [App\Http\Controllers\PelangganController::class, 'tableIndex'])->name('pelanggan.table.index');
        Route::GET('/pelanggan/new', [App\Http\Controllers\PelangganController::class, 'create'])->name('pelanggan.create');
        Route::POST('/pelanggan', [App\Http\Controllers\PelangganController::class, 'store'])->name('pelanggan.store');
        Route::GET('/pelanggan/{id}/edit', [App\Http\Controllers\PelangganController::class, 'edit'])->name('pelanggan.edit');
        Route::PUT('/pelanggan/{id}', [App\Http\Controllers\PelangganController::class, 'update'])->name('pelanggan.update');
        Route::DELETE('/pelanggan/{id}', [App\Http\Controllers\PelangganController::class, 'destroy'])->name('pelanggan.destroy');
    });

    Route::GET('/penjualan', [App\Http\Controllers\PenjualanController::class, 'index'])->name('penjualan.index');
    Route::GET('/penjualan/new', [App\Http\Controllers\PenjualanController::class, 'create'])->name('penjualan.create');
    Route::GET('/penjualan/{id}/edit', [App\Http\Controllers\PenjualanController::class, 'edit'])->name('penjualan.edit');
    // Route::middleware(['OnlyAjax'])->group(function () {
        Route::GET('/penjualan/table', [App\Http\Controllers\PenjualanController::class, 'tableIndex'])->name('penjualan.table.index');
        Route::POST('/penjualan', [App\Http\Controllers\PenjualanController::class, 'store'])->name('penjualan.store');
        Route::PUT('/penjualan/{id}', [App\Http\Controllers\PenjualanController::class, 'update'])->name('penjualan.update');
        Route::DELETE('/penjualan/{id}', [App\Http\Controllers\PenjualanController::class, 'destroy'])->name('penjualan.destroy');
    // });

    // System Info
    Route::GET('/log', [App\Http\Controllers\HomeController::class, 'log'])->name('home.log');
    Route::GET('/system', [App\Http\Controllers\HomeController::class, 'system'])->name('home.system');
    Route::GET('/info', [App\Http\Controllers\HomeController::class, 'info'])->name('home.info');
});
