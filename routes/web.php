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
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacilityController as AdminFacilityController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Wahana
Route::get('/wahana', [WahanaController::class, 'index'])->name('wahana');
Route::get('/category/{slug}', [FacilityController::class, 'show'])->name('categories.show');

// Rute Authentication
// Route::middleware('guest')->group(function () {
//     Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
//     Route::post('/login', [AuthController::class, 'login']);
//     Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
//     Route::post('/register', [AuthController::class, 'register']);
//     Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
//     Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
// });

// Rute Logout
Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute untuk halaman keranjang
Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');

Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout.process');

//Rute Sukses
Route::get('/checkout/success', [CartController::class, 'checkout'])->name('checkout.success');

// Rute untuk pesanan
Route::get('/pesanan', [OrderController::class, 'index'])->name('pesanan');
Route::post('/pesanan', [OrderController::class, 'store'])->name('pesanan.store');

// Midtrans Notification Route
Route::post('/midtrans-notification', [MidtransController::class, 'handleNotification']);


// Rute untuk halaman login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Rute untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Grup rute untuk admin
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    // Rute untuk dasbor admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Rute untuk pengguna
    Route::get('users', [ UserController::class, 'index'])->name('admin.users.index');
    Route::delete('users',[UserController::class, 'destroy'])->name('admin.users.destroy');

    // Rute untuk fasilitas
    Route::get('facilities', [AdminFacilityController::class, 'index'])->name('admin.facilities.index');
    Route::get('facilities/create', [AdminFacilityController::class, 'create'])->name('admin.facilities.create');
    Route::get('facilities/{facility}/edit', [AdminFacilityController::class, 'edit'])->name('admin.facilities.edit');
    Route::post('facilities', [AdminFacilityController::class, 'store'])->name('admin.facilities.store');
    Route::put('facilities/{facility}', [AdminFacilityController::class, 'update'])->name('admin.facilities.update');
    Route::delete('facilities/{facility}', [AdminFacilityController::class, 'destroy'])->name('admin.facilities.destroy');

    // Rute untuk kategori
    Route::get('categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Rute untuk pesanan
    Route::get('orders', [ AdminOrderController::class, 'index'])->name('admin.orders.index');

});

// untuk role user

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index'); // Menampilkan keranjang
    Route::post('/add', [CartController::class, 'addItem'])->name('add'); // Menambahkan item ke keranjang
    Route::delete('/remove/{id}', [CartController::class, 'removeItem'])->name('remove'); // Menghapus item dari keranjang
    Route::post('/clear', [CartController::class, 'clearCart'])->name('clear'); // Mengosongkan keranjang
});

// Rute untuk halaman fasilitas
Route::get('/fasilitas', [FacilityController::class, 'index'])->name('fasilitas');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');