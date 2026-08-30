@extends('layouts.app')
@section('title', 'LKE')

@php
    // $tahap = 'selesai';
    $role = Auth::user()->role;

    $isAdmin = $role === 'admin';
    $isSekretaris = $role === 'sekretaris';

    $bisaPemeriksaan = $isAdmin || $isSekretaris;
    $bisaUpload = $isAdmin || $role === 'pilar';
    $bisaMelihat = $role === 'pilar'|| $role === 'bps';

    $buktiAda = $pertanyaan->buktiDukung->isNotEmpty();

    $pemeriksaanTerakhir = $pertanyaan->pemeriksaanTerakhir;

    $sudahDiperiksa = $pemeriksaanTerakhir !== null;

    $pemeriksaanSesuai =
        $sudahDiperiksa &&
        $pemeriksaanTerakhir->status_pemeriksaan === 'sesuai';

    $statusPemeriksaan =
        $pemeriksaanTerakhir->status_pemeriksaan ?? '-';

    $catatanPemeriksaan =
        $pemeriksaanTerakhir->catatan_pemeriksaan ?? '-';

    $jawabanTerakhir =
        $pemeriksaanTerakhir->jawaban ?? '-';

    $narasiTerakhir =
        $pemeriksaanTerakhir->narasi ?? '-';

@endphp

@section('content')

{{-- =========================================================
    BREADCRUMB
========================================================= --}}
<div class="mb-2 flex items-center gap-1 text-[10px] text-slate-400">

    <a href="{{ route('lke') }}"
        class="transition hover:text-sky-700">
        Lembar Kerja Evaluasi
    </a>

    <i data-lucide="chevron-right" class="h-3 w-3"></i>

    <span class="font-medium text-slate-600">
        Detail Indikator
    </span>

</div>


