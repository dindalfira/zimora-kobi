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
        'status_pelaksanaan',
        'time_updated',
    ];

    protected $casts = [
        'waktu_pelaksanaan' => 'date',
        'time_updated' => 'datetime',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
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

    
    public function getStatusAktualAttribute()
    {
        if (!empty($this->dokumentasi)) {
            return 'selesai';
        }

        if (empty($this->waktu_pelaksanaan)) {
            return 'menunggu';
        }

        $tanggal = Carbon::parse($this->waktu_pelaksanaan);
        $sekarang = Carbon::today();

        // Tahun depan / masa depan
        if ($tanggal->year > $sekarang->year) {
            return 'menunggu';
        }

        // Tahun sudah lewat
        if ($tanggal->year < $sekarang->year) {
            return 'terlambat';
        }

        // Bulan berikutnya
        if ($tanggal->month > $sekarang->month) {
            return 'menunggu';
        }

        // Bulan sekarang
        if ($tanggal->month === $sekarang->month) {
            return 'berlangsung';
        }

        // Bulan sudah lewat
        return 'terlambat';
    }
}
