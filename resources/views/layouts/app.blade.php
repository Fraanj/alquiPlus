<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<header class="header">
    @include('layouts.navigation')
</header>

<main class="min-h-screen bg-gray-100">
    {{ $slot }}
</main>

<footer>
    <p>Contacto: <a href="mailto:innovadev@alquiplus.com">innovadev@alquiplus.com</a> |
        Tel: <a href="tel:+542215922204">+54 221 592 2204</a></p>
    <p>Dirección: La Plata 21, Buenos Aires, Argentina</p>
</footer>
</body>
</html>
