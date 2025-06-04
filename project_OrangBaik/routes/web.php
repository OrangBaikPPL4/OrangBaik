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
use App\Http\Controllers\Admin\DonationController as AdminDonationController;
use App\Http\Controllers\DisasterReportController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DisasterReportController as AdminDisasterReportController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\FaqFeedbackController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\VolunteerNotificationController;
use App\Http\Controllers\AdminNotificationController;

// Public Routes
Route::get('/', function () {
    // Fetch FAQs
    $faqs = \App\Models\Faq::all(); // Gunakan FQCN
    
    // Fetch statistics for the landing page
    $relawanCount = \App\Models\Relawan::count();
    $misiBantuanCount = \App\Models\Misi::count();
    $volunteerCount = \App\Models\Volunteer::count();
    
    // Fetch latest announcements
    $announcements = \App\Models\Announcement::latest()->take(3)->get();
    
    // Fetch disaster reports for the landing page
    $disasterReports = \App\Models\DisasterReport::latest()->take(5)->get();
    
    // Fetch latest volunteer events
    $volunteerEvents = \App\Models\Volunteer::latest()->take(3)->get();
    
    // Fetch latest missions
    $missions = \App\Models\Misi::latest()->take(3)->get();
    
    // Fetch latest testimonials
    $testimonials = \App\Models\Testimoni::where('status', 'verified')->latest()->take(3)->get();
    
    // Fetch latest education content
    $edukasi = \App\Models\Edukasi::latest()->take(3)->get();
    
    return view('landing', compact('faqs', 'relawanCount', 'misiBantuanCount', 'volunteerCount', 
        'announcements', 'disasterReports', 'volunteerEvents', 'missions', 'testimonials', 'edukasi'));
})->name('landing');

