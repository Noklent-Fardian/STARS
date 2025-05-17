<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PeringkatController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\TingkatanController;
use App\Http\Controllers\BidangKeahlianController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\AdminKelolaLombaController;
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

    // Admin Management Routes
    Route::prefix('adminManagement')->name('admin.adminManagement.')->group(function () {
        Route::get('/', [AdminManagementController::class, 'index'])->name('index');
        Route::get('/list', [AdminManagementController::class, 'getAdminList'])->name('list');
        Route::get('/show/{id}', [AdminManagementController::class, 'show'])->name('show');

        // AJAX routes
        Route::get('/create_ajax', [AdminManagementController::class, 'createAjax'])->name('createAjax');
        Route::post('/ajax', [AdminManagementController::class, 'storeAjax'])->name('storeAjax');
        Route::get('/{id}/edit_ajax', [AdminManagementController::class, 'editAjax'])->name('editAjax');
        Route::put('/{id}/update_ajax', [AdminManagementController::class, 'updateAjax'])->name('updateAjax');
        Route::get('/{id}/confirm_ajax', [AdminManagementController::class, 'confirmAjax'])->name('confirmAjax');
        Route::delete('/{id}/delete_ajax', [AdminManagementController::class, 'destroyAjax'])->name('destroyAjax');

        // Export routes
        Route::get('/export_pdf', [AdminManagementController::class, 'exportPDF'])->name('exportPDF');
        Route::get('/export_excel', [AdminManagementController::class, 'exportExcel'])->name('exportExcel');

        // Import routes
        Route::get('/import_form', [AdminManagementController::class, 'importForm'])->name('importForm');
        Route::post('/import_excel', [AdminManagementController::class, 'importExcel'])->name('importExcel');
        Route::get('/generate_template', [AdminManagementController::class, 'generateTemplate'])->name('generateTemplate');
    });

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

    // Admin Kelola Lomba
    Route::prefix('adminKelolaLomba')->name('admin.adminKelolaLomba.')->group(function () {
        Route::get('/', [AdminKelolaLombaController::class, 'index'])->name('index');
        Route::get('/list', [AdminKelolaLombaController::class, 'getLombaList'])->name('list');
        Route::get('/show/{id}', [AdminKelolaLombaController::class, 'show'])->name('show');

        // AJAX routes
        Route::get('/create_ajax', [AdminKelolaLombaController::class, 'createAjax'])->name('createAjax');
        Route::post('/ajax', [AdminKelolaLombaController::class, 'storeAjax'])->name('storeAjax');
        Route::get('/{id}/edit_ajax', [AdminKelolaLombaController::class, 'editAjax'])->name('editAjax');
        Route::put('/{id}/update_ajax', [AdminKelolaLombaController::class, 'updateAjax'])->name('updateAjax');
        Route::get('/{id}/confirm_ajax', [AdminKelolaLombaController::class, 'confirmAjax'])->name('confirmAjax');
        Route::delete('/{id}/delete_ajax', [AdminKelolaLombaController::class, 'destroyAjax'])->name('destroyAjax');

        // Export routes
        Route::get('/export_pdf', [AdminKelolaLombaController::class, 'exportPDF'])->name('exportPDF');
        Route::get('/export_excel', [AdminKelolaLombaController::class, 'exportExcel'])->name('exportExcel');

        // Import routes
        Route::get('/import_form', [AdminKelolaLombaController::class, 'importForm'])->name('importForm');
        Route::post('/import_excel', [AdminKelolaLombaController::class, 'importExcel'])->name('importExcel');
        Route::get('/generate_template', [AdminKelolaLombaController::class, 'generateTemplate'])->name('generateTemplate');
    });

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
        Route::get('/export_excel', [TingkatanController::class, 'exportExcel'])->name('exportExcel');

        // Import routes
        Route::get('/import_form', [TingkatanController::class, 'importForm'])->name('importForm');
        Route::post('/import_excel', [TingkatanController::class, 'importExcel'])->name('importExcel');
        Route::get('/generate_template', [TingkatanController::class, 'generateTemplate'])->name('generateTemplate');
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
        Route::get('/export_excel', [PeringkatController::class, 'exportExcel'])->name('exportExcel');
        Route::get('/import_form', [PeringkatController::class, 'importForm'])->name('importForm');
        Route::post('/import_excel', [PeringkatController::class, 'importExcel'])->name('importExcel');
        Route::get('/generate_template', [PeringkatController::class, 'generateTemplate'])->name('generateTemplate');
    });

    // Master Program Studi Routes
    Route::prefix('master/prodi')->name('admin.master.prodi.')->group(function () {
        Route::get('/', [ProdiController::class, 'index'])->name('index');
        Route::get('/list', [ProdiController::class, 'getProdiList'])->name('list');
        Route::post('/', [ProdiController::class, 'store']);
        Route::get('/show/{id}', [ProdiController::class, 'show']);

        // AJAX routes
        Route::get('/create_ajax', [ProdiController::class, 'createAjax'])->name('createAjax');
        Route::post('/ajax', [ProdiController::class, 'storeAjax'])->name('storeAjax');
        Route::get('/{id}/edit_ajax', [ProdiController::class, 'editAjax'])->name('editAjax');
        Route::put('/{id}/update_ajax', [ProdiController::class, 'updateAjax'])->name('updateAjax');
        Route::get('/{id}/confirm_ajax', [ProdiController::class, 'confirmAjax'])->name('confirmAjax');
        Route::delete('/{id}/delete_ajax', [ProdiController::class, 'destroyAjax'])->name('destroyAjax');

        // Export routes
        Route::get('/export_pdf', [ProdiController::class, 'exportPDF'])->name('exportPDF');
        Route::get('/export_excel', [ProdiController::class, 'exportExcel'])->name('exportExcel');

        // Import routes
        Route::get('/import_form', [ProdiController::class, 'importForm'])->name('importForm');
        Route::post('/import_excel', [ProdiController::class, 'importExcel'])->name('importExcel');
        Route::get('/generate_template', [ProdiController::class, 'generateTemplate'])->name('generateTemplate');
    });

    // Master Bidang Keahlian Routes
    Route::prefix('master/bidangKeahlian')->name('admin.master.bidangKeahlian.')->group(function () {
        Route::get('/', [BidangKeahlianController::class, 'index'])->name('index');
        Route::get('/list', [BidangKeahlianController::class, 'getBidangKeahlianList'])->name('list');

        // AJAX routes
        Route::get('/create_ajax', [BidangKeahlianController::class, 'createAjax'])->name('createAjax');
        Route::post('/store_ajax', [BidangKeahlianController::class, 'storeAjax'])->name('storeAjax');
        Route::get('/{id}/edit_ajax', [BidangKeahlianController::class, 'editAjax'])->name('editAjax');
        Route::put('/{id}/update_ajax', [BidangKeahlianController::class, 'updateAjax'])->name('updateAjax');
        Route::delete('/{id}/delete_ajax', [BidangKeahlianController::class, 'deleteAjax'])->name('deleteAjax');
        Route::get('/{id}/confirm_ajax', [BidangKeahlianController::class, 'confirmAjax'])->name('confirmAjax');
        Route::get('/{id}/lihat_mahasiswa', [BidangKeahlianController::class, 'lihatMahasiswa'])->name('lihatMahasiswa');

        Route::get('/show/{id}', [BidangKeahlianController::class, 'show'])->name('show');

        // Export/Import routes - converted from dash to underscore format
        Route::get('/export_pdf', [BidangKeahlianController::class, 'exportPDF'])->name('exportPDF');
        Route::get('/import_form', [BidangKeahlianController::class, 'importForm'])->name('importForm');
        Route::post('/import_excel', [BidangKeahlianController::class, 'importExcel'])->name('importExcel');
        Route::get('/export_excel', [BidangKeahlianController::class, 'exportExcel'])->name('exportExcel');
        Route::get('/generate_template', [BidangKeahlianController::class, 'generateTemplate'])->name('generateTemplate');
    });

    // Master Semester Routes
    Route::prefix('master/semester')->name('admin.master.semester.')->group(function () {
        Route::get('/', [SemesterController::class, 'index'])->name('index');
        Route::get('/list', [SemesterController::class, 'getSemesterList'])->name('list');
        Route::post('/', [SemesterController::class, 'store']);
        Route::get('/show/{id}', [SemesterController::class, 'show']);

        // AJAX routes
        Route::get('/create_ajax', [SemesterController::class, 'createAjax'])->name('createAjax');
        Route::post('/ajax', [SemesterController::class, 'storeAjax'])->name('storeAjax');
        Route::get('/{id}/edit_ajax', [SemesterController::class, 'editAjax'])->name('editAjax');
        Route::put('/{id}/update_ajax', [SemesterController::class, 'updateAjax'])->name('updateAjax');
        Route::get('/{id}/confirm_ajax', [SemesterController::class, 'confirmAjax'])->name('confirmAjax');
        Route::delete('/{id}/delete_ajax', [SemesterController::class, 'destroyAjax'])->name('destroyAjax');

        // Export routes
        Route::get('/export_pdf', [SemesterController::class, 'exportPDF'])->name('exportPDF');
        Route::get('/export_excel', [SemesterController::class, 'exportExcel'])->name('exportExcel');

        // Import routes
        Route::get('/import_form', [SemesterController::class, 'importForm'])->name('importForm');
        Route::post('/import_excel', [SemesterController::class, 'importExcel'])->name('importExcel');
        Route::get('/generate_template', [SemesterController::class, 'generateTemplate'])->name('generateTemplate');
    });


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
