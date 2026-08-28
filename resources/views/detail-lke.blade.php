@extends('layouts.app')

@section('title', 'LKE')
@php
    // $tahap = $tahap ?? 'dasar';
    $role = Auth::user()->role;

    $isAdmin = $role === 'admin';
    $isSekretaris = $role === 'sekretaris';

    $bisaPemeriksaan = $isAdmin || $isSekretaris;
    $bisaUpload = $isAdmin || $role === 'pilar';

    $buktiAda = $pertanyaan->buktiDukung->isNotEmpty();

    $pemeriksaanTerakhir = $pertanyaan->pemeriksaanTerakhir;

    $sudahDiperiksa = $pemeriksaanTerakhir !== null;

    $pemeriksaanSesuai =
        $sudahDiperiksa &&
        $pemeriksaanTerakhir->status_pemeriksaan === 'sesuai';
@endphp
@section('content')

{{-- =========================================================
    BREADCRUMB
========================================================= --}}
<div class="mb-4 flex items-center gap-1 text-[10px] text-slate-400">

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
<div class="rounded-xl border border-slate-200 bg-white p-1 shadow-sm">

    <div class="min-h-screen bg-slate-50">


        {{-- =====================================================
            HEADER
        ====================================================== --}}
        <div class="border-b border-slate-200 bg-white">

            <div class="mx-auto max-w-[1600px] px-2 py-2 sm:px-6 lg:px-8">

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
                        {{ $pertanyaan->nama_pertanyaan }}
                    </h1>

                </div>

            </div>

        </div>



        {{-- =====================================================
            MAIN CONTENT
        ====================================================== --}}
        <div class="mx-auto max-w-[1600px] px-4 py-5 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-5 xl:grid-cols-[minmax(0,1fr)_430px]">


                {{-- =================================================
                    KOLOM KIRI
                    FORM PEMERIKSAAN
                ================================================== --}}
                

                    @csrf


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

                                        <span>
                                            {{ $pertanyaan->link_pedoman }}
                                        </span>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </section>
               
            <form
                action="{{ route('lke.pemeriksaan.simpan', $pertanyaan->id) }}"
                method="POST"
                class="space-y-5"
                >

                @if (in_array($tahap, ['pemeriksaan', 'penilaian', 'selesai']))
                    {{-- =================================================
                        2. STATUS PEMERIKSAAN
                    ================================================== --}}
                    <section
                        class="rounded-2xl border border-slate-200
                               bg-white shadow-sm"
                        x-data="{
                            open: false,
                            selected: '{{ Str::title($pertanyaan->pemeriksaanTerakhir->status_pemeriksaan ?? '') }}',
                            value: '{{ $pertanyaan->pemeriksaanTerakhir->status_pemeriksaan ?? '' }}'
                        }"
                    >

                        <div class="px-5 pt-5">

                            <div class="flex items-center gap-2">

                                <i data-lucide="shapes"
                                    class="h-4 w-4 text-sky-600"></i>

                                <h2 class="text-xs font-bold uppercase
                                           tracking-wide text-slate-600">

                                    Status Pemeriksaan

                                    <span class="text-red-500">*</span>

                                </h2>

                            </div>


                            <p class="mt-1 text-[10px] leading-4 text-slate-400">
                                Tentukan status berdasarkan hasil pemeriksaan
                                mandiri terhadap bukti dukung.
                            </p>

                        </div>


                        <div class="relative p-5">


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
                        @if (in_array($tahap, ['penilaian', 'selesai']))
                            <input
                                type="hidden"
                                name="status_pemeriksaan"
                                :value="value"
                                required
                        
                            >
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
                                </h2>

                            </div>


                            <p class="mt-1 text-[10px] leading-4 text-slate-400">
                                Catatan hasil pemeriksaan bukti dukung sebelum
                                dilakukan penilaian.
                            </p>

                        </div>


                        <div class="p-5">

                        @if ($tahap === 'pemeriksaan')
                            @if($bisaPemeriksaan && $buktiAda)
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
                            >{{ old('catatan_pemeriksaan', $pertanyaan->pemeriksaanTerakhir->catatan_pemeriksaan ?? '') }}</textarea>
                            @endif

                        @else
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm text-slate-600">
                                    {{ $pertanyaan->pemeriksaanTerakhir->catatan_pemeriksaan ?? '-' }}
                                </p>
                            </div>
                        @endif
                        </div>

                    </section>
                @endif



                    {{-- =================================================
                        PERSIAPAN PILIHAN JAWABAN
                    ================================================== --}}
                    @php

                        $pilihan = preg_split(
                            '/\r\n|\r|\n/',
                            trim($pertanyaan->kriteria_nilai ?? '')
                        );

                        $pilihan = array_values(
                            array_filter(
                                $pilihan,
                                fn($item) => trim($item) !== ''
                            )
                        );

                        $jawabanTerakhir =
                            $pertanyaan->pemeriksaanTerakhir->jawaban ?? '';

                        $jawabanTerakhirText = '';

                        foreach ($pilihan as $item) {

                            $itemTrim = trim($item);

                            preg_match(
                                '/^([a-eA-E])[\.\)]?\s*/',
                                $itemTrim,
                                $match
                            );

                            $kode = isset($match[1])
                                ? strtolower($match[1])
                                : strtolower(substr($itemTrim, 0, 1));

                            if ($kode === $jawabanTerakhir) {

                                $jawabanTerakhirText = $itemTrim;

                                break;
                            }
                        }

                    @endphp

                    {{-- =================================================
                        7. RIWAYAT CATATAN MANDIRI
                    ================================================== --}}
                    <section class="rounded-2xl border border-slate-200
                                    bg-white shadow-sm">

                        {{-- <div class="border-b border-slate-200 px-5 py-4"> --}}

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


                        <div class="space-y-4 p-5">

                            @forelse(
                                $pertanyaan->pemeriksaan->sortByDesc('diperiksa_pada')
                                as $pemeriksaan
                            )

                                <div class="rounded-xl border border-slate-200
                                            bg-slate-50 p-4">


                                    {{-- Header --}}
                                    <div class="flex items-center
                                                justify-between gap-4">

                                        <span
                                            class="text-[10px] font-bold uppercase
                                                   tracking-wide
                                                   {{
                                                       $pemeriksaan->status_pemeriksaan === 'sesuai'
                                                           ? 'text-emerald-700'
                                                           : 'text-amber-700'
                                                   }}"
                                        >

                                            {{ ucfirst($pemeriksaan->status_pemeriksaan) }}

                                        </span>


                                        <span class="text-[10px] text-slate-400">

                                            {{ $pemeriksaan->diperiksa_pada
                                                ? $pemeriksaan->diperiksa_pada
                                                    ->translatedFormat('d M Y, H.i')
                                                : '-' }}

                                        </span>

                                    </div>



                                    {{-- Isi --}}
                                    <div class="mt-4 space-y-4">


                                        {{-- Pemeriksa --}}
                                        @if($pemeriksaan->pemeriksa)

                                            <div class="flex items-center gap-2
                                                        text-[10px] text-slate-400">

                                                <i
                                                    data-lucide="user"
                                                    class="h-3.5 w-3.5"
                                                ></i>

                                                <span>

                                                    Diperiksa oleh:

                                                    <span class="font-medium
                                                                 text-slate-600">

                                                        {{ $pemeriksaan->pemeriksa->name }}

                                                    </span>

                                                </span>

                                            </div>

                                        @endif



                                        {{-- Catatan --}}
                                        @if($pemeriksaan->catatan_pemeriksaan)

                                            <div class="border-t border-slate-200
                                                        pt-3">

                                                <p class="text-[10px] font-bold
                                                          uppercase tracking-wide
                                                          text-amber-700">
                                                    Catatan Pemeriksaan
                                                </p>


                                                <p class="mt-1 text-sm leading-6
                                                          text-slate-600">

                                                    {{ $pemeriksaan->catatan_pemeriksaan }}

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
                            value: '{{ $jawabanTerakhir }}'
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

                                    <span class="text-red-500">*</span>

                                </h2>

                            </div>


                            <p class="mt-1 text-[10px] leading-4 text-slate-400">
                                Pilih jawaban yang sesuai dengan hasil
                                penilaian mandiri.
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

                                            $item = trim($item);

                                            preg_match(
                                                '/^([a-eA-E])[\.\)]?\s*/',
                                                $item,
                                                $match
                                            );

                                            $kode = isset($match[1])
                                                ? strtolower($match[1])
                                                : strtolower(substr($item, 0, 1));

                                        @endphp


                                        <button
                                            type="button"
                                            @click="
                                                selected = @js($item);
                                                value = '{{ $kode }}';
                                                open = false;
                                            "
                                            class="w-full rounded-lg px-3 py-2.5
                                                   text-left text-sm text-slate-700
                                                   transition hover:bg-slate-50"
                                        >
                                            {{ $item }}
                                        </button>

                                    @endforeach

                                </div>

                            </div>
                        


                            {{-- Nilai yang dikirim --}}
                            @if (in_array($tahap, ['penilaian', 'selesai']))
                                <input
                                    type="hidden"
                                    name="jawaban"
                                    :value="value"
                                    required
                                >
                            @endif
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

                                    <span class="text-red-500">*</span>

                                </h2>

                            </div>


                            <p class="mt-1 text-[10px] leading-4 text-slate-400">
                                Penjelasan yang mendukung hasil penilaian mandiri.
                            </p>

                        </div>


                        <div class="p-5">
                            @if($bisaPemeriksaan && $buktiAda && $pemeriksaanSesuai)
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
                            >{{ old('narasi', $pertanyaan->pemeriksaanTerakhir->narasi ?? '') }}</textarea>
                            @endif
                        </div>

                    </section>
                @endif

                @if ($tahap === 'selesai')
                    {{-- =================================================
                        6. HASIL PENILAIAN MANDIRI
                    ================================================== --}}
                    @if($pertanyaan->nilai !== null)
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

                                $nilai = $pertanyaan->nilai ?? 0;

                                $bobot =
                                    $pertanyaan->subpilar->bobot ?? 0;

                                $persentase = $bobot > 0
                                    ? ($nilai / $bobot) * 100
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
                                            {{ number_format($bobot, 2) }}
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

                    @if ($tahap === 'pemeriksaan')
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
                    @elseif ($tahap === 'penilaian')

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

                    @elseif ($tahap === 'selesai')

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
                    class="xl:sticky xl:top-5 xl:h-[calc(100vh-40px)]"
                >

                    <section
                        class="flex h-full flex-col rounded-2xl
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
                                                            {{ $bukti->link_bukti_dukung }}
                                                        </p>

                                                        <p
                                                            class="mt-1 text-[9px]
                                                                   text-slate-400"
                                                        >
                                                            File bukti dukung
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
                                                        @if($bisaUpload)
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
                                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-refresh-cw-icon lucide-refresh-cw"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg> --}}

                                                        </button>
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
                                                           text-slate-400"
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
                    "{{ route('bukti-dukung.upload') }}",
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
                                File berhasil diupload
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