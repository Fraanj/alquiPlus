@extends('layouts.public')

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@section('content')
<style>
    .maintenance-container {
        max-width: 600px;
        margin: 40px auto;
        box-shadow: 0 3px 12px rgb(0 0 0 / 0.15);
        border-radius: 12px;
        padding: 40px;
        background: #fff;
    }

    .maintenance-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .maintenance-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }

    .maquina-info {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 25px;
        border-left: 4px solid #ffc107;
    }

    .maquina-info h3 {
        margin-top: 0;
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }

    .flatpickr-input {
        background: #f8fafc;
        border: 1.5px solid #e0e0e0;
        border-radius: 6px;
        padding: 12px 14px;
        font-size: 1rem;
        color: #333;
        width: 100%;
        box-sizing: border-box;
        transition: border-color 0.2s;
    }

    .flatpickr-input:focus {
        border-color: #ffc107;
        outline: none;
    }

    .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 30px;
    }

    .btn-maintenance {
        background-color: #ffc107;
        color: #000;
        font-weight: bold;
        padding: 12px 24px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
        flex: 1;
        font-size: 1rem;
    }

    .btn-maintenance:hover {
        background-color: #e0a800;
    }

    .btn-cancel {
        background-color: #6c757d;
        color: white;
        font-weight: bold;
        padding: 12px 24px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
        flex: 1;
        font-size: 1rem;
        text-decoration: none;
        text-align: center;
    }

    .btn-cancel:hover {
        background-color: #5a6268;
        text-decoration: none;
        color: white;
    }

    .alert-warning {
        background-color: #fff3cd;
        border: 1px solid #ffeaa7;
        color: #856404;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .flatpickr-calendar {
        font-family: inherit;
        border-radius: 8px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        border: 1px solid #ffc107;
    }

    .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange {
        background: #ffc107;
        color: #000;
        border-radius: 50%;
    }

    .flatpickr-day.inRange {
        background: #fff3cd;
        color: #856404;
    }
</style>

<div class="maintenance-container">
    <div class="maintenance-header">
        <h1 class="maintenance-title">🔧 Programar Mantenimiento</h1>
    </div>

    <div class="maquina-info">
        <h3><strong>{{ $maquinaria->nombre }}</strong></h3>
        <p><strong>codigo:</strong> {{ $maquinaria->codigo }}</p>
        <p><strong>precio: </strong>${{ $maquinaria->precio_por_dia }}</p>
        <p><strong>año de producción:</strong> {{ $maquinaria->anio_produccion }}</p>
        <p><strong>Sucursal:</strong> {{ $maquinaria->sucursal }}</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" style="color: #b91c1c; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="alert-warning">
        <strong>⚠️ Importante:</strong> Al programar el mantenimiento, se cancelarán automáticamente todas las reservas que coincidan con estas fechas y se notificará a los clientes.
    </div>

    <form method="POST" action="{{ route('maquinarias.startMaintenance', $maquinaria->id) }}">
        @csrf
        
        <div class="form-group">
            <label class="form-label" for="fecha_inicio">Fecha de Inicio del Mantenimiento</label>
            <input type="text" name="fecha_inicio" id="fecha_inicio" 
                   placeholder="Seleccionar fecha de inicio" 
                   autocomplete="off" 
                   class="flatpickr-input" 
                   required>
        </div>

        <div class="form-group">
            <label class="form-label" for="fecha_fin">Fecha de Fin del Mantenimiento</label>
            <input type="text" name="fecha_fin" id="fecha_fin" 
                   placeholder="Seleccionar fecha de fin" 
                   autocomplete="off" 
                   class="flatpickr-input" 
                   required>
        </div>

        <div class="btn-group">
            <a href="{{ url()->previous() }}" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-maintenance">Programar Mantenimiento</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar fecha de inicio
    const fechaInicioInput = flatpickr("#fecha_inicio", {
        dateFormat: "Y-m-d",
        minDate: "today",
        onChange: function(selectedDates, dateStr) {
            // Actualizar la fecha mínima del campo de fin
            if (selectedDates.length > 0) {
                fechaFinFlatpickr.set('minDate', dateStr);
                // Si ya hay una fecha fin seleccionada y es anterior a la nueva fecha inicio, limpiarla
                const fechaFinValue = document.getElementById('fecha_fin').value;
                if (fechaFinValue && new Date(fechaFinValue) < selectedDates[0]) {
                    fechaFinFlatpickr.clear();
                }
            }
        }
    });

    // Inicializar fecha de fin
    const fechaFinFlatpickr = flatpickr("#fecha_fin", {
        dateFormat: "Y-m-d",
        minDate: "today"
    });
});
</script>

@endsection