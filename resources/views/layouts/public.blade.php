@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header class="header">
        @include('layouts.navigation')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>Contacto: <a href="mailto:innovadev@alquiplus.com">innovadev@alquiplus.com</a> |
            Tel: <a href="tel:+542215922204">+54 221 592 2204</a></p>
        <p>Dirección: La Plata 21, Buenos Aires, Argentina</p>
    </footer>

</body>
</html>
