<?php

namespace App\Services;

use App\Models\SubPilarLKE;
use App\Models\PertanyaanLKE;

class PenilaianLkeService
{
    public function hitungNilaiMandiri($subpilar, $pertanyaan)
    {
        return $subpilar->sum(function ($subpilarItem) use ($pertanyaan) {

            $nilaiAvg = $pertanyaan
                ->where(
                    'id_subpilar',
                    $subpilarItem->id_subpilar
                )
                ->map(
                    fn ($p) => $p->nilai_pertanyaan ?? 0
                )
                ->avg();

            return $nilaiAvg * ($subpilarItem->bobot ?? 0);
        });
    }

    public function hitungPerAspek(
        $subpilar,
        $pertanyaan,
        $aspek
    ) {
        return $subpilar
            ->where('nama_aspek', $aspek)
            ->sum(function ($subpilarItem) use ($pertanyaan) {

                $nilaiAvg = $pertanyaan
                    ->where(
                        'id_subpilar',
                        $subpilarItem->id_subpilar
                    )
                    ->map(
                        fn ($p) => $p->nilai_pertanyaan ?? 0
                    )
                    ->avg();

                return $nilaiAvg *
                    ($subpilarItem->bobot ?? 0);
            });
    }

    public function hitungNilaiPerPilar($subpilar, $pertanyaan)
    {
        return $subpilar
            ->groupBy('pilar')
            ->map(function ($subpilarsPilar, $kodePilar) use ($pertanyaan) {

                $nilaiPilar = 0;
                $bobotPilar = 0;
                $persentasePilar = 0;

                foreach ($subpilarsPilar as $subpilarItem) {

                    // Pertanyaan pada subpilar
                    $pertanyaanSubpilar = $pertanyaan
                        ->where('id_subpilar', $subpilarItem->id_subpilar);

                    // Rata-rata nilai pertanyaan
                    $nilaiAvg = $pertanyaanSubpilar
                        ->map(fn ($p) => $p->nilai_pertanyaan ?? 0)
                        ->avg();

                    // Nilai subpilar
                    $nilaiSubpilar = $nilaiAvg * ($subpilarItem->bobot ?? 0);

                    // Tambahkan ke Pilar
                    $nilaiPilar += $nilaiSubpilar;

                    // Jumlah bobot subpilar
                    $bobotPilar += ($subpilarItem->bobot ?? 0);

                    // Persentase nilai pilar
                    $persentasePilar = $nilaiPilar/$bobotPilar*100;
                }

                // Ambil aspek dan area dari subpilar pertama
                $firstSubpilar = $subpilarsPilar->first();

                return [
                    'pilar' => $kodePilar,
                    'aspek' => $firstSubpilar->nama_aspek ?? null,
                    'area' => $firstSubpilar->nama_area ?? null,
                    'bobot' => $bobotPilar,
                    'nilai' => $nilaiPilar,
                    'persentase' => $persentasePilar,
                ];
            })
            ->sortKeys() 
            ->values();
    }
}