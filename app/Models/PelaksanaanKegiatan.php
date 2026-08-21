<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Models\Kegiatan;

class PelaksanaanKegiatan extends Model
{
    protected $table = 'pelaksanaan_kegiatan';

    protected $fillable = [
        'kegiatan_id',
        'periode_ke',
        'waktu_pelaksanaan',
        'dokumentasi',
        // 'status_pelaksanaan',
    ];

    protected $casts = [
        'waktu_pelaksanaan' => 'date',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function tentukanStatusPelaksanaan()
    {
        // Dokumentasi sudah ada
        if (!empty($this->dokumentasi)) {
            return 'selesai';
        }

        // Belum ada jadwal
        if (!$this->waktu_pelaksanaan) {
            return 'menunggu';
        }

        $sekarang = now()->startOfMonth();

        $waktuPelaksanaan = Carbon::parse(
            $this->waktu_pelaksanaan
        )->startOfMonth();


        // Jadwal bulan/tahun berikutnya
        if ($waktuPelaksanaan->isAfter($sekarang)) {
            return 'menunggu';
        }


        // Jadwal bulan/tahun sekarang
        if ($waktuPelaksanaan->equalTo($sekarang)) {
            return 'berlangsung';
        }


        // Jadwal sudah lewat
        return 'terlambat';
    }
}
