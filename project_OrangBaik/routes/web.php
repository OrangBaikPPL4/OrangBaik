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
use App\Http\Controllers\FaqController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\FaqFeedbackController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\VolunteerNotificationController;

// Halaman Welcome (Guest)
Route::get('/', function () {
    // Fetch FAQs
    $faqs = \App\Models\Faq::all(); // Gunakan FQCN
    
    // Fetch statistics for the landing page
    $relawanCount = \App\Models\Relawan::count();
    $misiBantuanCount = \App\Models\Misi::count();
    $volunteerCount = \App\Models\Volunteer::count();
    
    return view('landing', compact('faqs', 'relawanCount', 'misiBantuanCount', 'volunteerCount'));
})->name('landing');

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
Route::get('/dashboard-admin', [HomeController::class, 'index'])->name('dashboard.admin');

// Admin tambahan
Route::middleware(['auth', 'admin'])->group(function () {
    // Volunteer
    Route::get('/volunteer', [VolunteerController::class, 'index'])->name('volunteer.index');
    Route::get('/volunteer/create', [VolunteerController::class, 'create'])->name('volunteer.create');
    Route::resource('volunteer', VolunteerController::class)->except(['show']);
    Route::get('/volunteer/{id}', [VolunteerController::class, 'show'])->name('volunteer.show');
    Route::post('/volunteer/manage-participant/{eventId}/{relawanVolunteerId}/{status}', [VolunteerController::class, 'manageParticipantStatus'])->name('volunteer.manageParticipant')->middleware('admin');
    Route::get('/volunteer/{id}/edit', [VolunteerController::class, 'edit'])->name('volunteer.edit');
    Route::put('/volunteer/{id}', [VolunteerController::class, 'update'])->name('volunteer.update');
    Route::delete('/volunteer/{id}', [VolunteerController::class, 'destroy'])->name('volunteer.destroy');
    Route::match(['post', 'patch'], '/volunteer/{id}/update-status', [VolunteerController::class, 'updateVolunteerStatus'])->name('volunteer.updateStatus');
    Route::post('/volunteer/{id}/tambah-relawan', [VolunteerController::class, 'tambahRelawan'])->name('volunteer.tambahRelawan');
    Route::delete('/volunteer/{volunteer_id}/relawan/{relawan_id}', [VolunteerController::class, 'hapusRelawan'])->name('volunteer.hapusRelawan');
    Route::post('/volunteer/{volunteer_id}/relawan/{relawan_id}/update-kehadiran', [VolunteerController::class, 'updateKehadiran'])->name('volunteer.updateKehadiran');

    Route::get('/admin/request-bantuan', [RequestBantuanController::class, 'adminIndex'])->name('admin.request-bantuan.index');
    Route::post('/admin/request-bantuan/{id}/update-status', [RequestBantuanController::class, 'updateStatus'])->name('admin.request-bantuan.update-status');

    Route::post('/relawan/{id}/update-status', [RelawanController::class, 'updateStatus'])->name('relawan.updateStatus');

    Route::get('/admin/misi/create', [MisiController::class, 'create'])->name('misi.create');
    Route::post('/misi', [MisiController::class, 'store'])->name('misi.store');
    Route::get('/misi/{id}/edit', [MisiController::class, 'edit'])->name('misi.edit');
    Route::put('/misi/{id}', [MisiController::class, 'update'])->name('misi.update');
    Route::delete('/misi/{id}', [MisiController::class, 'destroy'])->name('misi.destroy');
    Route::post('/misi/{id}/update-status', [MisiController::class, 'updateMisiStatus'])->name('misi.updateStatus');
    Route::get('/misi/{id}/admin-show', [MisiController::class, 'show'])->name('misi.admin.show');

    Route::get('/admin/donations', [AdminDonationController::class, 'index'])->name('admin.donations.index');
    Route::get('/admin/donations/{donation}', [AdminDonationController::class, 'show'])->name('admin.donations.show');
    Route::post('/admin/donations/{donation}/status', [AdminDonationController::class, 'updateStatus'])->name('admin.donations.updateStatus');
});

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
    Route::get('/relawan', [RelawanController::class, 'index'])->name('relawan.index');
    Route::get('/relawan/create', [RelawanController::class, 'create'])->name('relawan.create');
    Route::post('/relawan', [RelawanController::class, 'store'])->name('relawan.store');
    Route::get('/relawan/{id}/edit', [RelawanController::class, 'edit'])->name('relawan.edit');
    Route::put('/relawan/{id}', [RelawanController::class, 'update'])->name('relawan.update');
    Route::delete('/relawan/{id}', [RelawanController::class, 'destroy'])->name('relawan.destroy');
    Route::get('/relawan/profil', [RelawanController::class, 'show'])->name('relawan.show');
    Route::get('/relawan/{id}/show', [RelawanController::class, 'show'])->name('relawan.admin.show');
    Route::get('/relawan/misi', [RelawanController::class, 'misiRelawan'])->name('relawan.misi');
    
    // Volunteer untuk relawan
    Route::get('/volunteer', [VolunteerController::class, 'index'])->name('volunteer.index');
    
    // Notifikasi volunteer
    Route::get('/volunteer-notifications', [VolunteerNotificationController::class, 'index'])->name('volunteer.notifications.index');
    Route::post('/volunteer-notifications/{id}/mark-read', [VolunteerNotificationController::class, 'markAsRead'])->name('volunteer.notifications.mark-read');
    Route::post('/volunteer-notifications/mark-all-read', [VolunteerNotificationController::class, 'markAllAsRead'])->name('volunteer.notifications.mark-all-read');
    Route::delete('/volunteer-notifications/{id}', [VolunteerNotificationController::class, 'destroy'])->name('volunteer.notifications.destroy');
    
    Route::get('/volunteer/{id}', [VolunteerController::class, 'show'])->name('volunteer.show');
    Route::post('/volunteer/{id}/join', [VolunteerController::class, 'joinEvent'])->name('volunteer.joinEvent'); // Moved here
    Route::post('/volunteer/{id}/gabung', [VolunteerController::class, 'gabungVolunteer'])->name('volunteer.gabung');

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

