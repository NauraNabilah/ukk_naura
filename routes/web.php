<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Middleware\AuthenticateSession;
use App\Http\Controllers\PenjualanController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::middleware([AuthenticateSession::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('produks', ProdukController::class);
    Route::post('produks/{produk}/update-stock', [ProdukController::class, 'updateStock'])->name('produks.updateStock');

    Route::resource('users', UserController::class);

    Route::get('penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
    Route::post('penjualan/store', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('penjualan/{id}/checkout', [PenjualanController::class, 'checkout'])->name('penjualan.checkout');
    Route::post('penjualan/{id}/bayar', [PenjualanController::class, 'bayar'])->name('penjualan.bayar');
    Route::post('penjualan/rincian', [PenjualanController::class, 'rincian'])->name('penjualan.rincian');
    Route::get('penjualan/rincian/view', [PenjualanController::class, 'rincianView'])->name('penjualan.rincian.view');
    Route::get('/penjualan/{id}/hasil', [PenjualanController::class, 'hasil'])->name('penjualan.hasil');

    Route::get('/penjualan/{id}/add-member', [PenjualanController::class, 'addMember'])->name('penjualan.add-member');
    Route::post('/member/store', [PenjualanController::class, 'storeMember'])->name('member.store');

    Route::get('/penjualan/{id}/unduh', [PenjualanController::class, 'unduhPdf'])->name('penjualan.unduh');
    Route::get('/penjualan/export-excel', [\App\Http\Controllers\PenjualanController::class, 'exportExcel'])
    ->name('penjualan.exportExcel');
   
    Route::get('penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
});
