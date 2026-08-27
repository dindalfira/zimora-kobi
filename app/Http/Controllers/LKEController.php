<?php

namespace App\Http\Controllers;

use App\Models\BuktiDukungLKE;
use App\Models\PemeriksaanLKE;
use App\Models\PertanyaanLKE;
use App\Models\RiwayatPenilaianLKE;
use App\Models\SubPilarLKE;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LkeController extends Controller
{
    public function index()
    {
        $subpilar = SubPilarLKE::query()
            ->orderBy('pilar')
            ->orderBy('subpilar')
            ->orderBy('id_subpilar')
            ->get();

        $pertanyaan = PertanyaanLKE::query()
            ->orderBy('id_subpilar')
            ->orderBy('id_pertanyaan')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS PERTANYAAN OTOMATIS
        |--------------------------------------------------------------------------
        */

        foreach ($pertanyaan as $item) {

            $statusBaru = $this->getStatusPertanyaan($item);

            if ($item->status_pertanyaan !== $statusBaru) {

                $item->update([
                    'status_pertanyaan' => $statusBaru,
                ]);

                // Pastikan object yang dikirim ke Blade
                // menggunakan status terbaru
                $item->status_pertanyaan = $statusBaru;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PERIODE PENILAIAN
        |--------------------------------------------------------------------------
        */

        $periode = now()->year;

        /*
        |--------------------------------------------------------------------------
        | TOTAL SELURUH BUKTI DUKUNG
        |--------------------------------------------------------------------------
        */

        $totalBuktiDukung = BuktiDukungLKE::count();

        /*
        |--------------------------------------------------------------------------
        | BUKTI DUKUNG YANG SUDAH TERISI
        |--------------------------------------------------------------------------
        */

        $buktiDukungTerisi = BuktiDukungLKE::whereNotNull(
            'link_bukti_dukung'
        )
            ->where(
                'link_bukti_dukung',
                '!=',
                ''
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | PROGRESS BUKTI DUKUNG
        |--------------------------------------------------------------------------
        */

        $progressBuktiDukung = $totalBuktiDukung > 0
            ? ($buktiDukungTerisi / $totalBuktiDukung) * 100
            : 0;

        /*
        |--------------------------------------------------------------------------
        | AMBIL SELURUH BUKTI DUKUNG
        |--------------------------------------------------------------------------
        */

        $buktiDukung = BuktiDukungLKE::get();

        /*
        |--------------------------------------------------------------------------
        | BUKTI DUKUNG PER PILAR
        |--------------------------------------------------------------------------
        */

        $buktiDukungPerPilar = $buktiDukung
            ->groupBy(function ($bukti) use ($pertanyaan) {

                $pertanyaanItem = $pertanyaan->firstWhere(
                    'id_pertanyaan',
                    $bukti->id_pertanyaan
                );

                return $pertanyaanItem?->subpilar?->pilar;
            })
            ->map(function ($items) {

                $total = $items->count();

                $terisi = $items->filter(function ($item) {
                    return !empty($item->link_bukti_dukung);
                })->count();

                return [
                    'total' => $total,
                    'terisi' => $terisi,
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | BUKTI DUKUNG PER PERTANYAAN
        |--------------------------------------------------------------------------
        */

        $buktiDukungPerPertanyaan = $buktiDukung
            ->groupBy('id_pertanyaan')
            ->map(function ($items) {

                $total = $items->count();

                $terisi = $items->filter(function ($item) {
                    return !empty($item->link_bukti_dukung);
                })->count();

                return [
                    'total' => $total,
                    'terisi' => $terisi,
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | RIWAYAT PENILAIAN PERIODE BERJALAN
        |--------------------------------------------------------------------------
        */

        $riwayatPenilaian = RiwayatPenilaianLKE::where(
            'periode',
            $periode
        )->get();

        $riwayatPerSubpilar = $riwayatPenilaian->keyBy(
            'id_subpilar'
        );

        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
        |--------------------------------------------------------------------------
        */

        return view('lke', compact(
            'subpilar',
            'pertanyaan',
            'periode',
            'riwayatPenilaian',
            'riwayatPerSubpilar',
            'totalBuktiDukung',
            'buktiDukungTerisi',
            'progressBuktiDukung',
            'buktiDukungPerPilar',
            'buktiDukungPerPertanyaan',
        ));
    }


    public function detail($id_pertanyaan)
    {
        $pertanyaan = PertanyaanLKE::with('subpilar')
            ->where(
                'id_pertanyaan',
                $id_pertanyaan
            )
            ->firstOrFail();

        $subpilar = $pertanyaan->subpilar;

        return view('detail-lke', compact(
            'pertanyaan',
            'subpilar',
        ));
    }


    public function simpanRiwayatPenilaian($periode)
    {
        $subpilar = SubPilarLKE::all();

        foreach ($subpilar as $item) {

            $pertanyaanSubpilar = PertanyaanLKE::where(
                'id_subpilar',
                $item->id_subpilar
            )->get();

            $nilaiMandiri = $pertanyaanSubpilar->avg(
                'nilai_pertanyaan'
            ) ?? 0;

            $bobot = $item->bobot ?? 0;

            $bobotMandiri = $nilaiMandiri * $bobot;

            RiwayatPenilaianLKE::updateOrCreate(
                [
                    'periode' => $periode,
                    'id_subpilar' => $item->id_subpilar,
                ],
                [
                    'nilai_mandiri' => $nilaiMandiri,
                    'bobot' => $bobot,
                    'bobot_mandiri' => $bobotMandiri,
                ]
            );
        }

        return redirect()
            ->back()
            ->with(
                'success',
                'Penilaian berhasil disimpan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | MENENTUKAN TANGGAL WAKTU
    |--------------------------------------------------------------------------
    */

    private function getTanggalWaktu($waktu)
    {
        if (empty($waktu)) {
            return [];
        }

        $waktu = strtolower(trim($waktu));

        $isNPlusOne = str_contains(
            $waktu,
            '(n+1)'
        );

        $tahun = now()->year
            + ($isNPlusOne ? 1 : 0);

        $periode = trim(
            str_replace(
                '(n+1)',
                '',
                $waktu
            )
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
            | SEMENTARA TETAP SEPERTI SEBELUMNYA
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


    /*
    |--------------------------------------------------------------------------
    | CEK KELENGKAPAN BUKTI DUKUNG
    |--------------------------------------------------------------------------
    */

    private function buktiDukungLengkap($pertanyaan)
    {
        $buktiDukung = BuktiDukungLKE::where(
            'id_pertanyaan',
            $pertanyaan->id_pertanyaan
        )->get();

        /*
        | Tidak punya bukti dukung
        | berarti belum lengkap
        */

        if ($buktiDukung->isEmpty()) {
            return false;
        }

        $total = $buktiDukung->count();

        $terisi = $buktiDukung->filter(
            function ($item) {

                return !empty(
                    $item->link_bukti_dukung
                );
            }
        )->count();

        return $terisi === $total;
    }


    /*
    |--------------------------------------------------------------------------
    | MENENTUKAN STATUS PERTANYAAN
    |--------------------------------------------------------------------------
    |
    | URUTAN:
    |
    | 1. PEMERIKSAAN SESUAI
    | 2. PEMERIKSAAN PERBAIKAN
    | 3. SUDAH DINILAI
    | 4. BUKTI DUKUNG LENGKAP
    | 5. TERLAMBAT
    | 6. BELUM
    |
    |--------------------------------------------------------------------------
    */

    private function getStatusPertanyaan($pertanyaan)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. CEK PEMERIKSAAN TERAKHIR
        |--------------------------------------------------------------------------
        */

        $pemeriksaan = PemeriksaanLKE::where(
            'pertanyaan_lke_id',
            $pertanyaan->id
        )
            ->latest('diperiksa_pada')
            ->first();

        if ($pemeriksaan) {

            /*
            | Pemeriksaan sesuai
            */

            if (
                $pemeriksaan->status_pemeriksaan
                === 'sesuai'
            ) {
                return 'sesuai';
            }

            /*
            | Pemeriksaan membutuhkan perbaikan
            */

            if (
                $pemeriksaan->status_pemeriksaan
                === 'perbaikan'
            ) {
                return 'perbaikan';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | 2. SUDAH DINILAI
        |--------------------------------------------------------------------------
        */

        if (
            !is_null(
                $pertanyaan->nilai_mandiri
            )
        ) {
            return 'dinilai';
        }


        /*
        |--------------------------------------------------------------------------
        | 3. BUKTI DUKUNG LENGKAP
        |--------------------------------------------------------------------------
        */

        if (
            $this->buktiDukungLengkap(
                $pertanyaan
            )
        ) {
            return 'pemeriksaan';
        }


        /*
        |--------------------------------------------------------------------------
        | 4. CEK KETERLAMBATAN
        |--------------------------------------------------------------------------
        */

        $tanggalWaktu = $this->getTanggalWaktu(
            $pertanyaan->waktu
        );

        if (!empty($tanggalWaktu)) {

            $tanggalSekarang = now()
                ->startOfDay();

            $tanggalTarget = $tanggalWaktu[0]
                ->copy()
                ->startOfDay();

            if (
                $tanggalSekarang->gt(
                    $tanggalTarget
                )
            ) {
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


    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS MANUAL
    |--------------------------------------------------------------------------
    |
    | Tidak wajib digunakan karena index()
    | sudah melakukan update otomatis.
    |
    |--------------------------------------------------------------------------
    */

    public function updateStatusPertanyaan()
    {
        $pertanyaan = PertanyaanLKE::all();

        foreach ($pertanyaan as $item) {

            $statusBaru = $this->getStatusPertanyaan(
                $item
            );

            if (
                $item->status_pertanyaan
                !== $statusBaru
            ) {

                $item->update([
                    'status_pertanyaan' => $statusBaru,
                ]);
            }
        }

        return back()->with(
            'success',
            'Status pertanyaan berhasil diperbarui.'
        );
    }
}