<?php

namespace App\Http\Controllers;

use App\Models\BuktiDukungLKE;
use App\Models\PertanyaanLKE;
use App\Models\RiwayatPenilaianLKE;
use App\Models\SubPilarLKE;
use App\Models\PelaksanaanKegiatan;
use App\Services\PenilaianLKEService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $penilaianService;

    public function __construct(
        PenilaianLKEService $penilaianService
    ) {
        $this->penilaianService = $penilaianService;
    }

    public function index(Request $request)
    {
        // nilai
        $subpilar = SubPilarLKE::get();

        $pertanyaan = PertanyaanLKE::get();

        $nilaiTotal = $this->penilaianService
            ->hitungNilaiMandiri(
                $subpilar,
                $pertanyaan
            );

        $nilaiPengungkit = $this->penilaianService
            ->hitungPerAspek(
                $subpilar,
                $pertanyaan,
                'PENGUNGKIT'
            );

        $nilaiHasil = $this->penilaianService
            ->hitungPerAspek(
                $subpilar,
                $pertanyaan,
                'HASIL'
            );

         /*
        |--------------------------------------------------------------------------
        | DATA BOBOT NILAI PILAR
        |--------------------------------------------------------------------------
        */
        $nilaiPerPilar = $this->penilaianService
            ->hitungNilaiPerPilar(
                $subpilar,
                $pertanyaan
            );

        /*
        |--------------------------------------------------------------------------
        | DATA PERTANYAAN LKE
        |--------------------------------------------------------------------------
        */

        $totalPertanyaan = PertanyaanLKE::count();

        $statusPertanyaan = PertanyaanLKE::selectRaw(
            'status_pertanyaan, COUNT(*) as total'
        )
            ->groupBy('status_pertanyaan')
            ->pluck('total', 'status_pertanyaan');
       


        /*
        |--------------------------------------------------------------------------
        | DATA BUKTI DUKUNG
        |--------------------------------------------------------------------------
        */

        $totalBuktiDukung = BuktiDukungLKE::count();

        $buktiDukungTerisi = BuktiDukungLKE::whereNotNull(
            'link_bukti_dukung'
        )
            ->where('link_bukti_dukung', '!=', '')
            ->count();

        $buktiDukungBelumTerisi =
            $totalBuktiDukung - $buktiDukungTerisi;

        $persentaseBuktiTerisi = $totalBuktiDukung > 0
            ? round(($buktiDukungTerisi / $totalBuktiDukung) * 100, 2)
            : 0;

        $persentaseBuktiBelumTerisi = $totalBuktiDukung > 0
            ? round(($buktiDukungBelumTerisi / $totalBuktiDukung) * 100, 2)
            : 0;


        /*
        |--------------------------------------------------------------------------
        | DATA SUBPILAR
        |--------------------------------------------------------------------------
        */

        $totalSubPilar = SubPilarLKE::count();


        /*
        |--------------------------------------------------------------------------
        | DATA BAR CHART PER PILAR
        |--------------------------------------------------------------------------
        */

        $subpilar = SubPilarLKE::where('aspek', 'A')->get();

        $pertanyaanLKE = PertanyaanLKE::get();

        $buktiDukungLKE = BuktiDukungLKE::get();

        // $riwayatPenilaian = RiwayatPenilaianLKE::with('subpilar')
        //     ->where('periode', $periode)
        //     ->get();


        /*
        |--------------------------------------------------------------------------
        | PILAR
        |--------------------------------------------------------------------------
        */

        $pilars = $subpilar
            ->pluck('pilar')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $namapilars = $pilars
            ->map(fn ($pilars) => 'Pilar ' . $pilars)
            ->values();


        /*
        |--------------------------------------------------------------------------
        | DATA PEMENUHAN & KESESUAIAN
        |--------------------------------------------------------------------------
        */

        $pemenuhanPerPilar = [];

        $kesesuaianPerPilar = [];


        /*
        |--------------------------------------------------------------------------
        | DATA NILAI PER PILAR
        |--------------------------------------------------------------------------
        */


        foreach ($pilars as $pilar) {

            /*
            |--------------------------------------------------------------------------
            | SUBPILAR PADA PILAR
            |--------------------------------------------------------------------------
            */

            $subpilarPilar = $subpilar
                ->where('pilar', $pilar);

            $idSubpilar = $subpilarPilar
                ->pluck('id_subpilar');
                


            /*
            |--------------------------------------------------------------------------
            | PERTANYAAN PADA PILAR
            |--------------------------------------------------------------------------
            */

            $pertanyaanPilar = $pertanyaanLKE
                ->whereIn('id_subpilar', $idSubpilar);


            /*
            |--------------------------------------------------------------------------
            | 1. PEMENUHAN
            |
            | Pertanyaan dianggap terpenuhi jika SEMUA bukti dukungnya
            | sudah memiliki link.
            |--------------------------------------------------------------------------
            */

            $totalPertanyaanPilar = $pertanyaanPilar->count();

            $pertanyaanTerpenuhiPilar = $pertanyaanPilar
                ->filter(function ($pertanyaan) use ($buktiDukungLKE) {

                    $bukti = $buktiDukungLKE
                        ->where(
                            'id_pertanyaan',
                            $pertanyaan->id_pertanyaan
                        );

                    // Tidak punya bukti dukung = belum terpenuhi
                    if ($bukti->isEmpty()) {
                        return false;
                    }

                    // Semua bukti harus sudah terisi
                    return $bukti->every(function ($item) {
                        return !empty($item->link_bukti_dukung);
                    });
                })
                ->count();

            $pemenuhan = $totalPertanyaanPilar > 0
                ? ($pertanyaanTerpenuhiPilar / $totalPertanyaanPilar) * 100
                : 0;

            $pemenuhanPerPilar[] = round($pemenuhan, 2);


            /*
            |--------------------------------------------------------------------------
            | 2. KESESUAIAN
            |
            | Pertanyaan dengan status sesuai atau dinilai.
            |--------------------------------------------------------------------------
            */

            $pertanyaanSesuaiPilar = $pertanyaanPilar
                ->whereIn(
                    'status_pertanyaan',
                    ['sesuai', 'dinilai']
                )
                ->count();

            $kesesuaian = $totalPertanyaanPilar > 0
                ? ($pertanyaanSesuaiPilar / $totalPertanyaanPilar) * 100
                : 0;

            $kesesuaianPerPilar[] = round($kesesuaian, 2);

        }


        $pertanyaanBelum = (int) $statusPertanyaan->get('belum', 0);
        $pertanyaanPemeriksaan = (int) $statusPertanyaan->get('pemeriksaan', 0);
        $pertanyaanPerbaikan = (int) $statusPertanyaan->get('perbaikan', 0);
        $pertanyaanSesuai = (int) $statusPertanyaan->get('sesuai', 0);
        $pertanyaanDinilai = (int) $statusPertanyaan->get('dinilai', 0);
        $pertanyaanTerlambat = (int) $statusPertanyaan->get('terlambat', 0);


        

        // status kegiatan
        $pelaksanaan = PelaksanaanKegiatan::all();

        $statusKegiatan = [
            'menunggu' => 0,
            'berlangsung' => 0,
            'selesai' => 0,
            'terlambat' => 0,
        ];

        foreach ($pelaksanaan as $item) {
            $status = strtolower($item->status_aktual);

            if (isset($statusKegiatan[$status])) {
                $statusKegiatan[$status]++;
            }
        }

        $statusKegChart = [
        $statusKegiatan['menunggu'],
        $statusKegiatan['berlangsung'],
        $statusKegiatan['selesai'],
        $statusKegiatan['terlambat'],
    ];

        /*
        |--------------------------------------------------------------------------
        | RETURN DASHBOARD
        |--------------------------------------------------------------------------
        */


        return view('dashboard', compact(

            'totalPertanyaan',

            'pertanyaanBelum',
            'pertanyaanPemeriksaan',
            'pertanyaanPerbaikan',
            'pertanyaanSesuai',
            'pertanyaanDinilai',
            'pertanyaanTerlambat',

            'totalBuktiDukung',
            'buktiDukungTerisi',
            'buktiDukungBelumTerisi',
            'persentaseBuktiTerisi',
            'persentaseBuktiBelumTerisi',

            'totalSubPilar',

            'nilaiTotal',
            'nilaiPengungkit',
            'nilaiHasil',
            'nilaiPerPilar',

            // 'periode',

            // BAR CHART
            'pilars',
            'namapilars',
            'pemenuhanPerPilar',
            'kesesuaianPerPilar',
            // 'nilaiPerPilar',
            // 'bobotPerPilar',

            'statusKegiatan',
            'statusKegChart'
        ));
    }
}