<?php

namespace App\Http\Controllers;

use App\Models\BuktiDukungLKE;
use App\Models\Notification;
use App\Models\PelaksanaanKegiatan;
use App\Models\User;
use App\Services\PertanyaanLkeStatusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    protected PertanyaanLkeStatusService $statusService;

    public function __construct(PertanyaanLkeStatusService $statusService)
    {
        $this->statusService = $statusService;
    }
    public function uploadBuktiDukung(Request $request)
    {
        $request->validate([
            'id_bukti_dukung' => 'required|exists:bukti_dukung_lke,id_bukti_dukung',
            'file' => 'required|file|mimes:pdf|max:5120',
        ]);

        $bukti = BuktiDukungLKE::where(
            'id_bukti_dukung',
            $request->id_bukti_dukung
        )->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Hapus file lama jika ada
        |--------------------------------------------------------------------------
        */

        if ($bukti->link_bukti_dukung) {
            Storage::disk('public')->delete(
                $bukti->link_bukti_dukung
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan file baru
        |--------------------------------------------------------------------------
        */

        $file = $request->file('file');

        $namaFile = $bukti->id_bukti_dukung
                   . ' '
                   . $bukti->nama_bukti_dukung_singkat
                   . '.'
                   . $file->getClientOriginalExtension();

        $path = $file->storeAs(
            'bukti-dukung',
            $namaFile,
            'public'
        );


        /*
        |--------------------------------------------------------------------------
        | SIMPAN KE DATABASE
        |--------------------------------------------------------------------------
        */

        $isUpload = empty($bukti->time_updated);

        $updateData = [
            'link_bukti_dukung' => $path,
            'status_bukti_dukung' => 'sudah',
            'user_id' => Auth::user()->id,
            'time_updated' => now()
        ];

        if ($isUpload) {
            $updateData['time_uploaded'] = now();
        }

        $bukti->update($updateData);

        /*
        |--------------------------------------------------------------------------
        | CEK APAKAH SEMUA BUKTI DUKUNG PERTANYAAN SUDAH LENGKAP
        |--------------------------------------------------------------------------
        */

        $pertanyaan = $bukti->pertanyaan;

        if ($pertanyaan) {

            // Ambil semua bukti dukung untuk pertanyaan ini
            $semuaBukti = BuktiDukungLKE::where(
                'id_pertanyaan',
                $pertanyaan->id
            )->get();

            // Cek apakah SEMUA bukti sudah memiliki file
            $semuaLengkap = $semuaBukti->every(function ($item) {
                return !empty($item->link_bukti_dukung);
            });

            if ($semuaLengkap) {

                // update status
                 $status = $this->statusService->updateStatus($pertanyaan);

                /*
                |--------------------------------------------------------------------------
                | CEGAH NOTIFIKASI DUPLIKAT
                |--------------------------------------------------------------------------
                */

                $sudahAdaNotif = Notification::where(
                        'id_pertanyaan',
                        $pertanyaan->id_pertanyaan
                    )
                    ->where(
                        'tipe',
                        'bukti_lengkap'
                    )
                    ->exists();

                if (!$sudahAdaNotif) {

                    /*
                    |--------------------------------------------------------------------------
                    | KIRIM NOTIFIKASI KE PEMERIKSA
                    |--------------------------------------------------------------------------
                    */

                    $pemeriksa = User::where(
                        'role',
                        'sekretaris'
                    )->get();

                    foreach ($pemeriksa as $user) {

                        Notification::create([
                            'user_id' => $user->id,

                            'tipe' => 'bukti_lengkap',

                            'judul' => 'Bukti Dukung Lengkap',

                            'pesan' => 'Seluruh bukti dukung untuk pertanyaan "' .
                                ($pertanyaan->id_pertanyaan ?? "") . " " .
                                ($pertanyaan->nama_pertanyaan ?? 'Pertanyaan LKE') .
                                '" telah diunggah dan siap diperiksa.',

                            'id_pilar' => $pertanyaan->subPilar->pilar ?? null,

                            'id_pertanyaan' => $pertanyaan->id,

                            'url' => route('lke.detail', $pertanyaan->id_pertanyaan,
                            ),

                            'dibaca' => false,

                            'dibaca_at' => null,
                        ]);
                    }
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Response AJAX
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'message' => 'File berhasil diupload.',
            'id_bukti_dukung' => $bukti->id_bukti_dukung,
            'file_name' => $namaFile,
            'file_url' => asset('storage/' . $bukti->link_bukti_dukung),
            'time_uploaded' => $bukti->time_uploaded,
            'time_updated' => $bukti->time_updated,
            'isUpload' => $isUpload,
            'status' => $status,
        ]);
    }
    // public function uploadBuktiDukung(Request $request)
    // {
    //     $request->validate([
    //         'id' => 'required|exists:bukti_dukung,id',
    //         'file' => [
    //             'required',
    //             'file',
    //             'max:5120',
    //             'mimes:pdf',
    //         ],
    //     ]);

    //     $bukti = BuktiDukungLKE::findOrFail($request->id);

    //     $file = $request->file('file');

    //     // Hapus file lama jika ada
    //     if ($bukti->link_bukti_dukung) {
    //         Storage::disk('public')->delete(
    //             $bukti->link_bukti_dukung
    //         );
    //     }

    //     $namaFile = $bukti->id_bukti_dukung
    //         . ' '
    //         . $bukti->nama_bukti_dukung_singkat
    //         . '.'
    //         . $file->getClientOriginalExtension();

    //     // Simpan file
    //     $path = $file->storeAs(
    //         'bukti_dukung/' . $bukti->id_pertanyaan,
    //         $namaFile,
    //         'public'
    //     );

    //     // Simpan path ke database
    //     $bukti->update([
    //         'status' => 'sudah',
    //         'link_bukti_dukung' => $path,
    //     ]);

    //     return back()->with(
    //         'success',
    //         'Bukti dukung berhasil diupload.'
    //     );
    // }


    /**
     * Hapus bukti dukung
     */
    // public function delete($id)
    // {
    //     $bukti = BuktiDukungLKE::findOrFail($id);

    //     // Hapus file dari storage
    //     if ($bukti->link_bukti_dukung) {
    //         Storage::disk('public')->delete(
    //             $bukti->link_bukti_dukung
    //         );
    //     }

    //     // Kosongkan data file
    //     $bukti->update([
    //         'nama_bukti_dukung' => null,
    //         'status' => 'Belum',
    //         'link_bukti_dukung' => null,
    //     ]);

    //     return back()->with(
    //         'success',
    //         'Bukti dukung berhasil dihapus.'
    //     );
    // }

    public function uploadDokumentasi(Request $request, $id)
    {
        $request->validate([
            'dokumentasi' => [
                'required',
                'file',
                'max:5120',
                'mimes:pdf,jpg,jpeg,png',
            ],
        ]);

        $pelaksanaan = PelaksanaanKegiatan::with('kegiatan')
                                            ->findOrFail($id);

        $file = $request->file('dokumentasi');


        // Hapus dokumentasi lama jika ada
        if ($pelaksanaan->dokumentasi) {
            Storage::disk('public')->delete(
                $pelaksanaan->dokumentasi
            );
        }

        $namaKegiatan = $pelaksanaan->kegiatan->nama_kegiatan;

        // Nama file dokumentasi
        $namaFile = $namaKegiatan
            . ' Periode '
            . $pelaksanaan->periode_ke
            . '.'
            . $file->getClientOriginalExtension();

        // Simpan file
        $path = $file->storeAs(
            'dokumentasi_kegiatan/' . $pelaksanaan->kegiatan_id,
            $namaFile,
            'public'
        );

        // Simpan path ke database
        $pelaksanaan->update([
            'dokumentasi' => $path,
            'status_pelaksanaan' => 'selesai',
            'time_updated' => now(),
        ]);

        return back()->with([
            'success' => 'Dokumentasi kegiatan berhasil diupload.',
            'time_updated' => $pelaksanaan->time_updated,
        ]);
    }

    public function downloadBuktiDukung($id)
    {
        $bukti = BuktiDukungLKE::findOrFail($id);

        if (!$bukti->link_bukti_dukung) {
            abort(404, 'File tidak ditemukan.');
        }

        $path = storage_path(
            'app/public/' . $bukti->link_bukti_dukung
        );

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan di storage.');
        }

        return response()->download(
            $path,
            basename($path)
        );
    }

    public function downloadDokumentasi($id)
    {
        $pelaksanaan = PelaksanaanKegiatan::findOrFail($id);

        if (!$pelaksanaan->dokumentasi) {
            abort(404, 'Dokumentasi tidak ditemukan.');
        }

        $path = storage_path(
            'app/public/' . $pelaksanaan->dokumentasi
        );

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan di storage.');
        }

        return response()->download(
            $path,
            basename($path)
        );
    }

    public function deleteBuktiDukung($id)
    {
        $bukti = BuktiDukungLKE::findOrFail($id);

        if (!$bukti->link_bukti_dukung) {
            return back()->with('error', 'Bukti Dukung tidak ditemukan.');
        }

        // Hapus file dari storage
        if (Storage::disk('public')->exists($bukti->link_bukti_dukung)) {
            Storage::disk('public')->delete($bukti->link_bukti_dukung);
        }

        // Kosongkan kolom link_bukti_dukung di database
        $bukti->update([
            'link_bukti_dukung' => null,
            'status_bukti_dukung' => 'belum',
            'user_id' => null,
            'time_updated' => null,
        ]);

        return back()->with('success', 'Bukti Dukung berhasil dihapus.');
    }

    public function deleteDokumentasi($id)
    {
        $pelaksanaan = PelaksanaanKegiatan::findOrFail($id);

        if (!$pelaksanaan->dokumentasi) {
            return back()->with('error', 'Dokumentasi tidak ditemukan.');
        }

        // Hapus file dari storage
        if (Storage::disk('public')->exists($pelaksanaan->dokumentasi)) {
            Storage::disk('public')->delete($pelaksanaan->dokumentasi);
        }

        // Kosongkan kolom dokumentasi di database
        $pelaksanaan->update([
            'dokumentasi' => null,
            'time_updated' => null,
        ]);

        return back()->with('success', 'Dokumentasi berhasil dihapus.');
    }

}
