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
</body>

</html>