<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EdukasiController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RelawanController;
use App\Http\Controllers\MisiController;

use App\Http\Controllers\DisasterReportController;
use App\Http\Controllers\DonationController;

use Illuminate\Support\Facades\Mail;
use App\Notifications\PaymentProofUploaded;
use App\Models\Donation;

use App\Models\Edukasi;

Route::get('/', function () {
    return view('landing');
});

Route::get('/dashboard', function () {
    $edukasi = Edukasi::latest()->take(5)->get();
    return view('dashboard', compact('edukasi'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    

    Route::get('/edukasi', [EdukasiController::class, 'index'])->name('edukasi.index');
    Route::get('/edukasi/{edukasi}', [EdukasiController::class, 'show'])->name('edukasi.show');

});

// Middleware group for authenticated users
Route::middleware('auth')->group(function () {
    // Relawan Routes
    Route::get('/relawan', [RelawanController::class, 'index'])->name('relawan.index');
    Route::get('/relawan/create', [RelawanController::class, 'create'])->name('relawan.create');
    Route::post('/relawan', [RelawanController::class, 'store'])->name('relawan.store');
    Route::get('/relawan/profil', [RelawanController::class, 'show'])->name('relawan.show');
    Route::get('/relawan/{id}/edit', [RelawanController::class, 'edit'])->name('relawan.edit');
    Route::put('/relawan/{id}', [RelawanController::class, 'update'])->name('relawan.update');
    Route::delete('/relawan/{id}', [RelawanController::class, 'destroy'])->name('relawan.destroy');
    Route::get('/relawan/misi', [RelawanController::class, 'misiRelawan'])->name('relawan.misi');

    // Misi Routes
    Route::get('/misi', [MisiController::class, 'index'])->name('misi.index');
    Route::get('/misi/{id}', [MisiController::class, 'show'])->name('misi.show');
    Route::post('/misi/{id}/gabung', [MisiController::class, 'gabungMisi'])->name('misi.gabung');
    Route::post('/misi/{id}/lapor', [MisiController::class, 'laporProgress'])->name('misi.lapor');
    Route::post('/misi/{id}/tambah-relawan', [MisiController::class, 'tambahRelawan'])->name('misi.tambahRelawan');
    Route::delete('/misi/{misi_id}/relawan/{relawan_id}', [MisiController::class, 'hapusRelawan'])->name('misi.hapusRelawan');
    
    // Admin Routes - protected by admin middleware
    Route::middleware('admin')->group(function () {
        // Admin Dashboard
        Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        
        // Admin Relawan Management
        Route::post('/relawan/{id}/update-status', [RelawanController::class, 'updateStatus'])->name('relawan.updateStatus');
        
        // Admin Misi Management
        Route::get('/admin/misi/create', [MisiController::class, 'create'])->name('misi.create');
        Route::post('/misi', [MisiController::class, 'store'])->name('misi.store');
        Route::get('/misi/{id}/edit', [MisiController::class, 'edit'])->name('misi.edit');
        Route::put('/misi/{id}', [MisiController::class, 'update'])->name('misi.update');
        Route::delete('/misi/{id}', [MisiController::class, 'destroy'])->name('misi.destroy');
        Route::post('/misi/{id}/update-status', [MisiController::class, 'updateMisiStatus'])->name('misi.updateStatus');

        // Admin Donation Management
        Route::get('/admin/donations', [App\Http\Controllers\Admin\DonationController::class, 'index'])->name('admin.donations.index');
        Route::get('/admin/donations/{donation}', [App\Http\Controllers\Admin\DonationController::class, 'show'])->name('admin.donations.show');
        Route::post('/admin/donations/{donation}/status', [App\Http\Controllers\Admin\DonationController::class, 'updateStatus'])->name('admin.donations.updateStatus');
    });
});

// Public donation routes
Route::resource('donations', DonationController::class);

// Only authenticated users can upload proof, confirm, or reject
Route::middleware(['auth'])->group(function () {
    Route::post('donations/{donation}/upload-proof', [DonationController::class, 'uploadProof'])->name('donations.upload-proof');
    Route::post('donations/{donation}/confirm', [DonationController::class, 'confirm'])->name('donations.confirm');
    Route::post('donations/{donation}/reject', [DonationController::class, 'reject'])->name('donations.reject');
});

Route::get('/disaster-report/create', [DisasterReportController::class, 'create'])->name('disaster_report.create');
Route::post('/disaster-report', [DisasterReportController::class, 'store'])->name('disaster_report.store');
Route::get('/disaster-report', [DisasterReportController::class, 'index'])->name('disaster_report.index');
Route::get('/disaster-report/{id}', [DisasterReportController::class, 'show'])->name('disaster_report.show');

Route::get('/test-email', function () {
    try {
        // Create a test donation
        $donation = Donation::first();
        
        if (!$donation) {
            return "No donation found to test with";
        }

        // Try to send the notification
        $donation->user->notify(new PaymentProofUploaded($donation));
        
        return "Email test completed. Check Mailtrap inbox.";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

require __DIR__.'/auth.php';



Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('/edukasi', EdukasiController::class)->except(['show']);
});

