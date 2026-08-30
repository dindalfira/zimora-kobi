<aside class="fixed left-0 top-0 z-40 flex h-screen w-64 flex-col bg-sky-950 py-4">

    {{-- Logo --}}
    <div class="mb-8 flex items-center gap-3 px-6">

        <div class="flex h-10 w-15 items-center justify-center rounded-xl bg-white p-1">
            <img
                src="{{ asset('images/logo_bps.png') }}"
                alt="Logo BPS"
                class="h-full w-full object-contain"
            >
        </div>

        <div>
            <div class="text-sm font-bold leading-6 text-white">
                ZI-MORA KOBI
            </div>

            <div class="text-[10px] text-white/50">
                Monitoring Rencana Aksi Zona Integritas BPS Kota Bima
            </div>
        </div>

    </div>


    {{-- Menu --}}
    <nav class="space-y-1 px-3">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center rounded-lg px-4 py-2.5 text-xs font-bold tracking-wide transition
           {{ request()->routeIs('dashboard')
                ? 'bg-sky-700 text-white'
                : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

            <i data-lucide="layout-dashboard" class="mr-2 h-4 w-4"></i>

            Dashboard
        </a>


        {{-- Jadwal --}}
        <a href="{{ route('jadwal') }}"
           class="flex items-center rounded-lg px-4 py-2.5 text-xs font-bold tracking-wide transition
           {{ request()->routeIs('jadwal')
                ? 'bg-sky-700 text-white'
                : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

            <i data-lucide="calendar-days" class="mr-2 h-4 w-4"></i>

            Jadwal
        </a>


        {{-- Monitoring Kegiatan --}}
        <a href="{{ route('kegiatan.index') }}"
           class="flex items-center rounded-lg px-4 py-2.5 text-xs font-bold tracking-wide transition
           {{ request()->routeIs('kegiatan.index', 'kegiatan.detail')
                ? 'bg-sky-700 text-white'
                : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

            <i data-lucide="monitor" class="mr-2 h-4 w-4"></i>

            Monitoring Kegiatan
        </a>


        {{-- LKE --}}
        <a href="{{ route('lke') }}"
           class="flex items-center rounded-lg px-4 py-2.5 text-xs font-bold tracking-wide transition
           {{ request()->routeIs('lke', 'detail-lke')
                ? 'bg-sky-700 text-white'
                : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

            <i data-lucide="file-text" class="mr-2 h-4 w-4"></i>

            LKE
        </a>


        {{-- Pengaturan --}}
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('pengaturan') }}"
            class="flex items-center rounded-lg px-4 py-2.5 text-xs font-bold tracking-wide transition
            {{ request()->routeIs('pengaturan')
                    ? 'bg-sky-700 text-white'
                    : 'text-white/70 hover:bg-white/10 hover:text-white' }}">

                <i data-lucide="settings" class="mr-2 h-4 w-4"></i>

                Pengaturan
            </a>
        @endif

    </nav>


    {{-- Logout --}}
    <div class="mt-auto border-t border-white/10 px-3 pt-4 ">

        <form
            method="POST"
            action="{{ route('logout') }}"
            id="logout-form"
            class=""
        >
            @csrf

            <button
                type="button"
                onclick="confirmLogout()"
                class="flex items-center w-full rounded-lg px-4 py-2.5 text-xs font-bold
                    tracking-wide text-white/70 transition
                    hover:bg-white/10 hover:text-white">

                <i data-lucide="log-out" class="mr-2 h-4 w-4"></i>

                Logout
            </button>
        </form>

    </div>

</aside>