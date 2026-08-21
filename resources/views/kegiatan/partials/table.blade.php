@forelse ($kegiatan as $item)

    <tr class="transition hover:bg-slate-50 text-center">

        {{-- NO --}}
        <td class="px-2 py-3 text-slate-500">
            {{ $kegiatan->firstItem() + $loop->index }}
        </td>


        {{-- KEGIATAN --}}
        <td class="px-2 py-2 text-left max-w-xs">

            <div
                class="block truncate font-medium text-slate-600 hover:text-sky-900"
                title="{{ $item->nama_kegiatan }}"
            >
                {{ $item->nama_kegiatan }}
            </div>

        </td>


        {{-- PILAR --}}
        <td class="px-2 py-3 text-slate-600">
            Pilar {{ $item->pilar }}
        </td>


        {{-- WAKTU PELAKSANAAN --}}
        <td class="px-2 py-3 text-slate-700">

            @if ($item->waktu_pemenuhan)

                {{ \Carbon\Carbon::parse($item->waktu_pemenuhan)->translatedFormat('d F Y') }}

            @else

                -

            @endif

        </td>


        {{-- STATUS --}}
        <td class="px-2 py-3">

            @switch(strtolower($item->status_aktual))

                {{-- MENUNGGU --}}
                @case('menunggu')

                    <span
                        class="inline-flex items-center gap-1.5 rounded-full
                        border border-slate-100 px-2.5 py-1.5
                        text-[10px] font-medium text-slate-700 bg-slate-50"
                    >

                        <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            width="14" height="14" viewBox="0 0 24 24" 
                            fill="none" stroke="currentColor" stroke-width="2" 
                            stroke-linecap="round" stroke-linejoin="round" 
                            class="lucide lucide-clock-icon lucide-clock">
                            <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                        </svg>

                        {{-- <i
                            data-lucide="clock"
                            class="h-3.5 w-3.5">
                        </i> --}}

                        Menunggu

                    </span>

                    @break


                {{-- BERLANGSUNG --}}
                @case('berlangsung')

                    <span
                        class="inline-flex items-center gap-1.5 rounded-full
                        border border-blue-100 px-2.5 py-1.5
                        text-[10px] font-medium text-sky-700 bg-blue-50"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" 
                        width="14" height="14" viewBox="0 0 24 24" fill="none" 
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                        stroke-linejoin="round" 
                        class="lucide lucide-loader-icon lucide-loader">
                        <path d="M12 2v4"/><path d="m16.2 7.8 2.9-2.9"/>
                        <path d="M18 12h4"/><path d="m16.2 16.2 2.9 2.9"/>
                        <path d="M12 18v4"/><path d="m4.9 19.1 2.9-2.9"/>
                        <path d="M2 12h4"/><path d="m4.9 4.9 2.9 2.9"/>
                    </svg>

                        {{-- <i
                            data-lucide="loader"
                            class="h-3.5 w-3.5">
                        </i> --}}

                        Berlangsung

                    </span>

                    @break


                {{-- SELESAI --}}
                @case('selesai')

                    <span
                        class="inline-flex items-center gap-1.5 rounded-full
                        border border-emerald-100 px-2.5 py-1.5
                        text-[10px] font-medium text-emerald-700 bg-emerald-50"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            width="14" height="14" viewBox="0 0 24 24" fill="none" 
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                            stroke-linejoin="round" 
                            class="lucide lucide-circle-check-icon lucide-circle-check"><circle cx="12" cy="12" r="10"/>
                            <path d="m9 12 2 2 4-4"/>
                        </svg>

                        {{-- <i
                            data-lucide="circle-check"
                            class="h-3.5 w-3.5">
                        </i> --}}

                        Selesai

                    </span>

                @break


                {{-- TERLAMBAT --}}
                @case('terlambat')

                    <span
                        class="inline-flex items-center gap-1.5 rounded-full
                        border border-red-100 px-2.5 py-1.5
                        text-[10px] font-medium text-red-700 bg-red-50"
                    >

                        <svg xmlns="http://www.w3.org/2000/svg" 
                            width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                            stroke-linejoin="round" 
                            class="lucide lucide-octagon-x-icon lucide-octagon-x">
                            <path d="m15 9-6 6"/>
                            <path d="M2.586 16.726A2 2 0 0 1 2 15.312V8.688a2 2 0 0 1 .586-1.414l4.688-4.688A2 2 0 0 1 8.688 2h6.624a2 2 0 0 1 1.414.586l4.688 4.688A2 2 0 0 1 22 8.688v6.624a2 2 0 0 1-.586 1.414l-4.688 4.688a2 2 0 0 1-1.414.586H8.688a2 2 0 0 1-1.414-.586z"/>
                            <path d="m9 9 6 6"/>
                        </svg>

                        {{-- <i
                            data-lucide="triangle-alert"
                            class="h-3.5 w-3.5">
                        </i> --}}

                        Terlambat

                    </span>

                @break

                {{-- TINDAK LANJUT --}}
                @case('tindak_lanjut')

                    <span
                        class="inline-flex items-center gap-1.5 rounded-full
                        border border-amber-100 px-2.5 py-1.5
                        text-[10px] font-medium text-amber-700 bg-amber-50"
                    >

                        <svg xmlns="http://www.w3.org/2000/svg" 
                            width="14" height="14" viewBox="0 0 24 24" fill="none" 
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                            stroke-linejoin="round" 
                            class="lucide lucide-triangle-alert-icon lucide-triangle-alert">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/>
                            <path d="M12 9v4"/><path d="M12 17h.01"/>
                        </svg>

                        Tindak Lanjut

                    </span>

                @break               


                {{-- DEFAULT --}}
                @default

                    <span
                        class="inline-flex items-center gap-1.5 rounded-full
                        border border-slate-100 px-2.5 py-1.5
                        text-[10px] font-medium text-slate-700 bg-slate-50"
                    >
                        <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            width="14" height="14" viewBox="0 0 24 24" 
                            fill="none" stroke="currentColor" stroke-width="2" 
                            stroke-linecap="round" stroke-linejoin="round" 
                            class="lucide lucide-clock-icon lucide-clock">
                            <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                        </svg>

                        Menunggu

                    </span>

            @endswitch

        </td>


        {{-- AKSI --}}
        <td class="px-2 py-3 text-center">

            <a
                href="{{ route('kegiatan.detail', $item->id) }}"
                class="inline-flex items-center gap-1.5 rounded-full
                border border-slate-200 px-2.5 py-1.5
                text-[10px] font-medium text-slate-600
                transition hover:border-sky-200
                hover:bg-sky-50 hover:text-sky-700"
            >
                <svg xmlns="http://www.w3.org/2000/svg" 
                    width="14" height="14" viewBox="0 0 24 24" fill="none" 
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                    stroke-linejoin="round" 
                    class="lucide lucide-eye-icon lucide-eye">
                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>

                {{-- <i
                    data-lucide="eye"
                    class="h-3.5 w-3.5">
                </i> --}}

                Detail

            </a>

        </td>

    </tr>

@empty

    <tr>

        <td
            colspan="6"
            class="px-4 py-12 text-center"
        >

            <div class="flex flex-col items-center gap-2">

                <i
                    data-lucide="search-x"
                    class="h-8 w-8 text-slate-300">
                </i>

                <p class="text-sm text-slate-400">
                    Tidak ada kegiatan yang ditemukan.
                </p>

            </div>

        </td>

    </tr>

@endforelse