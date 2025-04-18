<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EdukasiController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

use App\Models\Edukasi;

Route::get('/', function () {
    return view('welcome');
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

require __DIR__.'/auth.php';

route::get('admin/dashboard',[HomeController::class,'index'])->middleware(['auth','admin']);

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('/edukasi', EdukasiController::class);
});