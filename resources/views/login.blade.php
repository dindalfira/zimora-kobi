<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login ZI-MORA KOBI</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="min-h-screen">

    <div
        class="relative flex min-h-screen items-center justify-center overflow-hidden bg-sky-950"
    >

        {{-- Background --}}
        <div
            class="absolute inset-0 bg-linear-to-br from-cyan-900/20 via-sky-950 to-sky-950"
        ></div>

        <div
            class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(255,255,255,0.05),transparent_40%)]"
        ></div>


        {{-- Login Card --}}
        <div
            class="relative z-10 w-full max-w-md rounded-3xl bg-white p-8 shadow-2xl sm:p-10 h-140"
        >

            {{-- <div class="relative h-25 w-25 items-center justify-center p-1"> --}}
                <img
                    src="{{ asset('images/logo_bps.png') }}"
                    alt="Logo BPS"
                    class="h-12 w-full object-contain"
                >
            {{-- </div> --}}

            {{-- Header --}}
            <div class="mb-10 text-center">

                <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                    ZI-MORA KOBI
                </h1>

                <p class="mt-3 text-sm leading-5 text-gray-500">
                    Sistem Monitoring Rencana Aksi Zona Integritas
                </p>
                <p class="mt-1 text-sm leading-5 text-gray-500">
                    BPS Kota Bima
                </p>

            </div>


            {{-- Form --}}
            <form action="{{ route('login.process') }}" method="POST" class="space-y-6">
                @csrf

                @if ($errors->any())
                    <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3">
                        <p class="text-xs font-medium text-rose-700">
                            {{ $errors->first() }}
                        </p>
                    </div>
                @endif


                {{-- Username --}}
                <div>

                    <label
                        for="username"
                        class="mb-2 block text-xs font-semibold tracking-wide text-slate-900"
                    >
                        Username
                    </label>

                    <div class="relative">

                        <div
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"
                        >
                            <i
                                data-lucide="user"
                                class="h-4 w-4"
                            ></i>
                        </div>

                        <input
                            id="username"
                            name="username"
                            type="text"
                            autocomplete="username"
                            placeholder="Masukkan username Anda"
                            class="w-full rounded-2xl border border-gray-200 bg-white py-2 pl-11 pr-4 text-xs text-slate-700 outline-none transition placeholder:text-gray-400 focus:border-sky-700 focus:ring-2 focus:ring-sky-100"
                        >

                    </div>

                </div>


                {{-- Password --}}
                <div
                    x-data="{ showPassword: false }"
                    class="self-stretch flex flex-col gap-2.5"
                >
                    {{-- Label --}}
                    <label
                        for="password"
                        class="text-xs font-semibold tracking-wide text-slate-900"
                    >
                        Password
                    </label>

                    {{-- Input Password --}}
                    <div class="relative">

                        {{-- Icon Lock --}}
                        <i
                            data-lucide="lock"
                            class="pointer-events-none absolute left-4 top-1/2 h-4 w-4
                                -translate-y-1/2 text-gray-400"
                        ></i>

                        <input
                            id="password"
                            name="password"
                            x-bind:type="showPassword ? 'text' : 'password'"
                            placeholder="Masukkan password Anda"
                            autocomplete="current-password"
                            required
                            class="w-full rounded-2xl border border-gray-200 bg-white
                                py-2 pl-11 pr-12 text-xs text-slate-900
                                outline-none transition
                                placeholder:text-gray-400
                                focus:border-sky-700
                                focus:ring-2 focus:ring-sky-100"
                        >

                        {{-- Tombol Eye --}}
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 flex h-8 w-8
                                -translate-y-1/2 items-center justify-center
                                rounded-lg text-gray-400 transition
                              hover:text-slate-700"
                            :aria-label="showPassword ? 'Sembunyikan password' : 'Tampilkan password'"
                        >

                            {{-- Eye Off: kondisi default --}}
                            <i
                                x-show="!showPassword"
                                data-lucide="eye-off"
                                class="h-4 w-4"
                            ></i>

                            {{-- Eye: ketika password ditampilkan --}}
                            <i
                                x-show="showPassword"
                                data-lucide="eye"
                                class="h-4 w-4"
                            ></i>

                        </button>

                    </div>
                </div>


                {{-- Remember + Forgot Password --}}
                <div class="flex items-center justify-between">

                    <label class="flex cursor-pointer items-center gap-2">

                        <input
                            type="checkbox"
                            name="remember"
                            class="h-3 w-3 rounded border-gray-300 text-sky-700 focus:ring-sky-600"
                        >

                        <span class="text-xs text-gray-500">
                            Ingat Saya
                        </span>

                    </label>


                    <a
                        href="#"
                        class="text-xs font-semibold text-blue-600 transition hover:text-blue-800"
                    >
                        Lupa kata sandi?
                    </a>

                </div>


                {{-- Login Button --}}
                <button
                    type="submit"
                    class="flex h-9 w-full items-center justify-center rounded-2xl bg-linear-to-r from-cyan-900 to-sky-700 px-4 text-base font-bold text-white shadow-lg shadow-sky-900/20 transition hover:from-cyan-950 hover:to-sky-800"
                >
                    Masuk
                </button>

            </form>


            {{-- Footer --}}
            <div class="mt-8 border-t border-gray-200 pt-6 text-center">

                <p class="text-xs leading-5 text-gray-400">
                    © Tim Reformasi Birokrasi BPS Kota Bima
                </p>

            </div>

        </div>

    </div>


    {{-- Toggle Password --}}
    <script>
        function togglePassword() {

            const password = document.getElementById('password');
            const icon = document.getElementById('password-icon');

            if (password.type === 'password') {

                password.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');

            } else {

                password.type = 'password';
                icon.setAttribute('data-lucide', 'eye');

            }

            lucide.createIcons();
        }
    </script>

</body>

</html>