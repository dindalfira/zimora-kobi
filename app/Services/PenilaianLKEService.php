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
}