@extends('layouts.app')
@section('title', 'LKE')
@section('content')

{{-- Breadcrumb --}}
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

                    {{-- Aspek --}}
                    <span class="inline-flex items-center gap-1.5 rounded-full
                                border border-slate-100 px-2.5 py-1
                                text-[10px] font-medium text-slate-700 bg-slate-100">
                        Pemenuhan
                    </span>

                    {{-- Status --}}
                    <span class="inline-flex items-center gap-1.5 rounded-full
                                border border-emerald-100 px-2.5 py-1
                                text-[10px] font-medium text-emerald-700 bg-emerald-50">
                        <i data-lucide="circle-check" class="h-3.5 w-3.5"></i>
                        Disetujui
                    </span>
                </div>

                <h1 class="mt-2 text-md font-bold leading-5 text-sky-950 sm:text-base">
                    Penentuan Anggota Tim Dipilih Melalui Prosedur/Mekanisme yang Jelas
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
                                PILAR I
                            </p>

                            <h3 class="mt-1 text-md font-bold text-sky-950">
                                MANAJEMEN PERUBAHAN
                            </h3>

                            <p class="mt-1 text-xs font-medium text-slate-500">
                                ii. Penyusunan Tim Kerja
                            </p>

                            <p class="mt-1 text-xs italic leading-5 text-slate-400">
                                a. Penentuan anggota tim dipilih melalui
                                prosedur/mekanisme yang jelas
                            </p>

                        </div>


                        {{-- KRITERIA NILAI --}}
                        <div>

                            <div class="mb-3 flex items-center gap-2">

                                <i data-lucide="target"
                                class="h-4 w-4 text-sky-600"></i>

                                <h3 class="text-xs font-bold uppercase tracking-wide text-slate-600">
                                    Kriteria Nilai
                                </h3>

                            </div>


                            <div class="rounded-xl border border-slate-200
                                        bg-slate-50 p-4">

                                <div class="space-y-2 text-xs leading-5 text-slate-700">

                                    <p>
                                        <span class="font-semibold">a.</span>
                                        Jika dengan prosedur/mekanisme yang jelas dan
                                        mewakili seluruh unsur dalam unit kerja.
                                    </p>

                                    <p>
                                        <span class="font-semibold">b.</span>
                                        Jika sebagian menggunakan prosedur yang mewakili
                                        sebagian besar unsur dalam unit kerja.
                                    </p>

                                    <p>
                                        <span class="font-semibold">c.</span>
                                        Jika tidak diseleksi.
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- PEDOMAN --}}
                        <div>

                            <div class="mb-3 flex items-center gap-2">

                                <i data-lucide="link"
                                class="h-4 w-4 text-sky-600"></i>

                                <h3 class="text-xs font-bold uppercase tracking-wide text-slate-600">
                                    Pedoman Bukti Dukung
                                </h3>

                            </div>


                            <div class="rounded-xl border border-slate-200
                                        bg-white p-4">

                                <a href="http://s.bps.go.id/ManajemenPerubahan_1b"
                                target="_blank"
                                class="flex items-start gap-2 text-xs font-medium
                                        leading-5 text-sky-700 hover:underline">

                                    <i data-lucide="external-link"
                                    class="mt-0.5 h-3.5 w-3.5 shrink-0"></i>

                                    <span>
                                        http://s.bps.go.id/ManajemenPerubahan_1b
                                    </span>

                                </a>

                            </div>

                        </div>

                    </div>

                </section>



                {{-- =========================================================
                    2. CATATAN PEMERIKSAAN MANDIRI
                ========================================================== --}}
                <section class="rounded-2xl border border-slate-200
                                bg-white shadow-sm">

                    <div class="px-5 pt-5">

                        <div class="flex items-center gap-2">

                            <i data-lucide="clipboard-check"
                            class="h-4 w-4 text-sky-600"></i>

                            <h2 class="text-xs font-bold uppercase tracking-wide text-slate-600">
                                Catatan Pemeriksaan Mandiri
                            </h2>

                        </div>

                        <p class="mt-1 text-[10px] leading-4 text-slate-400">
                            Catatan hasil pemeriksaan bukti dukung sebelum dilakukan penilaian.
                        </p>

                    </div>


                    <div class="p-5">

                        <textarea
                            rows="4"
                            name="catatan_pemeriksaan"
                            class="w-full resize-none rounded-xl border border-slate-200
                                bg-white px-4 py-3 text-sm leading-6 text-slate-700
                                outline-none transition
                                placeholder:text-slate-400
                                focus:border-sky-500
                                focus:ring-2 focus:ring-sky-100"
                            placeholder="Tuliskan hasil pemeriksaan bukti dukung...">Dokumen penetapan anggota tim telah tersedia dan sesuai dengan indikator. Perlu memastikan seluruh unsur dalam unit kerja terwakili.</textarea>

                    </div>

                </section>

                {{-- =========================================================
                    STATUS PEMERIKSAAN
                ========================================================== --}}
                <section class="rounded-2xl border border-slate-200
                                bg-white shadow-sm"
                        x-data="{
                            open: false,
                            selected: 'Sesuai',
                            value: 'sesuai'
                        }">

                    <div class="px-5 pt-5">
                        <div class="flex items-center gap-2">
                            <i data-lucide="shapes"
                                class="h-4 w-4 text-sky-600"></i>


                            <h2 class="text-xs font-bold uppercase tracking-wide text-slate-600">
                                Status Pemeriksaan
                                <span class="text-red-500">*</span>
                            </h2>
                        </div>

                        <p class="mt-1 text-[10px] leading-4 text-slate-400">
                            Tentukan status berdasarkan hasil pemeriksaan mandiri terhadap bukti dukung.
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
                                bg-white px-4 py-3
                                text-left text-sm text-slate-700
                                outline-none transition
                                hover:border-slate-300
                                focus:border-sky-500
                                focus:ring-2 focus:ring-sky-100">

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


                        {{-- =================================================
                            DROPDOWN MENU
                        ================================================== --}}
                        <div
                            x-show="open"
                            x-transition
                            class="absolute left-5 right-5 top-[calc(100%-1rem)]
                                z-30 mt-1 overflow-hidden
                                rounded-xl border border-slate-200
                                bg-white shadow-lg"
                            style="display: none;">


                            {{-- =================================================
                                SESUAI
                            ================================================== --}}
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
                                    hover:text-emerald-700">

                                <div class="flex items-start gap-3">

                                    {{-- Icon --}}
                                    <div class="mt-0.5 flex h-5 w-5 shrink-0
                                                items-center justify-center rounded-full
                                                bg-emerald-50">

                                        <i
                                            data-lucide="check"
                                            class="h-3 w-3 text-emerald-600">
                                        </i>

                                    </div>


                                    {{-- Text --}}
                                    <div>

                                        <p class="font-medium">
                                            Sesuai
                                        </p>

                                    </div>

                                </div>

                            </button>


                            {{-- =================================================
                                PERBAIKAN
                            ================================================== --}}
                            <button
                                type="button"
                                @click="
                                    selected = 'Perbaikan';
                                    value = 'perbaikan';
                                    open = false;
                                "
                                class="w-full border-t border-slate-100
                                    px-4 py-3 text-left
                                    text-xs leading-5 text-slate-700
                                    transition hover:bg-amber-50
                                    hover:text-amber-700">

                                <div class="flex items-start gap-3">

                                    {{-- Icon --}}
                                    <div class="mt-0.5 flex h-5 w-5 shrink-0
                                                items-center justify-center rounded-full
                                                bg-amber-50">

                                        <i
                                            data-lucide="alert-triangle"
                                            class="h-3 w-3 text-amber-600">
                                        </i>

                                    </div>


                                    {{-- Text --}}
                                    <div>

                                        <p class="font-medium">
                                            Perbaikan
                                        </p>


                                    </div>

                                </div>

                            </button>

                        </div>


                        {{-- =================================================
                            HIDDEN VALUE
                        ================================================== --}}
                        <input
                            type="hidden"
                            name="status_pemeriksaan"
                            :value="value">

                    </div>

                </section>




                {{-- NILAI SELF ASSESSMENT --}}
                {{-- =========================================================
                    PILIH KONDISI / JAWABAN
                ========================================================== --}}
                <section class="rounded-2xl border border-slate-200
                                bg-white shadow-sm"
                        x-data="{
                            open: false,
                            selected: 'A. Jika dengan prosedur/mekanisme yang jelas dan mewakili seluruh unsur dalam unit kerja.',
                            value: '1'
                        }">

                    <div class="px-5 pt-5">
                        <div class="flex items-center gap-2">
                            <i data-lucide="circle-star"
                                class="h-4 w-4 text-sky-600"></i>


                            <h2 class="text-xs font-bold uppercase tracking-wide text-slate-600">
                                Pilih Jawaban
                                <span class="text-red-500">*</span>
                            </h2>
                        </div>

                        <p class="mt-1 text-[10px] leading-4 text-slate-400">
                            Pilih jawaban yang sesuai dengan hasil pemeriksaan mandiri.
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
                                bg-white px-4 py-3
                                text-left text-sm text-slate-700
                                outline-none transition
                                hover:border-slate-300
                                focus:border-sky-500
                                focus:ring-2 focus:ring-sky-100">

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


                        {{-- Dropdown Menu --}}
                        <div
                            x-show="open"
                            x-transition
                            class="absolute left-5 right-5 top-[calc(100%-1rem)]
                                z-30 mt-1 overflow-hidden
                                rounded-xl border border-slate-200
                                bg-white shadow-lg"
                            style="display: none;">

                            {{-- Pilihan 1 --}}
                            <button
                                type="button"
                                @click="
                                    selected = 'A. Jika dengan prosedur/mekanisme yang jelas dan mewakili seluruh unsur dalam unit kerja.';
                                    value = '1';
                                    open = false;
                                "
                                class="w-full px-4 py-3 text-left
                                    text-xs leading-5 text-slate-700
                                    transition hover:bg-sky-50 hover:text-sky-700">

                                <div class="flex items-start gap-3">

                                    <p class="mt-0.5 text-[11px] leading-5 text-slate-500">
                                        A. Unit kerja telah menentukan anggota tim
                                        melalui mekanisme yang jelas.
                                    </p>

                                </div>

                            </button>


                            {{-- Pilihan 2 --}}
                            <button
                                type="button"
                                @click="
                                    selected = 'B. Jika dengan prosedur/mekanisme yang jelas dan mewakili seluruh unsur dalam unit kerja.';
                                    value = '2';
                                    open = false;
                                "
                                class="w-full border-t border-slate-100
                                    px-4 py-3 text-left
                                    text-xs leading-5 text-slate-700
                                    transition hover:bg-sky-50 hover:text-sky-700">

                                <div class="flex items-start gap-3">
                                    <p class="mt-0.5 text-[11px] leading-5 text-slate-500">
                                        B. Jika dengan prosedur/mekanisme yang jelas dan mewakili seluruh unsur dalam unit kerja.
                                    </p>

                                </div>

                            </button>


                            {{-- Pilihan 3 --}}
                            <button
                                type="button"
                                @click="
                                    selected = 'C.Jika tidak diseleksi';
                                    value = '3';
                                    open = false;
                                "
                                class="w-full border-t border-slate-100
                                    px-4 py-3 text-left
                                    text-xs leading-5 text-slate-700
                                    transition hover:bg-sky-50 hover:text-sky-700">

                                <div class="flex items-start gap-3">
                                    <p class="mt-0.5 text-[11px] leading-5 text-slate-500">
                                        C.Jika tidak diseleksi
                                    </p>

                                </div>

                            </button>

                        </div>


                        {{-- Hidden value untuk dikirim ke Laravel --}}
                        <input
                            type="hidden"
                            name="kondisi"
                            :value="value">

                    </div>

                </section>



                {{-- =========================================================
                    5. NARASI
                ========================================================== --}}
                <section class="rounded-2xl border border-slate-200
                                bg-white shadow-sm">

                    <div class="px-5 pt-5">

                        <div class="flex items-center gap-2">

                            <i data-lucide="file-text"
                            class="h-4 w-4 text-sky-600"></i>

                            <h2 class="text-xs font-bold uppercase tracking-wide text-slate-600">
                                Narasi
                                <span class="text-red-500">*</span>
                            </h2>

                        </div>

                        <p class="mt-1 text-[10px] leading-4 text-slate-400">
                            Penjelasan yang mendukung hasil penilaian mandiri.
                        </p>

                    </div>


                    <div class="p-5">

                        <textarea
                            rows="5"
                            name="narasi"
                            class="w-full resize-none rounded-xl border border-slate-200
                                bg-white px-4 py-3 text-sm leading-6 text-slate-700
                                outline-none transition
                                placeholder:text-slate-400
                                focus:border-sky-500
                                focus:ring-2 focus:ring-sky-100"
                            placeholder="Tuliskan narasi...">Unit kerja telah menentukan anggota tim melalui prosedur atau mekanisme yang jelas dan telah dituangkan dalam dokumen penetapan tim.</textarea>

                    </div>

                </section>

                
                {{-- =========================================================
                    4. HASIL PENILAIAN MANDIRI
                ========================================================== --}}
                <section class="rounded-2xl border border-slate-200
                                bg-white shadow-sm">

                    <div class="px-5 pt-5">

                        <div class="flex items-center gap-2">

                            <i data-lucide="award"
                            class="h-4 w-4 text-sky-600"></i>

                            <h2 class="text-xs font-bold uppercase tracking-wide text-slate-600">
                                Hasil Penilaian Mandiri
                            </h2>

                        </div>

                        <p class="mt-1 text-[10px] text-slate-400">
                            Nilai berdasarkan hasil pemeriksaan mandiri.
                        </p>

                    </div>


                    <div class="p-5">

                        <div class="grid grid-cols-2 gap-3">

                            {{-- NILAI --}}
                            <div class="rounded-xl border border-slate-200
                                        bg-slate-50 p-4">

                                <p class="text-[10px] font-semibold uppercase
                                        tracking-wide text-slate-400">
                                    Nilai
                                </p>

                                <div class="mt-2 flex items-end gap-1">

                                    <span class="text-2xl font-bold text-sky-700">
                                        1.00
                                    </span>

                                    <span class="mb-1 text-xs text-slate-400">
                                        / 1.00
                                    </span>

                                </div>

                            </div>


                            {{-- SKOR --}}
                            <div class="rounded-xl border border-emerald-100
                                        bg-emerald-50 p-4">

                                <p class="text-[10px] font-semibold uppercase
                                        tracking-wide text-emerald-600">
                                    Persentase
                                </p>

                                <div class="mt-2">

                                    <span class="text-2xl font-bold text-emerald-600">
                                        1
                                    </span>

                                    <span class="mb-1 text-xs text-slate-400">
                                        %
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>



                {{-- =========================================================
                    6. CATATAN PROVINSI TERBARU
                ========================================================== --}}
{{--                 
                <section>

                    <div class="mb-3 flex items-center gap-2">

                        <i data-lucide="message-square"
                        class="h-4 w-4 text-amber-600"></i>

                        <div>

                            <h2 class="text-xs font-bold uppercase tracking-wide text-slate-600">
                                Catatan Provinsi Terbaru
                            </h2>

                            <p class="mt-0.5 text-[10px] text-slate-400">
                                Catatan evaluasi terakhir dari verifikator provinsi.
                            </p>

                        </div>

                    </div>


                    <div class="rounded-xl border border-amber-200
                                bg-amber-50 p-5">

                        <p class="text-sm leading-6 text-amber-900">
                            Bukti dukung sesuai. Mohon memastikan seluruh anggota tim
                            yang mewakili unsur unit kerja dapat ditunjukkan.
                        </p>

                        <div class="mt-4 border-t border-amber-200 pt-3">

                            <div class="flex items-center justify-between">

                                <span class="text-[10px] font-semibold text-amber-700">
                                    Evaluasi Tahap 1
                                </span>

                                <span class="text-[10px] text-amber-600">
                                    31 Jul 2026, 08.01
                                </span>

                            </div>

                        </div>

                    </div>

                </section>
 --}}


                {{-- =========================================================
                    7. RIWAYAT CATATAN PROVINSI
                ========================================================== --}}
                
                {{-- <section class="rounded-2xl border border-slate-200
                                bg-white shadow-sm">

                    <div class="border-b border-slate-200 px-5 py-4">

                        <div class="flex items-center gap-2">

                            <i data-lucide="history"
                            class="h-4 w-4 text-slate-500"></i>

                            <div>

                                <h2 class="text-xs font-bold uppercase tracking-wide text-slate-600">
                                    Riwayat Catatan Provinsi
                                </h2>

                                <p class="mt-0.5 text-[10px] text-slate-400">
                                    Riwayat evaluasi dan verifikasi sebelumnya.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="space-y-4 p-5">

                        <div class="rounded-xl border border-slate-200
                                    bg-slate-50 p-4">

                            <div class="flex items-center justify-between gap-4">

                                <span class="text-[10px] font-bold uppercase
                                            tracking-wide text-amber-700">
                                    Evaluasi Tahap 1
                                </span>

                                <span class="text-[10px] text-slate-400">
                                    31 Jul 2026, 08.01
                                </span>

                            </div>


                            <div class="mt-4 space-y-4">

                                <div>

                                    <p class="text-[10px] font-bold uppercase
                                            tracking-wide text-slate-400">
                                        Jawaban
                                    </p>

                                    <p class="mt-1 text-sm font-medium leading-6 text-slate-700">
                                        Ya, unit kerja telah menentukan anggota tim
                                        melalui mekanisme yang jelas.
                                    </p>

                                </div>


                                <div>

                                    <p class="text-[10px] font-bold uppercase
                                            tracking-wide text-slate-400">
                                        Narasi
                                    </p>

                                    <p class="mt-1 text-sm leading-6 text-slate-600">
                                        Anggota tim telah ditentukan dan dituangkan
                                        dalam dokumen penetapan tim.
                                    </p>

                                </div>


                                <div class="border-t border-slate-200 pt-3">

                                    <p class="text-[10px] font-bold uppercase
                                            tracking-wide text-amber-700">
                                        Catatan Verifikator
                                    </p>

                                    <p class="mt-1 text-sm leading-6 text-slate-600">
                                        Mohon memastikan dokumen penetapan tim
                                        dapat ditampilkan sebagai bukti dukung.
                                    </p>

                                </div>


                                <div class="flex items-center justify-between
                                            border-t border-slate-200 pt-3">

                                    <span class="text-[10px] font-semibold text-slate-400">
                                        Hasil Verifikasi
                                    </span>

                                    <span class="text-sm font-bold text-indigo-600">
                                        1
                                    </span>

                                </div>

                            </div>

                        </div>


                        <div class="rounded-xl border border-slate-200
                                    bg-slate-50 p-4">

                            <div class="flex items-center justify-between gap-4">

                                <span class="text-[10px] font-bold uppercase
                                            tracking-wide text-slate-500">
                                    Evaluasi Sebelumnya
                                </span>

                                <span class="text-[10px] text-slate-400">
                                    15 Jul 2026, 10.20
                                </span>

                            </div>

                            <p class="mt-3 text-sm leading-6 text-slate-600">
                                Bukti dukung masih perlu dilengkapi.
                            </p>

                        </div>

                    </div>

                </section> --}}



                {{-- =========================================================
                    8. HASIL CAPAIAN MANDIRI
                ========================================================== --}}
                {{-- <section class="rounded-2xl border border-emerald-100
                                bg-emerald-50 px-5 py-4">

                    <div class="flex items-center justify-between">

                        <div>

                            <span class="text-sm font-bold uppercase
                                        tracking-wide text-emerald-700">
                                Hasil Capaian Mandiri
                            </span>

                            <p class="mt-1 text-[10px] text-emerald-600">
                                Hasil penilaian yang diberikan oleh unit kerja.
                            </p>

                        </div>

                        <span class="text-2xl font-bold text-emerald-600">
                            3
                        </span>

                    </div>

                </section> --}}



                {{-- =========================================================
                    9. HASIL CAPAIAN PROVINSI
                ========================================================== --}}
                {{-- <section class="rounded-2xl border border-indigo-100
                                bg-indigo-50 px-5 py-4">

                    <div class="flex items-center justify-between">

                        <div>

                            <span class="text-sm font-bold uppercase
                                        tracking-wide text-indigo-700">
                                Hasil Capaian Provinsi
                            </span>

                            <p class="mt-1 text-[10px] text-indigo-500">
                                Hasil verifikasi/penilaian terakhir dari provinsi.
                            </p>

                        </div>

                        <span class="text-2xl font-bold text-indigo-600">
                            3
                        </span>

                    </div>

                </section> --}}



                {{-- =========================================================
                    10. TOMBOL AKSI
                ========================================================== --}}
                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                    <a href="{{ route('lke') }}"
                    class="inline-flex items-center justify-center gap-2
                            rounded-xl border border-slate-200
                            bg-white px-5 py-2.5 text-xs font-semibold
                            text-slate-600 transition hover:bg-slate-50">

                        <i data-lucide="arrow-left"
                        class="h-4 w-4"></i>

                        Kembali

                    </a>


                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2
                            rounded-xl bg-sky-950 px-5 py-2.5
                            text-xs font-semibold text-white
                            transition hover:bg-sky-900">

                        <i data-lucide="save"
                        class="h-4 w-4"></i>

                        Simpan Pemeriksaan

                    </button>

                </div>

            </main>



            {{-- =================================================
                KOLOM KANAN - BUKTI DUKUNG
            ================================================== --}}
            <aside class="xl:sticky xl:top-5 xl:h-[calc(100vh-40px)]">

                <section class="flex h-full flex-col
                                rounded-2xl border border-slate-200
                                bg-white shadow-sm">


                    {{-- Header --}}
                    <div class="flex items-center justify-between
                                border-b border-slate-200 px-5 py-4">

                        <div>

                            <h2 class="text-sm font-bold uppercase
                                       tracking-wide text-sky-950">
                                File Bukti Dukung
                            </h2>

                        </div>


                        <span class="rounded-full bg-sky-50
                                     px-2.5 py-1 text-[10px]
                                     font-semibold text-sky-700">
                            1 File
                        </span>

                    </div>



                    {{-- Content --}}
                    <div class="flex-1 overflow-y-auto p-5">


                        {{-- =================================================
                            KEBUTUHAN BUKTI DUKUNG 1
                        ================================================== --}}
                        <div class="rounded-xl border border-slate-200
                                    bg-white">

                            {{-- Nama kebutuhan --}}
                            <div class="border-b border-slate-200
                                        bg-slate-50 px-4 py-4">

                                <div class="flex items-start gap-3">

                                    <div class="mt-0.5">

                                        <i data-lucide="folder"
                                           class="h-5 w-5 text-amber-500">
                                        </i>

                                    </div>


                                    <div class="min-w-0 flex-1">

                                        <h3 class="text-xs font-bold
                                                   leading-5 text-sky-950">

                                            Surat Keputusan / Surat Penunjukan
                                            Tim Pembangunan Zona Integritas

                                        </h3>

                                    </div>

                                </div>

                            </div>



                            {{-- File --}}
                            <div class="p-4">

                                <div class="space-y-3">

                                    {{-- FILE 2 --}}
                                    <div class="flex items-center gap-3
                                                rounded-lg border border-slate-200
                                                bg-white p-3">

                                        <div class="flex h-9 w-9 shrink-0
                                                    items-center justify-center
                                                    rounded-lg bg-blue-50">

                                            <i data-lucide="file-text"
                                               class="h-4 w-4 text-blue-500">
                                            </i>

                                        </div>


                                        <div class="min-w-0 flex-1">

                                            <p class="truncate text-xs
                                                      font-semibold text-slate-700">

                                                SK Penunjukan Tim ZI.pdf

                                            </p>

                                            <p class="mt-1 text-[9px] text-slate-400">
                                                1.5 MB • 13 Feb 2024
                                            </p>

                                        </div>


                                        <div class="flex items-center gap-1">

                                            {{-- Preview --}}
                                            <a
                                                href="https://drive.google.com/file/d/FILE_ID/view"
                                                target="_blank"
                                                class="inline-flex items-center gap-1.5 rounded-md
                                                    border border-sky-200 bg-sky-50
                                                    px-1.5 py-1 text-[9px] font-semibold
                                                    text-sky-700 transition hover:bg-sky-100"
                                            >
                                                <i data-lucide="eye" class="h-3.5 w-3.5"></i>
                                                {{-- Lihat --}}
                                            </a>


                                            {{-- Unduh --}}
                                            <a
                                                href="https://drive.google.com/uc?export=download&id=FILE_ID"
                                                class="inline-flex items-center gap-1.5 rounded-md
                                                    border border-emerald-200 bg-emerald-50
                                                    px-1.5 py-1 text-[9px] font-semibold
                                                    text-emerald-700 transition hover:bg-emerald-100"
                                            >
                                                <i data-lucide="download" class="h-3.5 w-3.5"></i>
                                                {{-- Unduh --}}
                                            </a>


                                            {{-- Ganti File --}}
                                            <button
                                                type="button"
                                                onclick="document.getElementById('replace-file').click()"
                                                class="inline-flex items-center gap-1.5 rounded-md
                                                    border border-amber-200 bg-amber-50
                                                    px-1.5 py-1 text-[9px] font-semibold
                                                    text-amber-700 transition hover:bg-amber-100"
                                            >
                                                <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                                                {{-- Perbarui --}}
                                            </button>

                                            <input
                                                type="file"
                                                id="replace-file"
                                                class="hidden"
                                            >

                                        </div>
                                    </div>



                                   
                                </div>



                                

                            </div>

                        </div>



                        {{-- =================================================
                            KEBUTUHAN BUKTI DUKUNG 2
                        ================================================== --}}
                        <div class="mt-4 rounded-xl border
                                    border-slate-200 bg-white">

                            <div class="border-b border-slate-200
                                        bg-slate-50 px-4 py-4">

                                <div class="flex items-start gap-3">

                                    <i data-lucide="folder"
                                       class="mt-0.5 h-5 w-5 shrink-0
                                              text-amber-500">
                                    </i>

                                    <div>

                                        <h3 class="text-xs font-bold
                                                   leading-5 text-sky-950">

                                            Notulen/laporan pelaksanaan rapat pembentukan Tim Kerja yang telah disahkan oleh kepala satker

                                        </h3>

                                    </div>

                                </div>

                            </div>

                        {{-- =================================================
                                UPLOAD AREA
                            ================================================== --}}
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

                    </div>



                    {{-- Footer panel --}}
                    <div class="border-t border-slate-200 bg-slate-50
                                px-5 py-4">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-[10px] font-medium text-slate-500">
                                    Kelengkapan bukti dukung
                                </p>

                                <p class="mt-0.5 text-xs font-bold text-slate-700">
                                    3 dari 4 file
                                </p>

                            </div>


                            <div class="w-28">

                                <div class="h-1.5 overflow-hidden rounded-full
                                            bg-slate-200">

                                    <div class="h-full w-3/4 rounded-full
                                                bg-emerald-500">
                                    </div>

                                </div>

                                <p class="mt-1 text-right text-[9px]
                                          text-slate-400">
                                    75%
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