<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
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
            // dan minimal satu pelaksanaan
            // terlambat.

            if ($status === 'tindak_lanjut') {

                $query->where('jumlah_pelaksanaan', '>', 1)
                    ->whereHas('pelaksanaan', function ($q) {

                        $q->where(
                            'status_pelaksanaan',
                            'terlambat'
                        );

                    });

            }

            // =========================
            // BERLANGSUNG
            // =========================
            // Ada pelaksanaan berlangsung
            // DAN tidak ada pelaksanaan terlambat.
            //
            // Tindak lanjut punya prioritas
            // lebih tinggi.

            elseif ($status === 'berlangsung') {

                $query->whereHas('pelaksanaan', function ($q) {

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
            // Kegiatan satu kali
            // dan pelaksanaannya terlambat.

            elseif ($status === 'terlambat') {

                $query->where('jumlah_pelaksanaan', '<=', 1)
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
            // Semua pelaksanaan sudah selesai.

            elseif ($status === 'selesai') {

                $query->whereHas('pelaksanaan')
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

            elseif ($status === 'menunggu') {

                $query->whereHas('pelaksanaan')
                    ->whereDoesntHave('pelaksanaan', function ($q) {

                        $q->whereIn('status_pelaksanaan', [
                            'status_pelaksanaan',
                            '!=',
                            'menunggu',
                        ]);

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
                    'waktu_pemenuhan',
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