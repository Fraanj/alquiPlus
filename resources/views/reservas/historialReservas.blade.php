@extends('layouts.public')

@section('content')
<style>
        @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }

    @keyframes slideIn {
        from { 
            opacity: 0; 
            transform: translateY(-20px) scale(0.95); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0) scale(1); 
        }
    }

    .historial-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .historial-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .historial-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }

    .historial-subtitle {
        color: #666;
        font-size: 1.1rem;
    }

    .reservas-grid {
        display: grid;
        gap: 20px;
        margin-top: 20px;
    }

    .reserva-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        border-left: 4px solid #f97316;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .reserva-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .reserva-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .reserva-id {
        font-weight: 700;
        color: #333;
        font-size: 1.1rem;
    }

    .estado-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .estado-pendiente {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .estado-confirmada {
        background: #d4edda;
        color: #004085;
        border: 1px solid #c3e6cb;
    }

    .estado-cancelada {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .no-disponible {
        background: #f8d7da;
        color:rgb(148, 18, 31);
        border: 1px solid #f5c6cb;
    }

    .disponible {
        background: #d1ecf1;
        color:rgb(11, 121, 11);
        border: 1px solid #bee5eb;
    }

    .estado-completada {
        background: #cce7ff;
        color: #155724;
        border: 1px solid #b8daff;
    }

    .reserva-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 15px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-icon {
        font-size: 1.2rem;
        width: 20px;
        text-align: center;
    }

    .info-label {
        font-weight: 600;
        color: #555;
    }

    .info-value {
        color: #333;
    }

    .maquina-info {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-top: 15px;
    }

    .maquina-nombre {
        font-weight: 700;
        color: #333;
        margin-bottom: 5px;
    }

    .maquina-detalles {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .precio-total {
        font-size: 1.3rem;
        font-weight: 700;
        color: #f97316;
    }

    .fechas-container {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
    }

    .fecha-item {
        background: #e9ecef;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    .fecha-arrow {
        color: #6c757d;
        font-weight: bold;
    }

    .no-reservas {
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }

    .no-reservas-icon {
        font-size: 4rem;
        margin-bottom: 20px;
    }

    .filtros {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .filtro-btn {
        padding: 8px 16px;
        border: 2px solid #f97316;
        background: transparent;
        color: #f97316;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filtro-btn:hover,
    .filtro-btn.active {
        background: #f97316;
        color: white;
    }

    @media (max-width: 768px) {
        .reserva-info {
            grid-template-columns: 1fr;
        }
        
        .maquina-detalles {
            flex-direction: column;
            align-items: start;
        }
        
        .filtros {
            justify-content: center;
        }
    }
</style>

<div class="historial-container">
    <div class="historial-header">
        <h1 class="historial-title">📋 Historial de Reservas</h1>
    </div>

    @if(isset($filtros) && $filtros)
        <div class="filtros">
            <button class="filtro-btn active" onclick="filtrarReservas('todas')">Todas</button>
            <button class="filtro-btn" onclick="filtrarReservas('pendiente')">Pendientes</button>
            <button class="filtro-btn" onclick="filtrarReservas('confirmada')">Confirmadas</button>
            <button class="filtro-btn" onclick="filtrarReservas('cancelada')">Canceladas</button>
            <button class="filtro-btn" onclick="filtrarReservas('completada')">Completadas</button>
        </div>
    @endif

    <div class="reservas-grid">
        @forelse($reservas as $reserva)
            <div class="reserva-card" data-estado="{{ $reserva->estado }}">
                <div class="reserva-header">
                    <span class="reserva-id">Reserva #{{ $reserva->id }}</span>
                    {!! $reserva->getEstado() !!}
                </div>

                <div class="reserva-info">
                    <div class="info-item">
                        <span class="info-icon">📅</span>
                        <span class="info-label">Fecha de reserva:</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y') }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-icon">👤</span>
                        <span class="info-label">Cliente:</span>
                        <span class="info-value">{{ $reserva->usuario->name }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-icon">🏢</span>
                        <span class="info-label">Sucursal:</span>
                        <span class="info-value">{{ $reserva->maquinaria->sucursal ?? 'No especificada' }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-icon">💰</span>
                        <span class="info-label">Monto total:</span>
                        <span class="info-value precio-total">${{ number_format($reserva->monto_total, 2) }}</span>
                    </div>
                </div>

                <div class="fechas-container">
                    <div class="fecha-item">
                        <strong>Inicio:</strong> {{ \Carbon\Carbon::parse($reserva->fecha_inicio)->format('d/m/Y') }}
                    </div>
                    <span class="fecha-arrow">→</span>
                    <div class="fecha-item">
                        <strong>Fin:</strong> {{ \Carbon\Carbon::parse($reserva->fecha_fin)->format('d/m/Y') }}
                    </div>
                </div>

                <div class="maquina-info">
                    <div class="maquina-nombre">🚜 {{ $reserva->maquinaria->nombre }}
                        @if($reserva->maquinaria->entregada)
                            <span class="estado-badge no-disponible">Maquina no disponible</span>
                        @else
                            <span class="estado-badge disponible">Maquina en posesion</span>
                        @endif
                    </div> 
                    <div class="maquina-detalles">
                        <span><strong>Año de Produccion:</strong> {{ $reserva->maquinaria->anio_produccion ?? 'N/A' }}</span>
                        <span><strong>Código:</strong> {{ $reserva->maquinaria->codigo ?? 'N/A' }}</span>
                        <span><strong>Precio/día:</strong> ${{ number_format($reserva->maquinaria->precio_por_dia, 2) }}</span>
                    </div>
                    <div class="mt-3">
                        @if($reserva->maquinaria->entregada and $reserva->estado == 'confirmada')
                            <button onclick="cambiarEstadoEntrega({{ $reserva->id }}, 'completada')" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition-colors text-sm">
                                <span class="mr-2">📥</span>
                                Marcar como Recibida
                            </button>
                        @elseif (($reserva->maquinaria->entregada == false) and $reserva->estado == 'pendiente')
                            <button onclick="cambiarEstadoEntrega({{ $reserva->id }}, 'confirmada')" 
                                    class="inline-flex items-center px-4 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition-colors text-sm">
                                <span class="mr-2">📤</span>
                                Marcar como Entregada
                            </button>
                        @else 
                            <span class="inline-flex items-center px-4 py-2 bg-red-500 text-white font-semibold rounded-lg transition-colors text-sm">
                                Estado de entrega no disponible</span>
                        @endif

                        @if($reserva->estado == 'pendiente')
                            <button onclick="cancelarReserva({{ $reserva->id }})" 
                                    class="inline-flex items-center px-4 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition-colors text-sm ml-2">
                                <span class="mr-2">❌</span>
                                Cancelar Reserva
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="no-reservas">
                <div class="no-reservas-icon">📋</div>
                <h3>No hay reservas disponibles</h3>
                <p>Aún no se han realizado reservas en el sistema.</p>
            </div>
        @endforelse
    </div>
</div>

<script>
function filtrarReservas(estado) {
    const cards = document.querySelectorAll('.reserva-card');
    const buttons = document.querySelectorAll('.filtro-btn');
    
    // Actualizar botones activos
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Filtrar cards
    cards.forEach(card => {
        if (estado === 'todas' || card.dataset.estado === estado) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

function cambiarEstadoEntrega(id, accion) {
    window.location.href = `/reserva/${id}/${accion}`;
}

function cancelarReserva(id) {
    const modal = document.createElement('div');
    modal.id = 'modal-cancelar';
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
    modal.style.animation = 'fadeIn 0.3s ease-out';
    
    modal.innerHTML = `
        <div class="bg-white rounded-lg shadow-2xl max-w-md w-full transform transition-all duration-300" 
             style="animation: slideIn 0.3s ease-out;">
            <div class="p-6">
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                
                <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">
                    ¿Cancelar Reserva?
                </h3>
                
                <p class="text-sm text-gray-600 text-center mb-6">
                    Esta acción no se puede deshacer.
                </p>
                
                <div class="flex space-x-3">
                    <button onclick="cerrarModal()" 
                            class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors font-medium">
                        <span class="inline-flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Mantener
                        </span>
                    </button>
                    
                    <button onclick="confirmarCancelacion(${id})" 
                            class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors font-medium">
                        <span class="inline-flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Cancelar
                        </span>
                    </button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}
function confirmarCancelacion(id) {
    window.location.href = `/reserva/${id}/cancelar`;
}

function cerrarModal() {
    const modal = document.getElementById('modal-cancelar');
    if (modal) {
        modal.style.animation = 'fadeOut 0.3s ease-in';
        setTimeout(() => {
            modal.remove();
        }, 300);
    }
}
</script>

@endsection