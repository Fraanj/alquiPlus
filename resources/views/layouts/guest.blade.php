<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
<!-- TU HEADER -->
<header class="header">
    @include('layouts.navigation')
</header>

<main class="flex-grow">
    <div class="py-12 flex flex-col sm:justify-center items-center bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</main>

<!-- TU FOOTER -->
<footer>
    <p>Contacto: <a href="mailto:innovadev@alquiplus.com">innovadev@alquiplus.com</a> |
        Tel: <a href="tel:+542215922204">+54 221 592 2204</a></p>
    <p>Dirección: La Plata 21, Buenos Aires, Argentina</p>
</footer>
</body>
</html>
