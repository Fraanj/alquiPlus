@extends('layouts.public')

@section('content')
<style>
    .estadisticas-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        min-height: 50vh;
        text-align: center;
        gap: 1.8rem;
        font-size: 1.3rem;
    }

    .estadisticas-titulo {
        font-size: 2.2rem;
        margin-bottom: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        justify-content: center;
    }

    .btn-group {
        display: flex;
        gap: 1rem;
        box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
        border-radius: 8px;
        background: white;
        padding: 0.5rem 1.5rem;
    }

    .btn-group a {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        font-size: 1.15rem;
        font-weight: 600;
        color: #333;
        text-decoration: none;
        border-radius: 6px;
        box-shadow: 0 0 8px rgb(0 0 0 / 0);
        transition: all 0.25s ease;
        user-select: none;
    }

    .btn-group a:hover {
        background-color: #f0f0f0;
        box-shadow: 0 2px 10px rgb(0 0 0 / 0.15);
        color: #000;
    }

    .btn-group a.btn-outline-primary {
        color: #0d6efd;
    }

    .btn-group a.btn-outline-secondary {
        color: #198754; /* Verde que usás en la vista reservas totales */
    }

    .btn-group a.btn-outline-success {
        color: #6f42c1; /* Violeta */
    }

    .texto-pendiente {
        margin-top: 2rem;
        font-style: italic;
        color: #666;
        font-size: 1.1rem;
    }
</style>

<div class="estadisticas-container">

    <p>Elegí qué estadística querés ver:</p>

    <div class="btn-group" role="group" aria-label="Opciones de estadísticas">
        <a href="{{ route('estadisticas.montoFacturado') }}" class="btn-outline-primary">
            <i class="bi bi-cash-stack"></i> Monto facturado
        </a>
        <a href="{{ route('estadisticas.reservasTotales') }}" class="btn-outline-secondary">
            <i class="bi bi-calendar-check"></i> Reservas totales
        </a>
        <a href="{{ route('estadisticas.nuevos-clientes') }}" class="btn-outline-success">
            <i class="bi bi-people"></i> Nuevos clientes
        </a>
    </div>

</div>

<!-- Bootstrap Icons CDN (si no lo tenés ya) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