{{-- =========================================================
    MAIN WRAPPER
========================================================= --}}
<div class="rounded-xl border border-slate-200 shadow-sm">

    <div class="min-h-screen bg-slate-50">


        {{-- =====================================================
            HEADER
        ====================================================== --}}
        <div class="border-b border-slate-200 bg-white">

            <div class="mx-auto max-w-[1600px] px-3 py-2 pb-3 sm:px-6">

                {{-- Judul indikator --}}
                <div>

                    <div class="flex flex-wrap items-center gap-2">

                        {{-- Aspek --}}
                        <span class="inline-flex items-center gap-1.5 rounded-full
                                    border border-slate-100 bg-slate-100
                                    px-2.5 py-1 text-[10px] font-medium
                                    text-slate-700">

                            {{ Str::title($pertanyaan->subpilar->nama_aspek ?? '-') }}

                        </span>


                        {{-- Status --}}
                    @if ($pertanyaan->status_pertanyaan === 'pemeriksaan')

                        <span class="inline-flex items-center gap-1.5 rounded-full
                                    border border-blue-100 px-2.5 py-1.5
                                    text-[10px] font-medium text-sky-700 bg-blue-50
                                    transition">

                            <i data-lucide="loader"
                                class="h-3.5 w-3.5"></i>

                            Pemeriksaan
                        </span>

                    @elseif ($pertanyaan->status_pertanyaan === 'belum')

                        <span class="inline-flex items-center gap-1.5 rounded-full
                                    border border-slate-100 px-2.5 py-1.5
                                    text-[10px] font-medium text-slate-700 bg-slate-50
                                    transition">

                            <i data-lucide="clock"
                                class="h-3.5 w-3.5"></i>

                            Belum
                        </span>

                    @elseif ($pertanyaan->status_pertanyaan === 'perbaikan')

                        <span class="inline-flex items-center gap-1.5 rounded-full
                                    border border-amber-100 px-2.5 py-1.5
                                    text-[10px] font-medium text-amber-700 bg-amber-50
                                    transition">

                            <i data-lucide="square-pen"
                                class="h-3.5 w-3.5"></i>

                            Perbaikan
                        </span>

                    @elseif ($pertanyaan->status_pertanyaan === 'sesuai')

                        <span class="inline-flex items-center gap-1.5 rounded-full
                                    border border-indigo-100 px-2.5 py-1.5
                                    text-[10px] font-medium text-indigo-700 bg-indigo-50
                                    transition">

                            <i data-lucide="circle-check"
                                class="h-3.5 w-3.5"></i>

                            Sesuai
                        </span>

                    @elseif ($pertanyaan->status_pertanyaan === 'dinilai')

                        <span class="inline-flex items-center gap-1.5 rounded-full
                                    border border-emerald-100 px-2.5 py-1.5
                                    text-[10px] font-medium text-emerald-700 bg-emerald-50
                                    transition">

                            <i data-lucide="award"
                                class="h-3.5 w-3.5"></i>

                            Dinilai
                        </span>

                    @elseif ($pertanyaan->status_pertanyaan === 'terlambat')

                        <span class="inline-flex items-center gap-1.5 rounded-full
                                    border border-red-100 px-2.5 py-1.5
                                    text-[10px] font-medium text-red-700 bg-red-50
                                    transition">

                            <i data-lucide="triangle-alert"
                                class="h-3.5 w-3.5"></i>

                            Terlambat
                        </span>

                    @else

                        <span class="inline-flex items-center gap-1.5 rounded-full
                                    border border-slate-100 px-2.5 py-1.5
                                    text-[10px] font-medium text-slate-500 bg-slate-50
                                    transition">

                            <i data-lucide="circle-help"
                                class="h-3.5 w-3.5"></i>

                            Tidak diketahui
                        </span>

                    @endif

                    </div>


                    <h1 class="mt-2 text-md font-bold leading-5 text-sky-950 sm:text-base">
                        {{ Str::title($pertanyaan->nama_pertanyaan) }}
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
                    FORM PEMERIKSAAN
                ================================================== --}}
                <form
                    action="{{ route('lke.pemeriksaan.simpan', $pertanyaan->id_pertanyaan) }}"
                    method="POST"
                    class="space-y-5">
                
                @csrf

                <input
                    type="hidden"
                    name="tahap"
                    value="{{ $tahap }}"
                >


                    {{-- =================================================
                        1. INFORMASI INDIKATOR
                    ================================================== --}}
                    <section class="rounded-2xl border border-slate-200
                                    bg-white shadow-sm">

                        <div class="border-b border-slate-200 px-5 py-4">

                            <div class="flex items-center gap-2">

                                <div class="flex h-8 w-8 items-center justify-center
                                            rounded-lg bg-sky-50">

                                    <i data-lucide="book-open"
                                        class="h-4 w-4 text-sky-700"></i>

                                </div>


                                <div>

                                    <h2 class="text-xs font-bold uppercase
                                               tracking-wide text-slate-700">
                                        Informasi Indikator
                                    </h2>

                                    <p class="mt-0.5 text-[10px] text-slate-400">
                                        Informasi konteks dan kriteria penilaian LKE
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="space-y-5 p-5">


                            {{-- KONTEKS --}}
                            <div class="border-l-2 border-sky-200 pl-4">

                                <p class="text-xs font-bold text-sky-700">
                                    PILAR {{ $pertanyaan->subpilar->pilar }}
                                </p>

                                <h3 class="mt-1 text-md font-bold text-sky-950">
                                    {{ $pertanyaan->subpilar->nama_pilar }}
                                </h3>

                                <p class="mt-1 text-xs font-medium text-slate-500">
                                    {{ $pertanyaan->subpilar->subpilar }}.
                                    {{ $pertanyaan->subpilar->nama_subpilar }}
                                </p>

                            </div>



                            {{-- KRITERIA NILAI --}}
                            <div>

                                <div class="mb-3 flex items-center gap-2">

                                    <i data-lucide="target"
                                        class="h-4 w-4 text-sky-600"></i>

                                    <h3 class="text-xs font-bold uppercase
                                               tracking-wide text-slate-600">
                                        Kriteria Nilai
                                    </h3>

                                </div>


                                <div class="rounded-xl border border-slate-200
                                            bg-slate-50 p-4">

                                    <div class="space-y-2 text-xs leading-5 text-slate-700">

                                        {!! nl2br(e($pertanyaan->kriteria_nilai)) !!}

                                    </div>

                                </div>

                            </div>



                            {{-- BUKTI DUKUNG --}}
                            <div>

                                <div class="mb-3 flex items-center gap-2">

                                    <i data-lucide="folder-plus"
                                        class="h-4 w-4 text-sky-600"></i>

                                    <h3 class="text-xs font-bold uppercase
                                               tracking-wide text-slate-600">
                                        Bukti Dukung
                                    </h3>

                                </div>


                                <div class="rounded-xl border border-slate-200
                                            bg-slate-50 p-4">

                                    <div class="space-y-2 text-xs leading-5 text-slate-700">

                                        @forelse($pertanyaan->buktiDukung as $bukti)

                                            <p>
                                                {{ $bukti->nama_bukti_dukung }}
                                            </p>

                                        @empty

                                            <p class="text-slate-400">
                                                -
                                            </p>

                                        @endforelse

                                    </div>

                                </div>

                            </div>



                            {{-- PEDOMAN --}}
                            <div>

                                <div class="mb-3 flex items-center gap-2">

                                    <i data-lucide="link"
                                        class="h-4 w-4 text-sky-600"></i>

                                    <h3 class="text-xs font-bold uppercase
                                               tracking-wide text-slate-600">
                                        Pedoman Bukti Dukung
                                    </h3>

                                </div>


                                <div class="rounded-xl border border-slate-200
                                            bg-white p-4">

                                    <a href="{{ $pertanyaan->link_pedoman }}"
                                        target="_blank"
                                        class="flex items-start gap-2 text-xs
                                               font-medium leading-5 text-sky-700
                                               hover:underline">

                                        <i data-lucide="external-link"
                                            class="mt-0.5 h-3.5 w-3.5 shrink-0"></i>

                                        <span class="min-w-0 break-all">
                                            {{ $pertanyaan->link_pedoman }}
                                        </span>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </section>
               
            

                    @if (in_array($tahap, ['pemeriksaan', 'penilaian', 'selesai']))
                        {{-- =================================================
                            2. STATUS PEMERIKSAAN
                        ================================================== --}}
                        <section
                            class="rounded-2xl border border-slate-200
                                bg-white shadow-sm"
                            x-data="{
                                open: false,
                                selected: '{{ Str::title($statusPemeriksaan ?? '') }}',
                                value: '{{ $statusPemeriksaan ?? '' }}'
                            }"
                        >

                            <div class="px-5 pt-5">

                                <div class="flex items-center gap-2">

                                    <i data-lucide="shapes"
                                        class="h-4 w-4 text-sky-600"></i>

                                    <h2 class="text-xs font-bold uppercase
                                            tracking-wide text-slate-600">

                                        Status Pemeriksaan

                                        @if($bisaPemeriksaan)<span class="text-red-500">*</span>@endif

                                    </h2>

                                </div>

                                
                                <p class="mt-1 text-[10px] leading-4 text-slate-400">
                                    @if($bisaPemeriksaan)
                                        Tentukan status berdasarkan hasil pemeriksaan
                                        mandiri terhadap bukti dukung.
                                    @else
                                        Status berdasarkan hasil pemeriksaan
                                        mandiri terhadap bukti dukung.
                                    @endif
                                </p>
                                

                            </div>


                            <div class="relative p-5">
                            @if($bisaPemeriksaan && $buktiAda && $tahap === 'pemeriksaan')



                                {{-- Tombol Dropdown --}}
                                <button
                                    type="button"
                                    @click="open = !open"
                                    @click.outside="open = false"
                                    class="flex w-full items-center justify-between
                                        rounded-xl border border-slate-200
                                        bg-white px-4 py-3 text-left text-sm
                                        text-slate-700 outline-none transition
                                        hover:border-slate-300
                                        focus:border-sky-500
                                        focus:ring-2 focus:ring-sky-100"
                                >

                                    <span
                                        class="truncate"
                                        x-text="selected">
                                    </span>


                                    <i
                                        data-lucide="chevron-down"
                                        class="ml-3 h-4 w-4 shrink-0 text-slate-400
                                            transition-transform duration-200"
                                        :class="{ 'rotate-180': open }">
                                    </i>

                                </button>



                                {{-- Dropdown --}}
                                <div
                                    x-show="open"
                                    x-transition
                                    class="absolute left-5 right-5
                                        top-[calc(100%-1rem)] z-30 mt-1
                                        overflow-hidden rounded-xl border
                                        border-slate-200 bg-white shadow-lg"
                                    style="display: none;"
                                >


                                    {{-- SESUAI --}}
                                    <button
                                        type="button"
                                        @click="
                                            selected = 'Sesuai';
                                            value = 'sesuai';
                                            open = false;
                                        "
                                        class="w-full px-4 py-3 text-left
                                            text-xs leading-5 text-slate-700
                                            transition hover:bg-emerald-50
                                            hover:text-emerald-700"
                                    >

                                        <div class="flex items-start gap-3">

                                            <div class="mt-0.5 flex h-5 w-5 shrink-0
                                                        items-center justify-center
                                                        rounded-full bg-emerald-50">

                                                <i data-lucide="check"
                                                    class="h-3 w-3 text-emerald-600"></i>

                                            </div>


                                            <div>
                                                <p class="font-medium">
                                                    Sesuai
                                                </p>
                                            </div>

                                        </div>

                                    </button>



                                    {{-- PERBAIKAN --}}
                                    <button
                                        type="button"
                                        @click="
                                            selected = 'Perbaikan';
                                            value = 'perbaikan';
                                            open = false;
                                        "
                                        class="w-full border-t border-slate-100
                                            px-4 py-3 text-left text-xs
                                            leading-5 text-slate-700
                                            transition hover:bg-amber-50
                                            hover:text-amber-700"
                                    >

                                        <div class="flex items-start gap-3">

                                            <div class="mt-0.5 flex h-5 w-5 shrink-0
                                                        items-center justify-center
                                                        rounded-full bg-amber-50">

                                                <i data-lucide="alert-triangle"
                                                    class="h-3 w-3 text-amber-600"></i>

                                            </div>


                                            <div>
                                                <p class="font-medium">
                                                    Perbaikan
                                                </p>
                                            </div>

                                        </div>

                                    </button>

                                </div>



                                {{-- Hidden value --}}
                                <input
                                    type="hidden"
                                    name="status_pemeriksaan"
                                    :value="value"
                                    required
                            
                                >
                            
                            @else

                                {{-- USER YANG HANYA BOLEH MELIHAT --}}
                                <div
                                    class="flex w-full items-center justify-between
                                        rounded-xl border border-slate-200
                                        bg-slate-50 px-4 py-3 text-left text-sm
                                        text-slate-700"
                                >
                                    <span class="truncate">
                                        {{ $statusPemeriksaan
                                            ? ucfirst($statusPemeriksaan)
                                            : '-' }}
                                    </span>

                                    <i
                                        data-lucide="chevron-down"
                                        class="ml-3 h-4 w-4 shrink-0 text-slate-300"
                                    ></i>
                                </div>

                            @endif

                            </div>

                        </section>
                    @endif

                    @if (in_array($tahap, ['pemeriksaan', 'penilaian', 'selesai']))
                        
                        {{-- =================================================
                            3. CATATAN PEMERIKSAAN MANDIRI
                        ================================================== --}}
                        <section class="rounded-2xl border border-slate-200
                                        bg-white shadow-sm">

                            <div class="px-5 pt-5">

                                <div class="flex items-center gap-2">

                                    <i data-lucide="clipboard-check"
                                        class="h-4 w-4 text-sky-600"></i>

                                    <h2 class="text-xs font-bold uppercase
                                            tracking-wide text-slate-600">
                                        Catatan Pemeriksaan Mandiri

                                        @if($bisaPemeriksaan)<span class="text-red-500">*</span>@endif

                                    </h2>

                                </div>


                                <p class="mt-1 text-[10px] leading-4 text-slate-400">
                                    Catatan hasil pemeriksaan bukti dukung sebelum
                                    dilakukan penilaian.
                                </p>

                            </div>


                            <div class="p-5">

      
                                @if($bisaPemeriksaan && $buktiAda && $tahap === 'pemeriksaan')
                                <textarea
                                    rows="4"
                                    name="catatan_pemeriksaan"
                                    class="w-full resize-none rounded-xl
                                        border border-slate-200 bg-white
                                        px-4 py-3 text-sm leading-6 text-slate-700
                                        outline-none transition
                                        placeholder:text-slate-400
                                        focus:border-sky-500
                                        focus:ring-2 focus:ring-sky-100"
                                    placeholder="Tuliskan hasil pemeriksaan bukti dukung..."
                                ></textarea>

                                @else
                                <div class="w-full resize-none rounded-xl
                                        border border-slate-200 bg-slate-50
                                        px-4 py-3 text-sm leading-6 text-slate-700
                                        outline-none transition">
                                    <p class="text-sm text-slate-600">
                                        {{ $catatanPemeriksaan ?? '-' }}
                                    </p>
                                </div>
                                @endif
                            
                            </div>

                        </section>
                    @endif




                    {{-- =================================================
                        7. RIWAYAT CATATAN MANDIRI
                    ================================================== --}}
                    @if (in_array($tahap, ['pemeriksaan', 'penilaian', 'selesai']) )
                        <section class="rounded-2xl border border-slate-200
                                        bg-white shadow-sm">

                            <div class="px-5 pt-5">

                                <div class="flex items-center gap-2">

                                        <i data-lucide="history"
                                            class="h-4 w-4 text-sky-600"></i>

                                        <h2 class="text-xs font-bold uppercase
                                                tracking-wide text-slate-600">
                                            Riwayat Catatan Pemeriksaan Mandiri
                                        </h2>

                                </div>


                                <p class="mt-1 text-[10px] leading-4 text-slate-400">
                                    Catatan hasil pemeriksaan bukti dukung sebelumnya.
                                </p>

                                </div>

                            {{-- </div> --}}


                            <div class="space-y-2 p-5 max-h-54 overflow-y-auto ">

                                @forelse(
                                    $pertanyaan->pemeriksaan->sortByDesc('created_at')
                                    as $pemeriksaan
                                )

                                    <div class="rounded-xl border border-slate-200
                                                bg-slate-50 p-4 max-h-36">




                                        {{-- Isi --}}
                                        <div class="space-y-2">

                                            {{-- Catatan --}}
                                            @if($pemeriksaan->catatan_pemeriksaan)

                                                <div class="
                                                            ">

                                                    <p class="text-[10px] font-medium
                                                            tracking-wide
                                                            text-slate-500">
                                                        <span class="text-[10px] font-bold
                                                            uppercase tracking-wide text-slate-700"
                                                        ><span class=" rounded-xl py-0.5 px-1 border font-medium capitalize
                                                            {{ 
                                                                $pemeriksaan->status_pemeriksaan === 'sesuai'
                                                                    ? 'text-emerald-700 bg-emerald-50 border-emerald-100'
                                                                    : 'text-amber-700 bg-amber-50 border-amber-100'
                                                            }}">{{ ucfirst($pemeriksaan->status_pemeriksaan) }}</span>

                                                             Catatan Pemeriksaan  </span>
                                                        • {{ Carbon\Carbon::parse($pemeriksaan->created_at)->setTimezone('Asia/Makassar')->format('d M Y, H:i') }}
                                                    </p>


                                                    <p class="mt-1 text-sm leading-6
                                                            text-slate-600">

                                                        {{ Str::title($pemeriksaan->catatan_pemeriksaan) }}

                                                    </p>

                                                </div>

                                            @endif

                                        </div>

                                    </div>

                                @empty

                                    <div class="rounded-xl border border-dashed
                                                border-slate-300 bg-slate-50
                                                p-6 text-center">

                                        <i
                                            data-lucide="history"
                                            class="mx-auto h-6 w-6 text-slate-300"
                                        ></i>

                                        <p class="mt-2 text-xs font-medium
                                                text-slate-500">
                                            Belum ada riwayat pemeriksaan
                                        </p>

                                        <p class="mt-1 text-[10px] text-slate-400">
                                            Catatan pemeriksaan akan muncul setelah
                                            pemeriksaan disimpan.
                                        </p>

                                    </div>

                                @endforelse

                            </div>

                        </section>
                    @endif

                    {{-- =================================================
                        PERSIAPAN PILIHAN JAWABAN
                    ================================================== --}}


                    @php
                        /*
                        |--------------------------------------------------------------------------
                        | AMBIL PEMERIKSAAN TERAKHIR
                        |--------------------------------------------------------------------------
                        */

                        $pemeriksaanTerakhir = $pertanyaan->pemeriksaanTerakhir;

                        /*
                        | Jawaban dari DB:
                        | a / b / c / d / e
                        */

                        $jawabanTerakhir = strtolower(
                            trim((string) ($pemeriksaanTerakhir->jawaban ?? ''))
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | SIAPKAN PILIHAN JAWABAN
                        |--------------------------------------------------------------------------
                        */

                        $pilihan = preg_split(
                            '/\r\n|\r|\n/',
                            trim($pertanyaan->kriteria_nilai ?? '')
                        );

                        $pilihan = array_values(
                            array_filter(
                                $pilihan,
                                fn ($item) => trim($item) !== ''
                            )
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | CARI TEKS PILIHAN BERDASARKAN JAWABAN
                        |--------------------------------------------------------------------------
                        |
                        | Contoh:
                        |
                        | jawaban = a
                        |
                        | kriteria_nilai:
                        | A. Sangat Baik
                        | B. Baik
                        | C. Cukup
                        |
                        | hasil:
                        | A. Sangat Baik
                        |
                        */

                        $jawabanTerakhirText = '';

                        foreach ($pilihan as $item) {

                            $itemTrim = trim($item);

                            /*
                            |--------------------------------------------------------------
                            | YA / TIDAK
                            |--------------------------------------------------------------
                            */
                            if (
                                strtolower(trim($pertanyaan->kriteria_jawaban))
                                === 'ya/tidak'
                            ) {

                                if (
                                    strtolower($itemTrim)
                                    === $jawabanTerakhir
                                ) {
                                    $jawabanTerakhirText = $itemTrim;
                                    break;
                                }

                                continue;
                            }

                            /*
                            |--------------------------------------------------------------
                            | A / B / C / D / E
                            |--------------------------------------------------------------
                            */
                            if (preg_match(
                                '/^([a-eA-E])(?:[.\)]|\s)/',
                                $itemTrim,
                                $match
                            )) {

                                $kodeItem = strtolower($match[1]);

                                if ($kodeItem === $jawabanTerakhir) {
                                    $jawabanTerakhirText = $itemTrim;
                                    break;
                                }
                            }
                        }

                        /*
                        |--------------------------------------------------------------
                        | FALLBACK
                        |--------------------------------------------------------------
                        */
                        if (
                            $jawabanTerakhirText === ''
                            && $jawabanTerakhir !== ''
                        ) {
                            $jawabanTerakhirText = strtoupper(
                                $jawabanTerakhir
                            );
                        }
                    @endphp





                    @if (in_array($tahap, ['penilaian', 'selesai']))

                        {{-- =================================================
                            4. PILIH JAWABAN
                        ================================================== --}}
                        <section
                            class="rounded-2xl border border-slate-200
                                bg-white shadow-sm"
                            x-data="{
                                open: false,
                                selected: @js($jawabanTerakhirText),
                                value: @js($jawabanTerakhir)
                            }"
                        >

                            <div class="px-5 pt-5">

                                <div class="flex items-center gap-2">

                                    <i
                                        data-lucide="circle-star"
                                        class="h-4 w-4 text-sky-600"
                                    ></i>

                                    <h2 class="text-xs font-bold uppercase
                                            tracking-wide text-slate-600">

                                        Pilih Jawaban

                                        @if($bisaPemeriksaan)<span class="text-red-500">*</span>@endif

                                    </h2>

                                </div>

                                <p class="mt-1 text-[10px] leading-4 text-slate-400">
                                    @if($bisaPemeriksaan)
                                        Pilih jawaban yang sesuai dengan hasil
                                        penilaian mandiri.
                                    @else
                                        Jawaban yang sesuai dengan hasil
                                        penilaian mandiri.
                                    @endif
                                </p>
                                
                            </div>


                            <div class="relative p-5">
                            @if($bisaPemeriksaan && $buktiAda && $pemeriksaanSesuai)

                                {{-- Tombol Dropdown --}}
                                <button
                                    type="button"
                                    @click="open = !open"
                                    @click.outside="open = false"
                                    class="flex w-full items-center justify-between
                                        rounded-xl border border-slate-200
                                        bg-white px-4 py-3 text-left text-sm
                                        text-slate-700 outline-none transition
                                        hover:border-slate-300
                                        focus:border-sky-500
                                        focus:ring-2 focus:ring-sky-100"
                                >

                                    <span
                                        class="truncate"
                                        :class="
                                            selected
                                                ? 'text-slate-700'
                                                : 'text-slate-400'
                                        "
                                        x-text="selected || 'Pilih jawaban'"
                                    ></span>


                                    <i
                                        data-lucide="chevron-down"
                                        class="ml-3 h-4 w-4 shrink-0 text-slate-400
                                            transition-transform duration-200"
                                        :class="{ 'rotate-180': open }"
                                    ></i>

                                </button>



                                {{-- Dropdown Menu --}}
                                <div
                                    x-show="open"
                                    x-transition
                                    class="absolute left-5 right-5
                                        top-[calc(100%-1rem)] z-30 mt-1
                                        overflow-hidden rounded-xl border
                                        border-slate-200 bg-white shadow-lg"
                                    style="display: none;"
                                >

                                    <div class="max-h-72 overflow-y-auto p-1">

                                        @foreach($pilihan as $item)

                                            @php
                                                $itemTrim = trim($item);

                                                /*
                                                |--------------------------------------------------------------
                                                | Jika kriteria Ya/Tidak
                                                |--------------------------------------------------------------
                                                */
                                                if (preg_match('/^(ya|tidak)(?:[.)])?\s*/i', $itemTrim, $match)) {

                                                    $kodeItem = strtolower($match[1]);

                                                } elseif (preg_match('/^([a-eA-E])(?:[.)])?\s*/', $itemTrim, $match)) {

                                                    $kodeItem = strtolower($match[1]);

                                                } else {

                                                    $kodeItem = strtolower(substr($itemTrim, 0, 1));
                                                }
                                            @endphp

                                            <button
                                                type="button"
                                                @click="
                                                    selected = @js($itemTrim);
                                                    value = @js($kodeItem);
                                                    open = false;
                                                "
                                                class="w-full rounded-lg px-3 py-2.5
                                                    text-left text-sm text-slate-700
                                                    transition hover:bg-slate-50"
                                            >
                                                {{ $itemTrim }}
                                            </button>
                                        @endforeach

                                    </div>

                                </div>
                            
                                {{-- Nilai yang dikirim --}}
                                    <input
                                        type="hidden"
                                        name="jawaban"
                                        :value="value"
                                        required
                                    >
                            
                            @else

                                {{-- USER YANG HANYA BOLEH MELIHAT --}}
                                <div
                                    class="flex w-full items-center justify-between
                                        rounded-xl border border-slate-200
                                        bg-slate-50 px-4 py-3 text-left text-sm
                                        text-slate-700"
                                >
                                    <span class="truncate">
                                      
                                        {{ Str::title($jawabanTerakhir) ?? '-' }}
                                    </span>

                                    <i
                                        data-lucide="chevron-down"
                                        class="ml-3 h-4 w-4 shrink-0 text-slate-300"
                                    ></i>
                                </div>

                            
                            @endif
                            </div>

                        </section>
                    @endif


                    @if (in_array($tahap, ['penilaian', 'selesai']))

                        {{-- =================================================
                            5. NARASI
                        ================================================== --}}
                        <section class="rounded-2xl border border-slate-200
                                        bg-white shadow-sm">

                            <div class="px-5 pt-5">

                                <div class="flex items-center gap-2">

                                    <i data-lucide="file-text"
                                        class="h-4 w-4 text-sky-600"></i>

                                    <h2 class="text-xs font-bold uppercase
                                            tracking-wide text-slate-600">

                                        Narasi

                                        @if($bisaPemeriksaan)<span class="text-red-500">*</span>@endif


                                    </h2>

                                </div>


                                <p class="mt-1 text-[10px] leading-4 text-slate-400">
                                    Penjelasan yang mendukung hasil penilaian mandiri.
                                </p>

                            </div>


                            <div class="p-5">
                                @if($bisaPemeriksaan && $buktiAda && $pemeriksaanSesuai )
                                <textarea
                                    rows="5"
                                    name="narasi"
                                    class="w-full resize-none rounded-xl
                                        border border-slate-200 bg-white
                                        px-4 py-3 text-sm leading-6 text-slate-700
                                        outline-none transition
                                        placeholder:text-slate-400
                                        focus:border-sky-500
                                        focus:ring-2 focus:ring-sky-100"
                                    placeholder="Tuliskan narasi..."
                                >{{ $narasiTerakhir ?? '' }}</textarea>
                                @else
                                    {{-- USER YANG HANYA BOLEH MELIHAT --}}
                                    <div
                                        class="flex w-full items-center justify-between
                                            rounded-xl border border-slate-200
                                            bg-slate-50 px-4 py-3 text-left text-sm
                                            text-slate-700"
                                    >
                                        <span class="truncate">
                                            {{ $narasiTerakhir ?? '-' }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                        </section>
                    @endif

                    @if ($tahap === 'selesai')
                        {{-- =================================================
                            6. HASIL PENILAIAN MANDIRI
                        ================================================== --}}
                        @if($pertanyaan->pemeriksaanTerakhir->nilai !== null)
                        <section class="rounded-2xl border border-slate-200
                                        bg-white shadow-sm">

                            <div class="px-5 pt-5">

                                <div class="flex items-center gap-2">

                                    <i data-lucide="award"
                                        class="h-4 w-4 text-sky-600"></i>

                                    <h2 class="text-xs font-bold uppercase
                                            tracking-wide text-slate-600">
                                        Hasil Penilaian Mandiri
                                    </h2>

                                </div>


                                <p class="mt-1 text-[10px] text-slate-400">
                                    Nilai berdasarkan hasil penilaian mandiri.
                                </p>

                            </div>


                            <div class="p-5">

                                @php

                                    $nilai = $pertanyaan->pemeriksaanTerakhir->nilai ?? 0;

                                    $bobot =
                                        $pertanyaan->subpilar->bobot ?? 0;

                                    $persentase = $bobot > 0
                                        ? ($nilai) * 100
                                        : 0;

                                @endphp


                                <div class="grid grid-cols-2 gap-3">


                                    {{-- NILAI --}}
                                    <div class="rounded-xl border border-slate-200
                                                bg-slate-50 p-4">

                                        <p class="text-[10px] font-semibold
                                                uppercase tracking-wide
                                                text-slate-400">
                                            Nilai
                                        </p>


                                        <div class="mt-2 flex items-end gap-1">

                                            <span class="text-2xl font-bold text-sky-700">
                                                {{ number_format($nilai, 2) }}
                                            </span>

                                            <span class="mb-1 text-xs text-slate-400">
                                                /
                                                1.00
                                            </span>

                                        </div>

                                    </div>



                                    {{-- PERSENTASE --}}
                                    <div class="rounded-xl border border-emerald-100
                                                bg-emerald-50 p-4">

                                        <p class="text-[10px] font-semibold
                                                uppercase tracking-wide
                                                text-emerald-600">
                                            Persentase
                                        </p>


                                        <div class="mt-2">

                                            <span class="text-2xl font-bold
                                                        text-emerald-600">
                                                {{ number_format($persentase, 2) }}
                                            </span>

                                            <span class="mb-1 text-xs text-slate-400">
                                                %
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </section>
                        @endif
                    @endif


                    {{-- =================================================
                        7. TOMBOL AKSI
                    ================================================== --}}
                    <div class="flex flex-col-reverse gap-3
                                sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('lke') }}"
                            class="inline-flex items-center justify-center
                                   gap-2 rounded-xl border border-slate-200
                                   bg-white px-5 py-2.5 text-xs font-semibold
                                   text-slate-600 transition hover:bg-slate-50"
                        >

                            <i
                                data-lucide="arrow-left"
                                class="h-4 w-4"
                            ></i>

                            Kembali

                        </a>

                        @if ($tahap === 'pemeriksaan' && $bisaPemeriksaan)
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center
                                    gap-2 rounded-xl bg-sky-950 px-5 py-2.5
                                    text-xs font-semibold text-white
                                    transition hover:bg-sky-900"
                            >

                                <i
                                    data-lucide="save"
                                    class="h-4 w-4"
                                ></i>

                                Simpan Pemeriksaan

                            </button>
                        @elseif ($tahap === 'penilaian'&& $bisaPemeriksaan)

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center
                                    gap-2 rounded-xl bg-sky-950 px-5 py-2.5
                                    text-xs font-semibold text-white
                                    transition hover:bg-sky-900"
                            >
                                <i
                                    data-lucide="save"
                                    class="h-4 w-4"
                                ></i>

                                Simpan Penilaian
                            </button>

                        @elseif ($tahap === 'selesai'&& $bisaPemeriksaan)

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center
                                    gap-2 rounded-xl bg-sky-950 px-5 py-2.5
                                    text-xs font-semibold text-white
                                    transition hover:bg-sky-900"
                            >
                                <i
                                    data-lucide="save"
                                    class="h-4 w-4"
                                ></i>

                                Perbarui Penilaian
                            </button>

                        @endif

                    </div>

                </form>

                {{-- =====================================================
                    END FORM PEMERIKSAAN KIRI
                ====================================================== --}}



                {{-- =================================================
                    KOLOM KANAN
                    BUKTI DUKUNG
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
                                    File Bukti Dukung
                                </h2>

                            </div>


                            {{-- <button
                                type="button"
                                class="flex rounded-full bg-emerald-50
                                       px-2.5 py-1 text-[10px] font-semibold
                                       text-emerald-700 transition
                                       hover:bg-emerald-100"
                            >

                                <i
                                    data-lucide="download"
                                    class="mr-2 h-3.5 w-3.5"
                                ></i>

                                Unduh

                            </button> --}}

                        </div>



                        {{-- =================================================
                            CONTENT
                        ================================================== --}}
                        <div class="flex-1 overflow-y-auto p-5">

                            @forelse($pertanyaan->buktiDukung as $bukti)


                                {{-- =================================================
                                    SLOT BUKTI DUKUNG
                                ================================================== --}}
                                <div
                                    class="bukti-slot mb-4 rounded-xl border
                                           border-slate-200 bg-white"
                                    data-bukti-id="{{ $bukti->id_bukti_dukung }}"
                                >


                                    {{-- =================================================
                                        NAMA KEBUTUHAN BUKTI
                                    ================================================== --}}
                                    <div class="border-b border-slate-200
                                                bg-slate-50 px-4 py-4">

                                        <div class="flex items-start gap-3">

                                            <i
                                                data-lucide="folder"
                                                class="mt-0.5 h-5 w-5 shrink-0
                                                       text-amber-500"
                                            ></i>


                                            <div class="min-w-0 flex-1">

                                                <h3
                                                    class="text-xs font-bold
                                                           leading-5 text-sky-950"
                                                >
                                                    {{ $bukti->nama_bukti_dukung_singkat ?? '-' }}
                                                </h3>

                                            </div>

                                        </div>

                                    </div>



                                    {{-- =================================================
                                        FILE / UPLOAD
                                    ================================================== --}}
                                    <div class="bukti-content p-4">


                                        {{-- FILE SUDAH ADA --}}
                                        @if(!empty($bukti->link_bukti_dukung))

                                            <div class="file-container">

                                                <div
                                                    class="flex items-center gap-3
                                                           rounded-lg border
                                                           border-slate-200
                                                           bg-white p-3"
                                                >


                                                    {{-- Icon --}}
                                                    <div
                                                        class="flex h-9 w-9 shrink-0
                                                               items-center justify-center
                                                               rounded-lg bg-blue-50"
                                                    >

                                                        <i
                                                            data-lucide="file-text"
                                                            class="h-4 w-4 text-blue-500"
                                                        ></i>

                                                    </div>



                                                    {{-- Nama File --}}
                                                    <div class="min-w-0 flex-1">

                                                        <p
                                                            class="truncate text-xs
                                                                   font-semibold
                                                                   text-slate-700"
                                                        >
                                                            {{ $bukti->id_bukti_dukung . ' ' . $bukti->nama_bukti_dukung_singkat }}
                                                        </p>

                                                        <p
                                                            class="mt-1 text-[9px]
                                                                   text-slate-400"
                                                        >
                                                            @if($bukti->time_uploaded === $bukti->time_updated)
                                                                Diupload: 
                                                            @else
                                                                Diperbarui: 
                                                            @endif
                                                            {{ Carbon\Carbon::parse($bukti->time_updated)->setTimezone('Asia/Makassar')->format('d M Y, H:i') }}
                                                        </p>

                                                    </div>



                                                    {{-- Tombol --}}
                                                    <div class="flex items-center gap-1">


                                                        {{-- Lihat --}}
                                                        <a
                                                            href="{{ asset('storage/' . $bukti->link_bukti_dukung) }}"
                                                            target="_blank"
                                                            title="Lihat"
                                                            class="inline-flex items-center
                                                                   justify-center rounded-md
                                                                   border border-sky-200
                                                                   bg-sky-50 p-1.5
                                                                   text-sky-700
                                                                   transition hover:bg-sky-100"
                                                        >

                                                            <i
                                                                data-lucide="eye"
                                                                class="h-3.5 w-3.5"
                                                            ></i>

                                                        </a>



                                                        {{-- Download --}}
                                                        <a
                                                            href="{{ route('download.bukti-dukung', $bukti->id) }}"
                                                            download
                                                            title="Download"
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



                                                        {{-- Reupload --}}
                                                        @if($bisaUpload && in_array($tahap, ['dasar', 'pemeriksaan'] ))
                                                        <button
                                                            type="button"
                                                            title="Reupload"
                                                            onclick="document.getElementById('file-{{ $bukti->id_bukti_dukung }}').click()"
                                                            class="inline-flex items-center
                                                                   justify-center rounded-md
                                                                   border border-amber-200
                                                                   bg-amber-50 p-1.5
                                                                   text-amber-700
                                                                   transition hover:bg-amber-100"
                                                        >

                                                            <i
                                                                data-lucide="pencil"
                                                                class="h-3.5 w-3.5"
                                                            ></i>

                                                        </button>
                                                        @endif

                                                        {{-- Hapus --}}
                                                        @if($isAdmin)
                                                            <form
                                                                action="{{ route('delete.bukti-dukung', $bukti->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Yakin ingin menghapus file ini?')"
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

                                            </div>

                                        @endif



                                        {{-- =================================================
                                            FORM UPLOAD / REUPLOAD
                                        ================================================== --}}
                                        <form action="{{ route('upload.bukti-dukung') }}"
                                            method="POST"
                                            class="upload-form
                                                {{ !empty($bukti->link_bukti_dukung) ? 'hidden' : '' }}"
                                            data-bukti-id="{{ $bukti->id_bukti_dukung }}"
                                            enctype="multipart/form-data"
                                        >

                                            @csrf

                                            @if($bisaUpload)
                                            <input
                                                type="hidden"
                                                name="id_bukti_dukung"
                                                value="{{ $bukti->id_bukti_dukung }}"
                                            >

                                            {{-- tentukan tahapan --}}
                                            <input
                                                type="hidden"
                                                name="tahap"
                                                value="{{ $tahap }}"
                                            >


                                            {{-- Input file --}}
                                            <input
                                                type="file"
                                                id="file-{{ $bukti->id_bukti_dukung }}"
                                                name="file"
                                                class="hidden"
                                                accept=".pdf,application/pdf"
                                                onchange="uploadBuktiDukung(this)"
                                            >


                                            {{-- Upload area --}}
                                            <label
                                                for="file-{{ $bukti->id_bukti_dukung }}"
                                                class="upload-label flex cursor-pointer
                                                       flex-col items-center justify-center
                                                       rounded-xl border-2 border-dashed
                                                       border-slate-200 bg-slate-50
                                                       px-4 py-4 text-center
                                                       transition hover:border-sky-300
                                                       hover:bg-sky-50"
                                            >

                                                <div
                                                    class="upload-icon-wrapper
                                                           flex h-8 w-8
                                                           items-center justify-center
                                                           rounded-full bg-white
                                                           shadow-sm"
                                                >

                                                    <i
                                                        data-lucide="upload"
                                                        class="upload-icon h-4 w-4
                                                               text-sky-600"
                                                    ></i>

                                                </div>


                                                <p
                                                    class="upload-text mt-3 text-xs
                                                           font-semibold text-slate-700"
                                                >
                                                    Upload Bukti Dukung
                                                </p>


                                                <p
                                                    class="mt-1 text-[10px]
                                                        font-medium text-sky-600"
                                                >
                                                    PDF
                                                </p>


                                                <p
                                                    class="mt-1 text-[10px]
                                                           text-slate-400"
                                                >
                                                    Maksimal 5 MB
                                                </p>

                                            </label>


                                            {{-- Error --}}
                                            <p
                                                class="file-error mt-2 hidden
                                                       text-center text-[10px]
                                                       font-medium text-red-600"
                                            ></p>
                                            @endif
                                        </form>

                                    </div>

                                </div>

                            @empty


                                {{-- Tidak ada bukti --}}
                                <div
                                    class="rounded-xl border border-dashed
                                           border-slate-300 bg-slate-50
                                           p-6 text-center"
                                >

                                    <i
                                        data-lucide="folder-open"
                                        class="mx-auto h-6 w-6 text-slate-300"
                                    ></i>

                                    <p
                                        class="mt-2 text-sm font-medium
                                               text-slate-500"
                                    >
                                        Belum ada bukti dukung
                                    </p>

                                </div>

                            @endforelse

                        </div>



                        {{-- =================================================
                            FOOTER PROGRESS
                        ================================================== --}}
                        <div
                            class="border-t border-slate-200
                                   bg-slate-50 px-5 py-4"
                        >

                            @php

                                $totalBukti =
                                    $pertanyaan->buktiDukung->count();

                                $totalTerpenuhi =
                                    $pertanyaan->buktiDukung
                                        ->filter(
                                            fn($bukti) =>
                                                !empty($bukti->link_bukti_dukung)
                                        )
                                        ->count();

                                $persentase =
                                    $totalBukti > 0
                                        ? ($totalTerpenuhi / $totalBukti) * 100
                                        : 0;

                            @endphp


                            <div class="flex items-center justify-between">


                                <div>

                                    <p class="text-[10px] font-medium
                                              text-slate-500">
                                        Kelengkapan bukti dukung
                                    </p>


                                    <p
                                        id="progress-text"
                                        class="mt-0.5 text-xs font-bold
                                               text-slate-700"
                                    >

                                        {{ $totalTerpenuhi }}
                                        dari
                                        {{ $totalBukti }}
                                        file

                                    </p>

                                </div>



                                {{-- Progress --}}
                                <div class="w-28">

                                    <div
                                        class="h-1.5 overflow-hidden
                                               rounded-full bg-slate-200"
                                    >

                                        <div
                                            id="progress-bar"
                                            class="h-full rounded-full
                                                   bg-emerald-500 transition-all
                                                   duration-500"
                                            style="width: {{ $persentase }}%"
                                        ></div>

                                    </div>


                                    <p
                                        id="progress-percentage"
                                        class="mt-1 text-right
                                               text-[9px] text-slate-400"
                                    >
                                        {{ number_format($persentase, 2) }}%
                                    </p>

                                </div>

                            </div>

                        </div>

                    </section>

                </aside>

            </div>

        </div>

    </div>

</div>

@endsection

<script src="https://unpkg.com/lucide@latest"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        lucide.createIcons();
    });