// Dashboard utama (menampilkan edukasi terbaru)
Route::get('/dashboard', function () {
    $edukasi = Edukasi::latest()->take(5)->get();
    return view('dashboard', compact('edukasi'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Announcements routes (public)
Route::get('/announcements', [\App\Http\Controllers\AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/{id}', [\App\Http\Controllers\AnnouncementController::class, 'show'])->name('announcements.show');

// Authentication routes
require __DIR__.'/auth.php';

// Login Admin
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');

// Dashboard khusus user & admin
Route::get('/dashboard-user', [DashboardUserController::class, 'index'])->middleware(['auth'])->name('dashboard.user');
Route::get('/dashboard-admin', [HomeController::class, 'index'])->name('dashboard.admin');

// Public Donation Routes
Route::get('donations', [DonationController::class, 'index'])->name('donations.index');
Route::get('donations/create', [DonationController::class, 'create'])->name('donations.create');
Route::post('donations', [DonationController::class, 'store'])->name('donations.store');
Route::get('donations/{donation}', [DonationController::class, 'show'])->name('donations.show');
Route::get('/donation-dashboard', [DonationController::class, 'publicDashboard'])->name('donation.dashboard');

// Authenticated User Routes
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
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Request Bantuan
    Route::get('/request-bantuan/create', fn() => view('request-bantuan.create'))->name('request-bantuan.create');
    Route::post('/request-bantuan', [RequestBantuanController::class, 'store'])->name('request-bantuan.store');
    Route::get('/request-bantuan', [RequestBantuanController::class, 'index'])->name('request-bantuan.index');
    
    // Edukasi Routes
    Route::get('/edukasi', [EdukasiController::class, 'index'])->name('edukasi.index');
    Route::get('/edukasi/{edukasi}', [EdukasiController::class, 'show'])->name('edukasi.show');

    // Authenticated Donation Routes
    Route::post('donations/{donation}/upload-proof', [DonationController::class, 'uploadProof'])->name('donations.upload-proof');
    Route::post('donations/{donation}/confirm', [DonationController::class, 'confirm'])->name('donations.confirm');
    Route::post('donations/{donation}/reject', [DonationController::class, 'reject'])->name('donations.reject');

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

    // Testimoni
    Route::get('/testimoni/create', [TestimoniController::class, 'create'])->name('testimoni.create');
    Route::post('/testimoni', [TestimoniController::class, 'store'])->name('testimoni.store');

});

// Manajemen konten edukasi (diluar dashboard)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/manajemen-edukasi', [EdukasiController::class, 'menu'])->name('edukasi.menu');
    Route::get('/konten-edukasi', [EdukasiController::class, 'adminIndex'])->name('admin.edukasi.index');
    Route::get('/edukasi/create', [EdukasiController::class, 'create'])->name('edukasi.create');
    Route::post('/edukasi', [EdukasiController::class, 'store'])->name('edukasi.store');
    Route::get('/edukasi/{edukasi}/edit', [EdukasiController::class, 'edit'])->name('edukasi.edit');
    Route::put('/edukasi/{edukasi}', [EdukasiController::class, 'update'])->name('edukasi.update');
    Route::delete('/edukasi/{edukasi}', [EdukasiController::class, 'destroy'])->name('edukasi.destroy');
});

// Edukasi publik
Route::get('/edukasi', [EdukasiController::class, 'publicIndex'])->name('edukasi.index');
Route::get('/edukasi/{edukasi}', [EdukasiController::class, 'show'])->name('edukasi.show')->where('edukasi', '[0-9]+');

// Testimoni publik
Route::get('/testimoni', [TestimoniController::class, 'index'])->name('testimoni.index');
Route::get('/testimoni/{id}', [TestimoniController::class, 'show'])->name('testimoni.show');


// Admin tambahan
Route::middleware(['auth', 'admin'])->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
        // Admin Donation Management
        Route::get('/donations', [AdminDonationController::class, 'index'])->name('donations.index');
        Route::get('/donations/{donation}', [AdminDonationController::class, 'show'])->name('donations.show');
        Route::post('/donations/{donation}/update-status', [AdminDonationController::class, 'updateStatus'])->name('donations.updateStatus');
        Route::get('/donations/{donation}/edit', [AdminDonationController::class, 'edit'])->name('donations.edit');
        Route::put('/donations/{donation}', [AdminDonationController::class, 'update'])->name('donations.update');
        Route::delete('/donations/{donation}', [AdminDonationController::class, 'destroy'])->name('donations.destroy');
        Route::post('/donations/bulk-destroy', [AdminDonationController::class, 'bulkDestroy'])->name('donations.bulkDestroy');
        // Admin Relawan Management
        Route::post('/relawan/{id}/update-status', [RelawanController::class, 'updateStatus'])->name('relawan.updateStatus');
        // Admin Misi Management
        Route::get('/misi/create', [MisiController::class, 'create'])->name('misi.create');
        Route::post('/misi', [MisiController::class, 'store'])->name('misi.store');
        Route::get('/misi/{id}/edit', [MisiController::class, 'edit'])->name('misi.edit');
        Route::put('/misi/{id}', [MisiController::class, 'update'])->name('misi.update');
        Route::delete('/misi/{id}', [MisiController::class, 'destroy'])->name('misi.destroy');
        Route::post('/misi/{id}/update-status', [MisiController::class, 'updateMisiStatus'])->name('misi.updateStatus');
        Route::get('/misi/{id}/admin-show', [MisiController::class, 'show'])->name('misi.admin.show');
        // Admin Edukasi Management
        Route::resource('edukasi', EdukasiController::class);
        // Admin Management
        Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class);
        // Admin Request Bantuan Management
        Route::get('/request-bantuan', [RequestBantuanController::class, 'adminIndex'])->name('request-bantuan.index');
        Route::post('/request-bantuan/{id}/update-status', [RequestBantuanController::class, 'updateStatus'])->name('request-bantuan.update-status');
        // Admin Donation Distribution
        Route::post('/donations/{donation}/distribute', [\App\Http\Controllers\Admin\DonationController::class, 'distribute'])->name('admin.donations.distribute');
        // Admin Donation Export
        Route::get('/donations/export', [App\Http\Controllers\Admin\DonationController::class, 'export'])->name('admin.donations.export');
    });
});

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

    Route::get('/admin/testimoni/moderasi', [TestimoniController::class, 'moderation'])->name('testimoni.moderation');
    Route::post('/admin/testimoni/{id}/approve', [TestimoniController::class, 'approve'])->name('testimoni.approve');
    Route::post('/admin/testimoni/{id}/reject', [TestimoniController::class, 'reject'])->name('testimoni.reject');

    Route::get('/admin/disaster-reports', [AdminDisasterReportController::class, 'index'])->name('admin.disaster_reports.index');
    Route::get('/admin/disaster-reports/{id}', [AdminDisasterReportController::class, 'show'])->name('admin.disaster_reports.show');
    Route::put('/admin/disaster-reports/{id}/verify', [AdminDisasterReportController::class, 'verify'])->name('admin.disaster_reports.verify');
    
    Route::get('/admin/announcements', [AnnouncementController::class, 'index'])->name('admin.announcements.index');
    Route::get('/admin/announcements/create', [AnnouncementController::class, 'create'])->name('admin.announcements.create');
    Route::post('/admin/announcements', [AnnouncementController::class, 'store'])->name('admin.announcements.store');
    Route::get('/admin/announcements', [AnnouncementController::class, 'index'])->name('admin.announcements.index');
    Route::get('/admin/announcements/{id}', [AnnouncementController::class, 'show'])->name('admin.announcements.show');
    Route::get('/admin/announcements/{id}/edit', [AnnouncementController::class, 'edit'])->name('admin.announcements.edit');
    Route::put('/admin/announcements/{id}', [AnnouncementController::class, 'update'])->name('admin.announcements.update');
    Route::delete('/admin/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('admin.announcements.destroy');

    // Admin Notifications
    Route::get('/admin/notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
    Route::post('/admin/notifications/{id}/mark-read', [AdminNotificationController::class, 'markAsRead'])->name('admin.notifications.mark-read');
    Route::post('/admin/notifications/mark-all-read', [AdminNotificationController::class, 'markAllAsRead'])->name('admin.notifications.mark-all-read');
    Route::delete('/admin/notifications/{id}', [AdminNotificationController::class, 'destroy'])->name('admin.notifications.destroy');



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
        if (!$donation) {
            return "No donation found to test with";
        }
        Mail::to('test@example.com')->send(new PaymentProofUploaded($donation));
        return "Email sent successfully";
    } catch (\Exception $e) {
        return "Error sending email: " . $e->getMessage();
    }
});


Route::post('donations/{donation}/update-status', [DonationController::class, 'updateStatus'])->name('donations.updateStatus');

Route::get('/notifications', function () {
    return 'Notifikasi belum tersedia.';
})->name('notifications.index');

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





