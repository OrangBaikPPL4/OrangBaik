<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestBantuanController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routing untuk user yang sudah login
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Form Request Bantuan (GET)
    Route::get('/request-bantuan/create', function () {
        return view('request-bantuan.create');
    })->name('request-bantuan.create');

    // Proses kirim Request Bantuan (POST)
    Route::post('/request-bantuan', [RequestBantuanController::class, 'store'])->name('request-bantuan.store');
});

// Admin
Route::get('admin/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'admin']);

// Auth routes
require __DIR__.'/auth.php';

Route::middleware('auth')->get('/request-bantuan', [RequestBantuanController::class, 'index'])->name('request-bantuan.index');