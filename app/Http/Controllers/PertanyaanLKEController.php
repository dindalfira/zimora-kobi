<?php

namespace App\Http\Controllers;

use App\Models\BuktiDukungLKE;
use App\Models\Notification;
use App\Models\PemeriksaanLKE;
use App\Models\PertanyaanLKE;
use App\Models\RiwayatPenilaianLKE;
use App\Models\SubPilarLKE;
use App\Models\User;
use App\Services\PertanyaanLkeStatusService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PertanyaanLKEController extends Controller
{
    protected PertanyaanLkeStatusService $statusService;

    public function __construct(PertanyaanLkeStatusService $statusService)
    {
        $this->statusService = $statusService;
    }
    public function index()
    {
        $pertanyaan = PertanyaanLKE::with('subPilar','buktiDukung')
            ->orderBy('id_subpilar')
            ->get();

        foreach ($pertanyaan as $item) {

             $this->statusService->updateStatus($item);
            $item->status_sistem = $item->status_pertanyaan;
        }

        return view('lke', compact('pertanyaan'));
    }

    public function detail($id_pertanyaan)
    {
        $pertanyaan = PertanyaanLKE::with([
            'subpilar',
            'buktiDukung',
            'pemeriksaan.pemeriksa',
            'pemeriksaanTerakhir',
        ])->findOrFail($id_pertanyaan);

        $status = $this->statusService->getStatus($pertanyaan);
        $semuaBuktiLengkap =
            $this->statusService->isBuktiDukungLengkap($pertanyaan);

        $pemeriksaanTerakhir =
            $pertanyaan->pemeriksaanTerakhir;

            // dd([
            //     'id_pertanyaan' => $pertanyaan->id_pertanyaan,

            //     'bukti_dukung' => BuktiDukungLKE::where(
            //         'id_pertanyaan',
            //         $pertanyaan->id_pertanyaan
            //     )->get([
            //         'id_bukti_dukung',
            //         'id_pertanyaan',
            //         'nama_bukti_dukung',
            //         'link_bukti_dukung',
            //     ])->toArray(),

            //     'jumlah_bukti' => BuktiDukungLKE::where(
            //         'id_pertanyaan',
            //         $pertanyaan->id_pertanyaan
            //     )->count(),

            //     'jumlah_bukti_terisi' => BuktiDukungLKE::where(
            //         'id_pertanyaan',
            //         $pertanyaan->id_pertanyaan
            //     )
            //     ->whereNotNull('link_bukti_dukung')
            //     ->where('link_bukti_dukung', '!=', '')
            //     ->count(),

            //     'semuaBuktiLengkap' => $semuaBuktiLengkap,

            //     'pemeriksaanTerakhir' => $pemeriksaanTerakhir,
            // ]);
        /*
        |--------------------------------------------------------------------------
        | TENTUKAN TAHAP
        |--------------------------------------------------------------------------
        */

        if (!$semuaBuktiLengkap) {

            $tahap = 'dasar';

        } elseif (!$pemeriksaanTerakhir) {

            $tahap = 'pemeriksaan';

        } elseif (
            $pemeriksaanTerakhir->status_pemeriksaan === 'sesuai'
            && is_null($pemeriksaanTerakhir->jawaban)
        ) {

            $tahap = 'penilaian';

        } elseif (
            $pemeriksaanTerakhir->status_pemeriksaan === 'sesuai'
            && !is_null($pemeriksaanTerakhir->jawaban)
        ) {

            $tahap = 'selesai';

        } else {

            /*
            |--------------------------------------------------------------------------
            | STATUS PERBAIKAN
            |--------------------------------------------------------------------------
            */

            $tahap = 'pemeriksaan';
        }

        return view(
            'detail-lke',
            compact(
                'pertanyaan',
                'tahap',
                'semuaBuktiLengkap', 
                'status',
                'semuaBuktiLengkap',
            )
        );
    }

    private function konversiNilai(
        string $jawaban,
        string $kriteria_jawaban
    ): float {

        $jawaban = strtolower(trim($jawaban));
        

        $kriteria_jawaban = strtolower(
            trim($kriteria_jawaban)
        );

        // Normalisasi spasi di sekitar "/"
        $kriteria_jawaban = preg_replace(
            '/\s*\/\s*/',
            '/',
            $kriteria_jawaban
        );

        return match ($kriteria_jawaban) {

            /*
            |--------------------------------------------------------------------------
            | YA / TIDAK
            |--------------------------------------------------------------------------
            */
            'ya/tidak' => match ($jawaban) {
                'ya'    => 1.00,
                'tidak' => 0.00,

                default => throw ValidationException::withMessages([
                    'jawaban' => 'Jawaban harus Ya atau Tidak.'
                ]),
            },


            /*
            |--------------------------------------------------------------------------
            | A / B / C
            |--------------------------------------------------------------------------
            */
            'a/b/c' => match ($jawaban) {
                'a' => 1.00,
                'b' => 0.50,
                'c' => 0.00,

                default => throw ValidationException::withMessages([
                    'jawaban' => 'Jawaban harus A, B, atau C.'
                ]),
            },


            /*
            |--------------------------------------------------------------------------
            | A / B / C / D
            |--------------------------------------------------------------------------
            */
            'a/b/c/d' => match ($jawaban) {
                'a' => 1.00,
                'b' => 0.67,
                'c' => 0.33,
                'd' => 0.00,

                default => throw ValidationException::withMessages([
                    'jawaban' => 'Jawaban harus A, B, C, atau D.'
                ]),
            },


            /*
            |--------------------------------------------------------------------------
            | A / B / C / D / E
            |--------------------------------------------------------------------------
            */
            'a/b/c/d/e' => match ($jawaban) {
                'a' => 1.00,
                'b' => 0.75,
                'c' => 0.50,
                'd' => 0.25,
                'e' => 0.00,

                default => throw ValidationException::withMessages([
                    'jawaban' => 'Jawaban harus A, B, C, D, atau E.'
                ]),
            },


            /*
            |--------------------------------------------------------------------------
            | NILAI 0-4
            |--------------------------------------------------------------------------
            */
            'nilai (0-4)' => (
                is_numeric($jawaban)
                && (float) $jawaban >= 0
                && (float) $jawaban <= 4
            )
                ? (float) $jawaban / 4
                : throw ValidationException::withMessages([
                    'jawaban' => 'Nilai harus antara 0 sampai 4.'
                ]),


            /*
            |--------------------------------------------------------------------------
            | JUMLAH
            |--------------------------------------------------------------------------
            */
            'jumlah' => is_numeric($jawaban)
                ? (float) $jawaban
                : throw ValidationException::withMessages([
                    'jawaban' => 'Jawaban harus berupa angka.'
                ]),


            /*
            |--------------------------------------------------------------------------
            | PERSENTASE
            |--------------------------------------------------------------------------
            */
            '%' => (
                is_numeric($jawaban)
                && (float) $jawaban >= 0
                && (float) $jawaban <= 100
            )
                ? (float) $jawaban / 100
                : throw ValidationException::withMessages([
                    'jawaban' => 'Persentase harus antara 0 sampai 100.'
                ]),


            default => throw ValidationException::withMessages([
                'jawaban' => 'Kriteria jawaban belum dikonfigurasi.'
            ]),
        };
    }

    public function simpanPemeriksaan(Request $request, $id)
    {

        
        $pertanyaan = PertanyaanLKE::with([
            'buktiDukung',
            'pemeriksaanTerakhir',
        ])->where(
            'id_pertanyaan',
            $id
        )->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | CEK ROLE
        |--------------------------------------------------------------------------
        */

        $role = strtolower(Auth::user()->role ?? '');

        if (!in_array($role, ['admin', 'sekretaris'])) {
            abort(403, 'Anda tidak memiliki akses untuk melakukan pemeriksaan.');
        }

        /*
        |--------------------------------------------------------------------------
        | CEK BUKTI DUKUNG
        |--------------------------------------------------------------------------
        */

        $semuaBuktiLengkap = $this->statusService->isBuktiDukungLengkap($pertanyaan);

        /*
        |--------------------------------------------------------------------------
        | TENTUKAN TAHAP
        |--------------------------------------------------------------------------
        */

        $tahap = $request->input('tahap');

        /*
        |--------------------------------------------------------------------------
        | TAHAP 1
        | PEMERIKSAAN
        |--------------------------------------------------------------------------
        */

        if ($tahap === 'pemeriksaan') {

            if (!$semuaBuktiLengkap) {
                throw ValidationException::withMessages([
                    'status_pemeriksaan' =>
                        'Bukti dukung belum lengkap. Pemeriksaan belum dapat dilakukan.'
                ]);
            }

            $validated = $request->validate([
                'status_pemeriksaan' => [
                    'required',
                    'in:sesuai,perbaikan'
                ],

                'catatan_pemeriksaan' => [
                    'nullable',
                    'string'
                ],
            ]);

            /*
            |--------------------------------------------------------------------------
            | SIMPAN RIWAYAT PEMERIKSAAN
            |--------------------------------------------------------------------------
            |
            | Setiap kali dilakukan pemeriksaan baru,
            | dibuat record baru.
            |
            */

            PemeriksaanLKE::create([
                'pertanyaan_lke_id' => $pertanyaan->id_pertanyaan,

                'status_pemeriksaan' =>
                    $validated['status_pemeriksaan'],

                'catatan_pemeriksaan' =>
                    $validated['catatan_pemeriksaan'] ?? null,

                'jawaban' => null,

                'nilai' => null,

                'bobot' => null,

                'narasi' => null,

                'diperiksa_oleh' => Auth::user()->id,

                'diperiksa_pada' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | UPDATE STATUS PERTANYAAN
            |--------------------------------------------------------------------------
            */

            $pertanyaan->update([
                'status_pertanyaan' => 
                    $validated['status_pemeriksaan']
            ]);

           
            // Jika hasil pemeriksaan adalah PERBAIKAN
            if ($validated['status_pemeriksaan'] === 'perbaikan') {

                // Cari user Pilar
                $pilar = User::where('role', 'pilar')
                    // ->where('pilar', $pertanyaan->subPilar->pilar)
                    ->get();

                foreach ($pilar as $user) {

                    // Cegah notifikasi duplikat
                    $sudahAdaNotif = Notification::where('user_id', $user->id)
                        ->where('id_pertanyaan', $pertanyaan->id)
                        ->where('tipe', 'pemeriksaan_perbaikan')
                        ->where('dibaca', false)
                        ->exists();

                    if (!$sudahAdaNotif) {
                        Notification::create([
                            'user_id' => $user->id,
                            'tipe' => 'pemeriksaan_perbaikan',
                            'judul' => 'Bukti Dukung Perlu Perbaikan',
                            'pesan' => 'Hasil pemeriksaan pada pertanyaan "' . 
                                ($pertanyaan->id_pertanyaan ?? "") . " " .
                                ($pertanyaan->nama_pertanyaan ?? 'Pertanyaan LKE') .
                                '" memerlukan perbaikan.' .
                                ($request->catatan
                                    ? ' Catatan pemeriksa: ' . $request->catatan
                                    : ''),
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

            return redirect()
                ->route('lke.detail', $pertanyaan->id_pertanyaan)
                ->with(
                    'success',
                    'Pemeriksaan berhasil disimpan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | TAHAP 2
        | PENILAIAN
        |--------------------------------------------------------------------------
        */

        if (in_array($tahap, ['penilaian', 'selesai'])) {

            if (!$semuaBuktiLengkap) {
                throw ValidationException::withMessages([
                    'jawaban' =>
                        'Bukti dukung belum lengkap.'
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | AMBIL PEMERIKSAAN TERAKHIR
            |--------------------------------------------------------------------------
            */
            $pemeriksaan =
                PemeriksaanLKE::where(
                    'pertanyaan_lke_id',
                    $pertanyaan->id_pertanyaan
                )
                ->latest('diperiksa_pada')
                ->first();

            /*
            |--------------------------------------------------------------------------
            | WAJIB SUDAH SESUAI
            |--------------------------------------------------------------------------
            */

            if (
                !$pemeriksaan ||
                $pemeriksaan->status_pemeriksaan !== 'sesuai'
            ) {
                throw ValidationException::withMessages([
                    'jawaban' =>
                        'Pertanyaan belum dinyatakan sesuai oleh pemeriksa.'
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | VALIDASI PENILAIAN
            |--------------------------------------------------------------------------
            */


            $validated = $request->validate([
                'jawaban' => [
                    'required',
                    'string'
                ],

                'narasi' => [
                    'required',
                    'string'
                ],
            ]);

            /*
            |--------------------------------------------------------------------------
            | KONVERSI NILAI
            |--------------------------------------------------------------------------
            */

            $jawaban = strtolower(trim($validated['jawaban']));


            $nilai = $this->konversiNilai(
                $jawaban,
                $pertanyaan->kriteria_jawaban
            );

            /*
            |--------------------------------------------------------------------------
            | HITUNG BOBOT
            |--------------------------------------------------------------------------
            */


            $persentase = $nilai * 100;

            /*
            |--------------------------------------------------------------------------
            | UPDATE PEMERIKSAAN TERAKHIR
            |--------------------------------------------------------------------------
            |
            | Tidak membuat pemeriksaan baru.
            | Data penilaian masuk ke pemeriksaan yang sudah SESUAI.
            |
            */

            $pemeriksaan->update([
                'jawaban' => $jawaban,

                'nilai' => $nilai,

                'persentase' => $persentase,

                'narasi' => $validated['narasi'],

                'diperiksa_pada' => now(),
            ]);

            // dd([
            //     'pemeriksaan_id' => $pemeriksaan->id,
            //     'sebelum' => $pemeriksaan->only([
            //         'jawaban',
            //         'nilai',
            //         'persentase',
            //         'narasi',
            //     ]),

            //     'akan_disimpan' => [
            //         'jawaban' => $jawaban,
            //         'nilai' => $nilai,
            //         'persentase' => $persentase,
            //         'narasi' => $validated['narasi'],
            //     ],
            // ]);

            /*
            |--------------------------------------------------------------------------
            | UPDATE NILAI PERTANYAAN
            |--------------------------------------------------------------------------
            */

            $pertanyaan->update([
                'nilai_pertanyaan' => $nilai,

                'status_pertanyaan' => 'dinilai',
            ]);

            return redirect()
                ->route('lke.detail', 
                        $pertanyaan->id_pertanyaan )
                ->with(
                    'success',
                    'Penilaian berhasil disimpan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | TAHAP TIDAK VALID
        |--------------------------------------------------------------------------
        */

        abort(403, 'Tahap proses tidak valid.');
    }

    // public function uploadBuktiDukung(Request $request)
    // {
    //     $validated = $request->validate([
    //         'id_bukti_dukung' => [
    //             'required',
    //             'exists:bukti_dukung_lke,id_bukti_dukung',
    //         ],

    //         'file' => [
    //             'required',
    //             'file',
    //             'mimes:pdf',
    //             'max:5120',
    //         ],
    //     ]);

    //     // Ambil data bukti dukung
    //     $bukti = BuktiDukungLKE::where(
    //         'id_bukti_dukung',
    //         $validated['id_bukti_dukung']
    //     )->firstOrFail();


    //     // File yang diupload
    //     $file = $request->file('file');


    //     /*
    //     |--------------------------------------------------------------------------
    //     | NAMA FILE
    //     |--------------------------------------------------------------------------
    //     |
    //     | Format:
    //     | id_bukti_dukung + spasi + nama_bukti_dukung + .pdf
    //     |
    //     */

    //     $namaFile =
    //         $bukti->id_bukti_dukung .
    //         ' ' .
    //         $bukti->nama_bukti_dukung_singkat .
    //         '.pdf';


    //     /*
    //     |--------------------------------------------------------------------------
    //     | HAPUS FILE LAMA JIKA REUPLOAD
    //     |--------------------------------------------------------------------------
    //     */
    // // perbaiki ini nanti pas sambungin gdrive
    //     if (!empty($bukti->link)) {

    //         $fileLama =
    //             storage_path(
    //                 'app/public/bukti-dukung/' .
    //                 $bukti->file
    //             );

    //         if (file_exists($fileLama)) {
    //             unlink($fileLama);
    //         }
    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | SIMPAN FILE
    //     |--------------------------------------------------------------------------
    //     */

    //     $file->storeAs(
    //         'bukti-dukung',
    //         $namaFile,
    //         'public'
    //     );


    //     /*
    //     |--------------------------------------------------------------------------
    //     | SIMPAN NAMA FILE KE DATABASE
    //     |--------------------------------------------------------------------------
    //     */

    //     $bukti->link_bukti_dukung = $namaFile;

    //     $bukti->save();


    //     /*
    //     |--------------------------------------------------------------------------
    //     | RESPONSE AJAX
    //     |--------------------------------------------------------------------------
    //     */

    //     return response()->json([
    //         'success' => true,

    //         'message' =>
    //             'Bukti dukung berhasil diupload.',

    //         'id_bukti_dukung' =>
    //             $bukti->id_bukti_dukung,

    //         'file_name' =>
    //             $namaFile,

    //         'file_url' =>
    //             asset(
    //                 'storage/bukti-dukung/' . $namaFile
    //             ),
    //     ]);
    // }

    // menentukan tanggal
    // private function getTanggalWaktu($waktu)
    // {
    //     if (empty($waktu)) {
    //         return [];
    //     }

    //     $waktu = strtolower(trim($waktu));

    //     $isNPlusOne = str_contains($waktu, '(n+1)');

    //     $tahun = now()->year + ($isNPlusOne ? 1 : 0);

    //     $periode = trim(
    //         str_replace('(n+1)', '', $waktu)
    //     );

    //     return match ($periode) {

    //         'triwulan i' => [
    //             Carbon::create($tahun, 1, 31)
    //         ],

    //         'triwulan ii' => [
    //             Carbon::create($tahun, 4, 30)
    //         ],

    //         'triwulan iii' => [
    //             Carbon::create($tahun, 7, 31)
    //         ],

    //         'triwulan iv' => [
    //             Carbon::create($tahun, 10, 31)
    //         ],

    //         'triwulan i-iv' => [
    //             Carbon::create($tahun, 12, 15)
    //         ],

    //         'triwulan ii-iv' => [
    //             Carbon::create($tahun, 12, 15)
    //         ],

    //         'triwulan i/ii/iii/iv' => [
    //             Carbon::create($tahun, 12, 15)
    //         ],

    //         'triwulan iv atau triwulan i' => [
    //             Carbon::create($tahun, 1, 31)
    //         ],

    //         default => [],
    //     };
    // }

    // private function buktiDukungLengkap($pertanyaan)
    // {
    //     $buktiDukung = BuktiDukungLKE::where(
    //         'id_pertanyaan',
    //         $pertanyaan->id_pertanyaan
    //     )->get();

    //     if ($buktiDukung->isEmpty()) {
    //         return false;
    //     }

    //     $total = $buktiDukung->count();

    //     $terisi = $buktiDukung->filter(function ($item) {
    //         return !empty($item->link_bukti_dukung);
    //     })->count();

    //     return $terisi === $total;
    // }

    // private function getStatusPertanyaan($pertanyaan)
    // {
        
    //     // Refresh data terbaru dari database
    //     $pertanyaan->refresh();

    //     // 1. Sudah dinilai
    //     if (!is_null($pertanyaan->nilai_pertanyaan)) {
    //         return 'dinilai';
    //     }

    //     // 2. Cek pemeriksaan terakhir
    //     $pemeriksaan = PemeriksaanLKE::where(
    //         'pertanyaan_lke_id',
    //         $pertanyaan->id_pertanyaan
    //     )
    //     ->latest('diperiksa_pada')
    //     ->first();

    //     if ($pemeriksaan) {

    //         if ($pemeriksaan->status_pemeriksaan === 'sesuai') {
    //             return 'sesuai';
    //         }

    //         if ($pemeriksaan->status_pemeriksaan === 'perbaikan') {
    //             return 'perbaikan';
    //         }
    //     }

    //     // 3. Bukti dukung lengkap
    //     if ($this->buktiDukungLengkap($pertanyaan)) {
    //         return 'pemeriksaan';
    //     }

    //     // 4. Terlambat
    //     $tanggalWaktu = $this->getTanggalWaktu($pertanyaan->waktu);

    //     if (!empty($tanggalWaktu)) {

    //         $tanggalSekarang = now()->startOfDay();
    //         $tanggalTarget = $tanggalWaktu[0];

    //         if ($tanggalSekarang->gt($tanggalTarget)) {
    //             return 'terlambat';
    //         }
    //     }

    //     // 5. Default
    //     return 'belum';
    // }

    // public function updateStatusPertanyaan()
    // {
    //     $pertanyaan = PertanyaanLKE::all();

    //     foreach ($pertanyaan as $item) {

    //         $statusBaru = $this->getStatusPertanyaan($item);

    //         if ($item->status_pertanyaan !== $statusBaru) {

    //             $item->update([
    //                 'status_pertanyaan' => $statusBaru,
    //             ]);
    //         }
    //     }

    //     return back()->with(
    //         'success',
    //         'Status pertanyaan berhasil diperbarui.'
    //     );
    // }

    //     public function cekStatusPertanyaan($id)
    // {
    //     $pertanyaan = PertanyaanLKE::findOrFail($id);

    //     $statusBaru = $this->getStatusPertanyaan($pertanyaan);

    //     // Sinkronkan database
    //     if ($pertanyaan->status_pertanyaan !== $statusBaru) {
    //         $pertanyaan->update([
    //             'status_pertanyaan' => $statusBaru,
    //         ]);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'status' => $statusBaru,
    //     ]);
    // }

}

