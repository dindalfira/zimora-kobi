@extends('layouts.app')
@section('title', 'Pengaturan')
@section('content')

<div class="min-h-screen bg-slate-50 p-4 sm:p-6">

    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="text-xl font-bold text-sky-950">
            Pengaturan
        </h1>

        <p class="mt-1 text-xs text-slate-500">
            Kelola konfigurasi akun, notifikasi, WhatsApp, dan sistem monitoring ZI.
        </p>
    </div>


    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

        <!-- SIDEBAR -->
        <aside class="lg:col-span-3">

            <div class="rounded-2xl border border-slate-200 bg-white p-2 shadow-sm">

                <button
                    class="flex w-full items-center gap-3 rounded-xl bg-sky-50 px-4 py-3
                           text-left text-xs font-semibold text-sky-700"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 6h9m-9 6h9m-9 6h9M4.5 6h.01M4.5 12h.01M4.5 18h.01"/>
                    </svg>

                    Umum
                </button>


                <button
                    class="flex w-full items-center gap-3 rounded-xl px-4 py-3
                           text-left text-xs font-medium text-slate-600
                           hover:bg-slate-50"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0
                               3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0
                               0115 0"/>
                    </svg>

                    Akun
                </button>


                <button
                    class="flex w-full items-center gap-3 rounded-xl px-4 py-3
                           text-left text-xs font-medium text-slate-600
                           hover:bg-slate-50"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.25 18.75a6 6 0 00-12 0
                               M8.25 12a3.75 3.75 0 100-7.5
                               3.75 3.75 0 000 7.5z
                               M16.5 8.25h5.25M19.125 5.625v5.25"/>
                    </svg>

                    Notifikasi
                </button>


                <!-- WHATSAPP -->
                <button
                    class="flex w-full items-center gap-3 rounded-xl px-4 py-3
                           text-left text-xs font-medium text-slate-600
                           hover:bg-slate-50"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.625 10.875a6.75 6.75 0 008.5 8.5
                               l3.75 1.125-1.125-3.75a6.75 6.75
                               0 00-8.5-8.5z"/>
                    </svg>

                    WhatsApp
                </button>


                <button
                    class="flex w-full items-center gap-3 rounded-xl px-4 py-3
                           text-left text-xs font-medium text-slate-600
                           hover:bg-slate-50"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.594 3.06c.53-1.06 2.276-1.06
                               2.807 0l.25.5a2.25 2.25 0
                               002.09 1.24l.557-.018c1.183-.038
                               1.774 1.394.84 2.1l-.44.334a2.25
                               2.25 0 00-.82 2.516l.17.53c.36
                               1.13-.93 2.06-1.89 1.36l-.45-.33
                               a2.25 2.25 0 00-2.65 0l-.45.33
                               c-.96.7-2.25-.23-1.89-1.36l.17-.53
                               a2.25 2.25 0 00-.82-2.516l-.44-.334
                               c-.934-.706-.343-2.138.84-2.1l.557.018
                               a2.25 2.25 0 002.09-1.24z"/>
                    </svg>

                    Monitoring
                </button>


                <button
                    class="flex w-full items-center gap-3 rounded-xl px-4 py-3
                           text-left text-xs font-medium text-slate-600
                           hover:bg-slate-50"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 15.75a3.75 3.75 0 100-7.5
                               3.75 3.75 0 000 7.5z
                               M19.5 12a7.5 7.5 0 01-.08
                               1.07l2.02 1.58-2.25 3.9-2.4-.96
                               a7.5 7.5 0 01-1.85 1.07L14.55
                               21h-4.5l-.39-2.34a7.5 7.5
                               0 01-1.85-1.07l-2.4.96-2.25-3.9
                               2.02-1.58A7.5 7.5 0 015.1
                               12c0-.36.03-.72.08-1.07L3.16
                               9.35l2.25-3.9 2.4.96a7.5 7.5
                               0 011.85-1.07L10.05 3h4.5l.39
                               2.34a7.5 7.5 0 011.85 1.07l2.4-.96
                               2.25 3.9-2.02 1.58c.05.35.08.71.08
                               1.07z"/>
                    </svg>

                    Keamanan
                </button>

            </div>

        </aside>


        <!-- CONTENT -->
        <main class="lg:col-span-9">

            <!-- GENERAL -->
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-5 py-4">

                    <h2 class="text-sm font-bold text-sky-950">
                        Pengaturan Umum
                    </h2>

                    <p class="mt-1 text-[10px] text-slate-400">
                        Konfigurasi dasar aplikasi Monitoring ZI.
                    </p>

                </div>


                <div class="space-y-5 p-5">

                    <!-- APPLICATION NAME -->
                    <div>
                        <label class="text-xs font-semibold text-slate-700">
                            Nama Aplikasi
                        </label>

                        <input
                            type="text"
                            value="Monitoring Zona Integritas"
                            class="mt-2 w-full rounded-xl border border-slate-200
                                   px-3 py-2.5 text-xs text-slate-700
                                   outline-none transition
                                   focus:border-sky-400 focus:ring-2
                                   focus:ring-sky-100"
                        >
                    </div>


                    <!-- ACTIVE YEAR -->
                    <div>
                        <label class="text-xs font-semibold text-slate-700">
                            Tahun Monitoring
                        </label>

                        <select
                            class="mt-2 w-full rounded-xl border border-slate-200
                                   px-3 py-2.5 text-xs text-slate-700
                                   outline-none focus:border-sky-400
                                   focus:ring-2 focus:ring-sky-100"
                        >
                            <option>2026</option>
                            <option>2025</option>
                            <option>2024</option>
                        </select>
                    </div>


                    <!-- SAVE -->
                    <div class="flex justify-end border-t border-slate-100 pt-4">

                        <button
                            class="rounded-xl bg-sky-600 px-4 py-2.5
                                   text-xs font-semibold text-white
                                   shadow-sm transition hover:bg-sky-700"
                        >
                            Simpan Perubahan
                        </button>

                    </div>

                </div>

            </div>

            <!-- ROLE & HAK AKSES -->
            <div class="mt-5 rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-5 py-4">

                    <h2 class="text-sm font-bold text-sky-950">
                        Role & Hak Akses
                    </h2>

                    <p class="mt-1 text-[10px] text-slate-400">
                        Atur peran pengguna dan kewenangan yang dapat dilakukan pada sistem.
                    </p>

                </div>


                <div class="p-5">

                    <!-- ROLE LIST -->
                    <div class="overflow-x-auto">

                        <table class="w-full text-left">

                            <thead>
                                <tr class="border-b border-slate-100">

                                    <th class="px-3 py-3 text-[10px] font-bold
                                            uppercase tracking-wide text-slate-400">
                                        Role
                                    </th>

                                    <th class="px-3 py-3 text-[10px] font-bold
                                            uppercase tracking-wide text-slate-400">
                                        Deskripsi
                                    </th>

                                    <th class="px-3 py-3 text-[10px] font-bold
                                            uppercase tracking-wide text-slate-400">
                                        Pengguna
                                    </th>

                                    <th class="px-3 py-3 text-right text-[10px]
                                            font-bold uppercase tracking-wide text-slate-400">
                                        Aksi
                                    </th>

                                </tr>
                            </thead>


                            <tbody class="divide-y divide-slate-100">

                                <!-- ADMIN -->
                                <tr>

                                    <td class="px-3 py-4">

                                        <div class="flex items-center gap-2">

                                            <div class="flex h-7 w-7 items-center
                                                        justify-center rounded-full
                                                        bg-slate-800 text-[10px]
                                                        font-bold text-white">
                                                A
                                            </div>

                                            <span class="text-xs font-semibold text-slate-700">
                                                Admin
                                            </span>

                                        </div>

                                    </td>

                                    <td class="px-3 py-4 text-[10px] text-slate-500">
                                        Mengelola sistem dan seluruh pengguna.
                                    </td>

                                    <td class="px-3 py-4 text-xs text-slate-600">
                                        1
                                    </td>

                                    <td class="px-3 py-4 text-right">

                                        <button
                                            class="rounded-lg px-3 py-1.5 text-[10px]
                                                font-semibold text-sky-600
                                                hover:bg-sky-50"
                                        >
                                            Atur Hak Akses
                                        </button>

                                    </td>

                                </tr>


                                <!-- SEKRETARIAT -->
                                <tr>

                                    <td class="px-3 py-4">

                                        <div class="flex items-center gap-2">

                                            <div class="flex h-7 w-7 items-center
                                                        justify-center rounded-full
                                                        bg-cyan-800 text-[10px]
                                                        font-bold text-white">
                                                S
                                            </div>

                                            <span class="text-xs font-semibold text-slate-700">
                                                Sekretariat
                                            </span>

                                        </div>

                                    </td>

                                    <td class="px-3 py-4 text-[10px] text-slate-500">
                                        Memantau, memeriksa, dan menilai bukti dukung.
                                    </td>

                                    <td class="px-3 py-4 text-xs text-slate-600">
                                        3
                                    </td>

                                    <td class="px-3 py-4 text-right">

                                        <button
                                            class="rounded-lg px-3 py-1.5 text-[10px]
                                                font-semibold text-sky-600
                                                hover:bg-sky-50"
                                        >
                                            Atur Hak Akses
                                        </button>

                                    </td>

                                </tr>


                                <!-- PILAR -->
                                <tr>

                                    <td class="px-3 py-4">

                                        <div class="flex items-center gap-2">

                                            <div class="flex h-7 w-7 items-center
                                                        justify-center rounded-full
                                                        bg-sky-700 text-[10px]
                                                        font-bold text-white">
                                                P1
                                            </div>

                                            <span class="text-xs font-semibold text-slate-700">
                                                Pilar 1
                                            </span>

                                        </div>

                                    </td>

                                    <td class="px-3 py-4 text-[10px] text-slate-500">
                                        Mengelola bukti dukung Pilar 1.
                                    </td>

                                    <td class="px-3 py-4 text-xs text-slate-600">
                                        4
                                    </td>

                                    <td class="px-3 py-4 text-right">

                                        <button
                                            class="rounded-lg px-3 py-1.5 text-[10px]
                                                font-semibold text-sky-600
                                                hover:bg-sky-50"
                                        >
                                            Atur Hak Akses
                                        </button>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>


                    <!-- ADD ROLE -->
                    <div class="mt-5 flex justify-end border-t border-slate-100 pt-4">

                        <button
                            class="rounded-xl bg-sky-600 px-4 py-2.5
                                text-xs font-semibold text-white
                                shadow-sm transition hover:bg-sky-700"
                        >
                            + Tambah Role
                        </button>

                    </div>

                </div>

            </div>


            <!-- WHATSAPP / FONNTE -->
            <div class="mt-5 rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-5 py-4">

                    <div class="flex items-center justify-between">

                        <div>
                            <h2 class="text-sm font-bold text-sky-950">
                                WhatsApp Notification
                            </h2>

                            <p class="mt-1 text-[10px] text-slate-400">
                                Konfigurasi pengiriman notifikasi melalui Fonnte.
                            </p>
                        </div>


                        <!-- STATUS -->
                        <label class="relative inline-flex cursor-pointer items-center">

                            <input
                                type="checkbox"
                                class="peer sr-only"
                                checked
                            >

                            <div
                                class="h-5 w-9 rounded-full bg-slate-200
                                       after:absolute after:left-0.5
                                       after:top-0.5 after:h-4 after:w-4
                                       after:rounded-full after:bg-white
                                       after:transition-all
                                       peer-checked:bg-sky-600
                                       peer-checked:after:translate-x-4"
                            ></div>

                        </label>

                    </div>

                </div>


                <div class="space-y-5 p-5">

                    <!-- API TOKEN -->
                    <div>

                        <label class="text-xs font-semibold text-slate-700">
                            Fonnte API Token
                        </label>

                        <input
                            type="password"
                            placeholder="Masukkan API token Fonnte"
                            class="mt-2 w-full rounded-xl border border-slate-200
                                   px-3 py-2.5 text-xs text-slate-700
                                   outline-none focus:border-sky-400
                                   focus:ring-2 focus:ring-sky-100"
                        >

                        <p class="mt-1.5 text-[10px] text-slate-400">
                            Token digunakan oleh sistem untuk mengirim pesan WhatsApp.
                        </p>

                    </div>


                    <!-- DEVICE -->
                    <div>

                        <label class="text-xs font-semibold text-slate-700">
                            Device WhatsApp
                        </label>

                        <input
                            type="text"
                            placeholder="Contoh: 628xxxxxxxxxx"
                            class="mt-2 w-full rounded-xl border border-slate-200
                                   px-3 py-2.5 text-xs text-slate-700
                                   outline-none focus:border-sky-400
                                   focus:ring-2 focus:ring-sky-100"
                        >

                    </div>


                    <!-- RECIPIENT -->
                    <div>

                        <label class="text-xs font-semibold text-slate-700">
                            Nomor Penerima Notifikasi
                        </label>

                        <textarea
                            rows="3"
                            placeholder="628xxxxxxxxxx, 628xxxxxxxxxx"
                            class="mt-2 w-full rounded-xl border border-slate-200
                                   px-3 py-2.5 text-xs text-slate-700
                                   outline-none focus:border-sky-400
                                   focus:ring-2 focus:ring-sky-100"
                        ></textarea>

                        <p class="mt-1.5 text-[10px] text-slate-400">
                            Pisahkan beberapa nomor dengan koma.
                        </p>

                    </div>


                    <!-- NOTIFICATION TYPES -->
                    <div>

                        <label class="text-xs font-semibold text-slate-700">
                            Jenis Notifikasi WhatsApp
                        </label>

                        <div class="mt-3 space-y-3">

                            <label class="flex items-center justify-between rounded-xl
                                          border border-slate-100 px-4 py-3">

                                <div>
                                    <p class="text-xs font-medium text-slate-700">
                                        Pengingat Deadline
                                    </p>

                                    <p class="text-[10px] text-slate-400">
                                        Kirim pengingat sebelum batas waktu.
                                    </p>
                                </div>

                                <input
                                    type="checkbox"
                                    checked
                                    class="h-4 w-4 rounded border-slate-300
                                           text-sky-600 focus:ring-sky-500"
                                >

                            </label>


                            <label class="flex items-center justify-between rounded-xl
                                          border border-slate-100 px-4 py-3">

                                <div>
                                    <p class="text-xs font-medium text-slate-700">
                                        Bukti Dukung Diunggah
                                    </p>

                                    <p class="text-[10px] text-slate-400">
                                        Informasikan ketika bukti dukung masuk.
                                    </p>
                                </div>

                                <input
                                    type="checkbox"
                                    checked
                                    class="h-4 w-4 rounded border-slate-300
                                           text-sky-600 focus:ring-sky-500"
                                >

                            </label>


                            <label class="flex items-center justify-between rounded-xl
                                          border border-slate-100 px-4 py-3">

                                <div>
                                    <p class="text-xs font-medium text-slate-700">
                                        Revisi Bukti Dukung
                                    </p>

                                    <p class="text-[10px] text-slate-400">
                                        Informasikan ketika bukti dukung perlu diperbaiki.
                                    </p>
                                </div>

                                <input
                                    type="checkbox"
                                    checked
                                    class="h-4 w-4 rounded border-slate-300
                                           text-sky-600 focus:ring-sky-500"
                                >

                            </label>

                        </div>

                    </div>


                    <!-- TEST -->
                    <div class="flex flex-col gap-3 border-t border-slate-100
                                pt-4 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <p class="text-xs font-semibold text-slate-700">
                                Uji Koneksi WhatsApp
                            </p>

                            <p class="text-[10px] text-slate-400">
                                Pastikan token Fonnte dapat digunakan.
                            </p>

                        </div>


                        <button
                            class="rounded-xl border border-sky-200 bg-sky-50
                                   px-4 py-2 text-xs font-semibold text-sky-700
                                   hover:bg-sky-100"
                        >
                            Test WhatsApp
                        </button>

                    </div>


                    <!-- SAVE -->
                    <div class="flex justify-end border-t border-slate-100 pt-4">

                        <button
                            class="rounded-xl bg-sky-600 px-4 py-2.5
                                   text-xs font-semibold text-white
                                   shadow-sm hover:bg-sky-700"
                        >
                            Simpan Pengaturan WhatsApp
                        </button>

                    </div>

                </div>

            </div>

        </main>

    </div>

</div>


@endsection