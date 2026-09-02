<header class="sticky top-0 z-40 flex h-10 py-1 items-center justify-end border-b border-neutral-300 bg-slate-50 px-2">

    {{-- User --}}
    <div class="flex items-center gap-4">
        @php
            $jumlahNotif = \App\Models\Notification::where('user_id', auth()->id())
                ->where('dibaca', false)
                ->count();
        @endphp

    @if(Auth::user()->role !== 'bps')
        <a
            href="{{ route('notification.index') }}"
            class="relative flex h-10 w-10 items-center justify-center rounded-lg
                text-gray-600 hover:text-sky-600"
        >
            <i data-lucide="bell"
                        class="h-5 w-5 transition border-amber-600"></i>

            @if($jumlahNotif > 0)
                <span
                    class="relative -left-2 -top-2 flex h-3 min-w-3 items-center
                        justify-center rounded-full bg-red-500  text-[10px]
                        font-bold text-white"
                >
                    {{ $jumlahNotif > 99 ? '99+' : $jumlahNotif }}
                </span>
            @endif
        </a>
    @endif

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