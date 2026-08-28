<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\PelaksanaanKegiatan;
use App\Models\PertanyaanLKE;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PelaksanaanKegiatanController extends Controller
{
    /**
     * Menampilkan seluruh pelaksanaan dari satu kegiatan.
     */
    public function index(Kegiatan $kegiatan)
    {
        $kegiatan->load([
            'pertanyaan',
            'pertanyaan.subpilar',
        ]);

        // Pastikan data pelaksanaan sudah dibuat
        $this->generatePelaksanaanData($kegiatan);

        $pelaksanaan = $kegiatan->pelaksanaan()
            ->orderBy('periode_ke', 'asc')
            ->get();

        return view(
            'detail-kegiatan',
            compact('kegiatan', 'pelaksanaan')
        );
    }

    private function generatePelaksanaanData(Kegiatan $kegiatan)
    {
        $jumlah = (int) $kegiatan->jumlah_pelaksanaan;

        if ($jumlah < 1) {
            return;
        }

        for ($i = 1; $i <= $jumlah; $i++) {

            $waktuPelaksanaan = $this->hitungWaktuPelaksanaan(
                $kegiatan,
                $i
            );

            $pelaksanaan = PelaksanaanKegiatan::firstOrCreate(
                [
                    'kegiatan_id' => $kegiatan->id,
                    'periode_ke' => $i,
                ],
                [
                    'waktu_pelaksanaan' => $waktuPelaksanaan,
                    'dokumentasi' => null,
                    'status_pelaksanaan' => 'menunggu',
                ]
            );

            $pelaksanaan->status_pelaksanaan =
                $pelaksanaan->tentukanStatusPelaksanaan();

            $pelaksanaan->save();
        }
    }

    /**
     * Membuat pelaksanaan berdasarkan
     * jumlah_pelaksanaan.
     */
    public function generatePelaksanaan(Kegiatan $kegiatan)
    {
        $jumlah = (int) $kegiatan->jumlah_pelaksanaan;

        if ($jumlah < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah pelaksanaan tidak valid.',
            ], 422);
        }

        $this->generatePelaksanaanData($kegiatan);

        return response()->json([
            'success' => true,
            'message' => 'Pelaksanaan kegiatan berhasil dibuat.',
        ]);
    }

    // public function generatePelaksanaan(Kegiatan $kegiatan)
    // {
    //     $jumlah = (int) $kegiatan->jumlah_pelaksanaan;

    //     if ($jumlah < 1) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Jumlah pelaksanaan tidak valid.',
    //         ], 422);
    //     }

    //     for ($i = 1; $i <= $jumlah; $i++) {

    //         $waktuPelaksanaan = $this->hitungWaktuPelaksanaan(
    //             $kegiatan,
    //             $i
    //         );

    //         $pelaksanaan = PelaksanaanKegiatan::firstOrCreate(
    //             [
    //                 'kegiatan_id' => $kegiatan->id,
    //                 'periode_ke' => $i,
    //             ],
    //             [
    //                 'waktu_pelaksanaan' => $waktuPelaksanaan,
    //                 'dokumentasi' => null,
    //                 'status_pelaksanaan' => 'menunggu',
    //             ]
    //         );

    //         $pelaksanaan->status_pelaksanaan =
    //             $pelaksanaan->tentukanStatusPelaksanaan();

    //         $pelaksanaan->save();
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Pelaksanaan kegiatan berhasil dibuat.',
    //     ]);
    // }


    /**
     * Menghitung waktu pelaksanaan berdasarkan:
     *
     * waktu_pemenuhan = tanggal awal
     * frekuensi_pelaksanaan = interval
     * periode_ke = urutan pelaksanaan
     */
    private function hitungWaktuPelaksanaan(
        Kegiatan $kegiatan,
        int $periodeKe
    ) {
        $waktuAwal = Carbon::parse(
            $kegiatan->waktu_pemenuhan
        );

        $frekuensi = strtolower(
            trim($kegiatan->frekuensi_pelaksanaan)
        );


        // Triwulan
        if (str_contains($frekuensi, 'triwulan')) {

            return $waktuAwal
                ->copy()
                ->addMonths(3 * ($periodeKe - 1))
                ->format('Y-m-d');
        }


        // Semester
        if (str_contains($frekuensi, 'semester')) {

            return $waktuAwal
                ->copy()
                ->addMonths(6 * ($periodeKe - 1))
                ->format('Y-m-d');
        }


        // Bulanan
        if (str_contains($frekuensi, 'bulan')) {

            return $waktuAwal
                ->copy()
                ->addMonths($periodeKe - 1)
                ->format('Y-m-d');
        }


        // Tahunan
        if (str_contains($frekuensi, 'tahun')) {

            return $waktuAwal
                ->copy()
                ->addYears($periodeKe - 1)
                ->format('Y-m-d');
        }


        // Jika tidak ada frekuensi yang dikenali,
        // gunakan tanggal awal.
        return $waktuAwal->format('Y-m-d');
    }


    /**
     * Update waktu pelaksanaan.
     *
     * Digunakan Tim Pilar untuk mengubah
     * jadwal periode tertentu.
     */
    public function updateWaktuPelaksanaan(
        Request $request,
        PelaksanaanKegiatan $pelaksanaanKegiatan
    ) {
        $validated = $request->validate([
            'waktu_pelaksanaan' => [
                'required',
                'date',
            ],
        ]);

        $pelaksanaanKegiatan->waktu_pelaksanaan =
            $validated['waktu_pelaksanaan'];

        $pelaksanaanKegiatan->status_pelaksanaan =
            $pelaksanaanKegiatan->tentukanStatusPelaksanaan();

        $pelaksanaanKegiatan->save();

        return response()->json([
            'success' => true,
            'message' => 'Tanggal pelaksanaan berhasil diperbarui.',
        ]);
    }



    /**
     * Update dokumentasi.
     *
     * Untuk sementara dokumentasi berupa link.
     * Upload Google Drive bisa kita integrasikan
     * pada tahap berikutnya.
     */
    // public function updateDokumentasi(
    //     Request $request,
    //     PelaksanaanKegiatan $pelaksanaanKegiatan
    // ) {
    //     $validated = $request->validate([
    //         'dokumentasi' => [
    //             'nullable',
    //             'string',
    //         ],
    //     ]);

    //     $pelaksanaanKegiatan->dokumentasi =
    //         $validated['dokumentasi'];

    //     $pelaksanaanKegiatan->status_pelaksanaan =
    //         $pelaksanaanKegiatan->tentukanStatusPelaksanaan();

    //     $pelaksanaanKegiatan->save();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Dokumentasi berhasil diperbarui.',
    //     ]);
    // }

    public function updateDokumentasi(
        Request $request,
        PelaksanaanKegiatan $pelaksanaanKegiatan
    ) {
        $validated = $request->validate([
            'dokumentasi' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $file = $validated['dokumentasi'];

        // Upload $file ke Google Drive
        // kemudian ambil URL Google Drive

        // contoh:
        // $url = $googleDriveService->upload($file);

        // $pelaksanaanKegiatan->dokumentasi = $url;

        // $pelaksanaanKegiatan->save();

        // ...
    }
}