@vite([
    'resources/css/app.css',
])
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>
<div class="container">
    <header class="header">
        <!-- Logo -->
        <div class="logo">
            <div class="logo-img">
                <img src="/images/mannylogo.png" alt="Logo" />
            </div>
        </div>
        <!-- Título -->
        <h1 class="titulo">
            <span class="marca">MANNY</span> <span class="subtitulo">Maquinarias</span>
        </h1>

        <!-- Acciones -->
        <div class="actions">
            <a href="{{ route('login') }}">Iniciar sesión</a>
            <a href="{{ route('register') }}">Registrarse</a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
    <footer>
        <p>Contacto: <a href="mailto:innovadev@alquiplus.com">innovadev@alquiplus.com</a> |
            Tel: <a href="tel:+542215922204">+54 221 592 2204</a></p>
        <p>Dirección: La Plata 21, Buenos Aires, Argentina</p>
    </footer>
</div>

</body>
</html>
