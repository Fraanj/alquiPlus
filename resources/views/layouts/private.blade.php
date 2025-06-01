@vite([
    'resources/css/app.css',
])
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MANNY Maquinarias')</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>
<header class="header">
    <div class="logo">
        <img src="/images/mannylogo.png" alt="Logo">
    </div>
    <h1>MANNY Maquinarias</h1>
    <div class="actions">
        <div class="dropdown">
            <button class="dropdown-btn">
                {{ Auth::user()->name }}
                <div class="usuario-icono">
                    <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" alt="Usuario" />
                </div>
                <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" class="avatar">
            </button>
            <div class="dropdown-menu">
                <a href="#">Modificar datos</a>
                <a href="#">Cambiar contraseña</a>
                <a href="#">Historial de reservas</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            </div>
        </div>
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
</body>
</html>
