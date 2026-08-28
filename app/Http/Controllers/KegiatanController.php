<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $kegiatan = $this->getKegiatan($request);

        return view('monitoring-kegiatan', compact('kegiatan'));
    }


    public function data(Request $request)
    {
        $kegiatan = $this->getKegiatan($request);

        return response()->json([
            'html' => view(
                'kegiatan.partials.table',
                compact('kegiatan')
            )->render(),

            'pagination' => view(
                'kegiatan.partials.pagination',
                compact('kegiatan')
            )->render(),

            'total' => $kegiatan->total(),

            'firstItem' => $kegiatan->firstItem(),

            'lastItem' => $kegiatan->lastItem(),
        ]);
    }


    private function getKegiatan(Request $request)
    {
        $query = Kegiatan::with('pelaksanaan');

        // =========================
        // SEARCH
        // =========================

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_kegiatan', 'like', "%{$search}%")
                ->orWhere('kode_pertanyaan', 'like', "%{$search}%");
            });
        }


        // =========================
        // FILTER PILAR
        // =========================

        if ($request->filled('pilar')) {
            $query->where('pilar', $request->pilar);
        }


        // =========================
        // FILTER STATUS
        // =========================

        if ($request->filled('status')) {

            $status = $request->status;


            // =========================
            // TINDAK LANJUT
            // =========================
            // Kegiatan berulang
            // dan minimal satu pelaksanaan terlambat.
            //
            // PRIORITAS TERTINGGI
            // =========================

            if ($status === 'tindak_lanjut') {

                $query
                    ->where('jumlah_pelaksanaan', '>', 1)
                    ->whereHas('pelaksanaan', function ($q) {
                        $q->where('status_pelaksanaan', 'terlambat');
                    });

            }


            // =========================
            // BERLANGSUNG
            // =========================
            // Ada minimal satu pelaksanaan
            // berlangsung.
            //
            // Tetapi TIDAK boleh ada yang terlambat,
            // karena jika ada terlambat maka
            // statusnya Tindak Lanjut.
            // =========================

            elseif ($status === 'berlangsung') {

                $query
                    ->whereHas('pelaksanaan', function ($q) {
                        $q->where(
                            'status_pelaksanaan',
                            'berlangsung'
                        );
                    })
                    ->whereDoesntHave('pelaksanaan', function ($q) {
                        $q->where(
                            'status_pelaksanaan',
                            'terlambat'
                        );
                    });

            }


            // =========================
            // TERLAMBAT
            // =========================
            // HANYA untuk kegiatan satu kali.
            //
            // Kalau berulang + ada terlambat
            // → Tindak Lanjut.
            // =========================

            elseif ($status === 'terlambat') {

                $query
                    ->where('jumlah_pelaksanaan', '<=', 1)
                    ->whereHas('pelaksanaan', function ($q) {
                        $q->where(
                            'status_pelaksanaan',
                            'terlambat'
                        );
                    });

            }


            // =========================
            // SELESAI
            // =========================
            // Semua pelaksanaan selesai.
            // =========================

            elseif ($status === 'selesai') {

                $query
                    ->whereHas('pelaksanaan')
                    ->whereDoesntHave('pelaksanaan', function ($q) {
                        $q->where(function ($q) {

                            $q->whereNull('status_pelaksanaan')
                            ->orWhere(
                                'status_pelaksanaan',
                                '!=',
                                'selesai'
                            );

                        });
                    });

            }


            // =========================
            // MENUNGGU
            // =========================
            // Semua pelaksanaan masih menunggu.
            // =========================

            elseif ($status === 'menunggu') {

                $query
                    ->whereHas('pelaksanaan')
                    ->whereDoesntHave('pelaksanaan', function ($q) {

                        $q->where(function ($q) {

                            $q->whereNull('status_pelaksanaan')
                            ->orWhere(
                                'status_pelaksanaan',
                                '!=',
                                'menunggu'
                            );

                        });

                    });

            }
        }


        // =========================
        // FILTER BULAN
        // =========================

        if ($request->filled('bulan')) {

            $bulan = $request->bulan;

            $query->whereHas('pelaksanaan', function ($q) use ($bulan) {

                $q->whereMonth(
                    'waktu_pelaksanaan',
                    $bulan
                );

            });
        }


        // =========================
        // PAGINATION
        // =========================

        $perPage = (int) $request->input('per_page', 10);

        if (!in_array($perPage, [10, 25, 50])) {
            $perPage = 10;
        }


        // =========================
        // SORTING
        // =========================

        return $query
            ->orderBy('waktu_pemenuhan', 'asc')
            ->paginate($perPage)
            ->withQueryString();
    }

    private function getPelaksanaanAktif($kegiatan)
    {
        $bulanSekarang = Carbon::today()->startOfMonth();

        // ==========================================
        // KEGIATAN TIDAK BERULANG
        // ==========================================

        if ($kegiatan->jumlah_pelaksanaan <= 1) {
            return $kegiatan->pelaksanaan->first();
        }


        // ==========================================
        // KEGIATAN BERULANG
        // ==========================================

        // 1. Cari periode bulan sekarang
        $pelaksanaanSekarang = $kegiatan->pelaksanaan
            ->filter(function ($item) use ($bulanSekarang) {

                if (!$item->waktu_pelaksanaan) {
                    return false;
                }

                return Carbon::parse($item->waktu_pelaksanaan)
                    ->startOfMonth()
                    ->equalTo($bulanSekarang);
            })
            ->sortBy('waktu_pelaksanaan')
            ->first();

        if ($pelaksanaanSekarang) {
            return $pelaksanaanSekarang;
        }


        // 2. Kalau tidak ada bulan sekarang,
        // ambil periode terdekat setelah bulan sekarang

        $berikutnya = $kegiatan->pelaksanaan
            ->filter(function ($item) use ($bulanSekarang) {

                if (!$item->waktu_pelaksanaan) {
                    return false;
                }

                return Carbon::parse($item->waktu_pelaksanaan)
                    ->startOfMonth()
                    ->greaterThan($bulanSekarang);
            })
            ->sortBy('waktu_pelaksanaan')
            ->first();

        if ($berikutnya) {
            return $berikutnya;
        }


        // 3. Kalau semua sudah lewat,
        // ambil periode terakhir

        return $kegiatan->pelaksanaan
            ->filter(fn ($item) => $item->waktu_pelaksanaan)
            ->sortByDesc('waktu_pelaksanaan')
            ->first();
    }


    public function updateStatus(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'status_pelaksanaan' => 'required',
        ]);

        $kegiatan->update([
            'status_pelaksanaan' => $request->status_pelaksanaan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui.',
        ]);
    }

    public function show(Kegiatan $kegiatan)
    {
        $kegiatan->load([
            'pelaksanaan' => function ($query) {
                $query->orderBy('periode_ke', 'asc');
            }
        ]);

        return view(
            'detail-kegiatan',
            compact('kegiatan')
        );
    }
}