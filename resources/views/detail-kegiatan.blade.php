@extends('layouts.app')
@section('title', 'Detail Kegiatan')
@section('content')

{{-- Breadcrumb --}}

<div class="mb-2 flex items-center gap-1 text-[10px] text-slate-400">

    <a href="{{ route('kegiatan.index') }}"
        class="transition hover:text-sky-700">
        Monitoring Kegiatan
    </a>

    <i data-lucide="chevron-right" class="h-3 w-3"></i>

    <span class="font-medium text-slate-600">
        Detail Kegiatan
    </span>

</div>

<div class="rounded-xl border border-slate-200 shadow-sm">

    <div class="min-h-screen bg-slate-50">

        {{-- =====================================================
            HEADER
        ====================================================== --}}
        <div class="border-b border-slate-200 bg-white">

            <div class="mx-auto max-w-[1600px] px-3 py-2 pb-3 sm:px-6">

                {{-- Judul indikator --}}
                <div class="">
                    <div class="flex flex-wrap items-center gap-2">
                        {{-- Pilar --}}
                        <span class="inline-flex items-center gap-1.5 rounded-full
                                    border border-slate-100 px-2.5 py-1
                                    text-[10px] font-medium text-slate-700 bg-slate-100">
                            Pilar {{ $kegiatan->pilar ?? '-' }}
                        </span>

                        {{-- Status --}}

                        @switch(strtolower($kegiatan->status_aktual))

                            {{-- MENUNGGU --}}
                            @case('menunggu')
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full
                                    border border-slate-100 px-2.5 py-1
                                    text-[10px] font-medium text-slate-700 bg-slate-50"
                                >
                                    <i data-lucide="clock" class="h-3.5 w-3.5"></i>
                                    Menunggu
                                </span>
                                @break


                            {{-- BERLANGSUNG --}}
                            @case('berlangsung')
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full
                                    border border-blue-100 px-2.5 py-1
                                    text-[10px] font-medium text-sky-700 bg-blue-50"
                                >
                                    <i data-lucide="loader" class="h-3.5 w-3.5"></i>
                                    Berlangsung
                                </span>
                                @break


                            {{-- SELESAI --}}
                            @case('selesai')
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full
                                    border border-emerald-100 px-2.5 py-1
                                    text-[10px] font-medium text-emerald-700 bg-emerald-50"
                                >
                                    <i data-lucide="circle-check" class="h-3.5 w-3.5"></i>
                                    Selesai
                                </span>
                                @break


                            {{-- TERLAMBAT --}}
                            @case('terlambat')
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full
                                    border border-red-100 px-2.5 py-1
                                    text-[10px] font-medium text-red-700 bg-red-50"
                                >
                                    <i data-lucide="octagon-x" class="h-3.5 w-3.5"></i>
                                    Terlambat
                                </span>
                                @break


                            {{-- TINDAK LANJUT --}}
                            @case('tindak_lanjut')
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full
                                    border border-amber-100 px-2.5 py-1
                                    text-[10px] font-medium text-amber-700 bg-amber-50"
                                >
                                    <i data-lucide="triangle-alert" class="h-3.5 w-3.5"></i>
                                    Tindak Lanjut
                                </span>
                                @break


                            {{-- DEFAULT --}}
                            @default
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full
                                    border border-slate-100 px-2.5 py-1
                                    text-[10px] font-medium text-slate-700 bg-slate-50"
                                >
                                    <i data-lucide="clock" class="h-3.5 w-3.5"></i>
                                    Menunggu
                                </span>

                        @endswitch

                    </div>


                    <h1 class="mt-2 text-md font-bold leading-5 text-sky-950 sm:text-base">
                        {{ Str::title($kegiatan->nama_kegiatan) ?? '-' }}
                    </h1>

                </div>

            </div>

        </div>


        {{-- =====================================================
            MAIN CONTENT
        ====================================================== --}}
        <div class="mx-auto max-w-[1600px] px-2 py-5 sm:px-6">

            <div class="grid grid-cols-1 gap-5 xl:grid-cols-[minmax(0,1fr)_430px]">


                {{-- =================================================
                    KOLOM KIRI
                ================================================== --}}
                <main class="space-y-5">

                    {{-- =========================================================
                        1. INFORMASI INDIKATOR
                    ========================================================== --}}
                    <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-200 px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div class="flex h-8 w-8 items-center justify-center
                                            rounded-lg bg-sky-50">
                                    <i data-lucide="book-open"
                                    class="h-4 w-4 text-sky-700"></i>
                                </div>

                                <div>
                                    <h2 class="text-xs font-bold uppercase tracking-wide text-slate-700">
                                        Informasi Kegiatan
                                    </h2>

                                    <p class="mt-0.5 text-[10px] text-slate-400">
                                        Informasi pelaksanaan kegiatan 
                                    </p>
                                </div>

                            </div>
                        </div>


                        <div class="space-y-5 p-5">

                            {{-- Nama kegiatan --}}
                            <div class="border-l-2 border-sky-200 pl-4">

                                <p class="text-[10px] font-bold uppercase tracking-wide text-sky-700">
                                    Nama Kegiatan
                                </p>

                                <h3 class="mt-1 text-base font-bold text-sky-950">
                                    {{ $kegiatan->nama_kegiatan ?? '-' }}
                                </h3>

                                {{-- <p class="mt-1 text-xs leading-5 text-slate-500">
                                    Terdapat monitoring dan evaluasi terhadap pembangunan Zona Integritas
                                </p> --}}
                            </div>

                            {{-- Detail --}}
                            <div class="grid gap-1">
                                {{-- @foreach($pelaksanaan as $item) --}}

                                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">

                                    <div class="flex items-center justify-between gap-2">
                                        <div class="flex items-center gap-2">

                                            <i data-lucide="calendar"
                                            class="h-4 w-4 text-sky-600">
                                            </i>

                                            <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                                Tanggal Pelaksanaan
                                            </p>
                                        </div>

                                        @php
                                            $bulanSekarang = \Carbon\Carbon::today()->startOfMonth();

                                            // Default
                                            $pelaksanaanAktif = null;

                                            if ($kegiatan->jumlah_pelaksanaan > 1) {

                                                // 1. Prioritas: pelaksanaan pada bulan sekarang
                                                $pelaksanaanAktif = $kegiatan->pelaksanaan
                                                    ->filter(function ($pelaksanaanItem) use ($bulanSekarang) {
                                                        if (!$pelaksanaanItem->waktu_pelaksanaan) {
                                                            return false;
                                                        }

                                                        return \Carbon\Carbon::parse(
                                                            $pelaksanaanItem->waktu_pelaksanaan
                                                        )->startOfMonth()->equalTo($bulanSekarang);
                                                    })
                                                    ->sortBy('waktu_pelaksanaan')
                                                    ->first();


                                                // 2. Kalau tidak ada bulan sekarang,
                                                // ambil bulan terdekat yang akan datang
                                                if (!$pelaksanaanAktif) {
                                                    $pelaksanaanAktif = $kegiatan->pelaksanaan
                                                        ->filter(function ($pelaksanaanItem) use ($bulanSekarang) {
                                                            if (!$pelaksanaanItem->waktu_pelaksanaan) {
                                                                return false;
                                                            }

                                                            return \Carbon\Carbon::parse(
                                                                $pelaksanaanItem->waktu_pelaksanaan
                                                            )->startOfMonth()->greaterThan($bulanSekarang);
                                                        })
                                                        ->sortBy('waktu_pelaksanaan')
                                                        ->first();
                                                }


                                                // 3. Kalau semua sudah lewat,
                                                // ambil periode terakhir
                                                if (!$pelaksanaanAktif) {
                                                    $pelaksanaanAktif = $kegiatan->pelaksanaan
                                                        ->filter(fn ($pelaksanaanItem) =>
                                                            $pelaksanaanItem->waktu_pelaksanaan
                                                        )
                                                        ->sortByDesc('waktu_pelaksanaan')
                                                        ->first();
                                                }

                                            } else {

                                                // Kegiatan tidak berulang
                                                $pelaksanaanAktif = $kegiatan->pelaksanaan->first();
                                            }
                                        @endphp

                                        {{-- Edit jadwal --}}
                                        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'pilar')
                                        <button
                                            type="button"
                                            onclick="openEditJadwal(
                                                {{ $pelaksanaanAktif?->id ?? 'null' }},
                                                @js($pelaksanaanAktif?->waktu_pelaksanaan
                                                            ? \Carbon\Carbon::parse(
                                                                $pelaksanaanAktif->waktu_pelaksanaan
                                                            )->format('Y-m-d')
                                                            : null
                                                    )
                                                )"
                                            class="inline-flex items-center gap-1
                                                rounded-md border border-sky-200
                                                bg-white px-2 py-1
                                                text-[9px] font-semibold text-sky-700
                                                transition hover:bg-sky-50">

                                            <i data-lucide="pencil" class="h-3 w-3"></i>
                                            Edit

                                        </button>
                                        @endif

                                        {{-- =========================================================
                                            MODAL EDIT TANGGAL PELAKSANAAN
                                        ========================================================= --}}
                                        <div
                                            id="editJadwalModal"
                                            class="fixed inset-0 z-50 hidden items-center justify-center
                                                bg-slate-900/40 px-4 backdrop-blur-sm">

                                            <div
                                                class="w-full max-w-md overflow-hidden rounded-2xl
                                                    border border-slate-200 bg-white shadow-xl">

                                                {{-- Header --}}
                                                <div class="flex items-center justify-between
                                                            border-b border-slate-200 px-5 py-4">

                                                    <div class="flex items-center gap-3">

                                                        <div class="flex h-8 w-8 items-center justify-center
                                                                    rounded-lg bg-sky-50">

                                                            <i data-lucide="calendar-edit"
                                                            class="h-4 w-4 text-sky-700">
                                                            </i>

                                                        </div>

                                                        <div>

                                                            <h2 class="text-xs font-bold uppercase
                                                                    tracking-wide text-slate-700">
                                                                Edit Waktu Pelaksanaan
                                                            </h2>

                                                            <p class="mt-0.5 text-[10px] text-slate-400">
                                                                Ubah tanggal pelaksanaan kegiatan
                                                            </p>

                                                        </div>

                                                    </div>

                                                    <button
                                                        type="button"
                                                        onclick="closeEditJadwal()"
                                                        class="rounded-lg p-1.5 text-slate-400
                                                            transition hover:bg-red-100
                                                            hover:text-slate-600">

                                                        <i data-lucide="x" class="h-4 w-4"></i>

                                                    </button>

                                                </div>


                                                {{-- Body --}}
                                                <div class="space-y-4 p-5">

                                                    {{-- Tanggal saat ini --}}
                                                    <div class="rounded-xl border border-slate-200
                                                                bg-slate-50 px-4 py-3">

                                                        <p class="text-[9px] font-bold uppercase
                                                                tracking-wide text-slate-400">
                                                            Waktu Saat Ini
                                                        </p>

                                                        <p
                                                            id="currentWaktuPelaksanaan"
                                                            class="mt-1 text-sm font-semibold text-slate-700">
                                                            -
                                                        </p>

                                                    </div>


                                                    {{-- Tanggal baru --}}
                                                    <div>

                                                        <label
                                                            for="editWaktuPelaksanaan"
                                                            class="text-[10px] font-bold uppercase
                                                                tracking-wide text-slate-500">

                                                            Waktu Pelaksanaan Baru

                                                        </label>

                                                        <input
                                                            type="date"
                                                            id="editWaktuPelaksanaan"
                                                            min="{{ now()->addDay()->format('Y-m-d') }}"
                                                            class="mt-1.5 w-full rounded-lg
                                                                border border-slate-200 bg-white
                                                                px-3 py-2 text-xs text-slate-700
                                                                outline-none transition
                                                                focus:border-sky-400
                                                                focus:ring-2 focus:ring-sky-100">

                                                        <p class="mt-1.5 text-[9px] text-slate-400">
                                                            Hanya dapat memilih tanggal setelah hari ini.
                                                        </p>

                                                        <p
                                                            id="editWaktuError"
                                                            class="mt-1.5 hidden text-[9px] text-rose-600">
                                                        </p>

                                                    </div>

                                                </div>


                                                {{-- Footer --}}
                                                <div class="flex items-center justify-end gap-2
                                                            border-t border-slate-200 bg-slate-50
                                                            px-5 py-3">

                                                    <button
                                                        type="button"
                                                        onclick="closeEditJadwal()"
                                                        class="rounded-lg border border-slate-200
                                                            bg-white px-3 py-2
                                                            text-[10px] font-semibold text-slate-600
                                                            transition hover:bg-slate-100">

                                                        Batal

                                                    </button>


                                                    <button
                                                        type="button"
                                                        id="btnSimpanWaktu"
                                                        onclick="saveEditJadwal()"
                                                        class="inline-flex items-center gap-1.5
                                                            rounded-lg bg-sky-600 px-3 py-2
                                                            text-[10px] font-semibold text-white
                                                            transition hover:bg-sky-700">

                                                        <i data-lucide="save" class="h-3.5 w-3.5"></i>

                                                        Simpan

                                                    </button>

                                                </div>

                                            </div>
                        
                                        </div>

                                    </div>

                                    @php
                                        $bulanSekarang = \Carbon\Carbon::today()->startOfMonth();

                                        if ($kegiatan->jumlah_pelaksanaan > 1) {

                                            // Prioritas 1:
                                            // cari pelaksanaan di bulan sekarang
                                            $tanggalPelaksanaan = $pelaksanaan
                                                ->filter(function ($p) use ($bulanSekarang) {
                                                    if (!$p->waktu_pelaksanaan) {
                                                        return false;
                                                    }

                                                    $tanggal = \Carbon\Carbon::parse(
                                                        $p->waktu_pelaksanaan
                                                    )->startOfMonth();

                                                    return $tanggal->equalTo($bulanSekarang);
                                                })
                                                ->sortBy('waktu_pelaksanaan')
                                                ->first();

                                            // Prioritas 2:
                                            // jika tidak ada bulan sekarang,
                                            // cari bulan terdekat setelah bulan sekarang
                                            if (!$tanggalPelaksanaan) {
                                                $tanggalPelaksanaan = $pelaksanaan
                                                    ->filter(function ($p) use ($bulanSekarang) {
                                                        if (!$p->waktu_pelaksanaan) {
                                                            return false;
                                                        }

                                                        $tanggal = \Carbon\Carbon::parse(
                                                            $p->waktu_pelaksanaan
                                                        )->startOfMonth();

                                                        return $tanggal->greaterThan($bulanSekarang);
                                                    })
                                                    ->sortBy('waktu_pelaksanaan')
                                                    ->first();
                                            }

                                            // Prioritas 3:
                                            // jika semua sudah lewat,
                                            // ambil periode terakhir
                                            if (!$tanggalPelaksanaan) {
                                                $tanggalPelaksanaan = $pelaksanaan
                                                    ->filter(fn ($p) => $p->waktu_pelaksanaan)
                                                    ->sortByDesc('waktu_pelaksanaan')
                                                    ->first();
                                            }

                                        } else {

                                            // Kegiatan tidak berulang
                                            $tanggalPelaksanaan = $pelaksanaan->first();
                                        }
                                    @endphp
                                    <p
                                        id="displayWaktuPelaksanaan-{{ $kegiatan->kegiatan_id }}"
                                        class="mt-2 text-sm font-semibold text-slate-700"
                                    >
                                        {{ $tanggalPelaksanaan?->waktu_pelaksanaan
                                                ? \Carbon\Carbon::parse($tanggalPelaksanaan?->waktu_pelaksanaan)
                                                    ->isoFormat('dddd, D MMMM YYYY')
                                                : '-' }}
                                    </p>

                                </div>

                                {{-- @ endforeach --}}


                                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">

                                    <div class="flex items-center gap-2">

                                        <i data-lucide="repeat"
                                        class="h-4 w-4 text-sky-600">
                                        </i>

                                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                            Frekuensi
                                        </p>

                                    </div>

                                    <p class="mt-2 text-sm font-semibold text-slate-700">
                                        {{ $kegiatan->frekuensi_pelaksanaan }}
                                    </p>

                                </div>

                            </div>

                        </div>

                        {{-- =========================================================
                                2. DOKUMENTASI YANG DIKUMPULKAN
                            ========================================================== --}}

                        <div class="border-b border-slate-200 px-5 py-4">

                            <div class="flex items-center gap-2">

                                <div class="flex h-8 w-8 items-center justify-center
                                            rounded-lg bg-sky-50">

                                    <i data-lucide="file-text"
                                    class="h-4 w-4 text-sky-700">
                                    </i>

                                </div>

                                <div>

                                    <h2 class="text-xs font-bold uppercase tracking-wide text-slate-700">
                                        Dokumentasi yang Dikumpulkan
                                    </h2>

                                    <p class="mt-0.5 text-[10px] text-slate-400">
                                        Dokumentasi yang perlu dikumpulkan untuk kegiatan ini
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="space-y-3 p-5">

                            <div class="flex items-start gap-3 rounded-xl
                                        border border-slate-200 bg-slate-50 px-4 py-3">
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs text-slate-600">
                                        {{ $kegiatan->pedoman_bukti }}
                                    </p>
                                </div>
                            </div>

                        </div>


                        <div class="border-b border-slate-200 px-5 py-4">

                            <div class="flex items-center gap-2">

                                <div class="flex h-8 w-8 items-center justify-center
                                            rounded-lg bg-sky-50">

                                    <i data-lucide="link-2"
                                    class="h-4 w-4 text-sky-700">
                                    </i>

                                </div>

                                <div>

                                    <h2 class="text-xs font-bold uppercase tracking-wide text-slate-700">
                                        Kaitan dengan LKE
                                    </h2>

                                    <p class="mt-0.5 text-[10px] text-slate-400">
                                        Indikator LKE yang dipenuhi melalui kegiatan ini
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="p-5">

                            <div class="rounded-xl border border-sky-100 bg-sky-50/50 p-4">

                                <div class="flex items-start justify-between gap-4">

                                    <div class="space-y-3">

                                        <div>

                                            <p class="text-[10px] font-bold uppercase tracking-wide text-sky-600">
                                                Pilar {{ $kegiatan->pilar }}
                                            </p>

                                            <p class="mt-1 text-sm font-bold text-sky-950">
                                                {{ $kegiatan->pertanyaan->subpilar->nama_pilar }}
                                            </p>

                                        </div>


                                        <div>

                                            <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                                Kode LKE
                                            </p>

                                            <p class="mt-1 text-xs font-semibold text-slate-700">
                                                {{ $kegiatan->kode_pertanyaan }}
                                            </p>

                                        </div>


                                        <div>

                                            <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                                Indikator
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-slate-600">
                                                {{ $kegiatan->pertanyaan->nama_pertanyaan }}
                                            </p>

                                        </div>

                                    </div>


                                    {{-- <a href="#" --}}
                                    <a href="{{ route('lke.detail', $kegiatan->kode_pertanyaan) }}"
                                    class="shrink-0 inline-flex items-center gap-1.5
                                            rounded-lg border border-sky-200
                                            bg-white px-3 py-2
                                            text-[10px] font-semibold text-sky-700
                                            transition hover:bg-sky-50">

                                        <i data-lucide="external-link"
                                        class="h-3.5 w-3.5">
                                        </i>

                                        Detail LKE

                                    </a>

                                </div>

                            </div>

                        </div>

                    </section>
                </main>




                {{-- =================================================
                    KOLOM KANAN - BUKTI DUKUNG
                ================================================== --}}
                <aside
                    class="xl:sticky xl:top-5"
                >

                    <section
                        class="rounded-2xl
                            border border-slate-200 bg-white shadow-sm"
                    >

                        {{-- =================================================
                            HEADER
                        ================================================== --}}
                        <div class="flex items-center justify-between
                                    border-b border-slate-200 px-5 py-4">

                            <div>

                                <h2 class="text-sm font-bold uppercase
                                        tracking-wide text-sky-950">
                                    Dokumentasi Kegiatan
                                </h2>

                                <p class="mt-1 text-[10px] text-slate-400">
                                    Dokumentasi berdasarkan periode pelaksanaan
                                </p>

                            </div>

                        </div>


                        {{-- =================================================
                            CONTENT
                        ================================================== --}}
                        <div class="flex-1 overflow-y-auto p-5">

                            @forelse($pelaksanaan as $item)

                                @php

                                    /*
                                    |--------------------------------------------------------------------------
                                    | FREKUENSI KEGIATAN
                                    |--------------------------------------------------------------------------
                                    */
                                    $frekuensi = strtolower(
                                        trim($kegiatan->frekuensi_pelaksanaan ?? '')
                                    );


                                    /*
                                    |--------------------------------------------------------------------------
                                    | NOMOR PERIODE
                                    |--------------------------------------------------------------------------
                                    */
                                    $periode = (int) $item->periode_ke;


                                    /*
                                    |--------------------------------------------------------------------------
                                    | NAMA PERIODE
                                    |--------------------------------------------------------------------------
                                    */
                                    if (str_contains($frekuensi, 'triwulan')) {

                                        $romawi = match ($periode) {
                                            1 => 'I',
                                            2 => 'II',
                                            3 => 'III',
                                            4 => 'IV',
                                            default => (string) $periode,
                                        };

                                        $namaPeriode = 'Triwulan ' . $romawi;


                                    } elseif (str_contains($frekuensi, 'semester')) {

                                        $romawi = match ($periode) {
                                            1 => 'I',
                                            2 => 'II',
                                            default => (string) $periode,
                                        };

                                        $namaPeriode = 'Semester ' . $romawi;


                                    } elseif (str_contains($frekuensi, 'bulan')) {

                                        $namaPeriode = 'Bulan ' . $periode;
                                        $romawi = $periode;


                                    } elseif (str_contains($frekuensi, 'tahun')) {

                                        $namaPeriode = 'Tahun ke-' . $periode;
                                        $romawi = $periode;


                                    } else {

                                        $namaPeriode = 'Periode ' . $periode;
                                        $romawi = $periode;

                                    }


                                    /*
                                    |--------------------------------------------------------------------------
                                    | STATUS
                                    |--------------------------------------------------------------------------
                                    */
                                    $status = strtolower(
                                        trim($item->status_pelaksanaan ?? 'menunggu')
                                    );


                                    /*
                                    |--------------------------------------------------------------------------
                                    | JENIS BUKTI DUKUNG
                                    |--------------------------------------------------------------------------
                                    |
                                    | Nilai diambil dari:
                                    | $kegiatan->jenis_bukti
                                    |
                                    | Contoh:
                                    | PDF
                                    | IMG
                                    | Image
                                    | PDF / IMG
                                    |
                                    */
                                    $jenisBukti = strtolower(
                                        trim($kegiatan->jenis_bukti ?? '')
                                    );


                                    /*
                                    |--------------------------------------------------------------------------
                                    | ACCEPT FILE
                                    |--------------------------------------------------------------------------
                                    */
                                    $accept = '';
                                    $labelJenisBukti = '';


                                    if (
                                        str_contains($jenisBukti, 'pdf') &&
                                        (
                                            str_contains($jenisBukti, 'img') ||
                                            str_contains($jenisBukti, 'image') ||
                                            str_contains($jenisBukti, 'gambar') ||
                                            str_contains($jenisBukti, 'foto')
                                        )
                                    ) {

                                        // PDF + gambar
                                        $accept = '.pdf,.jpg,.jpeg,.png,.webp';
                                        $labelJenisBukti = 'PDF atau Gambar';


                                    } elseif (str_contains($jenisBukti, 'pdf')) {

                                        // Hanya PDF
                                        $accept = '.pdf,application/pdf';
                                        $labelJenisBukti = 'PDF';


                                    } elseif (
                                        str_contains($jenisBukti, 'img') ||
                                        str_contains($jenisBukti, 'image') ||
                                        str_contains($jenisBukti, 'gambar') ||
                                        str_contains($jenisBukti, 'foto')
                                    ) {

                                        // Hanya gambar
                                        $accept = '.jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp';
                                        $labelJenisBukti = 'Gambar';


                                    } else {

                                        // Default
                                        $accept = '.pdf,.jpg,.jpeg,.png,.webp';
                                        $labelJenisBukti = 'PDF atau Gambar';

                                    }

                                @endphp


                                {{-- =================================================
                                    SATU PERIODE
                                ================================================== --}}
                                <div
                                    class="{{ !$loop->last ? 'mb-4' : '' }}
                                        rounded-xl border border-slate-200
                                        bg-white"
                                >

                                    {{-- =================================================
                                        HEADER PERIODE
                                    ================================================== --}}
                                    <div
                                        class="flex items-center justify-between
                                            border-b border-slate-200
                                            bg-slate-50 px-4 py-4"
                                    >

                                        <div class="flex items-center gap-3">

                                            {{-- Nomor --}}
                                            <div
                                                class="flex h-8 w-8 shrink-0
                                                    items-center justify-center
                                                    rounded-lg bg-sky-100"
                                            >

                                                <span
                                                    class="text-[10px] font-bold
                                                        text-sky-700"
                                                >
                                                    {{ $romawi }}
                                                </span>

                                            </div>


                                            {{-- Informasi --}}
                                            <div>

                                                <p
                                                    class="text-xs font-bold
                                                        text-slate-700"
                                                >
                                                    {{ $namaPeriode }}
                                                </p>


                                                <p
                                                    class="mt-0.5 text-[9px]
                                                        text-slate-400"
                                                >

                                                    @if($item->waktu_pelaksanaan)

                                                        {{ \Carbon\Carbon::parse(
                                                            $item->waktu_pelaksanaan
                                                        )->translatedFormat('d F Y') }}

                                                    @else

                                                        Tanggal belum ditentukan

                                                    @endif

                                                </p>

                                            </div>

                                        </div>


                                        {{-- =================================================
                                            STATUS
                                        ================================================== --}}
                                        <div>

                                            @if($status === 'selesai')

                                                <span
                                                    class="rounded-full bg-emerald-50
                                                        px-2 py-0.5 text-[8px]
                                                        font-bold text-emerald-700"
                                                >
                                                    Selesai
                                                </span>

                                            @elseif($status === 'berlangsung')

                                                <span
                                                    class="rounded-full bg-amber-50
                                                        px-2 py-0.5 text-[8px]
                                                        font-bold text-amber-700"
                                                >
                                                    Berlangsung
                                                </span>

                                            @elseif($status === 'terlambat')

                                                <span
                                                    class="rounded-full bg-rose-50
                                                        px-2 py-0.5 text-[8px]
                                                        font-bold text-rose-700"
                                                >
                                                    Terlambat
                                                </span>

                                            @else

                                                <span
                                                    class="rounded-full bg-slate-100
                                                        px-2 py-0.5 text-[8px]
                                                        font-bold text-slate-500"
                                                >
                                                    Menunggu
                                                </span>

                                            @endif

                                        </div>

                                    </div>


                                    {{-- =================================================
                                        FILE / UPLOAD
                                    ================================================== --}}
                                    <div class="p-4">

                                        {{-- =================================================
                                            SUDAH ADA DOKUMENTASI
                                        ================================================== --}}
                                        @if(!empty($item->dokumentasi))

                                            <div
                                                class="flex items-center gap-3
                                                    rounded-lg border
                                                    border-slate-200
                                                    bg-white p-3"
                                            >

                                                {{-- ICON --}}
                                                <div
                                                    class="flex h-9 w-9 shrink-0
                                                        items-center justify-center
                                                        rounded-lg bg-blue-50"
                                                >

                                                    @if(
                                                        str_contains(
                                                            strtolower($item->dokumentasi),
                                                            '.pdf'
                                                        )
                                                    )

                                                        <i
                                                            data-lucide="file-text"
                                                            class="h-4 w-4 text-blue-500"
                                                        ></i>

                                                    @else

                                                        <i
                                                            data-lucide="image"
                                                            class="h-4 w-4 text-blue-500"
                                                        ></i>

                                                    @endif

                                                </div>


                                                {{-- INFORMASI --}}
                                                <div class="min-w-0 flex-1">

                                                    <p
                                                        class="truncate text-xs
                                                            font-semibold
                                                            text-slate-700"
                                                    >
                                                        Dokumentasi {{ $namaPeriode }} 
                                                    </p>


                                                    <p
                                                        class="mt-1 truncate text-[9px]
                                                            text-slate-400"
                                                    >
                                                        @if(empty($item->time_updated))
                                                                Diupload: 
                                                            @else
                                                                Diperbarui: 
                                                            @endif
                                                        {{ Carbon\Carbon::parse($item->time_updated)->setTimezone('Asia/Makassar')->format('d M Y, H:i') }}
                                                    </p>

                                                </div>


                                                {{-- ACTION --}}
                                                <div
                                                    class="flex shrink-0
                                                        items-center gap-1"
                                                >

                                                    {{-- LIHAT --}}
                                                    <a
                                                        href="{{ asset('storage/' . $item->dokumentasi) }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        title="Lihat"
                                                        class="inline-flex items-center
                                                            justify-center rounded-md
                                                            border border-sky-200
                                                            bg-sky-50 p-1.5
                                                            text-sky-700
                                                            transition
                                                            hover:bg-sky-100"
                                                    >

                                                        <i
                                                            data-lucide="eye"
                                                            class="h-3.5 w-3.5"
                                                        ></i>

                                                    </a>

                                                    {{-- Download --}}
                                                    <a
                                                        href="{{ route('download.dokumentasi', $item->id) }}"
                                                        download
                                                        title="Unduh"
                                                        class="inline-flex items-center
                                                                justify-center rounded-md
                                                                border border-emerald-200
                                                                bg-emerald-50 p-1.5
                                                                text-emerald-700
                                                                transition hover:bg-emerald-100"
                                                    >

                                                        <i
                                                            data-lucide="download"
                                                            class="h-3.5 w-3.5"
                                                        ></i>

                                                    </a>


                                                    {{-- GANTI --}}
                                                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'pilar')
                                                    <form
                                                        action="{{route('upload.dokumentasi', $item->id) }}"
                                                        method="POST"
                                                        enctype="multipart/form-data"
                                                        class="inline"
                                                    >

                                                        @csrf

                                                        <input
                                                            type="file"
                                                            name="dokumentasi"
                                                            id="ganti-dokumentasi-{{ $item->id }}"
                                                            class="hidden"
                                                            accept="{{ $accept }}"
                                                            onchange="this.form.submit()"
                                                        >

                                                        <label
                                                            for="ganti-dokumentasi-{{ $item->id }}"
                                                            title="Edit"
                                                            class="inline-flex cursor-pointer
                                                                items-center justify-center
                                                                rounded-md
                                                                border border-amber-200
                                                                bg-amber-50 p-1.5
                                                                text-amber-700
                                                                transition
                                                                hover:bg-amber-100"
                                                        >

                                                            <i
                                                                data-lucide="pencil"
                                                                class="h-3.5 w-3.5"
                                                            ></i>

                                                        </label>

                                                    </form>
                                                @endif
                                                    
                                                    {{-- Hapus --}}
                                                @if(Auth::user()->role === 'admin')
                                                    <form
                                                        action="{{ route('delete.dokumentasi', $item->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus dokumentasi ini?')"
                                                    >
                                                        @csrf

                                                        <button
                                                            type="submit"
                                                            title="Hapus"
                                                            class="inline-flex items-center justify-center rounded-md
                                                                border border-red-200 bg-red-50 p-1.5 cursor-pointer
                                                                text-red-600 transition hover:bg-red-100"
                                                        >
                                                            <i data-lucide="trash" class="h-3.5 w-3.5"></i>
                                                        </button>
                                                    </form>
                                                @endif



                                                </div>

                                            </div>


                                        @else


                                            {{-- =================================================
                                                BELUM ADA DOKUMENTASI
                                            ================================================== --}}
                                            <form
                                                action="{{route('upload.dokumentasi', $item->id) }}"
                                                method="POST"
                                                enctype="multipart/form-data"
                                            >

                                                @csrf

                                                <input
                                                    type="file"
                                                    name="dokumentasi"
                                                    id="dokumentasi-{{ $item->id }}"
                                                    class="hidden"
                                                    accept="{{ $accept }}"
                                                    onchange="this.form.submit()"
                                                >


                                                {{-- UPLOAD AREA --}}
                                            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'pilar')
                                                <label
                                                    for="dokumentasi-{{ $item->id }}"
                                                    class="flex w-full cursor-pointer
                                                        flex-col items-center justify-center
                                                        rounded-xl border-2 border-dashed
                                                        border-slate-200 bg-slate-50
                                                        px-4 py-5 text-center
                                                        transition
                                                        hover:border-sky-300
                                                        hover:bg-sky-50"
                                                >

                                                    {{-- ICON --}}
                                                    <div
                                                        class="flex h-8 w-8
                                                            items-center justify-center
                                                            rounded-full bg-white
                                                            shadow-sm"
                                                    >

                                                        <i
                                                            data-lucide="upload"
                                                            class="h-4 w-4 text-sky-600"
                                                        ></i>

                                                    </div>


                                                    {{-- TITLE --}}
                                                    <p
                                                        class="mt-3 text-xs font-semibold
                                                            text-slate-700"
                                                    >
                                                        Upload Dokumentasi
                                                    </p>


                                                    {{-- JENIS BUKTI --}}
                                                    <p
                                                        class="mt-1 text-[10px]
                                                            font-medium text-sky-600"
                                                    >
                                                        {{ $labelJenisBukti }}
                                                    </p>


                                                    {{-- SIZE --}}
                                                    <p
                                                        class="mt-1 text-[10px]
                                                            text-slate-400"
                                                    >
                                                        Maksimal 5 MB
                                                    </p>

                                                </label>
                                            @endif

                                            </form>

                                        @endif

                                    </div>

                                </div>


                            @empty


                                {{-- =================================================
                                    BELUM ADA PELAKSANAAN
                                ================================================== --}}
                                <div
                                    class="rounded-xl border border-dashed
                                        border-slate-300 bg-slate-50
                                        p-6 text-center"
                                >

                                    <i
                                        data-lucide="calendar-x"
                                        class="mx-auto h-6 w-6 text-slate-300"
                                    ></i>


                                    <p
                                        class="mt-2 text-sm font-medium
                                            text-slate-500"
                                    >
                                        Belum ada pelaksanaan
                                    </p>


                                    <p
                                        class="mt-1 text-[10px]
                                            text-slate-400"
                                    >
                                        Data pelaksanaan kegiatan belum tersedia.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </section>

                </aside>

            </div>

        </div>

    </div>

