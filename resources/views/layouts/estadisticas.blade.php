@extends('layouts.public')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <h1 class="text-2xl font-bold text-{{ $color }}-700 mb-6 flex items-center">
                    <i class="bi bi-{{ $icon }} me-2"></i> {{ $title }}
                </h1>

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                    </div>
                @endif

                <form method="GET" action="{{ $route }}" class="mb-6">
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
                                placeholder="Selecciona fecha de inicio"
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
                                placeholder="Selecciona fecha de fin"
                            >
                            @error('fecha_fin')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" 
                        style="
                            margin-top: 1.5rem;
                            @if($color == 'purple') 
                                background-color: #7c3aed;
                            @elseif($color == 'green') 
                                background-color: #059669;
                            @elseif($color == 'blue') 
                                background-color: #2563eb;
                            @else 
                                background-color: #6b7280;
                            @endif
                            color: white; 
                            font-weight: bold; 
                            padding: 0.5rem 1.5rem; 
                            border-radius: 0.375rem; 
                            border: none; 
                            cursor: pointer; 
                            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
                            transition: background-color 0.2s;
                        "
                        onmouseover="
                            this.style.backgroundColor = 
                                @if($color == 'purple') '#6d28d9'
                                @elseif($color == 'green') '#047857'
                                @elseif($color == 'blue') '#1d4ed8'
                                @else '#4b5563'
                                @endif;
                        "
                        onmouseout="
                            this.style.backgroundColor = 
                                @if($color == 'purple') '#7c3aed'
                                @elseif($color == 'green') '#059669'
                                @elseif($color == 'blue') '#2563eb'
                                @else '#6b7280'
                                @endif;
                        ">
                    <i class="bi bi-search me-1"></i> Consultar
                </button>
                </form>

                <!-- ✅ CAMBIO: Solo mostrar total UNA VEZ -->
                @if(isset($total))
                    <div class="bg-{{ $color }}-100 border border-{{ $color }}-400 text-{{ $color }}-700 px-4 py-3 rounded mb-6">
                        <strong>{{ $totalLabel }}:</strong> {{ $total }}
                    </div>
                @endif

                @if(isset($dataPoints) && count($dataPoints) > 0)
                    <!-- ✅ Contenedor específico para PDF -->
                    <div id="pdfContainer" style="background: white; padding: 20px; border-radius: 8px;">
                        <!-- Título del gráfico -->
                        <h2 style="text-align: center; margin-bottom: 20px; color: {{ $color == 'purple' ? '#7c3aed' : ($color == 'green' ? '#059669' : ($color == 'blue' ? '#2563eb' : '#6b7280')) }}; font-size: 18px; font-weight: bold;">
                            {{ $chartTitle }}
                        </h2>
                        
                        <!-- ✅ Contenedor para ApexCharts -->
                        <div id="chartContainer" style="height: 400px; width: 100%;"></div>
                        
                        <!-- Información adicional -->
                        <div style="margin-top: 15px; text-align: center; font-size: 14px; color: #6b7280;">
                            <strong>{{ $totalLabel }}:</strong> {{ $total }}
                            @if(isset($fechaInicio) && isset($fechaFin) && $fechaInicio && $fechaFin)
                                | Período: {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
                            @endif
                        </div>
                    </div>
                    
                    <!-- ✅ Botón de descarga PDF -->
                    <div class="flex justify-end mt-4">
                        <button 
                            id="downloadPdfBtn"
                            style="
                                background-color: 
                                    @if($color == 'purple') #7c3aed
                                    @elseif($color == 'green') #059669  
                                    @elseif($color == 'blue') #2563eb
                                    @else #6b7280
                                    @endif;
                                color: white; 
                                font-weight: bold; 
                                padding: 0.5rem 1rem; 
                                border-radius: 0.375rem; 
                                border: none; 
                                cursor: pointer; 
                                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                                transition: all 0.2s;
                                font-size: 14px;
                            "
                            onmouseover="
                                this.style.backgroundColor = 
                                    @if($color == 'purple') '#6d28d9'
                                    @elseif($color == 'green') '#047857'
                                    @elseif($color == 'blue') '#1d4ed8'
                                    @else '#4b5563'
                                    @endif;
                                this.style.transform = 'translateY(-1px)';
                            "
                            onmouseout="
                                this.style.backgroundColor = 
                                    @if($color == 'purple') '#7c3aed'
                                    @elseif($color == 'green') '#059669'
                                    @elseif($color == 'blue') '#2563eb'
                                    @else '#6b7280'
                                    @endif;
                                this.style.transform = 'translateY(0)';
                            ">
                            <i class="bi bi-download me-1"></i> Descargar PDF
                        </button>
                    </div>
                @elseif(isset($total) && $total == 0)
                    <p class="text-gray-500 italic mt-4">{{ $emptyMessage }}</p>
                @endif

                <a href="{{ route('estadisticas') }}" class="inline-block mt-8 text-{{ $color }}-700 hover:underline">
                    ← Volver a estadísticas
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<!-- ✅ ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<!-- ✅ Librerías para PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<!-- Flatpickr CSS y JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ✅ Calcular hoy
        const hoy = new Date();
        
        // ✅ Formatear fechas para comparación (Y-m-d)
        const formatearFecha = (fecha) => {
            const año = fecha.getFullYear();
            const mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
            const dia = fecha.getDate().toString().padStart(2, '0');
            return `${año}-${mes}-${dia}`;
        };
        
        const fechaHoyFormateada = formatearFecha(hoy);

        const config = {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
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
                
                // ✅ Limpiar fecha fin si es HOY
                if (instance.element.id === 'fecha_fin_flatpickr') {
                    const valorActual = instance.element.value;
                    
                    if (valorActual === fechaHoyFormateada) {
                        console.log('Fecha fin es HOY, limpiando campo');
                        instance.clear();
                    }
                }
            },
            onChange: function(selectedDates, dateStr, instance) {
                const fechaInicio = document.getElementById('fecha_inicio_flatpickr');
                const fechaFin = document.getElementById('fecha_fin_flatpickr');
                
                if (instance.element.id === 'fecha_inicio_flatpickr' && selectedDates.length > 0) {
                    const fechaMinima = new Date(selectedDates[0]);
                    fechaMinima.setDate(fechaMinima.getDate() + 1);
                    
                    if (fechaFin._flatpickr) {
                        fechaFin._flatpickr.set('minDate', fechaMinima);
                        
                        const fechaFinActual = fechaFin._flatpickr.selectedDates[0];
                        if (fechaFinActual && fechaFinActual < fechaMinima) {
                            fechaFin._flatpickr.clear();
                        }
                    }
                }
            }
        };

        // Inicializar ambos calendarios
        flatpickr("#fecha_inicio_flatpickr", config);
        flatpickr("#fecha_fin_flatpickr", config);
    });