</script>


@push('scripts')

<script>

    document.addEventListener('DOMContentLoaded', function () {

        if (typeof lucide !== 'undefined') {

            lucide.createIcons();

        }

    });



    async function uploadBuktiDukung(input)
    {
        const file = input.files[0];

        if (!file) {
            return;
        }


        const form = input.closest('.upload-form');

        if (!form) {

            console.error(
                'Form upload tidak ditemukan.'
            );

            return;
        }


        const slot =
            input.closest('.bukti-slot');

        if (!slot) {

            console.error(
                'Slot bukti dukung tidak ditemukan.'
            );

            return;
        }


        const content =
            slot.querySelector('.bukti-content');

        const label =
            form.querySelector('.upload-label');

        const uploadText =
            form.querySelector('.upload-text');

        const icon =
            form.querySelector('.upload-icon');

        const errorElement =
            form.querySelector('.file-error');



        /*
        |--------------------------------------------------------------------------
        | RESET ERROR
        |--------------------------------------------------------------------------
        */

        errorElement.textContent = '';

        errorElement.classList.add('hidden');



        /*
        |--------------------------------------------------------------------------
        | VALIDASI PDF
        |--------------------------------------------------------------------------
        */

        const isPdf =
            file.type === 'application/pdf' ||
            file.name.toLowerCase().endsWith('.pdf');


        if (!isPdf) {

            errorElement.textContent =
                'File harus berformat PDF.';

            errorElement.classList.remove('hidden');

            input.value = '';

            return;
        }



        /*
        |--------------------------------------------------------------------------
        | VALIDASI SIZE
        |--------------------------------------------------------------------------
        */

        const maxSize =
            5 * 1024 * 1024;


        if (file.size > maxSize) {

            errorElement.textContent =
                'Ukuran file maksimal 5 MB.';

            errorElement.classList.remove('hidden');

            input.value = '';

            return;
        }



        /*
        |--------------------------------------------------------------------------
        | CSRF
        |--------------------------------------------------------------------------
        */

        const csrf =
            document.querySelector(
                'meta[name="csrf-token"]'
            );


        if (!csrf) {

            console.error(
                'CSRF token tidak ditemukan.'
            );

            tampilkanErrorUpload(
                errorElement,
                'CSRF token tidak ditemukan.'
            );

            return;
        }



        /*
        |--------------------------------------------------------------------------
        | FORM DATA
        |--------------------------------------------------------------------------
        |
        | PENTING:
        | FormData dibuat SEBELUM input.disabled = true.
        | Karena input disabled tidak akan ikut FormData.
        |
        */

        const formData =
            new FormData(form);



        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN LOADING TERLEBIH DAHULU
        |--------------------------------------------------------------------------
        */

        input.disabled = true;


        label.classList.remove(
            'cursor-pointer',
            'hover:border-sky-300',
            'hover:bg-sky-50'
        );


        label.classList.add(
            'cursor-wait',
            'border-sky-300',
            'bg-sky-50'
        );


        uploadText.textContent =
            'Mengupload...';



        /*
        |--------------------------------------------------------------------------
        | LOADING ICON
        |--------------------------------------------------------------------------
        */

        if (icon) {

            icon.setAttribute(
                'data-lucide',
                'loader-circle'
            );

            icon.classList.add(
                'animate-spin'
            );

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

        }



        /*
        |--------------------------------------------------------------------------
        | KIRIM AJAX
        |--------------------------------------------------------------------------
        */

        try {

            const response =
                await fetch(
                    "{{ route('upload.bukti-dukung') }}",
                    {
                        method: 'POST',

                        headers: {

                            'X-CSRF-TOKEN':
                                csrf.getAttribute('content'),

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest'

                        },

                        body: formData
                    }
                );





            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */

            const data =
                await response.json();


            console.log(
                'Upload response:',
                data
            );



            /*
            |--------------------------------------------------------------------------
            | ERROR SERVER
            |--------------------------------------------------------------------------
            */

            if (!response.ok) {

                let message =
                    data.message ||
                    'Upload gagal.';


                if (
                    data.errors &&
                    data.errors.file
                ) {

                    message =
                        data.errors.file[0];

                }


                throw new Error(message);
            }


            /*
            |--------------------------------------------------------------------------
            | BERHASIL
            |--------------------------------------------------------------------------
            */

            if (!data.success) {

                throw new Error(
                    data.message ||
                    'Upload gagal.'
                );

            }

            // membedakan upload dengan reupload
            const statusElement = document.getElementById(
                `upload-status-${data.id_bukti_dukung}`
            );

            if (statusElement) {
                statusElement.textContent =
                    `${data.isUpload ? 'Diupload:' : 'Diperbarui:'} ${data.time_updated}`;
            }


            /*
            |--------------------------------------------------------------------------
            | UPDATE SLOT
            |--------------------------------------------------------------------------
            */

            content.innerHTML = `

                <div class="file-existing">

                    <div
                        class="flex items-center gap-3
                            rounded-lg border
                            border-slate-200
                            bg-white p-3"
                    >

                        <div
                            class="flex h-9 w-9 shrink-0
                                items-center justify-center
                                rounded-lg bg-blue-50"
                        >

                            <i
                                data-lucide="file-text"
                                class="h-4 w-4 text-blue-500"
                            ></i>

                        </div>


                        <div class="min-w-0 flex-1">

                            <p
                                class="truncate text-xs
                                    font-semibold
                                    text-slate-700"
                            >
                                ${escapeHtml(data.file_name)}
                            </p>

                            <p
                                class="mt-1 text-[9px]
                                    text-emerald-600"
                            >
                                @if($bukti->time_uploaded === $bukti->time_updated)
                                    File berhasil diupload
                                @else 
                                    File berhasil diperbarui
                                @endif
                            </p>

                        </div>


                        <div class="flex items-center gap-1">

                            <a
                                href="${data.file_url}"
                                target="_blank"
                                class="inline-flex items-center
                                    justify-center rounded-md
                                    border border-sky-200
                                    bg-sky-50 p-1.5
                                    text-sky-700"
                            >

                                <i
                                    data-lucide="eye"
                                    class="h-3.5 w-3.5"
                                ></i>

                            </a>


                            <a
                                href="${data.file_url}"
                                download
                                class="inline-flex items-center
                                    justify-center rounded-md
                                    border border-emerald-200
                                    bg-emerald-50 p-1.5
                                    text-emerald-700"
                            >

                                <i
                                    data-lucide="download"
                                    class="h-3.5 w-3.5"
                                ></i>

                            </a>


                            <button
                                type="button"
                                onclick="document.getElementById(
                                    'file-${data.id_bukti_dukung}'
                                ).click()"
                                class="inline-flex items-center
                                    justify-center rounded-md
                                    border border-amber-200
                                    bg-amber-50 p-1.5
                                    text-amber-700"
                            >

                                <i
                                    data-lucide="pencil"
                                    class="h-3.5 w-3.5"
                                ></i>

                            </button>

                                                                                    {{-- Hapus --}}
                            @if($isAdmin)
                                <form
                                    action="{{ route('delete.bukti-dukung', $bukti->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus file ini?')"
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

                </div>

            `;



            /*
            |--------------------------------------------------------------------------
            | SEMBUNYIKAN FORM UPLOAD
            |--------------------------------------------------------------------------
            */

            form.classList.add('hidden');



            /*
            |--------------------------------------------------------------------------
            | UPDATE PROGRESS
            |--------------------------------------------------------------------------
            */

            updateProgress();



            /*
            |--------------------------------------------------------------------------
            | REFRESH ICON
            |--------------------------------------------------------------------------
            */

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }


        } catch (error) {

            console.error(
                'Upload error:',
                error
            );


            tampilkanErrorUpload(
                errorElement,
                error.message ||
                'Terjadi kesalahan saat upload.'
            );


            resetUpload(
                input,
                label,
                uploadText,
                icon
            );

        }

    }

    function updateProgress() {

    const slots = document.querySelectorAll('.bukti-slot');

    const totalBukti = slots.length;

    let totalTerpenuhi = 0;

    slots.forEach(slot => {

        const fileExisting =
            slot.querySelector('.file-existing');

        if (fileExisting) {
            totalTerpenuhi++;
        }

    });

    const persentase =
        totalBukti > 0
            ? (totalTerpenuhi / totalBukti) * 100
            : 0;

    const progressText =
        document.getElementById('progress-text');

    const progressBar =
        document.getElementById('progress-bar');

    const progressPercentage =
        document.getElementById('progress-percentage');


    if (progressText) {

        progressText.textContent =
            `${totalTerpenuhi} dari ${totalBukti} file`;

    }


    if (progressBar) {

        progressBar.style.width =
            `${persentase}%`;

    }


    if (progressPercentage) {

        progressPercentage.textContent =
            `${persentase.toFixed(2)}%`;

    }

}



    /*
    |--------------------------------------------------------------------------
    | ERROR
    |--------------------------------------------------------------------------
    */

    function tampilkanErrorUpload(
        element,
        message
    ) {

        element.textContent =
            message;

        element.classList.remove(
            'hidden'
        );

    }



    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    function resetUpload(
        input,
        label,
        uploadText,
        icon
    ) {

        input.disabled = false;


        label.classList.remove(
            'cursor-wait',
            'border-sky-300',
            'bg-sky-50'
        );


        label.classList.add(
            'cursor-pointer',
            'hover:border-sky-300',
            'hover:bg-sky-50'
        );


        uploadText.textContent =
            'Upload Bukti Dukung';


        if (icon) {

            icon.setAttribute(
                'data-lucide',
                'upload'
            );


            icon.classList.remove(
                'animate-spin'
            );


            if (typeof lucide !== 'undefined') {

                lucide.createIcons();

            }

        }


        input.value = '';

    }



    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value)
    {

        const div =
            document.createElement('div');


        div.textContent =
            value ?? '';


        return div.innerHTML;

    }

</script> 

@endpush