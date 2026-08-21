<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Models\PelaksanaanKegiatan;

class Kegiatan extends Model
{
    protected $table = 'kegiatans';
    protected $fillable = [
        'nama_kegiatan',
        'pilar',
        'kode_pertanyaan',
        'pedoman_bukti',
        'jenis_bukti',
        'waktu',
        'waktu_pemenuhan',
        'frekuensi_pelaksanaan',
        'jumlah_pelaksanaan',
        'status_pelaksanaan',
        'dokumentasi_kegiatan',
    ];

    protected $casts = [
        'waktu_pemenuhan' => 'date',
    ];

    // relasi ke tabel pelaksanaan_kegiatan
    public function pelaksanaan()
    {
        return $this->hasMany(PelaksanaanKegiatan::class);
    }

    // status kegiatan
    public function getStatusAktualAttribute()
    {
        // ==========================================
        // 1. SUDAH UPLOAD DOKUMENTASI
        // ==========================================
        if (!empty($this->dokumentasi_kegiatan)) {
            return 'selesai';
        }

        // ==========================================
        // 2. TANGGAL KEGIATAN KOSONG
        // ==========================================
        if (!$this->waktu_pemenuhan) {
            return 'menunggu';
        }

        $tanggalKegiatan = Carbon::parse($this->waktu_pemenuhan);
        $hariIni = Carbon::today();

        // ==========================================
        // 3. TAHUN KEGIATAN MASIH DI MASA DEPAN
        // ==========================================
        if ($tanggalKegiatan->year > $hariIni->year) {
            return 'menunggu';
        }

        // ==========================================
        // 4. TAHUN KEGIATAN SUDAH LEWAT
        // ==========================================
        if ($tanggalKegiatan->year < $hariIni->year) {
            return 'terlambat';
        }

        // ==========================================
        // 5. TAHUN SAMA → BANDINGKAN BULAN
        // ==========================================

        if ($tanggalKegiatan->month > $hariIni->month) {
            return 'menunggu';
        }

        if ($tanggalKegiatan->month === $hariIni->month) {
            return 'berlangsung';
        }

        // Bulan kegiatan sudah lewat
        return 'terlambat';
    }
}
