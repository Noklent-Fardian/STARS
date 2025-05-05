<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MahasiswaController;
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
Route::get('/', [LandingController::class, 'index']);
Route::get('/login', [LandingController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // Add other admin routes here
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