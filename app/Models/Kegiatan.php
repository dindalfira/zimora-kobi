<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Models\PelaksanaanKegiatan;
use App\Models\PertanyaanLKE;

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
        return $this->hasMany(PelaksanaanKegiatan::class, 'kegiatan_id');
    }

    // status kegiatan
    public function getStatusAktualAttribute()
    {
        $pelaksanaan = $this->pelaksanaan;

        // Tidak ada pelaksanaan
        if ($pelaksanaan->isEmpty()) {
            return 'menunggu';
        }

        $hariIni = Carbon::today();

        $adaTerlambat = false;
        $adaBerlangsung = false;
        $adaMenunggu = false;
        $adaBelumSelesai = false;


        // ==========================================
        // CEK SETIAP PELAKSANAAN
        // ==========================================

        foreach ($pelaksanaan as $item) {

            // --------------------------------------
            // SUDAH SELESAI
            // --------------------------------------

            if (!empty($item->dokumentasi)) {
                continue;
            }

            $adaBelumSelesai = true;


            // --------------------------------------
            // TANGGAL KOSONG
            // --------------------------------------

            if (empty($item->waktu_pelaksanaan)) {
                $adaMenunggu = true;
                continue;
            }


            $tanggal = Carbon::parse(
                $item->waktu_pelaksanaan
            );


            // ==========================================
            // TAHUN LEBIH BESAR
            // ==========================================

            if ($tanggal->year > $hariIni->year) {

                $adaMenunggu = true;

                continue;
            }


            // ==========================================
            // TAHUN LEBIH KECIL
            // ==========================================

            if ($tanggal->year < $hariIni->year) {

                $adaTerlambat = true;

                continue;
            }


            // ==========================================
            // TAHUN SAMA
            // BANDINKAN BULAN
            // ==========================================

            if ($tanggal->month > $hariIni->month) {

                // Bulan berikutnya
                $adaMenunggu = true;

                continue;
            }


            if ($tanggal->month === $hariIni->month) {

                // Bulan sekarang
                $adaBerlangsung = true;

                continue;
            }


            // ==========================================
            // BULAN SUDAH LEWAT
            // ==========================================

            if ($tanggal->month < $hariIni->month) {

                $adaTerlambat = true;

                continue;
            }
        }


        // ==========================================
        // SEMUA SUDAH SELESAI
        // ==========================================

        if (!$adaBelumSelesai) {
            return 'selesai';
        }


        // ==========================================
        // KEGIATAN BERULANG
        // ==========================================

        if ($this->jumlah_pelaksanaan > 1) {

            // Ada minimal satu periode yang
            // bulannya sudah lewat
            if ($adaTerlambat) {
                return 'tindak_lanjut';
            }

            // Ada periode di bulan sekarang
            if ($adaBerlangsung) {
                return 'berlangsung';
            }

            // Semua periode berikutnya
            // masih belum masuk bulannya
            if ($adaMenunggu) {
                return 'menunggu';
            }

            return 'menunggu';
        }


        // ==========================================
        // KEGIATAN TIDAK BERULANG
        // ==========================================

        if ($adaTerlambat) {
            return 'terlambat';
        }

        if ($adaBerlangsung) {
            return 'berlangsung';
        }

        return 'menunggu';
    }

    public function pertanyaan()
    {
        return $this->belongsTo(
            PertanyaanLKE::class,
            'kode_pertanyaan',
            'id_pertanyaan'
        );
    }
}
