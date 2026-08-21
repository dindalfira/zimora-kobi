@extends('layouts.app')
@section('title', 'LKE')
@section('content')

{{-- Breadcrumb --}}

<div class="mb-4 flex items-center gap-1 text-[10px] text-slate-400">

<a href="{{ route('kegiatan.index') }}"
    class="transition hover:text-sky-700">
    Monitoring Kegiatan
</a>

<i data-lucide="chevron-right" class="h-3 w-3"></i>

<span class="font-medium text-slate-600">
    Detail Kegiatan
</span>

</div>

<div class="rounded-xl border border-slate-200 bg-white p-1 shadow-sm">

<div class="min-h-screen bg-slate-50">

    {{-- =====================================================
        HEADER
    ====================================================== --}}
    <div class="border-b border-slate-200 bg-white">

        <div class="mx-auto max-w-[1600px] px-2 py-2 sm:px-6 lg:px-8">

            {{-- Judul indikator --}}
            <div class="">
                <div class="flex flex-wrap items-center gap-2">
                    {{-- Pilar --}}
                    <span class="inline-flex items-center gap-1.5 rounded-full
                                border border-slate-100 px-2.5 py-1
                                text-[10px] font-medium text-slate-700 bg-slate-100">
                        Pilar 1
                    </span>

                    {{-- Status --}}
                    <span class="inline-flex items-center gap-1.5 rounded-full
                                border border-slate-100 px-2.5 py-1
                                text-[10px] font-medium text-slate-700 bg-slate-50">
                        <i data-lucide="clock" class="h-3.5 w-3.5"></i>
                        Menunggu
                    </span>
                </div>


                <h1 class="mt-2 text-md font-bold leading-5 text-sky-950 sm:text-base">
                    Rapat Pembentukan Tim Kerja
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
                                Rapat Pembentukan Tim Kerja
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                Terbentuknya Tim Kerja Pembangunan ZI yang efektif dan efisien
                            </p>
                        </div>

                        {{-- Detail --}}
                        <div class="grid gap-1">

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

                              

                                    {{-- Edit jadwal --}}
                                    <button
                                        type="button"
                                        {{-- onclick="openEditJadwal(
                                            {{ $item->id }},
                                            '{{ $item->waktu_pelaksanaan?->format('Y-m-d') }}'
                                        )" --}}
                                        class="inline-flex items-center gap-1
                                            rounded-md border border-sky-200
                                            bg-white px-2 py-1
                                            text-[9px] font-semibold text-sky-700
                                            transition hover:bg-sky-50">

                                        <i data-lucide="pencil" class="h-3 w-3"></i>
                                        Edit

                                    </button>

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
                                                        transition hover:bg-slate-100
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
                                <p class="mt-2 text-sm font-semibold text-slate-700">
                                    18 Agustus 2026
                                </p>

                            </div>


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
                                    Bulanan
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
                                    Notulen Rapat
                                </p>

                                <div class="mt-2 flex flex-wrap gap-2">

                                    <span class="rounded-full bg-white px-2 py-1
                                                text-[9px] font-medium text-slate-500">
                                        PDF
                                    </span>

                                    <span class="rounded-full bg-white px-2 py-1
                                                text-[9px] font-medium text-slate-500">
                                        Maks. 5 MB
                                    </span>

                                    <span class="rounded-full bg-white px-2 py-1
                                                text-[9px] font-medium text-slate-500">
                                        1 file
                                    </span>

                                </div>
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
                                            Pilar I
                                        </p>

                                        <p class="mt-1 text-sm font-bold text-sky-950">
                                            Manajemen Perubahan
                                        </p>

                                    </div>


                                    <div>

                                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                            Kode LKE
                                        </p>

                                        <p class="mt-1 text-xs font-semibold text-slate-700">
                                            A.I.1.i.a
                                        </p>

                                    </div>


                                    <div>

                                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">
                                            Indikator
                                        </p>

                                        <p class="mt-1 text-xs leading-5 text-slate-600">
                                            Unit kerja telah membentuk tim untuk melakukan
                                            pembangunan Zona Integritas.
                                        </p>

                                    </div>

                                </div>


                                <a href="{{ route('detail-lke') }}"
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
            <aside class="xl:sticky xl:top-5 xl:h-[calc(100vh-40px)]">

                <section class="flex h-full flex-col
                                rounded-2xl border border-slate-200
                                bg-white shadow-sm">

                    {{-- HEADER --}}
                    <div class="border-b border-slate-200 px-5 py-4">

                        <div class="flex items-center gap-3">

                            <div class="flex h-8 w-8 items-center justify-center
                                        rounded-lg bg-sky-50">

                                <i data-lucide="folder-check"
                                class="h-4 w-4 text-sky-700">
                                </i>

                            </div>

                            <div>
                                <h2 class="text-xs font-bold uppercase tracking-wide text-slate-700">
                                    Dokumentasi Kegiatan
                                </h2>

                                <p class="mt-0.5 text-[10px] text-slate-400">
                                    Dokumentasi pelaksanaan kegiatan berdasarkan periode
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="space-y-4 p-5">

                        {{-- =================================================
                            PERIODE DOKUMENTASI
                        ================================================== --}}
                        <div class="overflow-hidden rounded-xl border border-slate-200">

                            {{-- =================================================
                                TRIWULAN I
                            ================================================== --}}
                            <div class="border-b border-slate-200 bg-white">

                                {{-- Header periode --}}
                                <div class="flex items-center justify-between
                                            border-b border-slate-100 bg-slate-50
                                            px-4 py-3">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-7 w-7 items-center justify-center
                                                    rounded-lg bg-sky-100">

                                            <span class="text-[10px] font-bold text-sky-700">
                                                I
                                            </span>

                                        </div>

                                        <div>

                                            <p class="text-xs font-bold text-slate-700">
                                                Pelaksanaan ke-1
                                            </p>

                                            <p class="mt-0.5 text-[9px] text-slate-400">
                                                3 Januari 2026
                                            </p>

                                        </div>

                                    </div>


                                    {{-- Status --}}
                                    <div class="text-right">
                                        <div class="mt-1 flex justify-end">

                                            <span class="rounded-full bg-emerald-50
                                                        px-2 py-0.5 text-[8px]
                                                        font-bold text-emerald-700">
                                                Selesai
                                            </span>

                                        </div>

                                    </div>

                                </div>


                                {{-- Isi --}}
                                <div class="p-4">

                                    <div class="flex items-center gap-3
                                                rounded-lg border border-slate-200
                                                bg-white p-3">

                                        <div class="flex h-9 w-9 shrink-0 items-center
                                                    justify-center rounded-lg bg-blue-50">

                                            <i data-lucide="file-text"
                                            class="h-4 w-4 text-blue-500">
                                            </i>

                                        </div>


                                        <div class="min-w-0 flex-1">

                                            <p class="truncate text-xs font-semibold
                                                    text-slate-700">
                                                Notulen_Rapat_Triwulan_I.pdf
                                            </p>

                                            <p class="mt-1 text-[9px] text-slate-400">
                                                2.4 MB • 5 Januari 2026
                                            </p>

                                        </div>


                                        <div class="flex shrink-0 items-center gap-1">

                                            {{-- Preview --}}
                                            <button
                                                type="button"
                                                class="inline-flex items-center gap-1.5
                                                    rounded-md border border-sky-200
                                                    bg-sky-50 px-2 py-1
                                                    text-[9px] font-semibold
                                                    text-sky-700
                                                    transition hover:bg-sky-100">

                                                <i data-lucide="eye"
                                                class="h-3.5 w-3.5">
                                                </i>

                                            </button>


                                            {{-- Unduh --}}
                                            <button
                                                type="button"
                                                class="inline-flex items-center gap-1.5
                                                    rounded-md border border-emerald-200
                                                    bg-emerald-50 px-2 py-1
                                                    text-[9px] font-semibold
                                                    text-emerald-700
                                                    transition hover:bg-emerald-100">

                                                <i data-lucide="download"
                                                class="h-3.5 w-3.5">
                                                </i>

                                            </button>


                                            {{-- Ganti --}}
                                            <button
                                                type="button"
                                                class="inline-flex items-center gap-1.5
                                                    rounded-md border border-amber-200
                                                    bg-amber-50 px-2 py-1
                                                    text-[9px] font-semibold
                                                    text-amber-700
                                                    transition hover:bg-amber-100">

                                                <i data-lucide="pencil"
                                                class="h-3.5 w-3.5">
                                                </i>

                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- =================================================
                                TRIWULAN II — PERIODE AKTIF
                            ================================================== --}}                              

                            <div class="border-b border-slate-200 bg-white">

                                {{-- Header periode --}}
                                <div class="flex items-center justify-between
                                            border-b border-slate-100 bg-slate-50
                                            px-4 py-3">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-7 w-7 items-center justify-center
                                                    rounded-lg bg-sky-100">

                                            <span class="text-[10px] font-bold text-sky-700">
                                                II
                                            </span>

                                        </div>

                                        <div>

                                            <div class="flex items-center gap-2">

                                                <p class="text-xs font-bold text-slate-700">
                                                    Pelaksanaan ke-2
                                                </p>

                                                <span class="rounded-full bg-emerald-50
                                                            px-2 py-0.5 text-[8px]
                                                            font-bold text-emerald-700">
                                                    PERIODE AKTIF
                                                </span>

                                            </div>

                                            <p class="mt-0.5 text-[9px] text-slate-400">
                                                3 April 2026
                                            </p>

                                        </div>

                                    </div>

                                    {{-- Status --}}
                                    <div class="text-right">
                                        <div class="mt-1 flex justify-end">

                                            <span class="rounded-full bg-emerald-50
                                                        px-2 py-0.5 text-[8px]
                                                        font-bold text-emerald-700">
                                                Selesai
                                            </span>

                                        </div>

                                    </div>


                                </div>


                                {{-- Upload --}}
                                <div class="p-4">

                                    <label
                                        class="flex cursor-pointer flex-col
                                                items-center justify-center
                                                rounded-xl border-2 border-dashed
                                                border-slate-200 bg-slate-50
                                                px-4 py-4 text-center
                                                transition hover:border-sky-300
                                                hover:bg-sky-50">

                                        <div class="flex h-8 w-8
                                                    items-center justify-center
                                                    rounded-full bg-white
                                                    shadow-sm">

                                            <i data-lucide="upload"
                                                class="h-4 w-4 text-sky-600">
                                            </i>

                                        </div>


                                        <p class="mt-3 text-xs font-semibold
                                                    text-slate-700">

                                            Upload Bukti Dukung

                                        </p>

                                        <p class="mt-1 text-[10px]
                                                    text-slate-400">

                                            PDF

                                        </p>

                                        <p class="mt-1 text-[10px]
                                                    text-slate-400">

                                            Maksimal 5 MB

                                        </p>


                                        <input
                                            type="file"
                                            class="hidden"
                                            single
                                            accept=".pdf"
                                        >

                                    </label>

                                </div>
                            </div>


                            {{-- =================================================
                                TRIWULAN III — BELUM DIMULAI
                            ================================================== --}}
                            <div class="border-b border-slate-200 bg-white">

                                <div class="flex items-center justify-between
                                            px-4 py-3">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-7 w-7 items-center justify-center
                                                    rounded-lg bg-slate-100">

                                            <span class="text-[10px] font-bold text-slate-500">
                                                III
                                            </span>

                                        </div>

                                        <div>

                                            <p class="text-xs font-bold text-slate-600">
                                                Triwulan III
                                            </p>

                                            <p class="mt-0.5 text-[9px] text-slate-400">
                                                Juli – September 2026
                                            </p>

                                        </div>

                                    </div>


                                    <span class="rounded-full bg-slate-100 px-2.5 py-1
                                                text-[9px] font-semibold text-slate-500">
                                        Belum Dimulai
                                    </span>

                                </div>

                            </div>


                            {{-- =================================================
                                TRIWULAN IV — BELUM DIMULAI
                            ================================================== --}}
                            <div class="bg-white">

                                <div class="flex items-center justify-between
                                            px-4 py-3">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-7 w-7 items-center justify-center
                                                    rounded-lg bg-slate-100">

                                            <span class="text-[10px] font-bold text-slate-500">
                                                IV
                                            </span>

                                        </div>

                                        <div>

                                            <p class="text-xs font-bold text-slate-600">
                                                Triwulan IV
                                            </p>

                                            <p class="mt-0.5 text-[9px] text-slate-400">
                                                Oktober – Desember 2026
                                            </p>

                                        </div>

                                    </div>


                                    <span class="rounded-full bg-slate-100 px-2.5 py-1
                                                text-[9px] font-semibold text-slate-500">
                                        Belum Dimulai
                                    </span>

                                </div>

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

