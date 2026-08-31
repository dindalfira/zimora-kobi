@extends('layouts.app')
@section('title', 'Jadwal')
@section('content')


<div
    x-data="calendarApp()"
    class="space-y-5 rounded-xl border border-slate-200 bg-white p-5 shadow-sm"
>

    {{-- Header --}}
    <div class="mb-5 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div>
            <h2 class="text-2xl font-semibold text-slate-900">
                Jadwal Kegiatan
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Jadwal pelaksanaan kegiatan  Reformasi Birokrasi BPS Kota Bima
            </p>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="flex items-center justify-center gap-3 rounded-xl border border-slate-200 bg-white px-4 py-1.5">

        <button
            type="button"
            @click="previousMonth()"
            class="flex h-7 w-7 items-center justify-center rounded-lg
                border border-slate-200 text-slate-500 hover:bg-slate-50"
        >
            <i data-lucide="chevron-left" class="h-4 w-4"></i>
        </button>

        <h2
            class="min-w-36 text-center text-lg font-semibold text-sky-950"
            x-text="monthName + ' ' + currentYear"
        ></h2>

        <button
            type="button"
            @click="nextMonth()"
            class="flex h-7 w-7 items-center justify-center rounded-lg
                border border-slate-200 text-slate-500 hover:bg-slate-50"
        >
            <i data-lucide="chevron-right" class="h-4 w-4"></i>
        </button>
    </div>


    {{-- Legend --}}
    <div class="flex flex-wrap items-center gap-5 px-1">

        <div class="flex items-center gap-2 text-xs text-slate-500">
            <span class="h-2.5 w-2.5 rounded-full bg-slate-500"></span>
            Menunggu
        </div>

        <div class="flex items-center gap-2 text-xs text-slate-500">
            <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>
            Berlangsung
        </div>

        <div class="flex items-center gap-2 text-xs text-slate-500">
            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
            Selesai
        </div>

        <div class="flex items-center gap-2 text-xs text-slate-500">
            <span class="h-2.5 w-2.5 rounded-full bg-red-700"></span>
            Terlambat
        </div>

    </div>


    {{-- Calendar --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">

        {{-- Nama hari --}}
        <div class="grid grid-cols-7 border-b border-slate-200 bg-slate-50">
            <template x-for="day in days" :key="day">
                <div
                    class="border-r border-slate-200 px-2 py-3 text-center text-[11px]
                        font-semibold tracking-wide text-slate-500 last:border-r-0"
                    x-text="day"
                ></div>
            </template>
        </div>

        {{-- Tanggal --}}
        <div class="grid h-[720px] grid-cols-7 grid-rows-6">

            <template x-for="date in calendarDays" :key="date.key">

                <div
                    class="relative min-h-0 overflow-hidden border-b border-r border-slate-200 p-2
                        transition hover:bg-slate-50"
                    :class="{
                        'bg-slate-50/70': !date.currentMonth,
                        'bg-sky-50/40': date.today
                    }"
                >

                    {{-- Nomor tanggal --}}
                    <div class="mb-1.5 flex items-center justify-between">

                        <span
                            class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full
                                text-xs font-medium"
                            :class="{
                                'text-slate-400': !date.currentMonth,
                                'text-slate-700': date.currentMonth && !date.today,
                                'bg-sky-700 text-white font-bold': date.today
                            }"
                            x-text="date.day"
                        ></span>

                    </div>

                    {{-- Daftar kegiatan --}}
                    <div class="max-h-20.5 space-y-1 overflow-y-auto pr-1">

                        <template
                            x-for="activity in getActivities(date.date)"
                            :key="activity.id"
                        >

                            <a
                                :href="activity.url"
                                class="group block rounded-md px-1 py-0.5 transition hover:shadow-sm"
                                :title="activity.name"
                            >

                                <div
                                    class="flex items-start gap-1 text-[10px] leading-tight font-medium"
                                    :class="{
                                        'text-emerald-800': activity.status === 'selesai',
                                        'text-blue-800': activity.status === 'berlangsung',
                                        'text-red-800': activity.status === 'terlambat',
                                        'text-slate-700': activity.status === 'menunggu'
                                    }"
                                >

                                    {{-- Bullet --}}
                                    <span class="shrink-0">•</span>

                                    {{-- Nama kegiatan --}}
                                    <span
                                        class="line-clamp-2 min-w-0 wrap-break-word "
                                        x-text="activity.name"
                                    ></span>

                                </div>

                            </a>

                        </template>

                    </div>

                </div>

            </template>

        </div>

    </div>


