@extends('layouts.public')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <h1 class="text-2xl font-bold text-purple-700 mb-6 flex items-center">
                    <i class="bi bi-people-fill me-2"></i> Estadísticas de Nuevos Clientes
                </h1>

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                    </div>
                @endif

                <form method="GET" action="{{ route('estadisticas.nuevos-clientes') }}" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="fecha_inicio" class="block font-semibold text-sm text-gray-700 mb-1">Fecha inicio</label>
                            <input 
                                type="text" 
                                name="fecha_inicio" 
                                id="fecha_inicio_flatpickr" 
                                class="form-input w-full rounded-lg shadow-sm border-gray-300" 
                                value="{{ old('fecha_inicio', $fechaInicio ?? '') }}" 
                                required 
                                autocomplete="off"
                            >
                            @error('fecha_inicio')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="fecha_fin" class="block font-semibold text-sm text-gray-700 mb-1">Fecha fin</label>
                            <input 
                                type="text" 
                                name="fecha_fin" 
                                id="fecha_fin_flatpickr" 
                                class="form-input w-full rounded-lg shadow-sm border-gray-300" 
                                value="{{ old('fecha_fin', $fechaFin ?? '') }}" 
                                required 
                                autocomplete="off"
                            >
                            @error('fecha_fin')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="mt-6 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded shadow">
                        <i class="bi bi-search me-1"></i> Consultar
                    </button>
                </form>

                @if(isset($total))
                    <div class="bg-purple-100 border border-purple-400 text-purple-700 px-4 py-3 rounded mb-6">
                        <strong>Total nuevos clientes:</strong> {{ $total }}
                    </div>
                @endif

                @if(isset($dataPoints) && count($dataPoints) > 0)
                    <div id="chartContainer" style="height: 370px; width: 100%; margin-top: 2rem;"></div>
                @elseif(isset($total) && $total == 0)
                    <p class="text-gray-500 italic mt-4">No se encontraron nuevos clientes en el rango de fechas seleccionado.</p>
                @endif

                <a href="{{ route('estadisticas') }}" class="inline-block mt-8 text-purple-700 hover:underline">
                    ← Volver a estadísticas
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<!-- CanvasJS -->
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<!-- Flatpickr CSS y JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const config = {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "j F, Y",
            maxDate: new Date(),
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                    longhand: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"]
                },
                months: {
                    shorthand: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                    longhand: [
                        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
                        "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                    ]
                },
                ordinal: () => "º"
            },
            allowInput: true,
            onReady: function(selectedDates, dateStr, instance) {
                if (instance.altInput) {
                    instance.altInput.style.width = '100%';
                    instance.altInput.style.boxSizing = 'border-box';
                }
            }
        };

        flatpickr("#fecha_inicio_flatpickr", config);
        flatpickr("#fecha_fin_flatpickr", config);
    });
</script>

@if(isset($dataPoints) && count($dataPoints) > 0)
<script>
    window.onload = function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title:{
                text: "Nuevos clientes por día"
            },
            axisX:{
                valueFormatString: "DD/MM/YYYY"
            },
            axisY: {
                title: "Cantidad de clientes",
                includeZero: true
            },
            data: [{
                type: "column",
                dataPoints: [
                    @foreach($dataPoints as $fecha => $cantidad)
                        { x: new Date("{{ $fecha }}"), y: {{ $cantidad }} },
                    @endforeach
                ]
            }]
        });
        chart.render();
    }
</script>
@endif
@endsection
