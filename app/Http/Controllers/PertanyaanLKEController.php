<?php

namespace App\Http\Controllers;

use App\Models\BuktiDukungLKE;
use App\Models\PemeriksaanLKE;
use App\Models\PertanyaanLKE;
use App\Models\RiwayatPenilaianLKE;
use App\Models\SubPilarLKE;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PertanyaanLKEController extends Controller
{
    public function index()
    {
        $pertanyaan = PertanyaanLKE::with('subPilar','buktiDukung')
            ->orderBy('id_subpilar')
            ->get();

        foreach ($pertanyaan as $item) {

            $statusBaru = $this->getStatusPertanyaan($item);

            if ($item->status_pertanyaan !== $statusBaru) {
                $item->update([
                    'status_pertanyaan' => $statusBaru,
                ]);
            }
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
        ])->firstOrFail($id_pertanyaan);



        return view('detail-lke', compact('pertanyaan'));
    }

    private function konversiNilai(
        string $jawaban,
        string $kriteria_jawaban
    ): float {

        $jawaban = strtolower(trim($jawaban));

        $kriteria_jawaban = strtolower(
            trim($kriteria_jawaban)
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
        $pertanyaan = PertanyaanLKE::where(
            'id_pertanyaan',
            $id
        )->firstOrFail();

        $validated = $request->validate([
            'catatan_pemeriksaan' => ['nullable', 'string'],
            'status_pemeriksaan' => ['required', 'in:sesuai,perbaikan'],
            'jawaban' => ['required', 'string'],
            'narasi' => ['required', 'string'],
        ]);

        $jawaban = $validated['jawaban'];

        /*
        |--------------------------------------------------------------------------
        | Nilai hasil konversi jawaban
        |--------------------------------------------------------------------------
        */

        $nilai = $this->konversiNilai(
            $jawaban,
            $pertanyaan->kriteria_jawaban
        );

        /*
        |--------------------------------------------------------------------------
        | Bobot penuh pertanyaan
        |--------------------------------------------------------------------------
        */

        $bobotPenuh = (float) $pertanyaan->bobot;

        /*
        |--------------------------------------------------------------------------
        | Bobot hasil
        |--------------------------------------------------------------------------
        */

        $bobot = $nilai * $bobotPenuh;

        PemeriksaanLKE::create([
            'pertanyaan_lke_id' => $pertanyaan->id,

            'jawaban' => $jawaban,

            'nilai' => $nilai,

            'bobot' => $bobot,

            'status_pemeriksaan' =>
                $validated['status_pemeriksaan'],

            'catatan_pemeriksaan' =>
                $validated['catatan_pemeriksaan'] ?? null,

            'narasi' =>
                $validated['narasi'],

            'diperiksa_oleh' => Auth::id(),

            'diperiksa_pada' => now(),
        ]);

        return redirect()
            ->route('lke.detail', $pertanyaan->id_pertanyaan)
            ->with('success', 'Pemeriksaan berhasil disimpan.');
    }

    public function uploadBuktiDukung(Request $request)
    {
        $validated = $request->validate([
            'id_bukti_dukung' => [
                'required',
                'exists:bukti_dukung_lke,id_bukti_dukung',
            ],

            'file' => [
                'required',
                'file',
                'mimes:pdf',
                'max:5120',
            ],
        ]);

        // Ambil data bukti dukung
        $bukti = BuktiDukungLKE::where(
            'id_bukti_dukung',
            $validated['id_bukti_dukung']
        )->firstOrFail();


        // File yang diupload
        $file = $request->file('file');


        /*
        |--------------------------------------------------------------------------
        | NAMA FILE
        |--------------------------------------------------------------------------
        |
        | Format:
        | id_bukti_dukung + spasi + nama_bukti_dukung + .pdf
        |
        */

        $namaFile =
            $bukti->id_bukti_dukung .
            ' ' .
            $bukti->nama_bukti_dukung .
            '.pdf';


        /*
        |--------------------------------------------------------------------------
        | HAPUS FILE LAMA JIKA REUPLOAD
        |--------------------------------------------------------------------------
        */
// perbaiki ini nanti pas sambungin gdrive
        if (!empty($bukti->link)) {

            $fileLama =
                storage_path(
                    'app/public/bukti-dukung/' .
                    $bukti->file
                );

            if (file_exists($fileLama)) {
                unlink($fileLama);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN FILE
        |--------------------------------------------------------------------------
        */

        $file->storeAs(
            'bukti-dukung',
            $namaFile,
            'public'
        );


        /*
        |--------------------------------------------------------------------------
        | SIMPAN NAMA FILE KE DATABASE
        |--------------------------------------------------------------------------
        */

        $bukti->link_bukti_dukung = $namaFile;

        $bukti->save();


        /*
        |--------------------------------------------------------------------------
        | RESPONSE AJAX
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'message' =>
                'Bukti dukung berhasil diupload.',

            'id_bukti_dukung' =>
                $bukti->id_bukti_dukung,

            'file_name' =>
                $namaFile,

            'file_url' =>
                asset(
                    'storage/bukti-dukung/' . $namaFile
                ),
        ]);
    }

    // menentukan tanggal
    private function getTanggalWaktu($waktu)
    {
        if (empty($waktu)) {
            return [];
        }

        $waktu = strtolower(trim($waktu));

        $isNPlusOne = str_contains($waktu, '(n+1)');

        $tahun = now()->year + ($isNPlusOne ? 1 : 0);

        $periode = trim(
            str_replace('(n+1)', '', $waktu)
        );

        return match ($periode) {

            'triwulan i' => [
                Carbon::create($tahun, 1, 31)
            ],

            'triwulan ii' => [
                Carbon::create($tahun, 4, 30)
            ],

            'triwulan iii' => [
                Carbon::create($tahun, 7, 31)
            ],

            'triwulan iv' => [
                Carbon::create($tahun, 10, 31)
            ],

            'triwulan i-iv' => [
                Carbon::create($tahun, 12, 15)
            ],

            'triwulan ii-iv' => [
                Carbon::create($tahun, 12, 15)
            ],

            'triwulan i/ii/iii/iv' => [
                Carbon::create($tahun, 12, 15)
            ],

            'triwulan iv atau triwulan i' => [
                Carbon::create($tahun, 1, 31)
            ],

            default => [],
        };
    }

    private function buktiDukungLengkap($pertanyaan)
    {
        $buktiDukung = BuktiDukungLKE::where(
            'id_pertanyaan',
            $pertanyaan->id_pertanyaan
        )->get();

        if ($buktiDukung->isEmpty()) {
            return false;
        }

        $total = $buktiDukung->count();

        $terisi = $buktiDukung->filter(function ($item) {
            return !empty($item->link_bukti_dukung);
        })->count();

        return $terisi === $total;
    }

    private function getStatusPertanyaan($pertanyaan)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. SUDAH DINILAI
        |--------------------------------------------------------------------------
        */

        if (!is_null($pertanyaan->nilai_mandiri)) {
            return 'dinilai';
        }


        /*
        |--------------------------------------------------------------------------
        | 2. CEK HASIL PEMERIKSAAN TERAKHIR
        |--------------------------------------------------------------------------
        */

        $pemeriksaan = PemeriksaanLKE::where(
            'pertanyaan_lke_id',
            $pertanyaan->id
        )
        ->latest('diperiksa_pada')
        ->first();

        if ($pemeriksaan) {

            if ($pemeriksaan->status_pemeriksaan === 'sesuai') {
                return 'sesuai';
            }

            if ($pemeriksaan->status_pemeriksaan === 'perbaikan') {
                return 'perbaikan';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | 3. CEK KELENGKAPAN BUKTI DUKUNG
        |--------------------------------------------------------------------------
        */

        if ($this->buktiDukungLengkap($pertanyaan)) {
            return 'pemeriksaan';
        }


        /*
        |--------------------------------------------------------------------------
        | 4. BUKTI BELUM LENGKAP
        |    CEK APAKAH SUDAH TERLAMBAT
        |--------------------------------------------------------------------------
        */

        $tanggalWaktu = $this->getTanggalWaktu($pertanyaan->waktu);

        if (!empty($tanggalWaktu)) {

            $tanggalSekarang = now()->startOfDay();

            $tanggalTarget = $tanggalWaktu[0];

            if ($tanggalSekarang->gt($tanggalTarget)) {
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

    public function updateStatusPertanyaan()
    {
        $pertanyaan = PertanyaanLKE::all();

        foreach ($pertanyaan as $item) {

            $statusBaru = $this->getStatusPertanyaan($item);

            if ($item->status_pertanyaan !== $statusBaru) {

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