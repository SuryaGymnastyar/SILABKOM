<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\VerificationController as AdminVerificationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

// Guest
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login.action');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.action');
});

// Login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil & Ganti Password
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Mahasiswa
    Route::middleware('role:mahasiswa')->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/katalog', [BookingController::class, 'katalog'])->name('katalog');
        Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
        Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
        Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
        Route::get('/booking/{id}/edit', [BookingController::class, 'edit'])->name('booking.edit');
        Route::put('/booking/{id}', [BookingController::class, 'update'])->name('booking.update');
        Route::delete('/booking/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');
    });

    // Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Kelola Ruangan Lab
        Route::resource('rooms', AdminRoomController::class);

        // Verifikasi Peminjaman
        Route::get('/verifikasi', [AdminVerificationController::class, 'index'])->name('verifikasi.index');
        Route::patch('/verifikasi/{id}/setujui', [AdminVerificationController::class, 'approve'])->name('verifikasi.approve');
        Route::patch('/verifikasi/{id}/tolak', [AdminVerificationController::class, 'reject'])->name('verifikasi.reject');

        // Kelola Pengguna
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::patch('/users/{id}/promote', [AdminUserController::class, 'promoteToAdmin'])->name('users.promote');

        // Riwayat Peminjaman
        Route::get('/verifikasi/riwayat', [AdminVerificationController::class, 'history'])->name('verifikasi.history');
    });
});