{{-- =========================================================
LUCIDE ICON
========================================================= --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>

<script>

    let editPelaksanaanId = null;


    function openEditJadwal(id, waktu) {

        editPelaksanaanId = id;

        const modal =
            document.getElementById('editJadwalModal');

        const input =
            document.getElementById('editWaktuPelaksanaan');

        const current =
            document.getElementById('currentWaktuPelaksanaan');

        const error =
            document.getElementById('editWaktuError');


        // Isi tanggal saat ini
        input.value = waktu;

        // Tampilkan tanggal saat ini
        if (waktu) {

            const date = new Date(waktu + 'T00:00:00');

            current.textContent =
                date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

        } else {

            current.textContent = '-';

        }


        // Bersihkan error
        error.textContent = '';
        error.classList.add('hidden');


        // Tampilkan modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');


        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }


    function closeEditJadwal() {

        const modal =
            document.getElementById('editJadwalModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        editPelaksanaanId = null;
    }


    async function saveEditJadwal() {

        const input =
            document.getElementById('editWaktuPelaksanaan');

        const error =
            document.getElementById('editWaktuError');

        const button =
            document.getElementById('btnSimpanWaktu');

        const waktu = input.value;


        // Reset error
        error.textContent = '';
        error.classList.add('hidden');


        // Validasi frontend
        if (!waktu) {

            error.textContent =
                'Tanggal pelaksanaan wajib diisi.';

            error.classList.remove('hidden');

            return;
        }


        // Pastikan tanggal > hari ini
        const hariIni = new Date();

        hariIni.setHours(0, 0, 0, 0);

        const tanggalDipilih =
            new Date(waktu + 'T00:00:00');


        if (tanggalDipilih <= hariIni) {

            error.textContent =
                'Tanggal pelaksanaan harus setelah hari ini.';

            error.classList.remove('hidden');

            return;
        }


        // Loading
        button.disabled = true;

        button.innerHTML = `
            <i data-lucide="loader-2"
               class="h-3.5 w-3.5 animate-spin"></i>
            Menyimpan...
        `;

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }


        try {

            const response = await fetch(
                `/pelaksanaan/${editPelaksanaanId}/waktu`,
                {
                    method: 'PUT',

                    headers: {
                        'Content-Type': 'application/json',

                        'Accept': 'application/json',

                        'X-CSRF-TOKEN':
                            document.querySelector(
                                'meta[name="csrf-token"]'
                            ).getAttribute('content')
                    },

                    body: JSON.stringify({
                        waktu_pelaksanaan: waktu
                    })
                }
            );


            const data = await response.json();


            if (!response.ok) {

                // Error validasi Laravel
                if (data.errors) {

                    const firstError =
                        Object.values(data.errors)[0][0];

                    error.textContent = firstError;

                } else {

                    error.textContent =
                        data.message ||
                        'Terjadi kesalahan saat menyimpan data.';

                }

                error.classList.remove('hidden');

                return;
            }


            // Berhasil
            closeEditJadwal();

            // Reload supaya tanggal dan status terbaru
            // langsung berasal dari database
            window.location.reload();


        } catch (err) {

            console.error(err);

            error.textContent =
                'Tidak dapat terhubung ke server.';

            error.classList.remove('hidden');


        } finally {

            button.disabled = false;

            button.innerHTML = `
                <i data-lucide="save"
                   class="h-3.5 w-3.5"></i>
                Simpan
            `;

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

        }

    }

</script>

