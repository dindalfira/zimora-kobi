<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'ZI-MORA KOBI')
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="bg-slate-50">

    @include('components.sidebar')

    <main class="min-h-screen pl-64">

        @include('components.header')

        <section class="p-6">

            @yield('content')

        </section>

        @include('components.footer')

    </main>

    @stack('scripts') 

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar dari sistem?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                buttonsStyling: false,

                customClass: {
                    confirmButton:
                        'rounded-lg bg-slate-700 px-4 py-2 text-xs font-medium text-white hover:bg-sky-600',

                    cancelButton:
                        'mr-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50'
                }
            }).then((result) => {

                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }

            });
        }
    </script>

</body>

</html>

