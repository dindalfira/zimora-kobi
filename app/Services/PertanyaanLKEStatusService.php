<?php

namespace App\Services;

use App\Models\BuktiDukungLKE;
use App\Models\PemeriksaanLKE;
use App\Models\PertanyaanLKE;
use Carbon\Carbon;

class PertanyaanLkeStatusService
{
    /**
     * Menentukan status satu pertanyaan.
     */
    public function getStatus(PertanyaanLKE $pertanyaan): string
    {
        /*
        |--------------------------------------------------------------------------
        | 1. SUDAH DINILAI
        |--------------------------------------------------------------------------
        */

        if (!is_null($pertanyaan->nilai_mandiri)) {
            return 'dinilai';
        }


        /*
        |--------------------------------------------------------------------------
        | 2. CEK PEMERIKSAAN TERAKHIR
        |--------------------------------------------------------------------------
        */

        $pemeriksaan = PemeriksaanLKE::where(
            'pertanyaan_lke_id',
            $pertanyaan->id
        )
        ->latest('diperiksa_pada')
        ->first();

        if ($pemeriksaan) {

            if ($pemeriksaan->status_pemeriksaan === 'sesuai') {
                return 'sesuai';
            }

            if ($pemeriksaan->status_pemeriksaan === 'perbaikan') {
                return 'perbaikan';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | 3. CEK BUKTI DUKUNG
        |--------------------------------------------------------------------------
        */

        if ($this->buktiDukungLengkap($pertanyaan)) {
            return 'pemeriksaan';
        }


        /*
        |--------------------------------------------------------------------------
        | 4. CEK TERLAMBAT
        |--------------------------------------------------------------------------
        */

        $tanggalWaktu = $this->getTanggalWaktu(
            $pertanyaan->waktu
        );

        if (!empty($tanggalWaktu)) {

            $tanggalSekarang = now()->startOfDay();

            $tanggalTarget = $tanggalWaktu[0];

            if ($tanggalSekarang->gt($tanggalTarget)) {
                return 'terlambat';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | 5. DEFAULT
        |--------------------------------------------------------------------------
        */

        return 'belum';
    }


    /**
     * Update status satu pertanyaan ke database.
     */
    public function updateStatus(PertanyaanLKE $pertanyaan): string
    {
        $statusBaru = $this->getStatus($pertanyaan);

        if ($pertanyaan->status_pertanyaan !== $statusBaru) {

            $pertanyaan->update([
                'status_pertanyaan' => $statusBaru,
            ]);
        }

        return $statusBaru;
    }


    /**
     * Update seluruh status pertanyaan.
     */
    public function updateAllStatus(): void
    {
        PertanyaanLKE::query()
            ->get()
            ->each(function ($pertanyaan) {

                $this->updateStatus($pertanyaan);
            });
    }


    /**
     * Cek kelengkapan bukti dukung.
     */
    private function buktiDukungLengkap(
        PertanyaanLKE $pertanyaan
    ): bool {

        $buktiDukung = BuktiDukungLKE::where(
            'id_pertanyaan',
            $pertanyaan->id_pertanyaan
        )->get();

        /*
        |--------------------------------------------------------------------------
        | Tidak ada bukti dukung
        |--------------------------------------------------------------------------
        */

        if ($buktiDukung->isEmpty()) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Hitung total dan yang terisi
        |--------------------------------------------------------------------------
        */

        $total = $buktiDukung->count();

        $terisi = $buktiDukung->filter(function ($item) {

            return !empty($item->link_bukti_dukung);

        })->count();

        return $terisi === $total;
    }


    /**
     * Menentukan tanggal berdasarkan kolom waktu.
     */
    private function getTanggalWaktu($waktu): array
    {
        if (empty($waktu)) {
            return [];
        }

        $waktu = strtolower(trim($waktu));

        /*
        |--------------------------------------------------------------------------
        | N+1
        |--------------------------------------------------------------------------
        */

        $isNPlusOne = str_contains(
            $waktu,
            '(n+1)'
        );

        $tahun = now()->year
            + ($isNPlusOne ? 1 : 0);

        /*
        |--------------------------------------------------------------------------
        | Bersihkan N+1
        |--------------------------------------------------------------------------
        */

        $periode = trim(
            str_replace('(n+1)', '', $waktu)
        );

        return match ($periode) {

            'triwulan i' => [
                Carbon::create(
                    $tahun,
                    1,
                    31
                )
            ],

            'triwulan ii' => [
                Carbon::create(
                    $tahun,
                    4,
                    30
                )
            ],

            'triwulan iii' => [
                Carbon::create(
                    $tahun,
                    7,
                    31
                )
            ],

            'triwulan iv' => [
                Carbon::create(
                    $tahun,
                    10,
                    31
                )
            ],

            /*
            |--------------------------------------------------------------------------
            | Sementara tetap seperti sebelumnya
            |--------------------------------------------------------------------------
            */

            'triwulan i-iv' => [
                Carbon::create(
                    $tahun,
                    12,
                    15
                )
            ],

            'triwulan ii-iv' => [
                Carbon::create(
                    $tahun,
                    12,
                    15
                )
            ],

            'triwulan i/ii/iii/iv' => [
                Carbon::create(
                    $tahun,
                    12,
                    15
                )
            ],

            'triwulan iv atau triwulan i' => [
                Carbon::create(
                    $tahun,
                    1,
                    31
                )
            ],

            default => [],
        };
    }
}