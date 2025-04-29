<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestBantuanController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Halaman Welcome (Guest)
Route::get('/', function () {
    return view('welcome');
});

// Routing untuk user yang sudah login
Route::middleware('auth')->group(function () {
    // Profile User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard User
    Route::get('/dashboard-user', function () {
        return view('dashboard-user.dashboard');
    })->name('dashboard.user');

    // Form Request Bantuan (PBI#29)
    Route::get('/request-bantuan/create', function () {
        return view('request-bantuan.create');
    })->name('request-bantuan.create');

    // Submit Request Bantuan (PBI#29)
    Route::post('/request-bantuan', [RequestBantuanController::class, 'store'])->name('request-bantuan.store');

    // Menampilkan Riwayat Permintaan Bantuan Korban (PBI#32)
    Route::get('/request-bantuan', [RequestBantuanController::class, 'index'])->name('request-bantuan.index');
});

// Routing untuk Admin
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

    // Menampilkan Semua Permintaan Bantuan Korban (PBI#30)
    Route::get('/admin/request-bantuan', [RequestBantuanController::class, 'adminIndex'])->name('admin.request-bantuan.index');

    // Update Status Permintaan Bantuan (PBI#31)
    Route::post('/admin/request-bantuan/{id}/update-status', [RequestBantuanController::class, 'updateStatus'])->name('admin.request-bantuan.update-status');
});

// Authentication routes
require __DIR__.'/auth.php';

// Login Admin Form
Route::get('/admin/login', [\App\Http\Controllers\Auth\AdminLoginController::class, 'showLoginForm'])->name('admin.login');

// Proses Login Admin
Route::post('/admin/login', [\App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('admin.login.submit');
