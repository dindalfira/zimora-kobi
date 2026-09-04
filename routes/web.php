<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LKEController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PelaksanaanKegiatanController;
use App\Http\Controllers\PertanyaanLKEController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

// =====================================================
// LOGIN DAN LOGOUT
// =====================================================

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');




Route::middleware('auth')->group(function () {

    // logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

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
    )->middleware('role:admin,pilar')
     ->name('pelaksanaan.updateWaktu');

    Route::post(
        '/pelaksanaan/{pelaksanaanKegiatan}/dokumentasi',
        [PelaksanaanKegiatanController::class, 'updateDokumentasi']
    )->middleware('role:admin,pilar')
     ->name('pelaksanaan.dokumentasi');


    // =====================================================
    // UPDATE DOKUMENTASI
    // =====================================================

    Route::put(
        '/pelaksanaan/{pelaksanaanKegiatan}/dokumentasi',
        [PelaksanaanKegiatanController::class, 'updateDokumentasi']
    )->middleware('role:admin,pilar')
     ->name('pelaksanaan.dokumentasi.update');


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
    ])->middleware('refresh.lke')
    ->name('dashboard');


    // =====================================================
    // JADWAL
    // =====================================================

    Route::get('/jadwal', [JadwalController::class, 'index'])
        ->middleware('refresh.lke')
        ->name('jadwal');


    // =====================================================
    // LKE
    // =====================================================

    Route::get('/lke', [LKEController::class, 'index'])
        ->middleware('refresh.lke')
        ->name('lke');

    Route::put('/lke/{id}', [PertanyaanLKEController::class, 'update'])
        ->name('lke.update');

    Route::get('/lke/{id_pertanyaan}', [LKEController::class, 'detail'])
        ->name('lke.detail');

    Route::get('/detail-lke/{id_pertanyaan}', [LKEController::class, 'detail']
        )->name('detail.lke');

    // Route::get('/lke/{id_pertanyaan}', [
    //     PertanyaanLKEController::class,
    //     'detail'
    // ])->name('lke.detail');

    // Route::get('/detail-lke/{id_pertanyaan}', [
    //     PertanyaanLKEController::class,
    //     'detail'
    // ])->name('detail.lke');

    Route::get('/lke/update-status',[PertanyaanLKEController::class, 'updateStatusPertanyaan']
        )->name('lke.update-status');

    Route::post('/lke/update-status',
        [PertanyaanLKEController::class, 'updateStatusPertanyaan']
    )->name('lke.update-status');

    Route::post(
        '/lke/{id}/pemeriksaan',
        [PertanyaanLKEController::class, 'simpanPemeriksaan']
    )->middleware('role:admin,sekretaris')
     ->name('lke.pemeriksaan.simpan');

    Route::get(
        '/pertanyaan/{id}/status',
        [PertanyaanLKEController::class, 'cekStatusPertanyaan']
    )->name('pertanyaan.status');

    // Route::post(
    //     '/detail-lke/bukti-dukung/upload',
    //     [PertanyaanLKEController::class, 'uploadBuktiDukung']
    // )->middleware('role:admin,pilar')
    //  ->name('bukti-dukung.upload');


    // =====================================================
    // DETAIL LKE
    // =====================================================

    // Route::get('/lke/{periode}', [LKEController::class, 'detail'])
    //     ->name('lke.detail');

    // Route::post(
    //     '/bukti-dukung/upload',
    //     [pertanyaanLKEController::class, 'upload']
    // )->middleware('role:admin,pilar')
    //  ->name('bukti-dukung.upload');

    // =====================================================
    // UPLOAD
    // =====================================================

    // Upload bukti dukung
    Route::post(
        '/upload/bukti-dukung',
        [UploadController::class, 'uploadBuktiDukung']
    )->middleware('role:admin,pilar')
     ->name('upload.bukti-dukung');

    // Bukti dukung
    Route::get(
        '/download/bukti-dukung/{id}',
        [UploadController::class, 'downloadBuktiDukung']
    )->middleware('role:admin,pilar,sekretaris,bps')
     ->name('download.bukti-dukung');

    // Bukti dukung
    Route::post(
        '/delete/bukti-dukung/{id}',
        [UploadController::class, 'deleteBuktiDukung']
    )->middleware('role:admin,pilar')
     ->name('delete.bukti-dukung');

    // Upload dokumentasi kegiatan
    Route::post(
        '/upload/dokumentasi/{id}',
        [UploadController::class, 'uploadDokumentasi']
    )->middleware('role:admin,pilar')
     ->name('upload.dokumentasi');

    Route::post(
        '/delete/dokumentasi/{id}',
        [UploadController::class, 'deleteDokumentasi']
    )->middleware('role:admin')
     ->name('delete.dokumentasi');


    // Dokumentasi kegiatan
    Route::get(
        '/download/dokumentasi/{id}',
        [UploadController::class, 'downloadDokumentasi']
    )->middleware('role:admin,pilar,sekretaris')
     ->name('download.dokumentasi');

    // notifikasi
    Route::get('/notifikasi', [
        NotificationController::class,
        'index'
    ])->name('notification.index');

    Route::get('/notifikasi/{notification}/read', [
        NotificationController::class,
        'read'
    ])->name('notification.read');

    Route::post('/notifikasi/read-all', [
        NotificationController::class,
        'readAll'
    ])->name('notification.readAll');
    
     // =====================================================
    // PENGATURAN
    // =====================================================

    Route::get('/pengaturan', function () {
        return view('pengaturan');
    })->middleware('role:admin')
      ->name('pengaturan');

});