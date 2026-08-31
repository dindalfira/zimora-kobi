@extends('layouts.app')
@section('title', 'LKE')

@php
    $subPilar = $subpilar->groupBy('pilar');
@endphp

@section('content')

<div
    x-data="{
        search: '',
        statusFilter: '',
        aspekFilter: '',
        cocok(indikator) {
            const search = this.search.toLowerCase().trim();

            const cocokSearch =
                search === '' ||
                indikator.kode.toLowerCase().includes(search) ||
                indikator.nama.toLowerCase().includes(search);

            const cocokStatus =
                this.statusFilter === '' ||
                indikator.status === this.statusFilter;

            const cocokAspek =
                this.aspekFilter === '' ||
                indikator.aspek === this.aspekFilter;

            return cocokSearch && cocokStatus && cocokAspek;
        }
    }"
    class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm"
>
    <div class="mx-auto max-w-[1600px] space-y-5">
                <div class="mb-5 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                    <div>
                        <h2 class="text-2xl font-semibold text-slate-900">
                            Lembar Kerja Evaluasi
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Monitoring dan penilaian mandiri Zona Integritas
                        </p>
                    </div>


                    {{-- Summary --}}
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">

                        {{-- Progress --}}
                        <div class="rounded-xl border border-slate-200 bg-white px-4 py-3">

                            <div class="text-[10px] font-semibold uppercase tracking-wide text-slate-500">
                                Progress
                            </div>

                            <div class="mt-1 flex items-center gap-3">
                                <span class="text-lg font-semibold text-sky-950">
                                   {{ number_format($progressBuktiDukung, 2) }}%
                                </span>

                                <div class="h-1.5 w-20 overflow-hidden rounded-full bg-slate-100">
                                    <div class="h-full rounded-full bg-sky-700" style="width:{{ $progressBuktiDukung }}%"></div>
                                </div>

                            </div>

                        </div>


                        {{-- Mandiri --}}
                        <div class="rounded-xl border border-slate-200 bg-white px-4 py-3">

                            <div class="text-[10px] font-semibold uppercase tracking-wide text-slate-500">
                                PEMENUHAN
                            </div>

                            <div class="mt-1 text-lg font-semibold text-slate-900">
                                {{ $buktiDukungTerisi }} / {{ $totalBuktiDukung }}
                            </div>

                        </div>


                        {{-- Nilai --}}
                        <div class="rounded-xl border border-slate-200 bg-white px-4 py-3">

                            <div class="text-[10px] font-semibold uppercase tracking-wide text-slate-500">
                                Bobot Nilai Mandiri
                            </div>

                            <div class="mt-1 text-lg font-semibold text-slate-900">
                                {{ number_format($nilaiMandiri, 2) }}
                            </div>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    FILTER
                ====================================================== --}}
                <div class="flex w-full flex-col gap-3 lg:flex-row lg:items-center">
                {{-- Search --}}
                {{-- <div class="flex min-w-0 flex-1 max-w-md items-center gap-2 rounded-lg border border-neutral-300 bg-slate-10 px-4 py-2 text-sm text-gray-500 focus-within:border-sky-700 focus-within:ring-1 focus-within:ring-sky-100"> --}}
                <div class="flex min-w-0 flex-1 items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-500 transition focus-within:border-sky-600 focus-within:ring-1 focus-within:ring-sky-100">
                    <i
                        data-lucide="search"
                        class="h-4 w-4 shrink-0 text-gray-400">
                    </i>

                    <input
                        type="text"
                        x-model="search"
                        placeholder="Cari indikator"
                        class="w-full bg-transparent text-xs text-gray-700 outline-none placeholder:text-gray-400"
                    >
                </div>

                {{-- Filter --}}
                <div class="flex w-full gap-3 lg:w-auto">

                    <div class="relative">

                        <select
                            x-model="statusFilter"
                            class="appearance-none w-full rounded-lg border border-slate-200 bg-white px-3 py-2 pr-9 text-xs text-slate-600 outline-none transition focus:border-sky-600 focus:ring-1 focus:ring-sky-100"
                        >
                            <option value="">Semua Status</option>
                            <option value="belum">Belum</option>
                            <option value="pemeriksaan">Pemeriksaan</option>
                            <option value="perbaikan">Perbaikan</option>
                            <option value="sesuai">Sesuai</option>
                            <option value="dinilai">Dinilai</option>
                            <option value="terlambat">Terlambat</option>                        </select>

                        <i
                            data-lucide="chevron-down"
                            class="pointer-events-none absolute right-3 top-1/2 h-3 w-3 -translate-y-1/2 text-slate-400">
                        </i>

                    </div>
                    <div class="relative">

                        <select
                            x-model="aspekFilter"
                            class="appearance-none w-full rounded-lg border border-slate-200 bg-white px-3 py-2 pr-9 text-xs text-slate-600 outline-none transition focus:border-sky-600 focus:ring-1 focus:ring-sky-100"
                        >      
                            <option value="">Semua Aspek</option>
                            <option value="PENGUNGKIT">Pengungkit</option>
                            <option value="HASIL">Hasil</option>                                                                 
                        </select>

                        <i
                            data-lucide="chevron-down"
                            class="pointer-events-none absolute right-3 top-1/2 h-3 w-3 -translate-y-1/2 text-slate-400">
                        </i>

                    </div>

                </div>

            </div>


                {{-- =====================================================
                    LKE CARD
                ====================================================== --}}
                <div class="space-y-1">


                    {{-- =================================================
                        PILAR / SECTION HEADER
                    ================================================== --}}
                @foreach ($subPilar as $kodePilar => $itemsPilar)
                    @php
                        $firstPilar = $itemsPilar->first();
                        
                        // Ambil pertanyaan yang termasuk dalam pilar ini
                        $pertanyaanPilar = $pertanyaan->filter(function ($item) use ($kodePilar) {
                            return $item->subpilar &&
                                $item->subpilar->pilar == $kodePilar;
                        });

                        // Kelompokkan pertanyaan berdasarkan id_subpilar
                        $pertanyaanPerArea = $pertanyaanPilar->groupBy(function ($item) {
                            return $item->subpilar->nama_area;
                        });

                         // Total bukti dukung untuk Pilar ini
                        $totalBuktiPilar = $pertanyaanPilar->sum('jumlah_bukti_dukung');
                    @endphp
                        <details open class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm ">

                            <summary
                                class="flex cursor-pointer list-none items-center justify-between
                                    bg-sky-950 px-4 py-3 text-white rounded-2xl
                                    transition-all
                                    group-open:rounded-b-none
                                    [&::-webkit-details-marker]:hidden">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10">
                                        <span class="text-sm font-semibold">
                                            {{ $kodePilar }}
                                        </span>
                                    </div>

                                    <div>

                                        <h3 class="text-sm font-semibold">
                                            {{ $firstPilar->nama_pilar }}
                                        </h3>

                                        <p class="text-[10px] text-white/60">
                                            Pilar {{ $kodePilar }}
                                        </p>

                                    </div>

                                </div>


                                @php
                                    $dataBuktiPilar = $buktiDukungPerPilar[$kodePilar] ?? [
                                        'total' => 0,
                                        'terisi' => 0,
                                    ];
                                @endphp

                                {{-- Summary --}}
                                <div class="flex items-center gap-3">

                                    <div class="hidden rounded-lg bg-white/10 px-3 pb-1.5 sm:block">

                                        <span class="text-[10px] text-white/70">
                                            PEMENUHAN
                                        </span>

                                        <span class="ml-1 text-xs font-semibold text-white">
                                            {{ $dataBuktiPilar['terisi'] }} / {{ $dataBuktiPilar['total'] }}
                                            {{-- ganti 0 dengan jumlah yang sudah terpenuhi --}}
                                        </span>

                                    </div>

                                    <div class="hidden rounded-lg bg-white/10 px-3 pb-1.5 md:block">

                                        <span class="text-[10px] text-white/70">
                                            NILAI
                                        </span>

                                        <span class="ml-1 text-xs font-semibold text-white">
                                            {{ number_format($nilaiPerPilar[$kodePilar] ?? 0, 2) }} 
                                            {{-- ganti dengan nilai --}}
                                            {{-- 0.92 --}}
                                        </span>

                                    </div>

                                    <i
                                        data-lucide="chevron-down"
                                        class="h-4 w-4 transition-transform duration-200 group-open:rotate-180">
                                    </i>

                                </div>

                            </summary>


                            {{-- =================================================
                                TABLE
                            ================================================== --}}
                            <div class="overflow-hidden rounded-b-2xl bg-white">
                                @foreach ($pertanyaanPilar->groupBy(function ($item) {
                                        return $item->subpilar->nama_area;
                                    }) as $namaArea => $itemsArea)

                                @php
                                    $filterDataArea = $itemsArea->map(function ($item) {
                                        return [
                                            'kode' => $item->id_pertanyaan,
                                            'nama' => $item->nama_pertanyaan,
                                            'status' => $item->status_pertanyaan,
                                            'aspek' => $item->subpilar->nama_aspek ?? '',
                                        ];
                                    })->values();
                                @endphp

                                <details
                                    open
                                    class="group/section"
                                    x-data="{
                                        indikatorArea: @js($filterDataArea)
                                    }"
                                    x-show="indikatorArea.some(indikator => cocok(indikator))"
                                >
                                    <summary
                                        class="flex cursor-pointer list-none items-center justify-between
                                            border-b border-slate-200 bg-slate-50 px-4 py-3
                                            [&::-webkit-details-marker]:hidden">

                                        <div class="flex items-center gap-2">

                                            <div class="h-2 w-2 rounded-full bg-sky-700"></div>

                                            <span class="text-xs font-bold tracking-wide text-sky-950">
                                                {{ $namaArea}}
                                            </span>

                                        </div>

                                        <i
                                            data-lucide="chevron-down"
                                            class="h-4 w-4 text-slate-500
                                                transition-transform duration-200
                                                group-open/section:rotate-180">
                                        </i>

                                    </summary>

                                    
                                    <div class="overflow-x-auto">

                                        <table class="w-full min-w-237.5 table-fixed border-collapse">

                                            {{-- ================= HEADER ================= --}}
                                            <thead>

                                                <tr class="border-b border-slate-200 bg-slate-50">

                                                    <th class="w-14 px-3 py-3 text-center text-[10px]
                                                            font-semibold uppercase tracking-wide text-slate-600">
                                                        No
                                                    </th>

                                                    <th class="w-28 px-3 py-3 text-left text-[10px]
                                                            font-semibold uppercase tracking-wide text-slate-600">
                                                        Kode
                                                    </th>

                                                    {{-- PALING LEBAR --}}
                                                    <th class="w-auto px-3 py-3 text-left text-[10px]
                                                            font-semibold uppercase tracking-wide text-slate-600">
                                                        Informasi Indikator Penilaian
                                                    </th>

                                                    <th class="w-32 px-3 py-3 text-center text-[10px]
                                                            font-semibold uppercase tracking-wide text-slate-600">
                                                        Waktu
                                                    </th>

                                                    <th class="w-24 px-3 py-3 text-center text-[10px]
                                                            font-semibold uppercase tracking-wide text-slate-600">
                                                        Status
                                                    </th>

                                                    <th class="w-28 px-3 py-3 text-center text-[10px]
                                                            font-semibold uppercase tracking-wide text-slate-600">
                                                        PEMENUHAN
                                                    </th>

                                                    <th class="w-28 px-3 py-3 text-center text-[10px]
                                                            font-semibold uppercase tracking-wide text-slate-600">
                                                        Nilai Mandiri
                                                    </th>

                                                    <th class="w-24 px-3 py-3 text-center text-[10px]
                                                            font-semibold uppercase tracking-wide text-slate-600">
                                                        Aksi
                                                    </th>

                                                </tr>

                                            </thead>


                                            {{-- ================= BODY ================= --}}

                                            <tbody class="divide-y divide-slate-100">
                                            @foreach ($itemsArea->groupBy('id_subpilar') as $idSubpilar => $items)
                                                @php
                                                    $subpilarItem = $items->first()->subpilar;

                                                    $filterDataSubpilar = $items->map(function ($item) {
                                                        return [
                                                            'kode' => $item->id_pertanyaan,
                                                            'nama' => $item->nama_pertanyaan,
                                                            'status' => $item->status_pertanyaan,
                                                            'aspek' => $item->subpilar->nama_aspek ?? '',
                                                        ];
                                                    })->values();

                                                    $riwayat = $riwayatPerSubpilar[$subpilarItem->id_subpilar] ?? null;

                                                    $nilaiAvg = $subpilarItem->pertanyaan
                                                        ->map(fn ($p) => $p->nilai_pertanyaan ?? 0)
                                                        ->avg();
                                                    $bobotNilai = $nilaiAvg * $subpilarItem->bobot;
                                                @endphp

                                                <tr
                                                    x-data="{
                                                        indikatorSubpilar: @js($filterDataSubpilar)
                                                    }"
                                                    x-show="indikatorSubpilar.some(indikator => cocok(indikator))"
                                                >
                                                    <td
                                                        colspan="8"
                                                        class="border-y border-slate-200 bg-blue-50
                                                            px-4 py-1.5 text-[10px] font-bold
                                                            uppercase tracking-wide text-sky-950"
                                                    >
                                                       {{ $subpilarItem -> nama_subpilar }}

                                                        <span
                                                            class="inline-flex rounded-xl border border-blue-100
                                                                bg-slate-50 px-2 py-1 text-[8px] ml-2
                                                                font-bold text-slate-600">
                                                            Bobot: {{ $subpilarItem -> bobot }}
                                                        </span>

                                                        <span
                                                            class="inline-flex rounded-xl border border-lime-200
                                                                bg-lime-50 px-2 py-1 text-[8px] ml-1
                                                                font-bold text-lime-700">
                                                            Bobot Nilai: 
                                                            @if (($nilaiAvg) > 0)
                                                                {{ number_format(
                                                                    ($bobotNilai),
                                                                    2
                                                                ) }}
                                                            @else 0.00
                                                            @endif
                                                        </span>

                                                        <span
                                                            class="inline-flex rounded-xl border border-violet-200
                                                                bg-violet-50 px-2 py-1 text-[8px] ml-1
                                                                font-bold text-violet-700 ">
                                                            Persentase:  
                                                                {{ number_format($nilaiAvg * 100, 2) }}%                               
                                                        </span>


                                                    </td>


                                                </tr>

                                                
                                                {{-- =================================================
                                                    SUB INDIKATOR
                                                ================================================== --}}
                                                @foreach($items as $index => $item)
                                                    
                                                    <tr
                                                        x-data="{
                                                            kode: @js($item->id_pertanyaan),
                                                            nama: @js($item->nama_pertanyaan),
                                                            status: @js($item->status_pertanyaan),
                                                            aspek: @js($item->subpilar->nama_aspek ?? ''),
                                                        }"
                                                        x-show="cocok($data)"
                                                        class="bg-white transition hover:bg-slate-50"
                                                    >

                                                        {{-- No --}}
                                                        <td class="px-3 py-4 text-center text-xs text-slate-500">
                                                            {{ $index + 1}}
                                                        </td>


                                                        {{-- Kode --}}
                                                        <td class="px-3 py-4">

                                                            <span class="text-xs font-medium text-sky-700">
                                                                {{ $item -> id_pertanyaan }}
                                                            </span>

                                                        </td>


                                                        {{-- Informasi --}}
                                                        <td class="px-3 py-4">

                                                            <div class="space-y-2">

                                                                <p class="text-xs leading-5 text-slate-700">
                                                                    {{ $item -> nama_pertanyaan }}
                                                                </p>

                                                            </div>

                                                        </td>

                                                                                                        {{-- Waktu --}}
                                                        <td class="px-3 py-4 text-center">

                                                            <span class="text-xs text-slate-500">
                                                                {{ $item -> waktu }}
                                                            </span>

                                                        </td>

                                                        @php
                                                            $status = $item->status_pertanyaan;
                                                        @endphp
                                                        {{-- Status --}}
                                                        <td class="px-3 py-4 text-center">

                                                            @if ($status === 'pemeriksaan')

                                                                <span class="inline-flex items-center gap-1.5 rounded-full
                                                                            border border-blue-100 px-2.5 py-1.5
                                                                            text-[10px] font-medium text-sky-700 bg-blue-50
                                                                            transition">
                                                                    <i data-lucide="loader" class="h-3.5 w-3.5"></i>
                                                                    Pemeriksaan
                                                                </span>

                                                            @elseif ($status === 'belum')

                                                                <span class="inline-flex items-center gap-1.5 rounded-full
                                                                            border border-slate-100 px-2.5 py-1.5
                                                                            text-[10px] font-medium text-slate-700 bg-slate-50
                                                                            transition">
                                                                    <i data-lucide="clock" class="h-3.5 w-3.5"></i>
                                                                    Belum
                                                                </span>

                                                            @elseif ($status === 'perbaikan')

                                                                <span class="inline-flex items-center gap-1.5 rounded-full
                                                                            border border-amber-100 px-2.5 py-1.5
                                                                            text-[10px] font-medium text-amber-700 bg-amber-50
                                                                            transition">
                                                                    <i data-lucide="square-pen" class="h-3.5 w-3.5"></i>
                                                                    Perbaikan
                                                                </span>

                                                            @elseif ($status === 'sesuai')

                                                                <span class="inline-flex items-center gap-1.5 rounded-full
                                                                            border border-indigo-100 px-2.5 py-1.5
                                                                            text-[10px] font-medium text-indigo-700 bg-indigo-50
                                                                            transition">
                                                                    <i data-lucide="circle-check" class="h-3.5 w-3.5"></i>
                                                                    Sesuai
                                                                </span>

                                                            @elseif ($status === 'dinilai')

                                                                <span class="inline-flex items-center gap-1.5 rounded-full
                                                                            border border-emerald-100 px-2.5 py-1.5
                                                                            text-[10px] font-medium text-emerald-700 bg-emerald-50
                                                                            transition">
                                                                    <i data-lucide="award" class="h-3.5 w-3.5"></i>
                                                                    Dinilai
                                                                </span>

                                                            @elseif ($status === 'terlambat')

                                                                <span class="inline-flex items-center gap-1.5 rounded-full
                                                                            border border-red-100 px-2.5 py-1.5
                                                                            text-[10px] font-medium text-red-700 bg-red-50
                                                                            transition">
                                                                    <i data-lucide="triangle-alert" class="h-3.5 w-3.5"></i>
                                                                    Terlambat
                                                                </span>

                                                            {{-- @else

                                                                <span class="inline-flex items-center gap-1.5 rounded-full
                                                                            border border-slate-100 px-2.5 py-1.5
                                                                            text-[10px] font-medium text-slate-500 bg-slate-50
                                                                            transition">
                                                                    <i data-lucide="circle-help" class="h-3.5 w-3.5"></i>
                                                                    Tidak diketahui
                                                                </span> --}}

                                                            @endif

                                                        </td>

                                                        @php
                                                            $buktiPertanyaan = $buktiDukungPerPertanyaan[$item->id_pertanyaan] ?? [
                                                                'total' => 0,
                                                                'terisi' => 0,
                                                            ];
                                                        @endphp     


                                                        {{-- PEMENUHAN --}}
                                                        <td class="px-3 py-4 text-center">

                                                            <div class="text-sm font-semibold text-slate-900">
                                                                {{ $buktiPertanyaan['terisi'] }}
                                                                <span class="text-xs font-normal text-slate-400">
                                                                    / {{ $buktiPertanyaan['total'] }}
                                                                </span>
                                                            </div>
                                                        </td>

                                                        {{-- Mandiri --}}
                                                        <td class="px-3 py-4 text-center">

                                                            <div class="text-sm font-semibold text-slate-900">
                                                                {{ $item -> nilai_pertanyaan ?? '0.00'}}
                                                            </div>
                                                        </td>



                                                        {{-- Aksi --}}
                                                        <td class="px-3 py-4 text-center">

                                                            <a
                                                                href="{{ route('lke.detail', $item->id_pertanyaan) }}"
                                                                class="inline-flex items-center gap-1.5 rounded-full
                                                                    border border-slate-200 px-2.5 py-1.5
                                                                    text-[10px] font-medium text-slate-600
                                                                    transition hover:border-sky-200
                                                                    hover:bg-sky-50 hover:text-sky-700">

                                                                <i data-lucide="eye" class="h-3.5 w-3.5"></i>

                                                                Detail

                                                            </a>

                                                        </td>

                                                    </tr>

                                                    {{-- end indikator --}}
                                                    @endforeach 

                                                {{-- end subpilar --}}
                                                @endforeach 
                  
                                            </tbody>
                                        
                                        </table>

                                    </div>
                                </details>
                                
                                {{-- end area --}}
                                @endforeach 

                            </div>
                        </details>

                        {{-- end pilar --}}
                        @endforeach 

                </div>


                {{-- =====================================================
                    INFORMATION
                ====================================================== --}}

                <div class="flex items-start gap-3 rounded-xl border border-blue-100 bg-blue-50 p-4">

                    <i
                        data-lucide="info"
                        class="mt-0.5 h-4 w-4 shrink-0 text-sky-700">
                    </i>

                    <div>

                        <p class="text-xs font-semibold text-sky-900">
                            Informasi
                        </p>

                        <p class="mt-1 text-[11px] leading-5 text-sky-800/80">
                            Nilai mandiri akan dihitung berdasarkan indikator yang telah
                            dinilai dan disetujui. Klik tombol <strong>Detail</strong>
                            untuk melihat informasi indikator dan bukti dukung.
                        </p>

                    </div>

                </div>

            </div>

        {{-- </section>

    </main> --}}

</div>


{{-- =========================================================
    LUCIDE
========================================================== --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>

@endsection