<script>
function calendarApp() {

    return {

        currentDate: new Date(),

        search: '',

        days: [
            'MIN',
            'SEN',
            'SEL',
            'RAB',
            'KAM',
            'JUM',
            'SAB',
            
        ],

activities: {{ Js::from(
    $pelaksanaan->map(function ($item) {
        return [
            'id' => $item->id,
            'name' => $item->kegiatan->nama_kegiatan ?? '-',

            'date' => $item->waktu_pelaksanaan
                ? \Carbon\Carbon::parse($item->waktu_pelaksanaan)->format('Y-m-d')
                : null,

            'status' => strtolower($item->status_pelaksanaan ?? 'menunggu'),

            'url' => route(
                'kegiatan.detail',
                $item->kegiatan_id
            ),
        ];
    })
) }},

        get currentYear() {
            return this.currentDate.getFullYear();
        },

        get currentMonth() {
            return this.currentDate.getMonth();
        },

        get monthName() {

            return new Intl.DateTimeFormat('id-ID', {
                month: 'long'
            }).format(this.currentDate);

        },

        get calendarDays() {

            const year = this.currentYear;
            const month = this.currentMonth;

            const firstDay = new Date(year, month, 1);

            let startDay = firstDay.getDay();

            const daysInMonth = new Date(
                year,
                month + 1,
                0
            ).getDate();

            const previousMonthDays = new Date(
                year,
                month,
                0
            ).getDate();

            const result = [];


            // Hari dari bulan sebelumnya
            for (let i = startDay - 1; i >= 0; i--) {

                const day = previousMonthDays - i;

                const date = new Date(
                    year,
                    month - 1,
                    day
                );

                result.push(
                    this.createDateObject(date, false)
                );

            }


            // Hari bulan sekarang
            for (let day = 1; day <= daysInMonth; day++) {

                const date = new Date(
                    year,
                    month,
                    day
                );

                result.push(
                    this.createDateObject(date, true)
                );

            }


            // Hari bulan berikutnya
            let nextDay = 1;

            while (result.length < 42) {

                const date = new Date(
                    year,
                    month + 1,
                    nextDay++
                );

                result.push(
                    this.createDateObject(date, false)
                );

            }

            return result;

        },


        createDateObject(date, currentMonth) {

            const today = new Date();

            const dateString = this.formatDate(date);

            const todayString = this.formatDate(today);

            return {

                key: dateString,

                date: dateString,

                day: date.getDate(),

                currentMonth: currentMonth,

                today: dateString === todayString

            };

        },


        formatDate(date) {

            const year = date.getFullYear();

            const month = String(
                date.getMonth() + 1
            ).padStart(2, '0');

            const day = String(
                date.getDate()
            ).padStart(2, '0');

            return `${year}-${month}-${day}`;

        },


        getActivities(date) {

            return this.activities.filter(activity => {

                const matchDate =
                    activity.date === date;

                const matchSearch =
                    activity.name
                        .toLowerCase()
                        .includes(
                            this.search.toLowerCase()
                        );

                return matchDate && matchSearch;

            });

        },


        previousMonth() {

            this.currentDate = new Date(
                this.currentYear,
                this.currentMonth - 1,
                1
            );

            this.$nextTick(() => {
                if (window.lucide) {
                    lucide.createIcons();
                }
            });

        },


        nextMonth() {

            this.currentDate = new Date(
                this.currentYear,
                this.currentMonth + 1,
                1
            );

            this.$nextTick(() => {
                if (window.lucide) {
                    lucide.createIcons();
                }
            });

        },


        goToday() {

            this.currentDate = new Date();

        }

    }

}
</script>

@endsection