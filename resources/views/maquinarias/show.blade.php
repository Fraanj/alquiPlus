@extends('layouts.public')

<script>
    // Pass reserved date ranges as an array of objects
    const reservedRanges = @json($reservas->map(fn($r) => [
        'from' => $r->fecha_inicio,
        'to' => $r->fecha_fin
    ]));
</script>
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@section('content')
    <style>
        .maquinaria-container {
            max-width: 900px;
            margin: 40px auto;
            box-shadow: 0 3px 12px rgb(0 0 0 / 0.15);
            border-radius: 12px;
            display: flex;
            gap: 24px;
            padding: 40px 24px 56px 24px; /* más padding abajo */
            background: #fff;
            min-height: 420px; /* más alto para que no quede tan cuadrado */
        }

        .maquinaria-imagen {              /*para editar la imagen*/
            flex: 1 1 40%;
            max-height: 300px;
            max-width: 55%;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
        }


        .maquinaria-info {
            flex: 1 1 60%;
            display: flex;
            flex-direction: column;
        }

        .maquinaria-nombre {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #333;
        }

        .precio {
            font-size: 1.5rem;
            color: #198754;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .badges {
            margin-bottom: 12px;
        }

        .badge {
            display: inline-block;
            background: #0dcaf0;
            color: #000;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-right: 10px;
            user-select: none;
        }

        .badge.disponible {
            background: #198754;
            color: #fff;
        }

        .badge.no-disponible {
            background: #dc3545;
            color: #fff;
        }

        .badge.sucursal {
            background: #6f42c1;
            color: #fff;
        }

        .descripcion {
            font-size: 1.1rem;
            margin-bottom: 12px;
            line-height: 1.4;
            color: #444;
        }

        .disclaimer {
            background: #fff3cd;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.9rem;
            color: #664d03;
            margin-bottom: 20px;
            border: 1px solid #ffeeba;
        }

        .btn-alquilar {
            background-color: #f97316;
            color: white;
            font-weight: bold;
            padding: 10px 23px;
            border-radius: 3px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: fit-content;
            align-self: flex-start;
            font-size: 1.1rem;
        }

        .btn-alquilar:hover:not(:disabled) {
            background-color: #d6640d;
        }

        .btn-alquilar:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .extras {
            margin-top: 20px;
            font-size: 0.95rem;
            color: #444;
        }

        .politica {
            margin-top: 8px;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .badge.tipo {
            background-color: #e0e0e0;
            color: #000;
        }

        @media (max-width: 600px) {
            .maquinaria-container {
                flex-direction: column;
                max-width: 95%;
                padding: 16px;
            }

            .maquinaria-imagen {
                max-height: 250px;
                width: 100%;
                margin-bottom: 20px;
                max-width: 350px;
            }

            .maquinaria-info {
                flex: none;
            }

            .btn-alquilar {
                width: 100%;
                text-align: center;
            }

            .badges {
                flex-wrap: wrap;
            }
        }
        /* reservas CSS (mejor mover todo el css a otro archivo imo) */
        .flatpickr-input, input[type="date"] {
            background: #f8fafc;
            border: 1.5px solid #e0e0e0;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 1rem;
            color: #333;
            margin-bottom: 12px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        .flatpickr-input:focus, input[type="date"]:focus {
            border-color: #f97316;
            outline: none;
        }

        .flatpickr-calendar {
            font-family: inherit;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
            border: 1px solid #f97316;
        }

        .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange {
            background: #f97316;
            color: #fff;
            border-radius: 50%;
        }

        .flatpickr-day.disabled, .flatpickr-day.notAllowed {
            background: #f3f3f3;
            color: #bbb;
            cursor: not-allowed;
        }

    </style>

    <div class="maquinaria-container">
        @if ($maquinaria->imagen)
            <img src="{{ asset('images/' . $maquinaria->imagen) }}" alt="{{ $maquinaria->nombre }}" class="maquinaria-imagen">


        @endif

        <div class="maquinaria-info">
            <h1 class="maquinaria-nombre">{{ $maquinaria->nombre }}</h1>
            <div class="precio">${{ number_format($maquinaria->precio_por_dia, 2) }} / día</div>

            <div class="badges" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                <span class="badge tipo">Tipo: {{ $maquinaria->tipo->nombre ?? 'Sin especificar' }}</span>
                <span class="badge">Año: {{ $maquinaria->anio_produccion }}</span>
                <span class="badge sucursal">📍 {{ $maquinaria->sucursal }}</span>

                @if($maquinaria->disponibilidad_id == 1)
                    <span class="badge disponible">Disponible</span>
                @else
                    <span class="badge no-disponible">En Mantenimiento</span>
                @endif
            </div>



            <p class="descripcion">{{ $maquinaria->descripcion }}</p>

            @if ($maquinaria->disclaimer)
                <div class="disclaimer">{{ $maquinaria->disclaimer }}</div>
            @endif

            <!-- Mensajes de error desde laravel, no pude configuralos en HTML por la libreria de flatpickr -->
            @if ($errors->any())
                <div class="alert alert-danger" style="color: #b91c1c; margin-bottom: 10px;">
                    <ul style="margin: 0; padding-left: 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('reservas.create') }}" class="p-4 border rounded shadow-sm bg-light">
                @csrf
                <input type="hidden" name="maquina_id" value="{{ $maquinaria->id }}">
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <input type="text" name="fecha_inicio" placeholder="Fecha inicio" autocomplete="off">
                    <input type="text" name="fecha_fin" placeholder="Fecha fin" autocomplete="off">
                </div>
                <button type="submit" class="btn-alquilar"
                        @if($maquinaria->disponibilidad_id != 1) disabled @endif  // si la maquina no esta disponible no se puede reservar
                        
                        onmouseover="if(!this.disabled) this.style.backgroundColor='#d6640d'"
                        onmouseout="if(!this.disabled) this.style.backgroundColor='#f97316'">
                    Reservar
                </button>
            </form>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // conversion a flatpickr de las fechas reservadas (bloqueadas)
                    const disabledRanges = reservedRanges.map(range => ({
                        from: range.from,
                        to: range.to
                    }));

                    // funcion axuiliar para obtener la fecha de inicio de la siguiente reserva
                    function getNextReservedStart(dateStr) {
                        const date = new Date(dateStr);
                        let next = null;
                        reservedRanges.forEach(range => {
                            const start = new Date(range.from);
                            if (start > date && (!next || start < new Date(next))) {
                                next = range.from;
                            }
                        });
                        return next;
                    }

                    // iniciar fecha inicio (tiene la logica para seleccionar fecha fin)
                    flatpickr("input[name='fecha_inicio']", {
                        dateFormat: "Y-m-d",
                        minDate: "today",
                        disable: disabledRanges,
                        onChange: function(selectedDates, dateStr) {
                            const fechaFinInput = document.querySelector("input[name='fecha_fin']");
                            // Set minDate to selected start, maxDate to the day before the next reserved range (if any)
                            const nextReserved = getNextReservedStart(dateStr);
                            let maxDate = null;
                            if (nextReserved) {
                                const d = new Date(nextReserved);
                                d.setDate(d.getDate() - 1);
                                maxDate = d.toISOString().slice(0,10);
                            }
                            //estas lineas bindean el fecha fin dinamicamente
                            fechaFinInput._flatpickr.set('minDate', dateStr);
                            fechaFinInput._flatpickr.set('maxDate', maxDate);
                        }
                    });

                    // fecha fin se actualiza dinamicamente desde fecha inicio
                    flatpickr("input[name='fecha_fin']", {
                        dateFormat: "Y-m-d",
                        minDate: "today",
                        disable: disabledRanges
                    });
                });
            </script>


            <div class="extras">
                <div class="politica">
                    Política de cancelación:
                    @if($maquinaria->politica_reembolso == '100')
                        Reembolso completo
                    @elseif($maquinaria->politica_reembolso == '20')
                        Reembolso del 20%
                    @else
                        Sin reembolso
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection
