<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleDriveOauthController;
use App\Http\Controllers\RekapIkuController;
use App\Http\Controllers\Iku1Controller;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public dashboard
Route::get('/', [DashboardController::class, 'index'])->name('home');

// Authenticated dashboard (with login)
Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User routes (CRUD for IKU data)
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    // IKU 1: Angka Efisiensi Edukasi
    Route::get('/iku1', [Iku1Controller::class, 'index'])->name('iku1.index');
    Route::get('/iku1/create', [Iku1Controller::class, 'create'])->name('iku1.create');
    Route::post('/iku1', [Iku1Controller::class, 'store'])->name('iku1.store');
    Route::get('/iku1/{iku1}/edit', [Iku1Controller::class, 'edit'])->name('iku1.edit');
    Route::put('/iku1/{iku1}', [Iku1Controller::class, 'update'])->name('iku1.update');
    Route::delete('/iku1/{iku1}', [Iku1Controller::class, 'destroy'])->name('iku1.destroy');
    
    // IKU 2: Lulusan Bekerja/Studi/Wirausaha
    Route::resource('iku2', \App\Http\Controllers\Iku2Controller::class);
    
    // IKU 3: Mahasiswa Berkegiatan di Luar Prodi
    Route::resource('iku3', \App\Http\Controllers\Iku3Controller::class);
    
    // IKU 4: Dosen Rekognisi Internasional
    Route::resource('iku4', \App\Http\Controllers\Iku4Controller::class);
    
    // IKU 5: Luaran Kerja Sama
    Route::resource('iku5', \App\Http\Controllers\Iku5Controller::class);
    
    // IKU 6: Publikasi Scopus/WoS
    Route::resource('iku6', \App\Http\Controllers\Iku6Controller::class);
    
    // IKU 7: Keterlibatan SDGs
    Route::resource('iku7', \App\Http\Controllers\Iku7Controller::class);
    
    // IKU 8: SDM Penyusun Kebijakan
    Route::resource('iku8', \App\Http\Controllers\Iku8Controller::class);
    
    // IKU 9: Pendapatan Non-UKT
    Route::resource('iku9', \App\Http\Controllers\Iku9Controller::class);
    
    // IKU 10: Zona Integritas
    Route::resource('iku10', \App\Http\Controllers\Iku10Controller::class);
    
    // IKU 11: Tata Kelola
    Route::resource('iku11', \App\Http\Controllers\Iku11Controller::class);
    
    // General IKU routes
    Route::get('/iku/filter', [RekapIkuController::class, 'filter'])->name('iku.filter');
    Route::resource('iku', RekapIkuController::class);

    Route::get('/drive/connect', [GoogleDriveOauthController::class, 'redirectToGoogle'])->name('drive.connect');
    Route::post('/drive/disconnect', [GoogleDriveOauthController::class, 'disconnect'])->name('drive.disconnect');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/auth/google/callback', [GoogleDriveOauthController::class, 'handleCallback'])->name('user.drive.callback');
});

// Admin routes (view all activities)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/activities', [AdminController::class, 'activities'])->name('activities');
    
    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    // Faculty detail
    Route::get('/fakultas/{kode}', [AdminController::class, 'fakultasDetail'])->name('fakultas');
    
    // Export rekap
    Route::get('/export', [AdminController::class, 'exportRekap'])->name('export');
});

require __DIR__.'/auth.php';
