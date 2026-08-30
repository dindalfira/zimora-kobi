@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')

<div class="space-y-5 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div>
            <h2 class="text-2xl font-semibold text-slate-900">
                Notifikasi
            </h2>

            <p class="mt-1 text-xs text-slate-500">
                Pemberitahuan terkait proses pemenuhan dan pemeriksaan LKE.
            </p>
        </div>

        {{-- Tandai semua sudah dibaca --}}
        @if($notification->where('dibaca', false)->count() > 0)

            <form
                action="{{ route('notification.readAll') }}"
                method="POST"
            >
                @csrf

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-lg
                           border border-slate-200 bg-white px-4 py-2
                           text-xs font-medium text-slate-600
                           transition hover:bg-slate-50"
                >
                    <i data-lucide="check-check" class="h-4 w-4"></i>

                    Tandai semua dibaca
                </button>
            </form>

        @endif

    </div>


    {{-- =========================================================
        DAFTAR NOTIFIKASI
    ========================================================== --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

        @forelse($notification as $item)

            <a
                href="{{ route('notification.read', $item->id) }}"
                class="group block border-b border-slate-200 last:border-b-0
                       transition hover:bg-slate-50
                       {{ !$item->dibaca ? 'bg-sky-50/40' : 'bg-white' }}"
            >

                <div class="flex gap-4 px-5 py-4">

                    {{-- =================================================
                        ICON
                    ================================================== --}}
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center
                        rounded-full
                        @if($item->tipe === 'perbaikan_bukti')
                            bg-amber-100 text-amber-600
                        @elseif($item->tipe === 'siap_diperiksa')
                            bg-emerald-100 text-emerald-600
                        @elseif($item->tipe === 'siap_diperiksa_ulang')
                            bg-blue-100 text-blue-600
                        @else
                            bg-slate-100 text-slate-600
                        @endif"
                    >

                        @if($item->tipe === 'perbaikan_bukti')

                            <i data-lucide="triangle-alert" class="h-5 w-5"></i>

                        @elseif($item->tipe === 'siap_diperiksa')

                            <i data-lucide="file-check-2" class="h-5 w-5"></i>

                        @elseif($item->tipe === 'siap_diperiksa_ulang')

                            <i data-lucide="refresh-cw" class="h-5 w-5"></i>

                        @else

                            <i data-lucide="bell" class="h-5 w-5"></i>

                        @endif

                    </div>


                    {{-- =================================================
                        ISI NOTIFIKASI
                    ================================================== --}}
                    <div class="min-w-0 flex-1">

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">

                                <h3
                                    class="text-xs font-semibold
                                    {{ !$item->dibaca
                                        ? 'text-slate-900'
                                        : 'text-slate-700' }}"
                                >
                                    {{ $item->judul }}
                                </h3>

                                <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                    {{ $item->pesan }}
                                </p>

                            </div>


                            {{-- Status belum dibaca --}}
                            @if(!$item->dibaca)

                                <span
                                    class="mt-1 h-2.5 w-2.5 shrink-0 rounded-full bg-sky-600"
                                    title="Belum dibaca"
                                ></span>

                            @endif

                        </div>


                        {{-- =================================================
                            FOOTER NOTIFIKASI
                        ================================================== --}}
                        <div class="mt-2 flex flex-wrap items-center gap-3">

                            @if($item->id_pilar)

                                <span
                                    class="inline-flex items-center gap-1
                                        rounded-md bg-slate-100 px-2 py-1
                                        text-[11px] font-medium text-slate-600"
                                >
                                    <i data-lucide="layers" class="h-3 w-3"></i>

                                    Pilar {{ $item->id_pilar }}
                                </span>

                            @endif

                            @if($item->id_pertanyaan)

                                <span
                                    class="inline-flex items-center gap-1
                                        rounded-md bg-slate-100 px-2 py-1
                                        text-[11px] font-medium text-slate-600"
                                >
                                    <i data-lucide="file-question" class="h-3 w-3"></i>

                                    Pertanyaan {{ $item->id_pertanyaan }}
                                </span>

                            @endif

                            @if($item->created_at)

                                <span class="text-xs text-slate-400">
                                    {{ $item->created_at->diffForHumans() }}
                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- =================================================
                        ARROW
                    ================================================== --}}
                    <div
                        class="flex shrink-0 items-center text-slate-300
                               transition group-hover:translate-x-0.5
                               group-hover:text-slate-500"
                    >
                        <i
                            data-lucide="chevron-right"
                            class="h-5 w-5"
                        ></i>
                    </div>

                </div>

            </a>

        @empty

            {{-- =========================================================
                EMPTY STATE
            ========================================================== --}}
            <div class="px-6 py-16 text-center">

                <div
                    class="mx-auto mb-4 flex h-14 w-14 items-center justify-center
                           rounded-full bg-slate-100 text-slate-400"
                >
                    <i
                        data-lucide="bell-off"
                        class="h-6 w-6"
                    ></i>
                </div>

                <h3 class="text-xs font-semibold text-slate-700">
                    Belum ada notifikasi
                </h3>

                <p class="mt-1 text-xs text-slate-400">
                    Pemberitahuan baru akan muncul di sini.
                </p>

            </div>

        @endforelse

    </div>


    {{-- =========================================================
        PAGINATION
    ========================================================== --}}
    @if($notification->hasPages())

        <div class="pt-1">
            {{ $notification->links() }}
        </div>

    @endif

</div>


{{-- =============================================================
    LUCIDE
============================================================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide) {
            lucide.createIcons();
        }
    });
</script>

@endsection