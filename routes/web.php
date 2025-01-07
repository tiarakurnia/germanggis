<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WahanaController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FacilityController as AdminFacilityController;

// Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Wahana
Route::get('/wahana', [WahanaController::class, 'index'])->name('wahana');
Route::get('/category/{slug}', [FacilityController::class, 'show'])->name('categories.show');

// Rute Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
});

// Rute Logout
Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute untuk halaman fasilitas
Route::get('/fasilitas', [FacilityController::class, 'index'])->name('fasilitas');

// Rute untuk halaman keranjang
Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');

Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout.process');

//Rute Sukses
Route::get('/checkout/success', [CartController::class, 'checkout'])->name('checkout.success');

// Rute untuk pesanan
Route::get('/pesanan', [OrderController::class, 'index'])->name('pesanan');
Route::post('/pesanan', [OrderController::class, 'store'])->name('pesanan.store');

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('facilities', [AdminFacilityController::class, 'index'])->name('facilities.index');
        Route::get('facilities/create', [AdminFacilityController::class, 'create'])->name('facilities.create');
        Route::post('facilities', [AdminFacilityController::class, 'store'])->name('facilities.store');
        Route::get('facilities/{facility}/edit', [AdminFacilityController::class, 'edit'])->name('facilities.edit');
        Route::put('facilities/{facility}', [AdminFacilityController::class, 'update'])->name('facilities.update');
        Route::delete('facilities/{facility}', [AdminFacilityController::class, 'destroy'])->name('facilities.destroy');

        Route::resource('categories', CategoryController::class);

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::put('/orders/{id}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');
    });
});

// Midtrans Notification Route
Route::post('/midtrans-notification', [MidtransController::class, 'handleNotification']);
