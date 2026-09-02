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
        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $aspek = $request->input('aspek');
        $area  = $request->input('area');
        $pilar = $request->input('pilar');

        /*
        |--------------------------------------------------------------------------
        | SUB PILAR
        |--------------------------------------------------------------------------
        */

        $subPilarQuery = SubPilarLKE::query()
            ->when($aspek, function ($query, $aspek) {
                $query->where('aspek', $aspek);
            })
            ->when($area, function ($query, $area) {
                $query->where('area', $area);
            })
            ->when($pilar, function ($query, $pilar) {
                $query->where('pilar', $pilar);
            });

        $subpilar = $subPilarQuery
            ->orderBy('pilar')
            ->orderBy('subpilar')
            ->orderBy('id_subpilar')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | ID SUBPILAR HASIL FILTER
        |--------------------------------------------------------------------------
        */

        $idSubPilar = $subpilar
            ->pluck('id_subpilar')
            ->filter()
            ->unique()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | DATA PERTANYAAN HASIL FILTER
        |--------------------------------------------------------------------------
        */

        $pertanyaan = PertanyaanLKE::with([
            'subpilar',
            'buktiDukung'
        ])
            ->whereIn('id_subpilar', $idSubPilar)
            ->orderBy('id_subpilar')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        $totalPertanyaan = $pertanyaan->count();

        $totalSubPilar = $subpilar->count();


        /*
        |--------------------------------------------------------------------------
        | STATUS PERTANYAAN
        |--------------------------------------------------------------------------
        |
        | PENTING:
        | Jangan menggunakan PertanyaanLKE::selectRaw() lagi karena
        | itu akan mengambil SEMUA pertanyaan dan mengabaikan filter.
        |
        */

        $statusPertanyaan = $pertanyaan
            ->groupBy('status_pertanyaan')
            ->map(function ($items) {
                return $items->count();
            });


        $pertanyaanBelum = (int) $statusPertanyaan->get('belum', 0);

        $pertanyaanPemeriksaan = (int)
            $statusPertanyaan->get('pemeriksaan', 0);

        $pertanyaanPerbaikan = (int)
            $statusPertanyaan->get('perbaikan', 0);

        $pertanyaanSesuai = (int)
            $statusPertanyaan->get('sesuai', 0);

        $pertanyaanDinilai = (int)
            $statusPertanyaan->get('dinilai', 0);

        $pertanyaanTerlambat = (int)
            $statusPertanyaan->get('terlambat', 0);


        /*
        |--------------------------------------------------------------------------
        | DATA BUKTI DUKUNG HASIL FILTER
        |--------------------------------------------------------------------------
        */

        $idPertanyaan = $pertanyaan
            ->pluck('id_pertanyaan')
            ->filter()
            ->unique()
            ->values();


        $buktiDukungLKE = BuktiDukungLKE::query()
            ->whereIn('id_pertanyaan', $idPertanyaan)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | TOTAL BUKTI DUKUNG
        |--------------------------------------------------------------------------
        */

        $totalBuktiDukung = $buktiDukungLKE->count();


        /*
        |--------------------------------------------------------------------------
        | BUKTI DUKUNG TERISI
        |--------------------------------------------------------------------------
        */

        $buktiDukungTerisi = $buktiDukungLKE
            ->filter(function ($bukti) {
                return !empty($bukti->link_bukti_dukung);
            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | BUKTI DUKUNG BELUM TERISI
        |--------------------------------------------------------------------------
        */

        $buktiDukungBelumTerisi =
            max(0, $totalBuktiDukung - $buktiDukungTerisi);


        /*
        |--------------------------------------------------------------------------
        | PERSENTASE BUKTI DUKUNG
        |--------------------------------------------------------------------------
        */

        $persentaseBuktiTerisi = $totalBuktiDukung > 0
            ? round(
                ($buktiDukungTerisi / $totalBuktiDukung) * 100,
                2
            )
            : 0;


        $persentaseBuktiBelumTerisi = $totalBuktiDukung > 0
            ? round(
                ($buktiDukungBelumTerisi / $totalBuktiDukung) * 100,
                2
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | NILAI MANDIRI
        |--------------------------------------------------------------------------
        |
        | Gunakan $subpilar dan $pertanyaan hasil filter.
        |
        */

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
        | NILAI PER PILAR
        |--------------------------------------------------------------------------
        */

        $nilaiPerPilar = $this->penilaianService
            ->hitungNilaiPerPilar(
                $subpilar,
                $pertanyaan
            );

        /*
        |--------------------------------------------------------------------------
        | STATUS KEGIATAN
        |--------------------------------------------------------------------------
        */

        $pelaksanaanQuery = PelaksanaanKegiatan::query()
            ->with('kegiatan');
       
        if ($pilar !== null && $pilar !== '') {
            $pelaksanaanQuery->whereHas('kegiatan', function ($query) use ($pilar) {
                $query->where('kegiatans.pilar', $pilar);
            });
        }

        $pelaksanaan = $pelaksanaanQuery->get();

        /*
        |--------------------------------------------------------------------------
        | DATA DONUT STATUS KEGIATAN
        |--------------------------------------------------------------------------
        */
        
        $statusKegiatan = [
            'menunggu'    => 0,
            'berlangsung' => 0,
            'selesai'     => 0,
            'terlambat'   => 0,
        ];

        foreach ($pelaksanaan as $item) {

            $status = strtolower(
                trim($item->status_aktual ?? '')
            );

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
        | DATA PILAR
        |--------------------------------------------------------------------------
        |
        | Hanya pilar yang masuk filter.
        |
        */

        $pilars = $pilar
            ? collect([(int) $pilar])
            : collect([1, 2, 3, 4, 5, 6]);

        $pilars = $pilars
            ->filter()
            ->unique()
            ->sort()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | NAMA PILAR UNTUK CHART
        |--------------------------------------------------------------------------
        */

        $namapilars = $pilars
            ->map(function ($pilar) {
                return 'Pilar ' . $pilar;
            })
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
        | LOOP SETIAP PILAR
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


            $idSubpilarPilar = $subpilarPilar
                ->pluck('id_subpilar')
                ->filter()
                ->values();


            /*
            |--------------------------------------------------------------------------
            | PERTANYAAN PADA PILAR
            |--------------------------------------------------------------------------
            */

            $pertanyaanPilar = $pertanyaan
                ->whereIn(
                    'id_subpilar',
                    $idSubpilarPilar
                );


            /*
            |--------------------------------------------------------------------------
            | PEMENUHAN
            |--------------------------------------------------------------------------
            |
            | Pertanyaan terpenuhi apabila:
            | 1. Memiliki bukti dukung
            | 2. Semua bukti dukung memiliki link
            |
            */

            $totalPertanyaanPilar =
                $pertanyaanPilar->count();


            $pertanyaanTerpenuhiPilar =
                $pertanyaanPilar
                    ->filter(function ($pertanyaanItem) use ($buktiDukungLKE) {

                        $bukti = $buktiDukungLKE
                            ->where(
                                'id_pertanyaan',
                                $pertanyaanItem->id_pertanyaan
                            );


                        // Tidak mempunyai bukti
                        if ($bukti->isEmpty()) {
                            return false;
                        }


                        // Semua bukti harus memiliki link
                        return $bukti->every(function ($item) {
                            return !empty(
                                $item->link_bukti_dukung
                            );
                        });
                    })
                    ->count();


            $pemenuhan = $totalPertanyaanPilar > 0
                ? (
                    $pertanyaanTerpenuhiPilar
                    / $totalPertanyaanPilar
                ) * 100
                : 0;


            $pemenuhanPerPilar[] =
                round($pemenuhan, 2);


            /*
            |--------------------------------------------------------------------------
            | KESESUAIAN
            |--------------------------------------------------------------------------
            |
            | Status sesuai + dinilai dianggap sesuai.
            |
            */

            $pertanyaanSesuaiPilar =
                $pertanyaanPilar
                    ->whereIn(
                        'status_pertanyaan',
                        [
                            'sesuai',
                            'dinilai'
                        ]
                    )
                    ->count();


            $kesesuaian = $totalPertanyaanPilar > 0
                ? (
                    $pertanyaanSesuaiPilar
                    / $totalPertanyaanPilar
                ) * 100
                : 0;


            $kesesuaianPerPilar[] =
                round($kesesuaian, 2);
        }

        /*
        |--------------------------------------------------------------------------
        | RETURN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(

            // Filter
            'aspek',
            'area',
            'pilar',

            // Data utama
            'subpilar',
            'pertanyaan',

            // Total
            'totalSubPilar',
            'totalPertanyaan',

            // Status pertanyaan
            'pertanyaanBelum',
            'pertanyaanPemeriksaan',
            'pertanyaanPerbaikan',
            'pertanyaanSesuai',
            'pertanyaanDinilai',
            'pertanyaanTerlambat',

            // Bukti dukung
            'totalBuktiDukung',
            'buktiDukungTerisi',
            'buktiDukungBelumTerisi',
            'persentaseBuktiTerisi',
            'persentaseBuktiBelumTerisi',

            // Nilai
            'nilaiTotal',
            'nilaiPengungkit',
            'nilaiHasil',
            'nilaiPerPilar',

            // Pilar
            'pilars',
            'namapilars',

            // Chart pemenuhan
            'pemenuhanPerPilar',
            'kesesuaianPerPilar',

            // Kegiatan
            'statusKegChart'
        ));
    }

}