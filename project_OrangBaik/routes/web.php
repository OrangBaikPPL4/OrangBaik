<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

use App\Models\Donation;
use App\Models\Edukasi;
use App\Notifications\PaymentProofUploaded;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestBantuanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\RelawanController;
use App\Http\Controllers\MisiController;
use App\Http\Controllers\DisasterReportController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DonationController as AdminDonationController;

// Halaman Welcome (Guest)
Route::get('/', function () {
    return view('landing');
});

// Dashboard utama (menampilkan edukasi terbaru)
Route::get('/dashboard', function () {
    $edukasi = Edukasi::latest()->take(5)->get();
    return view('dashboard', compact('edukasi'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Authentication routes
require __DIR__.'/auth.php';

// Login Admin
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');

// Dashboard khusus user & admin
Route::get('/dashboard-user', [DashboardUserController::class, 'index'])->middleware(['auth'])->name('dashboard.user');
Route::get('/dashboard-admin', [DashboardAdminController::class, 'index'])->middleware(['auth', 'admin'])->name('dashboard.admin');

// Profile User
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Request Bantuan
    Route::get('/request-bantuan/create', fn() => view('request-bantuan.create'))->name('request-bantuan.create');
    Route::post('/request-bantuan', [RequestBantuanController::class, 'store'])->name('request-bantuan.store');
    Route::get('/request-bantuan', [RequestBantuanController::class, 'index'])->name('request-bantuan.index');

    // Relawan
    Route::resource('relawan', RelawanController::class)->except(['show']);
    Route::get('/relawan/profil', [RelawanController::class, 'show'])->name('relawan.show');
    Route::get('/relawan/misi', [RelawanController::class, 'misiRelawan'])->name('relawan.misi');

    // Misi
    Route::get('/misi', [MisiController::class, 'index'])->name('misi.index');
    Route::get('/misi/{id}', [MisiController::class, 'show'])->name('misi.show');
    Route::post('/misi/{id}/gabung', [MisiController::class, 'gabungMisi'])->name('misi.gabung');
    Route::post('/misi/{id}/lapor', [MisiController::class, 'laporProgress'])->name('misi.lapor');
    Route::post('/misi/{id}/tambah-relawan', [MisiController::class, 'tambahRelawan'])->name('misi.tambahRelawan');
    Route::delete('/misi/{misi_id}/relawan/{relawan_id}', [MisiController::class, 'hapusRelawan'])->name('misi.hapusRelawan');

    // Donasi
    Route::post('donations/{donation}/upload-proof', [DonationController::class, 'uploadProof'])->name('donations.upload-proof');
    Route::post('donations/{donation}/confirm', [DonationController::class, 'confirm'])->name('donations.confirm');
    Route::post('donations/{donation}/reject', [DonationController::class, 'reject'])->name('donations.reject');
});

// Edukasi publik & admin
Route::get('/edukasi', [EdukasiController::class, 'index'])->name('edukasi.index');
Route::get('/edukasi/{edukasi}', [EdukasiController::class, 'show'])->name('edukasi.show');
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('/edukasi', EdukasiController::class)->except(['show']);
});

// Admin tambahan
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/request-bantuan', [RequestBantuanController::class, 'adminIndex'])->name('admin.request-bantuan.index');
    Route::post('/admin/request-bantuan/{id}/update-status', [RequestBantuanController::class, 'updateStatus'])->name('admin.request-bantuan.update-status');

    Route::post('/relawan/{id}/update-status', [RelawanController::class, 'updateStatus'])->name('relawan.updateStatus');

    Route::get('/admin/misi/create', [MisiController::class, 'create'])->name('misi.create');
    Route::post('/misi', [MisiController::class, 'store'])->name('misi.store');
    Route::get('/misi/{id}/edit', [MisiController::class, 'edit'])->name('misi.edit');
    Route::put('/misi/{id}', [MisiController::class, 'update'])->name('misi.update');
    Route::delete('/misi/{id}', [MisiController::class, 'destroy'])->name('misi.destroy');
    Route::post('/misi/{id}/update-status', [MisiController::class, 'updateMisiStatus'])->name('misi.updateStatus');

    Route::get('/admin/donations', [AdminDonationController::class, 'index'])->name('admin.donations.index');
    Route::get('/admin/donations/{donation}', [AdminDonationController::class, 'show'])->name('admin.donations.show');
    Route::post('/admin/donations/{donation}/status', [AdminDonationController::class, 'updateStatus'])->name('admin.donations.updateStatus');
});

// Donasi umum
Route::resource('donations', DonationController::class);

// Disaster Report
Route::get('/disaster-report/create', [DisasterReportController::class, 'create'])->name('disaster_report.create');
Route::post('/disaster-report', [DisasterReportController::class, 'store'])->name('disaster_report.store');
Route::get('/disaster-report', [DisasterReportController::class, 'index'])->name('disaster_report.index');
Route::get('/disaster-report/{id}', [DisasterReportController::class, 'show'])->name('disaster_report.show');
Route::get('/disaster-report/{id}/edit', [DisasterReportController::class, 'edit'])->name('disaster_report.edit');
Route::put('/disaster-report/{id}', [DisasterReportController::class, 'update'])->name('disaster_report.update');

// Test Email
Route::get('/test-email', function () {
    try {
        $donation = Donation::first();
        if (!$donation) return "No donation found to test with";
        $donation->user->notify(new PaymentProofUploaded($donation));
        return "Email test completed. Check Mailtrap inbox.";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
