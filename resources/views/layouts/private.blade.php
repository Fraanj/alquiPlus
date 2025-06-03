<!-- AGREGAR: Tailwind para formularios de Breeze -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WYO6X9q0TxXvxdIuFJ5ZkAlhO2G5+AYixF+BPZsLr6+6fUQ1rs9Jz0qX1s9M2zJQ" crossorigin="anonymous">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
<header class="header">
    @include('layouts.navigation')
</header>

<!-- Mensajito de éxito si el user cambió la contraseña -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show success-alert" role="alert" id="success-alert">
        {{ session('success') }}
        <button type="button" class="btn-close" onclick="closeAlert('success-alert')" aria-label="Close">&times;</button>
    </div>
@endif

<main>
    @yield('content')
</main>

<footer>
    <p>Contacto: <a href="mailto:innovadev@alquiplus.com">innovadev@alquiplus.com</a> |
        Tel: <a href="tel:+542215922204">+54 221 592 2204</a></p>
    <p>Dirección: La Plata 21, Buenos Aires, Argentina</p>
    <br>
</footer>
</body>
</html>
