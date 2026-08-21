<div class="flex items-center gap-1">

    {{-- PREVIOUS --}}
    @if ($kegiatan->currentPage() > 1)

        <button
            type="button"
            @click="loadData({{ $kegiatan->currentPage() - 1 }})"
            class="flex h-8 w-8 items-center justify-center
                   rounded-lg border border-slate-200
                   text-sm text-slate-600 hover:bg-slate-50"
        >
            ‹
        </button>

    @else

        <span
            class="flex h-8 w-8 items-center justify-center
                   rounded-lg border border-slate-200
                   text-sm text-slate-300"
        >
            ‹
        </span>

    @endif


    {{-- NOMOR HALAMAN --}}
    @for ($page = 1; $page <= $kegiatan->lastPage(); $page++)

        @if ($page == $kegiatan->currentPage())

            <span
                class="flex h-8 w-8 items-center justify-center
                       rounded-lg bg-sky-800
                       text-sm font-medium text-white"
            >
                {{ $page }}
            </span>

        @else

            <button
                type="button"
                @click="loadData({{ $page }})"
                class="flex h-8 w-8 items-center justify-center
                       rounded-lg border border-slate-200
                       text-sm text-slate-600 hover:bg-slate-50"
            >
                {{ $page }}
            </button>

        @endif

    @endfor


    {{-- NEXT --}}
    @if ($kegiatan->hasMorePages())

        <button
            type="button"
            @click="loadData({{ $kegiatan->currentPage() + 1 }})"
            class="flex h-8 w-8 items-center justify-center
                   rounded-lg border border-slate-200
                   text-sm text-slate-600 hover:bg-slate-50"
        >
            ›
        </button>

    @else

        <span
            class="flex h-8 w-8 items-center justify-center
                   rounded-lg border border-slate-200
                   text-sm text-slate-300"
        >
            ›
        </span>

    @endif

</div>