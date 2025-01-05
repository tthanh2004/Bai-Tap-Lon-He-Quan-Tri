<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NhapHangController;
use App\Http\Controllers\ChiTietHoaDonController;
use App\Http\Controllers\HoaDonController;
use App\Http\Controllers\HangController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\TheTichDiemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\ShopController; // Thêm ShopController
use Inertia\Inertia;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ShopController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('shop.dashboard');

// Route resource cho quản lý (admin)
Route::middleware('auth')->group(function () {
    Route::resource('khachhang', KhachHangController::class);
    Route::resource('nhanvien', NhanVienController::class);
    Route::resource('thetichdiem', TheTichDiemController::class);
    Route::resource('hang', HangController::class);
    Route::resource('sanpham', SanPhamController::class);
    Route::resource('nhaphang', NhapHangController::class);
    Route::resource('hoadon', HoaDonController::class);
    Route::resource('chitiethoadon', ChiTietHoaDonController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('shop')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/product/{sanpham}', [ShopController::class, 'show'])->name('shop.product.show');

    // Giỏ hàng
    Route::get('/cart', [ShopController::class, 'cart'])->name('shop.cart');
    Route::post('/cart/add/{sanpham}', [ShopController::class, 'addToCart'])->name('shop.cart.add');
    Route::post('/cart/remove/{sanpham}', [ShopController::class, 'removeFromCart'])->name('shop.cart.remove');

    // Checkout (thanh toán)
    Route::get('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout')->middleware('auth');
    Route::post('/checkout', [ShopController::class, 'processCheckout'])->name('shop.checkout.process')->middleware('auth');
});

require __DIR__ . '/auth.php';