</script>

@if(isset($dataPoints) && count($dataPoints) > 0)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ✅ Preparar datos correctamente ordenados por fecha
        const rawData = [
            @foreach($dataPoints as $fecha => $cantidad)
                {
                    x: '{{ $fecha }}', // Fecha en formato Y-m-d
                    y: {{ $cantidad }}
                },
            @endforeach
        ];

        // ✅ Ordenar por fecha (crucial para ApexCharts)
        rawData.sort((a, b) => new Date(a.x) - new Date(b.x));

        // ✅ Colores según el tipo
        @if($color == 'purple')
            const colorPrimary = '#7c3aed';
            const colorSecondary = '#a78bfa';
        @elseif($color == 'green')
            const colorPrimary = '#059669';
            const colorSecondary = '#34d399';
        @elseif($color == 'blue')
            const colorPrimary = '#2563eb';
            const colorSecondary = '#60a5fa';
        @else
            const colorPrimary = '#6b7280';
            const colorSecondary = '#9ca3af';
        @endif

        // ✅ Configuración de ApexCharts
        const options = {
            series: [{
                name: '{{ $yAxisLabel }}',
                data: rawData
            }],
            chart: {
                type: 'bar',
                height: 380,
                toolbar: {
                    show: false
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            colors: [colorPrimary],
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '60%',
                    distributed: false
                }
            },
            dataLabels: {
                enabled: false
            },
            title: {
                text: '{{ $chartTitle }}',
                align: 'center',
                style: {
                    fontSize: '16px',
                    fontWeight: 'bold',
                    color: colorPrimary
                }
            },
            xaxis: {
                type: 'datetime',
                labels: {
                    format: 'dd/MM',
                    rotate: -45,
                    style: {
                        fontSize: '10px'
                    }
                },
                title: {
                    text: 'Fecha',
                    style: {
                        fontWeight: 'bold',
                        color: colorPrimary
                    }
                }
            },
            yaxis: {
                title: {
                    text: '{{ $yAxisLabel }}',
                    style: {
                        fontWeight: 'bold',
                        color: colorPrimary
                    }
                },
                labels: {
                    formatter: function (val) {
                        return Math.round(val);
                    }
                }
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yyyy'
                },
                y: {
                    formatter: function (val) {
                        return val + ' {{ $yAxisLabelDesc ?? strtolower($yAxisLabel) }}';
                    }
                }
            },
            grid: {
                borderColor: '#e7e7e7',
                strokeDashArray: 3
            },
            fill: {
                opacity: 0.8,
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: 'vertical',
                    shadeIntensity: 0.25,
                    gradientToColors: [colorSecondary],
                    inverseColors: false,
                    opacityFrom: 0.85,
                    opacityTo: 0.55,
                    stops: [0, 100]
                }
            }
        };

        // ✅ Renderizar el gráfico
        const chart = new ApexCharts(document.querySelector("#chartContainer"), options);
        chart.render();

        // ✅ FUNCIONALIDAD DEL BOTÓN PDF (ARREGLADO)
        document.getElementById('downloadPdfBtn').addEventListener('click', function() {
            const boton = this;
            boton.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Generando PDF...';
            boton.disabled = true;
            
            // Capturar el contenedor específico del PDF
            const elemento = document.getElementById('pdfContainer');
            
            html2canvas(elemento, {
                scale: 3, // Mejor calidad
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#ffffff',
                height: elemento.scrollHeight,
                width: elemento.scrollWidth,
                logging: false // Evitar logs en consola
            }).then(canvas => {
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF('l', 'mm', 'a4'); // Formato horizontal
                
                const imgData = canvas.toDataURL('image/png', 1.0); // Máxima calidad
                const pdfWidth = 280; // Ancho A4 horizontal menos márgenes
                const pdfHeight = 190; // Alto disponible
                const imgWidth = canvas.width;
                const imgHeight = canvas.height;
                
                // Calcular dimensiones manteniendo proporción
                const ratio = Math.min(pdfWidth / imgWidth, pdfHeight / imgHeight);
                const finalWidth = imgWidth * ratio;
                const finalHeight = imgHeight * ratio;
                
                // Centrar en la página
                const x = (297 - finalWidth) / 2; // A4 horizontal = 297mm
                const y = (210 - finalHeight) / 2; // A4 horizontal = 210mm
                
                // Agregar imagen al PDF
                pdf.addImage(imgData, 'PNG', x, y, finalWidth, finalHeight);
                
                // Nombre del archivo con fecha y hora
                const ahora = new Date();
                const fecha = ahora.toISOString().split('T')[0];
                const hora = ahora.toTimeString().split(' ')[0].replace(/:/g, '-');
                const tipoStats = '{{ strtolower(str_replace([" ", "é", "í", "ó"], ["_", "e", "i", "o"], $chartTitle ?? "grafico")) }}';
                const nombreArchivo = `${tipoStats}_${fecha}_${hora}.pdf`;
                
                // Descargar
                pdf.save(nombreArchivo);
                
                // Restaurar botón
                boton.innerHTML = '<i class="bi bi-download me-1"></i> Descargar PDF';
                boton.disabled = false;
            }).catch(error => {
                console.error('Error generando PDF:', error);
                alert('Error al generar el PDF. Inténtalo de nuevo.');
                boton.innerHTML = '<i class="bi bi-download me-1"></i> Descargar PDF';
                boton.disabled = false;
            });
        });
    });
</script>
@endif
@endsection