</div>

@endsection

<script>
    let selectedPelaksanaanId = null;


    /* =========================================================
    BUKA MODAL EDIT JADWAL
    ========================================================= */
    function openEditJadwal(id, tanggal)
    {
        selectedPelaksanaanId = id;

        const modal =
            document.getElementById('editJadwalModal');

        const input =
            document.getElementById('editWaktuPelaksanaan');

        const current =
            document.getElementById('currentWaktuPelaksanaan');

        const error =
            document.getElementById('editWaktuError');


        /*
        |--------------------------------------------------------------------------
        | Isi tanggal input
        |--------------------------------------------------------------------------
        */
        input.value = tanggal ?? '';


        /*
        |--------------------------------------------------------------------------
        | Tampilkan tanggal saat ini
        |--------------------------------------------------------------------------
        */
        if (tanggal) {

            const date = new Date(tanggal + 'T00:00:00');

            current.textContent =
                date.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

        } else {

            current.textContent = '-';

        }


        /*
        |--------------------------------------------------------------------------
        | Reset error
        |--------------------------------------------------------------------------
        */
        error.textContent = '';
        error.classList.add('hidden');


        /*
        |--------------------------------------------------------------------------
        | Tampilkan modal
        |--------------------------------------------------------------------------
        */
        modal.classList.remove('hidden');
        modal.classList.add('flex');


        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }


    /* =========================================================
    TUTUP MODAL
    ========================================================= */
    function closeEditJadwal()
    {
        const modal =
            document.getElementById('editJadwalModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        selectedPelaksanaanId = null;
    }


    /* =========================================================
    SIMPAN JADWAL
    ========================================================= */
    async function saveEditJadwal() {

        const kegiatanId = window.editKegiatanId;
        const tanggal = document.getElementById('editWaktuPelaksanaan').value;
        const errorElement = document.getElementById('editWaktuError');
        const button = document.getElementById('btnSimpanWaktu');

        errorElement.classList.add('hidden');
        errorElement.textContent = '';

        if (!tanggal) {
            errorElement.textContent = 'Tanggal wajib dipilih.';
            errorElement.classList.remove('hidden');
            return;
        }

        button.disabled = true;
        button.innerHTML = `
            <i data-lucide="loader-2" class="h-3.5 w-3.5 animate-spin"></i>
            Menyimpan...
        `;

        try {

            const response = await fetch(
                `/pelaksanaan/${selectedPelaksanaanId}/waktu`,
                {
                    method: 'PUT',

                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'),

                        'Accept': 'application/json'
                    },

                    body: JSON.stringify({
                        waktu_pelaksanaan: tanggal
                    })
                }
            );

            const result = await response.json();

            if (!response.ok) {
                throw new Error(
                    result.message || 'Gagal memperbarui tanggal.'
                );
            }

            // ==========================================
            // BERHASIL
            // ==========================================

            closeEditJadwal();

            // Refresh halaman agar data terbaru dari database tampil
            window.location.reload();

        } catch (error) {

            errorElement.textContent = error.message;
            errorElement.classList.remove('hidden');

            button.disabled = false;

            button.innerHTML = `
                <i data-lucide="save" class="h-3.5 w-3.5"></i>
                Simpan
            `;

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }
    }

    


</script>

