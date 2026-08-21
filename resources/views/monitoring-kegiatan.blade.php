@extends('layouts.app')

@section('title', 'Monitoring Kegiatan')

@section('content')

<div
    class="space-y-5"
    x-data="monitoringKegiatan()"
>

    {{-- Container Utama --}}
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

        {{-- Header tabel + filter --}}
        <div class="mb-5 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

            <div>
                <h2 class="text-2xl font-semibold text-slate-900">
                    Daftar Kegiatan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Daftar kegiatan dan status pelaksanaan kegiatan Reformasi Birokrasi BPS Kota Bima
                </p>
            </div>
            
        </div>

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
                    @input="searchData()"
                    placeholder="Cari kegiatan"
                    class="w-full bg-transparent text-xs text-gray-700 outline-none placeholder:text-gray-400"
                >

            </div>

            {{-- Filter --}}
            <div class="flex w-full gap-3 lg:w-auto">

                <div class="relative">

                <select
                    x-model="pilar"
                    @change="loadData()"
                    class="appearance-none w-full rounded-lg border border-slate-200 bg-white px-3 py-2 pr-9 text-xs text-slate-600 outline-none transition focus:border-sky-600 focus:ring-1 focus:ring-sky-100"
                >
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
                        class="pointer-events-none absolute right-3 top-1/2 h-3 w-3 -translate-y-1/2 text-slate-400">
                    </i>

                </div>

                <div class="relative">

                    <select
                        x-model="status"
                        @change="loadData()"
                        class="appearance-none w-full rounded-lg border border-slate-200 bg-white px-3 py-2 pr-9 text-xs text-slate-600 outline-none transition focus:border-sky-600 focus:ring-1 focus:ring-sky-100"
                    >
                        <option value="">Semua Status</option>

                        <option value="menunggu">
                            Menunggu
                        </option>

                        <option value="berlangsung">
                            Berlangsung
                        </option>

                        <option value="selesai">
                            Selesai
                        </option>

                        <option value="terlambat">
                            Terlambat
                        </option>
                    </select>

                    <i
                        data-lucide="chevron-down"
                        class="pointer-events-none absolute right-3 top-1/2 h-3 w-3 -translate-y-1/2 text-slate-400">
                    </i>

                </div>
                <div class="relative">

                    <select
                        x-model="bulan"
                        @change="loadData()"
                        class="appearance-none w-full rounded-lg border border-slate-200 bg-white px-3 py-2 pr-9 text-xs text-slate-600 outline-none transition focus:border-sky-600 focus:ring-1 focus:ring-sky-100"
                    >
                        <option value="">Semua Bulan</option>

                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>

                    <i
                        data-lucide="chevron-down"
                        class="pointer-events-none absolute right-3 top-1/2 h-3 w-3 -translate-y-1/2 text-slate-400">
                    </i>

                </div>

            </div>

        </div>
        

        {{-- Informasi jumlah data --}}
        <div class="mb-4 mt-2 flex items-center justify-between">

            <div class="flex items-center gap-2 text-xs text-slate-500">

                <span>Tampilkan:</span>

                <div class="relative">

                    <select
                        x-model="perPage"
                        @change="loadData()"
                        class="appearance-none w-full rounded-lg border border-slate-200 bg-white px-3 py-1 pr-9 text-xs text-slate-600 outline-none transition focus:border-sky-600 focus:ring-1 focus:ring-sky-100"
                    >
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <i
                        data-lucide="chevron-down"
                        class="pointer-events-none absolute right-3 top-1/2 h-3 w-3 -translate-y-1/2 text-slate-400">
                    </i>

                </div>

                <span>per halaman</span>

            </div>

        </div>

        


        {{-- Tabel --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-200 border-collapse">

                {{-- Header --}}
                <thead>

                    <tr class="border-y border-slate-200 bg-slate-50">

                        <th class="w-10 px-2 py-4 text-center text-xs font-semibold text-slate-600">
                            No
                        </th>

                        <th class="min-w-90 px-1 py-4 text-left text-xs font-semibold text-slate-600">
                            Kegiatan
                        </th>

                        <th class="min-w-15 py-4 text-center text-xs font-semibold text-slate-600">
                            Tim Pilar
                        </th>

                        <th class="min-w-15  py-4 text-center text-xs font-semibold text-slate-600">
                            Waktu Pelaksanaan
                        </th>

                        <th class="min-w-15 py-4 text-center text-xs font-semibold text-slate-600">
                            Status Kegiatan
                        </th>

                        <th class="w-20 py-4 text-center text-xs font-semibold text-slate-600">
                            Aksi
                        </th>

                    </tr>

                </thead>


                {{-- Body --}}
            <tbody
                id="tabel-kegiatan"
                class="divide-y divide-slate-100 text-xs"
            >
                @include('kegiatan.partials.table', [
                    'kegiatan' => $kegiatan
                ])
            </tbody>

            </table>

        </div>


        {{-- Footer tabel --}}
        <div class="mt-4 flex flex-col gap-3 border-t border-slate-100 pt-4 sm:flex-row sm:items-center sm:justify-between">

            <p
                id="data-info"
                class="text-xs text-slate-500"
            >
                Menampilkan

                <span class="font-medium text-slate-700">
                    {{ $kegiatan->firstItem() ?? 0 }}
                    –
                    {{ $kegiatan->lastItem() ?? 0 }}
                </span>

                dari

                <span class="font-medium text-slate-700">
                    {{ $kegiatan->total() }}
                </span>

                kegiatan
            </p>

            <div class="flex items-center gap-1">

                <div
                    id="pagination-container"
                    class="flex items-center gap-1"
                >
                    @include('kegiatan.partials.pagination', [
                        'kegiatan' => $kegiatan
                    ])
                </div>

            </div>

        </div>

    </div>

</div>


@endsection

<script>
function monitoringKegiatan() {

    return {

        search: '',
        pilar: '',
        status: '',
        bulan: '',
        perPage: 10,

        timer: null,
        loading: false,


        // ==========================================
        // SEARCH REALTIME
        // ==========================================

        searchData() {

            clearTimeout(this.timer);

            this.timer = setTimeout(() => {

                this.loadData(1);

            }, 300);
        },


        // ==========================================
        // LOAD DATA
        // ==========================================

        async loadData(page = 1) {

            this.loading = true;

            const params = new URLSearchParams();

            if (this.search.trim() !== '') {
                params.set('search', this.search);
            }

            if (this.pilar !== '') {
                params.set('pilar', this.pilar);
            }

            if (this.status !== '') {
                params.set('status', this.status);
            }

            if (this.bulan !== '') {
                params.set('bulan', this.bulan);
            }

            params.set('per_page', this.perPage);
            params.set('page', page);


            try {

                const response = await fetch(
                    `{{ route('monitoring.kegiatan.data') }}?${params.toString()}`,
                    {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }
                );


                if (!response.ok) {
                    throw new Error('Gagal mengambil data');
                }


                const data = await response.json();


                // ==================================
                // UPDATE TABEL
                // ==================================

                document.querySelector(
                    '#tabel-kegiatan'
                ).innerHTML = data.html;


                // ==================================
                // UPDATE PAGINATION
                // ==================================

                document.querySelector(
                    '#pagination-container'
                ).innerHTML = data.pagination;

                Alpine.initTree(
                    document.querySelector('#pagination-container')
                );

                refreshIcons();


                // ==================================
                // UPDATE INFO
                // ==================================

                const info = document.querySelector(
                    '#data-info'
                );


                if (info) {

                    info.innerHTML = `
                        Menampilkan

                        <span class="font-medium text-slate-700">
                            ${data.firstItem ?? 0}
                            –
                            ${data.lastItem ?? 0}
                        </span>

                        dari

                        <span class="font-medium text-slate-700">
                            ${data.total}
                        </span>

                        kegiatan
                    `;

                }


                // ==================================
                // ICON LUCIDE
                // ==================================

                if (window.lucide) {
                    lucide.createIcons();
                }


            } catch (error) {

                console.error(
                    'Error mengambil data:',
                    error
                );

            } finally {

                this.loading = false;

            }

        }

    }
}

function refreshIcons() {
    if (window.lucide) {
        lucide.createIcons();
    }
}
</script>