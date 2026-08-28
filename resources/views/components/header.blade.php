<header class="flex h-10 py-1 items-center justify-end border-b border-neutral-300 bg-slate-50 px-2">

    {{-- User --}}
    <div class="flex items-center gap-4">

        <button
            type="button"
            class="relative flex h-9 w-9 items-center justify-center rounded-lg text-slate-600 "
            title="Notifikasi"
        >
            <i
                data-lucide="bell"
                class="h-5 w-5 transition hover:text-sky-800"
            ></i>

            {{-- Badge notifikasi --}}
            <span
                class="absolute right-1.5 top-1.5 h-1.5 w-1.5 rounded-full bg-red-500"
            ></span>
        </button>

        <button
            type="button"
            class="flex items-center gap-1 rounded-lg px-2 py-2"
        >

        @auth
                @php
                    $user = Auth::user();

                    // Ambil nama untuk avatar
                    $namaUser = $user->name ?? $user->username ?? 'User';

                    // Ambil huruf pertama nama
                    $inisial = strtoupper(substr($namaUser, 0, 1));

                    // Role dari database
                    $roleUser = $user->role ?? 'User';
                @endphp

            {{-- Informasi pengguna --}}
            <div class="min-w-0 text-left py-2">

                {{-- <div class="text-sm font-semibold text-slate-900">
                    Sekretaris
                </div> --}}

                <div class="text-xs text-slate-600 mr-2">
                    {{ $namaUser }}
                </div>

            </div>

            {{-- Avatar --}}
            <div
                class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-cyan-800 text-sm font-semibold text-white mr-2 "
            >
                 {{ $inisial }}
            </div>

            @else

                <div class="min-w-0 text-left py-2">
                    <div class="text-xs text-slate-600 mr-2">
                        Guest
                    </div>
                </div>

                <div
                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-cyan-800 text-sm font-semibold text-white mr-2"
                >
                    G
                </div>

            @endauth


        </button>


        

    </div>

</header>