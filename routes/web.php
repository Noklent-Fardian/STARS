<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\TingkatanController;
use App\Http\Controllers\PeringkatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/login', [LandingController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Manajemen Pengguna
    Route::get('/mahasiswa', [AdminController::class, 'mahasiswaIndex'])->name('admin.mahasiswa.index');
    Route::get('/dosen', [AdminController::class, 'dosenIndex'])->name('admin.dosen.index');
    Route::get('/admin', [AdminController::class, 'adminIndex'])->name('admin.admin.index');

    // Manajemen Prestasi
    Route::get('/prestasi/verification', [AdminController::class, 'prestasiVerification'])->name('admin.prestasi.verification');
    Route::get('/prestasi/akademik', [AdminController::class, 'prestasiAkademik'])->name('admin.prestasi.akademik');
    Route::get('/prestasi/non-akademik', [AdminController::class, 'prestasiNonAkademik'])->name('admin.prestasi.non-akademik');
    Route::get('/prestasi', [AdminController::class, 'prestasiIndex'])->name('admin.prestasi.index');
    Route::get('/prestasi/report', [AdminController::class, 'prestasiReport'])->name('admin.prestasi.report');

    // Manajemen Lomba
    Route::get('/lomba/verification', [AdminController::class, 'lombaVerification'])->name('admin.lomba.verification');
    Route::get('/lomba', [AdminController::class, 'lombaIndex'])->name('admin.lomba.index');

    // Master Data
    Route::get('/master/periode', [AdminController::class, 'masterPeriode'])->name('admin.master.periode');
    Route::get('/master/prodi', [AdminController::class, 'masterProdi'])->name('admin.master.prodi');

    // Master Tingkatan Lomba Routes
    Route::prefix('master/tingkatanLomba')->name('admin.master.tingkatanLomba.')->group(function () {
        Route::get('/', [TingkatanController::class, 'index'])->name('index');
        Route::get('/list', [TingkatanController::class, 'getTingkatanList'])->name('list');
        Route::post('/', [TingkatanController::class, 'store']);
        Route::get('/show/{id}', [TingkatanController::class, 'show']);
    
        // AJAX routes
        Route::get('/create_ajax', [TingkatanController::class, 'createAjax'])->name('createAjax');
        Route::post('/ajax', [TingkatanController::class, 'storeAjax'])->name('storeAjax');
        Route::get('/{id}/edit_ajax', [TingkatanController::class, 'editAjax'])->name('editAjax');
        Route::put('/{id}/update_ajax', [TingkatanController::class, 'updateAjax'])->name('updateAjax');
        Route::get('/{id}/confirm_ajax', [TingkatanController::class, 'confirmAjax'])->name('confirmAjax');
        Route::delete('/{id}/delete_ajax', [TingkatanController::class, 'destroyAjax'])->name('destroyAjax');

        // Export routes
        Route::get('/export_pdf', [TingkatanController::class, 'exportPDF'])->name('exportPDF');
    });

    // Master Peringkat Lomba Routes
    Route::prefix('master/peringkatLomba')->name('admin.master.peringkatLomba.')->group(function () {
        Route::get('/', [PeringkatController::class, 'index'])->name('index');
        Route::get('/list', [PeringkatController::class, 'getPeringkatList'])->name('list');
        Route::post('/', [PeringkatController::class, 'store']);
        Route::get('/show/{id}', [PeringkatController::class, 'show']);
    
        // AJAX routes
        Route::get('/create_ajax', [PeringkatController::class, 'createAjax'])->name('createAjax');
        Route::post('/ajax', [PeringkatController::class, 'storeAjax'])->name('storeAjax');
        Route::get('/{id}/edit_ajax', [PeringkatController::class, 'editAjax'])->name('editAjax');
        Route::put('/{id}/update_ajax', [PeringkatController::class, 'updateAjax'])->name('updateAjax');
        Route::get('/{id}/confirm_ajax', [PeringkatController::class, 'confirmAjax'])->name('confirmAjax');
        Route::delete('/{id}/delete_ajax', [PeringkatController::class, 'destroyAjax'])->name('destroyAjax');

        // Export routes
        Route::get('/export_pdf', [PeringkatController::class, 'exportPDF'])->name('exportPDF');
    });

    // Route::get('/master/peringkatLomba', [AdminController::class, 'masterPeringkatLomba'])->name('admin.master.peringkatLomba');
    Route::get('/master/keahlian', [AdminController::class, 'masterKeahlian'])->name('admin.master.keahlian');



    // Settings
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/admin/profile/edit', [AdminController::class, 'editProfile'])->name('admin.editProfile');
    Route::put('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.updateProfile');
});

// Dosen routes
Route::middleware(['auth', 'role:Dosen'])->prefix('dosen')->group(function () {
    Route::get('/dashboard', [DosenController::class, 'index'])->name('dosen.dashboard');
    // Add other dosen routes here
});

// Mahasiswa routes
Route::middleware(['auth', 'role:Mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', [MahasiswaController::class, 'index'])->name('mahasiswa.dashboard');
    // Add other mahasiswa routes here
});

// Fallback for unauthorized access
Route::fallback(function () {
    return redirect('/login');
});
