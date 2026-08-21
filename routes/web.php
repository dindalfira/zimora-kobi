<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PelaksanaanKegiatanController;
use App\Http\Controllers\JadwalController;



// =====================================================
// MONITORING KEGIATAN
// =====================================================

Route::get(
    '/monitoring-kegiatan',
    [KegiatanController::class, 'index']
)->name('kegiatan.index');


Route::get(
    '/monitoring-kegiatan/data',
    [KegiatanController::class, 'data']
)->name('monitoring.kegiatan.data');


Route::patch(
    '/kegiatan/{kegiatan}/status',
    [KegiatanController::class, 'updateStatus']
)->name('kegiatan.updateStatus');


// =====================================================
// DETAIL KEGIATAN / PELAKSANAAN
// =====================================================

Route::get(
    '/kegiatan/{kegiatan}/pelaksanaan',
    [PelaksanaanKegiatanController::class, 'index']
)->name('pelaksanaan.index');


Route::post(
    '/kegiatan/{kegiatan}/generate-pelaksanaan',
    [PelaksanaanKegiatanController::class, 'generatePelaksanaan']
)->name('pelaksanaan.generate');


// =====================================================
// UPDATE WAKTU PELAKSANAAN
// =====================================================

Route::put(
    '/pelaksanaan/{pelaksanaanKegiatan}/waktu',
    [PelaksanaanKegiatanController::class, 'updateWaktuPelaksanaan']
)->name('pelaksanaan.waktu.update');


// =====================================================
// UPDATE DOKUMENTASI
// =====================================================

Route::put(
    '/pelaksanaan/{pelaksanaanKegiatan}/dokumentasi',
    [PelaksanaanKegiatanController::class, 'updateDokumentasi']
)->name('pelaksanaan.dokumentasi.update');


// =====================================================
// DETAIL KEGIATAN
// =====================================================

Route::get(
    '/kegiatan/{kegiatan}/detail',
    [PelaksanaanKegiatanController::class, 'index']
)->name('kegiatan.detail');


// =====================================================
// DETAIL KEGIATAN DARI KEGIATAN CONTROLLER
// =====================================================

Route::get(
    '/kegiatan/{kegiatan}',
    [KegiatanController::class, 'show']
)->name('kegiatan.show');


// =====================================================
// LOGIN
// =====================================================

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

});


// =====================================================
// DASHBOARD
// =====================================================

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


// =====================================================
// JADWAL
// =====================================================

Route::get('/jadwal', function () {
    return view('jadwal');
})->name('jadwal');

Route::get('/jadwal', [JadwalController::class, 'index'])
    ->name('jadwal');


// =====================================================
// LKE
// =====================================================

Route::get('/lke', function () {
    return view('lke');
})->name('lke');


// =====================================================
// DETAIL LKE
// =====================================================

Route::get('/detail-lke', function () {
    return view('detail-lke');
})->name('detail-lke');


// =====================================================
// PENGATURAN
// =====================================================

Route::get('/pengaturan', function () {
    return view('pengaturan');
})->name('pengaturan');