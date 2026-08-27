<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LKEController;
use App\Http\Controllers\PelaksanaanKegiatanController;
use App\Http\Controllers\PertanyaanLKEController;
use Illuminate\Support\Facades\Route;

// =====================================================
// LOGIN DAN LOGOUT
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
// DASHBOARD
// =====================================================

Route::get('/dashboard', [
    DashboardController::class,
    'index'
])->name('dashboard');


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

Route::get('/lke', [LKEController::class, 'index'])
    ->name('lke');

Route::put('/lke/{id}', [PertanyaanLKEController::class, 'update'])
    ->name('lke.update');

Route::get('/lke/{id_pertanyaan}', [LKEController::class, 'detail'])
    ->name('lke.detail');

Route::get('/detail-lke/{id_pertanyaan}', [LKEController::class, 'detail']
    )->name('detail.lke');

Route::get('/lke/update-status',[PertanyaanLKEController::class, 'updateStatusPertanyaan']
    )->name('lke.update-status');

Route::post('/lke/update-status',
    [PertanyaanLKEController::class, 'updateStatusPertanyaan']
)->name('lke.update-status');

Route::post(
    '/lke/{id}/pemeriksaan',
    [PertanyaanLKEController::class, 'simpanPemeriksaan']
)->name('lke.pemeriksaan.simpan');

Route::post(
    '/detail-lke/bukti-dukung/upload',
    [PertanyaanLKEController::class, 'uploadBuktiDukung']
)->name('bukti-dukung.upload');


// =====================================================
// DETAIL LKE
// =====================================================

Route::get('/lke/{periode}', [LKEController::class, 'detail'])
    ->name('lke.detail');

Route::post(
    '/bukti-dukung/upload',
    [pertanyaanLKEController::class, 'upload']
)->name('bukti-dukung.upload');


// =====================================================
// PENGATURAN
// =====================================================

Route::get('/pengaturan', function () {
    return view('pengaturan');
})->name('pengaturan');