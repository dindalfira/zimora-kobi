<?php

namespace App\Http\Controllers;

use App\Models\BuktiDukungLKE;
use App\Models\PertanyaanLKE;
use App\Models\RiwayatPenilaianLKE;
use App\Models\SubPilarLKE;
use App\Models\PelaksanaanKegiatan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
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

        $pertanyaanBelum = $statusPertanyaan->get('belum', 0);
        $pertanyaanPemeriksaan = $statusPertanyaan->get('pemeriksaan', 0);
        $pertanyaanPerbaikan = $statusPertanyaan->get('perbaikan', 0);
        $pertanyaanSesuai = $statusPertanyaan->get('sesuai', 0);
        $pertanyaanDinilai = $statusPertanyaan->get('dinilai', 0);
        $pertanyaanTerlambat = $statusPertanyaan->get('terlambat', 0);


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
        | NILAI MANDIRI
        |--------------------------------------------------------------------------
        */

        $periode = now()->year;

        $riwayatPenilaian = RiwayatPenilaianLKE::with('subpilar')
            ->where('periode', $periode)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | NILAI TOTAL
        |--------------------------------------------------------------------------
        */

        $nilaiTotal = $riwayatPenilaian->sum('bobot_mandiri');


        /*
        |--------------------------------------------------------------------------
        | NILAI ASPEK PENGUNGKIT
        |--------------------------------------------------------------------------
        */

        $nilaiPengungkit = $riwayatPenilaian
            ->filter(function ($item) {
                return optional($item->subpilar)->nama_aspek === 'Pengungkit';
            })
            ->sum('bobot_mandiri');


        /*
        |--------------------------------------------------------------------------
        | NILAI ASPEK HASIL
        |--------------------------------------------------------------------------
        */

        $nilaiHasil = $riwayatPenilaian
            ->filter(function ($item) {
                return optional($item->subpilar)->nama_aspek === 'Hasil';
            })
            ->sum('bobot_mandiri');


        $nilaiPengungkit = round($nilaiPengungkit, 2);
        $nilaiHasil = round($nilaiHasil, 2);
        $nilaiTotal = round($nilaiTotal, 2);

        /*
        |--------------------------------------------------------------------------
        | DATA BAR CHART PER PILAR
        |--------------------------------------------------------------------------
        */

        $subpilar = SubPilarLKE::where('aspek', 'A')->get();

        $pertanyaanLKE = PertanyaanLKE::get();

        $buktiDukungLKE = BuktiDukungLKE::get();

        $riwayatPenilaian = RiwayatPenilaianLKE::with('subpilar')
            ->where('periode', $periode)
            ->get();


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

        $nilaiPerPilar = [];

        $bobotPerPilar = [];


        foreach ($pilars as $pilar) {

            /*
            |--------------------------------------------------------------------------
            | SUBPILAR PADA PILAR
            |--------------------------------------------------------------------------
            */

            $idSubpilar = $subpilar
                ->where('pilar', $pilar)
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
            | Berdasarkan bukti dukung yang sudah memiliki link
            |--------------------------------------------------------------------------
            */

            $idPertanyaanPilar = $pertanyaanPilar
                ->pluck('id_pertanyaan');


            $buktiPilar = $buktiDukungLKE
                ->whereIn('id_pertanyaan', $idPertanyaanPilar);


            $totalBuktiPilar = $buktiPilar->count();

            $buktiTerisiPilar = $buktiPilar
                ->filter(function ($item) {
                    return !empty($item->link_bukti_dukung);
                })
                ->count();


            $pemenuhan = $totalBuktiPilar > 0
                ? ($buktiTerisiPilar / $totalBuktiPilar) * 100
                : 0;


            $pemenuhanPerPilar[] = round($pemenuhan, 2);


            /*
            |--------------------------------------------------------------------------
            | 2. KESESUAIAN
            |
            | Berdasarkan status pertanyaan = sesuai
            |--------------------------------------------------------------------------
            */

            $totalPertanyaanPilar = $pertanyaanPilar->count();

            $pertanyaanSesuaiPilar = $pertanyaanPilar
                ->where('status_pertanyaan', 'sesuai')
                ->count();


            $kesesuaian = $totalPertanyaanPilar > 0
                ? ($pertanyaanSesuaiPilar / $totalPertanyaanPilar) * 100
                : 0;


            $kesesuaianPerPilar[] = round($kesesuaian, 2);


            /*
            |--------------------------------------------------------------------------
            | 3. NILAI PER PILAR
            |
            | Nilai = jumlah bobot_mandiri subpilar
            | Bobot maksimal = jumlah bobot subpilar
            |--------------------------------------------------------------------------
            */

            $subpilarPilar = $subpilar
                ->where('pilar', $pilar);


            $bobotMaksimal = $subpilarPilar
                ->sum('bobot');


            $nilaiMandiriPilar = $riwayatPenilaian
                ->whereIn('id_subpilar', $idSubpilar)
                ->sum('bobot_mandiri');


            $persentaseNilaiPilar = $bobotMaksimal > 0
                ? ($nilaiMandiriPilar / $bobotMaksimal) * 100
                : 0;


            $nilaiPerPilar[] = round($persentaseNilaiPilar, 2);

            $bobotPerPilar[] = round($bobotMaksimal, 2);
        }

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

            'periode',

            // BAR CHART
            'pilars',
            'namapilars',
            'pemenuhanPerPilar',
            'kesesuaianPerPilar',
            'nilaiPerPilar',
            'bobotPerPilar',

            'statusKegiatan',
            'statusKegChart'
        ));
    }
}