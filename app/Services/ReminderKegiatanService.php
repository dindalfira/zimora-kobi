<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\PelaksanaanKegiatan;
use App\Models\User;
use Carbon\Carbon;

class ReminderKegiatanService
{
    /**
     * Reminder awal bulan
     * Memberitahu Pilar kegiatan yang berjalan
     * pada bulan sekarang.
     */
    public function reminderAwalBulan()
    {
        $bulanSekarang = now()->month;
        $tahunSekarang = now()->year;

        $pelaksanaan = PelaksanaanKegiatan::with('kegiatan')
            ->whereMonth('waktu_pelaksanaan', $bulanSekarang)
            ->whereYear('waktu_pelaksanaan', $tahunSekarang)
            ->get();

        foreach ($pelaksanaan as $item) {

            if (!$item->kegiatan) {
                continue;
            }

            // Jangan kirim reminder jika sudah selesai
            if (!empty($item->dokumentasi)) {
                continue;
            }

            $this->kirimNotifikasi(
                $item,
                'reminder_bulanan_' . $tahunSekarang . '_' . $bulanSekarang,
                'Reminder Kegiatan Bulan Ini',
                'Kegiatan "' .
                    $item->kegiatan->nama_kegiatan .
                    '" dijadwalkan untuk dilaksanakan pada bulan ' .
                    now()->translatedFormat('F Y') .
                    '.'
            );
        }
    }


    /**
     * Mengecek kegiatan yang sudah melewati
     * tanggal pelaksanaan.
     *
     * Reminder:
     * H
     * H+3
     * H+7
     * H+14
     * H+21
     * H+28
     * dst.
     */
    public function cekKegiatanTerlambat()
    {
        $hariIni = Carbon::today();

        $pelaksanaan = PelaksanaanKegiatan::with('kegiatan')
            ->whereNotNull('waktu_pelaksanaan')
            ->whereNull('dokumentasi')
            ->get();

        foreach ($pelaksanaan as $item) {

            if (!$item->kegiatan) {
                continue;
            }

            $tanggalKegiatan = Carbon::parse(
                $item->waktu_pelaksanaan
            )->startOfDay();

            /*
             * Kalau tanggal kegiatan belum tiba,
             * tidak perlu reminder.
             */
            if ($hariIni->lt($tanggalKegiatan)) {
                continue;
            }

            $selisihHari = $tanggalKegiatan->diffInDays(
                $hariIni
            );

            /*
             * H
             */
            if ($selisihHari === 0) {

                $this->kirimNotifikasi(
                    $item,
                    'kegiatan_hari_h',
                    'Pengingat Kegiatan Hari Ini',
                    'Hari ini adalah jadwal pelaksanaan kegiatan "' .
                        $item->kegiatan->nama_kegiatan .
                        '". Mohon segera melaksanakan kegiatan dan mengunggah dokumentasi.'
                );

                continue;
            }

            /*
             * H+3
             */
            if ($selisihHari === 3) {

                $this->kirimNotifikasi(
                    $item,
                    'kegiatan_h_plus_3',
                    'Kegiatan Belum Selesai',
                    'Kegiatan "' .
                        $item->kegiatan->nama_kegiatan .
                        '" belum memiliki dokumentasi dan sudah melewati jadwal selama 3 hari.'
                );

                continue;
            }

            /*
             * H+7, H+14, H+21, H+28, dst.
             */
            if (
                $selisihHari >= 7 &&
                $selisihHari % 7 === 0
            ) {

                $this->kirimNotifikasi(
                    $item,
                    'kegiatan_h_plus_' . $selisihHari,
                    'Kegiatan Terlambat',
                    'Kegiatan "' .
                        $item->kegiatan->nama_kegiatan .
                        '" belum diselesaikan dan telah terlambat ' .
                        $selisihHari .
                        ' hari. Mohon segera melakukan tindak lanjut.'
                );
            }
        }
    }


    /**
     * Kirim notifikasi ke Pilar yang sesuai.
     */
    private function kirimNotifikasi(
        PelaksanaanKegiatan $pelaksanaan,
        string $tipe,
        string $judul,
        string $pesan
    ) {
        $kegiatan = $pelaksanaan->kegiatan;

        $users = User::where('role', 'pilar')
            // ->where('id_pilar', $kegiatan->pilar)
            ->get();

        /*
        * Buat tipe unik berdasarkan:
        * - jenis reminder
        * - ID pelaksanaan
        *
        * Jadi setiap periode/kegiatan memiliki
        * reminder masing-masing.
        */
        $tipeUnik = $tipe . '_pelaksanaan_' . $pelaksanaan->id;

        foreach ($users as $user) {

            $sudahAda = Notification::where('user_id', $user->id)
                ->where('tipe', $tipeUnik)
                ->exists();

            if ($sudahAda) {
                continue;
            }

            Notification::create([
                'user_id' => $user->id,
                'tipe' => $tipeUnik,
                'judul' => $judul,
                'pesan' => $pesan,
                'id_pilar' => $kegiatan->pilar,
                'id_pertanyaan' => null,
                'url' => route('kegiatan.index'),
                'dibaca' => false,
                'dibaca_at' => null,
            ]);
        }
    }
}