// Manajemen konten edukasi (diluar dashboard)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/manajemen-edukasi', [EdukasiController::class, 'menu'])->name('edukasi.menu');
    Route::get('/konten-edukasi', [EdukasiController::class, 'adminIndex'])->name('edukasi.admin');
    Route::get('/edukasi/create', [EdukasiController::class, 'create'])->name('edukasi.create');
    Route::post('/edukasi', [EdukasiController::class, 'store'])->name('edukasi.store');
    Route::get('/edukasi/{edukasi}/edit', [EdukasiController::class, 'edit'])->name('edukasi.edit');
    Route::put('/edukasi/{edukasi}', [EdukasiController::class, 'update'])->name('edukasi.update');
    Route::delete('/edukasi/{edukasi}', [EdukasiController::class, 'destroy'])->name('edukasi.destroy');
});

// Edukasi publik
Route::get('/edukasi', [EdukasiController::class, 'index'])->name('edukasi.index');
Route::get('/edukasi/{edukasi}', [EdukasiController::class, 'show'])->name('edukasi.show')->where('edukasi', '[0-9]+');


// Donasi umum
Route::resource('donations', DonationController::class);

// Disaster Report
Route::get('/disaster-report/create', [DisasterReportController::class, 'create'])->name('disaster_report.create');
Route::post('/disaster-report', [DisasterReportController::class, 'store'])->name('disaster_report.store');
Route::get('/disaster-report', [DisasterReportController::class, 'index'])->name('disaster_report.index');
Route::get('/disaster-report/{id}', [DisasterReportController::class, 'show'])->name('disaster_report.show');
Route::get('/disaster-report/{id}/edit', [DisasterReportController::class, 'edit'])->name('disaster_report.edit');
Route::put('/disaster-report/{id}', [DisasterReportController::class, 'update'])->name('disaster_report.update');

// Test Volunteer Create Form Route
Route::get('/test-volunteer-form', function () {
    if (Illuminate\Support\Facades\Auth::check() && Illuminate\Support\Facades\Auth::user()->usertype === 'admin') {
        return view('volunteer.create');
    }
    return abort(403, 'Unauthorized action.');
})->name('test.volunteer.create.form');

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

// User Routes
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
Route::post('/faq/feedback', [FaqFeedbackController::class, 'store'])->name('faq.feedback.store');

// Admin Routes (with middleware)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // FAQ Management
    Route::resource('faq', AdminFaqController::class)->names('admin.faq');
    
    // FAQ Feedback Management
    Route::get('faq-feedback', [\App\Http\Controllers\Admin\FaqFeedbackController::class, 'index'])->name('admin.faq.feedback.index');
    Route::patch('faq-feedback/{id}/mark-addressed', [\App\Http\Controllers\Admin\FaqFeedbackController::class, 'markAsAddressed'])->name('admin.faq.feedback.mark-addressed');
    Route::delete('faq-feedback/{id}', [\App\Http\Controllers\Admin\FaqFeedbackController::class, 'destroy'])->name('admin.faq.feedback.destroy');
});




