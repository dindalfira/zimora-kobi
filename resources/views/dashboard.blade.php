@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
    <div class="mx-auto max-w-[1600px] space-y-5">
        <div class="mb-5 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-slate-900">
                    Dashboard
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Ringkasan monitoring pemenuhan dan penilaian bukti dukung LKE
                </p>
            </div>
        </div>

<section
    x-data="{
        aspek: @js(request('aspek', '')),
        area: @js(request('area', '')),
        pilar: @js(request('pilar', '')),

        filter() {

            const params = new URLSearchParams();

            if (this.aspek) {
                params.set('aspek', this.aspek);
            }

            if (this.area) {
                params.set('area', this.area);
            }

            if (this.pilar) {
                params.set('pilar', this.pilar);
            }

            window.location.href =
                '{{ route('dashboard') }}?' + params.toString();
        },

        changeAspek() {
            this.area = '';
            this.pilar = '';
            this.filter();
        },

        changeArea() {
            this.pilar = '';
            this.filter();
        }
    }"
            class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm space-y-3">

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">

                {{-- Aspek --}}
                <div>
                    <label class="mb-1 block text-[10px] font-medium text-slate-500">
                        Aspek
                    </label>

                    <div class="relative w-full">
                        <select
                            x-model="aspek"
                            @change="filter()"
                            class="w-full appearance-none rounded-lg border border-slate-200 bg-white 
                                    px-3 py-2 pr-8 text-[11px] text-slate-600 outline-none transition 
                                    focus:border-sky-500 focus:ring-2 focus:ring-sky-100">

                            <option value="">Semua Aspek</option>
                            <option value="A">Pengungkit</option>
                            <option value="B">Hasil</option>

                        </select>

                        <i
                            data-lucide="chevron-down"
                            class="pointer-events-none absolute right-3 top-1/2
                                h-3.5 w-3.5 -translate-y-1/2
                                text-slate-400">
                        </i>
                    </div>
                </div>


                {{-- Area --}}
                <div>
                    <label class="mb-1 block text-[10px] font-medium text-slate-500">
                        Area
                    </label>

                    <div class="relative w-full">
                        <select
                            x-model="area"
                            @change="filter()"
                            class="w-full appearance-none rounded-lg border border-slate-200 bg-white 
                                    px-3 py-2 pr-8 text-[11px] text-slate-600 outline-none transition 
                                    focus:border-sky-500 focus:ring-2 focus:ring-sky-100">

                                    <option value="">Semua Area</option>
                                    <option value="I">Pemenuhan</option>
                                    <option value="II">Reform</option>

                        </select>

                        <i
                            data-lucide="chevron-down"
                            class="pointer-events-none absolute right-3 top-1/2
                                h-3.5 w-3.5 -translate-y-1/2
                                text-slate-400">
                        </i>
                    </div>
                </div>

                {{-- Pilar --}}
                <div>
                    <label class="mb-1 block text-[10px] font-medium text-slate-500">
                        Pilar
                    </label>

                    <div class="relative w-full">
                        <select
                            x-model="pilar"
                            @change="filter()"
                            class="w-full appearance-none rounded-lg border border-slate-200 bg-white 
                                    px-3 py-2 pr-8 text-[11px] text-slate-600 outline-none transition 
                                    focus:border-sky-500 focus:ring-2 focus:ring-sky-100">

                            <option value="">Semua Pilar</option>
                            <option value="1">Pilar 1</option>
                            <option value="2">Pilar 2</option>
                            <option value="3">Pilar 3</option>
                            <option value="4">Pilar 4</option>
                            <option value="5">Pilar 5</option>
                            <option value="6">Pilar 6</option>

                        </select>

                        <i
                            data-lucide="chevron-down"
                            class="pointer-events-none absolute right-3 top-1/2
                                h-3.5 w-3.5 -translate-y-1/2
                                text-slate-400">
                        </i>
                    </div>
                </div>

            </div>
        </section>

        {{-- =====================================================
            SUMMARY CARDS
        ====================================================== --}}
        <section class="w-full">

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

                {{-- =====================================================
                    HASIL PENILAIAN MANDIRI
                ====================================================== --}}
                <div class="w-full rounded-2xl bg-sky-950 p-6 text-white shadow-sm">

                    <p class="text-[9px] font-medium uppercase tracking-wider text-white/60">
                        Hasil Penilaian Mandiri
                    </p>

                    <div class="mt-1 flex items-end gap-2">

                        <span class="text-3xl font-bold">
                            {{ number_format($nilaiTotal, 2) }}
                        </span>

                        <span class="mb-1 text-xs text-white/50">
                            / 100
                        </span>

                    </div>

                    <div class="my-4 border-t border-white/10"></div>

                    <div class="space-y-3">


                        <div class="flex items-center justify-between">
                            <span class="text-[10px] text-white/60">
                                Aspek Pengungkit
                            </span>

                            <span class="text-[10px] font-semibold">
                                {{ number_format($nilaiPengungkit, 2) }}
                                <span class="text-[10px] text-white/50">
                                    / 60
                                </span>
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-[10px] text-white/60">
                                Aspek Hasil
                            </span>

                            <span class="text-[10px] font-semibold">
                                {{ number_format($nilaiHasil, 2) }}
                                <span class="text-[10px] text-white/50">
                                    / 40
                                </span>
                            </span>
                        </div>

                    </div>

                    <div class="my-4 border-t border-white/10"></div>

                    <div class="space-y-3">

                        <div class="flex items-center justify-between">
                            <span class="text-[10px] text-white/60">
                                Total Sub Pilar
                            </span>

                            <span class="text-[10px] font-semibold">
                                {{ $totalSubPilar }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-[10px] text-white/60">
                                Total Pertanyaan
                            </span>

                            <span class="text-[10px] font-semibold">
                                {{ $totalPertanyaan }}
                            </span>
                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    STATISTIK BUKTI DUKUNG
                ====================================================== --}}
                <div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

                        {{-- CARD 1 --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <div class="flex items-start justify-between">

                                <div>
                                    <p class="text-3xl font-bold text-sky-950">
                                        {{ $buktiDukungTerisi }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Bukti Dukung Terpenuhi
                                    </p>
                                </div>

                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50">
                                    <i data-lucide="folder-check" class="h-5 w-5 text-sky-600"></i>
                                </div>

                            </div>

                            <div class="mt-5 flex items-center gap-3">
                                <div class="h-2 flex-1 overflow-hidden rounded-full bg-slate-100">
                                    <div class="h-full rounded-full bg-sky-600" style="width: {{ $persentaseBuktiTerisi }}%"></div>
                                </div>

                                <span class="shrink-0 text-[10px] font-semibold text-slate-400">
                                    {{ number_format($persentaseBuktiTerisi, 2) }}%
                                </span>
                            </div>
                        </div>


                        {{-- CARD 2 --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <div class="flex items-start justify-between">

                                <div>
                                    <p class="text-3xl font-bold text-sky-950">
                                        {{ $buktiDukungBelumTerisi }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Bukti Dukung Belum Diunggah
                                    </p>
                                </div>

                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50">
                                    <i data-lucide="file-warning" class="h-5 w-5 text-red-500"></i>
                                </div>

                            </div>

                            <div class="mt-5 flex items-center gap-3">
                                <div class="h-2 flex-1 overflow-hidden rounded-full bg-slate-100">
                                    <div class="h-full rounded-full bg-red-400" style="width: {{ $persentaseBuktiBelumTerisi }}%"></div>
                                </div>

                                <span class="shrink-0 text-[10px] font-semibold text-slate-400">
                                    {{ number_format($persentaseBuktiBelumTerisi, 2) }}%
                                </span>
                            </div>
                        </div>


                        {{-- CARD 3 --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <div class="flex items-start justify-between">

                                <div>
                                    <p class="text-3xl font-bold text-sky-950">
                                        {{ $pertanyaanPemeriksaan }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Bukti Dukung Diperiksa
                                    </p>
                                </div>

                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50">
                                    <i data-lucide="search-check" class="h-5 w-5 text-violet-500"></i>
                                </div>

                            </div>

                            <div class="mt-5 flex items-center gap-3">
                                <div class="h-2 flex-1 overflow-hidden rounded-full bg-slate-100">
                                    <div class="h-full rounded-full bg-violet-500" 
                                                style="width: {{ $totalPertanyaan > 0
                                                            ? number_format(($pertanyaanPemeriksaan / $totalPertanyaan) * 100, 2)
                                                            : '0.00'
                                                        }}%">
                                    </div>
                                </div>

                                <span class="shrink-0 text-[10px] font-semibold text-slate-400">
                                    {{ $totalPertanyaan > 0
                                        ? number_format(($pertanyaanPemeriksaan / $totalPertanyaan) * 100, 2)
                                        : '0.00'
                                    }}%
                                </span>
                            </div>
                        </div>

                        {{-- CARD 4 --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <div class="flex items-start justify-between">

                                <div>
                                    <p class="text-3xl font-bold text-sky-950">
                                        {{ $pertanyaanPerbaikan }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Bukti Dukung Perlu Diperbaiki
                                    </p>
                                </div>

                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50">
                                    <i data-lucide="file-pen" class="h-5 w-5 text-amber-600"></i>
                                </div>

                            </div>

                            <div class="mt-5 flex items-center gap-3">
                                <div class="h-2 flex-1 overflow-hidden rounded-full bg-slate-100">
                                    <div class="h-full rounded-full bg-amber-400" 
                                                style="width: {{ $totalPertanyaan > 0
                                                            ? number_format(($pertanyaanPerbaikan / $totalPertanyaan),2) * 100
                                                            : 0
                                                        }}%">
                                    </div>
                                </div>

                                <span class="shrink-0 text-[10px] font-semibold text-slate-400">
                                    {{ $totalPertanyaan > 0
                                        ? number_format(($pertanyaanPerbaikan / $totalPertanyaan) * 100,2)
                                        : 0
                                    }}%
                                </span>
                            </div>
                        </div>

                        {{-- CARD 5 --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <div class="flex items-start justify-between">

                                <div>
                                    <p class="text-3xl font-bold text-sky-950">
                                        {{ $pertanyaanSesuai }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Bukti Dukung Telah Sesuai
                                    </p>
                                </div>

                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 ">
                                    <i data-lucide="circle-check-big" class="h-5 w-5 text-indigo-500"></i>
                                </div>

                            </div>

                            <div class="mt-5 flex items-center gap-3">
                                <div class="h-2 flex-1 overflow-hidden rounded-full bg-indigo-100">
                                    <div class="h-full rounded-full bg-indigo-400" 
                                                style="width: {{ $totalPertanyaan > 0
                                                        ? ($pertanyaanSesuai / $totalPertanyaan) * 100
                                                        : 0
                                                    }}%">
                                    </div>
                                </div>

                                <span class="shrink-0 text-[10px] font-semibold text-slate-400">
                                    {{ $totalPertanyaan > 0
                                        ? number_format(($pertanyaanSesuai / $totalPertanyaan) * 100,2)
                                        : 0
                                    }}%
                                </span>
                            </div>
                        </div>


                        {{-- CARD 6 --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <div class="flex items-start justify-between">

                                <div>
                                    <p class="text-3xl font-bold text-sky-950">
                                        {{ $pertanyaanDinilai }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Bukti Dukung Telah Dinilai
                                    </p>
                                </div>

                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50">
                                    <i data-lucide="trophy" class="h-5 w-5 text-emerald-500"></i>
                                </div>

                            </div>

                            <div class="mt-5 flex items-center gap-3">
                                <div class="h-2 flex-1 overflow-hidden rounded-full bg-slate-100">
                                    <div class="h-full rounded-full bg-emerald-500" 
                                                style="width: {{ $totalPertanyaan > 0
                                                    ? ($pertanyaanDinilai / $totalPertanyaan) * 100
                                                    : 0
                                                }}%">
                                    </div>
                                </div>

                                <span class="shrink-0 text-[10px] font-semibold text-slate-400">
                                    {{ $totalPertanyaan > 0
                                        ? number_format(($pertanyaanDinilai / $totalPertanyaan) * 100,2)                                        : 0
                                    }}%
                                </span>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
            NILAI + DONUT
        ====================================================== --}}
        <section class="w-full grid grid-cols-1 gap-5 lg:grid-cols-2">

            {{-- DONUT KEGIATAN --}}
            <div
                class="rounded-2xl border border-slate-200 bg-white p-5
                    shadow-sm">

                <div class="flex items-center justify-between">

                    <div>
                        <h2 class="text-xs font-bold text-sky-950">
                            Status Pelaksanaan Kegiatan
                        </h2>

                        <p class="mt-1 text-[10px] text-slate-400">
                            Komposisi status pelaksanaan kegiatan
                        </p>
                    </div>
                </div>

                <div class="mt-4 h-52">
                    <canvas id="statusKegChart"></canvas>
                </div>

            </div>

            {{-- DONUT BUKTI DUKUNG --}}
            <div
                class="rounded-2xl border border-slate-200 bg-white p-5
                    shadow-sm">

                <div class="flex items-center justify-between">

                    <div>
                        <h2 class="text-xs font-bold text-sky-950">
                            Status Bukti Dukung
                        </h2>

                        <p class="mt-1 text-[10px] text-slate-400">
                            Komposisi status bukti dukung 
                        </p>
                    </div>

                </div>

                <div class="mt-4 h-52">
                    <canvas id="statusChart"></canvas>
                </div>

            </div>

        </section>


        {{-- =====================================================
            BAR CHART
        ====================================================== --}}
        <section class="w-full grid grid-cols-1 gap-4 lg:grid-cols-2">

            <!-- Chart 1 -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xs font-bold text-sky-950">
                            Capaian Pemenuhan dan Kesesuaian Bukti Dukung
                        </h2>

                        <p class="mt-1 text-[10px] text-slate-400">
                            Perbandingan pemenuhan dan kesesuaian bukti dukung setiap pilar
                        </p>
                    </div>
                </div>

                <div class="mt-5 h-64">
                    <canvas id="pilarChart"></canvas>
                </div>
            </div>

            <!-- Chart 2 -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xs font-bold text-sky-950">
                            Penilaian Capaian Bukti Dukung
                        </h2>

                        <p class="mt-1 text-[10px] text-slate-400">
                            Perbandingan nilai hasil pemenuhan bukti dukung setiap pilar
                        </p>
                    </div>
                </div>

                <div class="mt-5 h-72">
                    <canvas id="nilaiChart"></canvas>
                </div>
            </div>

        </section>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>

    document.addEventListener('DOMContentLoaded', function () {

        /*
        |--------------------------------------------------------------------------
        | STATUS KEGIATAN
        |--------------------------------------------------------------------------
        */

        const statusKegCtx = document
            .getElementById('statusKegChart')
            .getContext('2d');

        new Chart(statusKegCtx, {

            type: 'doughnut',

            data: {

                labels: [
                    'Menunggu',
                    'Berlangsung',
                    'Selesai',
                    'Terlambat'
                ],

                datasets: [{
                    data: @json($statusKegChart),

                    backgroundColor: [
                        '#BFC6C4', // Menunggu
                        '#67BED9', // Berlangsung
                        '#10b981', // Selesai
                        '#ef4444'  // Terlambat
                    ],

                    borderWidth: 0
                }],

            },

            options: {

                responsive: true,
                maintainAspectRatio: false,

                cutout: '68%',

                plugins: {

                    legend: {

                        position: 'right',

                        labels: {
                            boxWidth: 8,
                            boxHeight: 8,
                            padding: 12,

                            font: {
                                size: 9
                            }
                        }

                    },

                    tooltip: {

                        callbacks: {

                            label: function(context) {

                                const dataset = context.dataset;

                                const total = dataset.data.reduce(
                                    (sum, value) => sum + value,
                                    0
                                );

                                const value = context.parsed;

                                const percentage =
                                    ((value / total) * 100).toFixed(1);

                                return context.label + ': ' + value + ' kegiatan (' + percentage + '%)';

                            }

                        }

                    },

                    datalabels: {

                        color: '#ffffff',

                        font: {
                            size: 10,
                            weight: 'bold'
                        },

                        formatter: function(value, context) {

                            const total = context.dataset.data.reduce(
                                (sum, value) => sum + value,
                                0
                            );

                            const percentage =
                                (value / total) * 100;

                            return percentage >= 5
                                ? percentage.toFixed(1) + '%'
                                : '';

                        }

                    }

                }

            },

            plugins: [ChartDataLabels]

        });

        /*
        |--------------------------------------------------------------------------
        | STATUS BUKTI DUKUNG
        |--------------------------------------------------------------------------
        */

        const statusCtx = document
        .getElementById('statusChart')
        .getContext('2d');

        new Chart(statusCtx, {

        type: 'doughnut',

        data: {

        labels: [
            'Terpenuhi',
            'Belum Terpenuhi'
        ],

        datasets: [{
            data: [ 
                {{ $persentaseBuktiTerisi }},
                {{ $persentaseBuktiBelumTerisi }}
            ],

            backgroundColor: [
                '#10b981', // Terpenuhi
                '#BFC6C4'  // Belum Terpenuhi
            ],

            borderWidth: 0
        }]

        },

        options: {

        responsive: true,
        maintainAspectRatio: false,

        cutout: '68%',

        plugins: {

            legend: {

                position: 'right',

                labels: {
                    boxWidth: 8,
                    boxHeight: 8,
                    padding: 12,

                    font: {
                        size: 9
                    }
                }

            },

            tooltip: {

                callbacks: {

                    label: function(context) {

                        const value = context.parsed;

                        return context.label + ': ' + value.toFixed(2) + '%';

                    }

                }

            },

            datalabels: {

                color: '#ffffff',

                font: {
                    size: 10,
                    weight: 'bold'
                },

                formatter: function(value) {

                    return value.toFixed(2) + '%';

                }

            }

        }

        },

        plugins: [ChartDataLabels]

        });

        /*
        |--------------------------------------------------------------------------
        | NILAI PER PILAR
        |--------------------------------------------------------------------------
        */

        const pilarCtx = document
            .getElementById('pilarChart')
            .getContext('2d');

        const pemenuhan = @json($pemenuhanPerPilar);

        const kesesuaian = @json($kesesuaianPerPilar);

        const selisih = pemenuhan.map((nilai, index) => {
            return nilai - kesesuaian[index];
        });

        new Chart(pilarCtx, {

            type: 'bar',

            data: {

                labels: @json($namapilars),

                datasets: [

                    {
                        label: 'Kesesuaian',

                        data: kesesuaian,

                        backgroundColor: '#0284c7',

                        borderRadius: {
                            topLeft: 5,
                            bottomLeft: 5
                        },

                        borderWidth: 0,

                        barThickness: 24,

                        stack: 'pilar'
                    },

                    {
                        label: 'Pemenuhan',

                        data: selisih,

                        backgroundColor: '#8CC0EB',

                        borderRadius: {
                            topRight: 5,
                            bottomRight: 5
                        },

                        borderWidth: 0,

                        barThickness: 24,

                        stack: 'pilar'
                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                indexAxis: 'y',

                scales: {

                    x: {

                        stacked: true,

                        beginAtZero: true,

                        max: 100,

                        grid: {
                            color: '#f1f5f9'
                        },

                        ticks: {

                            font: {
                                size: 9
                            },

                            callback: function(value) {
                                return value + '%';
                            }

                        }

                    },

                    y: {

                        stacked: true,

                        grid: {
                            display: false
                        },

                        ticks: {

                            font: {
                                size: 10
                            }

                        }

                    }

                },

                plugins: {

                    legend: {

                        display: true,

                        position: 'top',

                        align: 'end',

                        labels: {

                            boxWidth: 8,

                            boxHeight: 8,

                            padding: 12,

                            font: {
                                size: 9
                            }

                        }

                    },

                    tooltip: {

                        callbacks: {

                            label: function(context) {

                                const index = context.dataIndex;

                                if (context.datasetIndex === 0) {

                                    return 'Kesesuaian: '
                                        + kesesuaian[index].toFixed(2)
                                        + '%';

                                }

                                return 'Pemenuhan: '
                                    + pemenuhan[index].toFixed(2)
                                    + '%';

                            }

                        }

                    },

                    datalabels: {

                        color: '#ffffff',

                        font: {
                            size: 9,
                            weight: 'bold'
                        },

                        formatter: function(value, context) {

                            const index = context.dataIndex;

                            if (context.datasetIndex === 0) {

                                return kesesuaian[index].toFixed(2) + '%';

                            }

                            return pemenuhan[index].toFixed(2) + '%';

                        }

                    }

                }

            },

            plugins: [ChartDataLabels]

        });

        /*
        |--------------------------------------------------------------------------
        | PERBANDINGAN NILAI PERUBAHAN
        |--------------------------------------------------------------------------
        */

        const nilaiCtx = document
            .getElementById('nilaiChart')
            .getContext('2d');

        const nilaiPerPilar = @json($nilaiPerPilar);

        new Chart(nilaiCtx, {

            type: 'bar',

            data: {

                labels: @json($namapilars),

                datasets: [{

                    label: '% Nilai',

                    data: nilaiPerPilar.map(item => item.persentase),

                    backgroundColor: '#0284c7',

                    borderRadius: 4,

                    barThickness: 24,

                    maxBarThickness: 24

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                layout: {
                    padding: {
                        top: 20
                    }
                },

                scales: {

                    y: {

                        beginAtZero: true,

                        max: 100,

                        ticks: {

                            stepSize: 20,

                            font: {
                                size: 9
                            },

                            callback: function(value) {
                                return value + '%';
                            }

                        },

                        grid: {
                            color: '#f1f5f9'
                        }

                    },

                    x: {

                        grid: {
                            display: false
                        },

                        ticks: {

                            font: {
                                size: 9
                            }

                        }

                    }

                },

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {

                        callbacks: {

                            label: function(context) {

                                return '% Nilai: '
                                    + context.parsed.y.toFixed(2)
                                    + '%';

                            }

                        }

                    },

                    datalabels: {

                        anchor: 'end',

                        align: 'top',

                        offset: 3,

                        color: '#334155',

                        font: {

                            size: 9,

                            weight: '600'

                        },

                        formatter: function(value) {

                            return value.toFixed(2) + '%';

                        }

                    }

                }

            },

            plugins: [ChartDataLabels]

        });

    });

</script>
@endpush