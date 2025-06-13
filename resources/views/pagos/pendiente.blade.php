@extends('layouts.private')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <!-- Card principal con forma de recibo -->
            <div class="card shadow-lg border-0 recibo-card">
                <!-- Header amarillo -->
                <div class="card-header bg-warning text-dark text-center py-3">
                    <h4 class="mb-0 fw-bold">Pago Pendiente</h4>
                </div>
                
                <div class="card-body p-4">
                    <!-- Título -->
                    <div class="text-center mb-4">
                        <h5 class="text-warning mb-2">Pago en Proceso</h5>
                        <p class="text-muted">
                            Tu pago está siendo procesado. Te notificaremos cuando se complete la transacción.
                        </p>
                    </div>

                    <!-- Información del pago -->
                    @if(isset($paymentData))
                    <div class="mb-4">
                        <div class="row mb-2">
                            <div class="col-5"><strong>ID de Pago:</strong></div>
                            <div class="col-7">#{{ $paymentData->id }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><strong>Estado:</strong></div>
                            <div class="col-7">
                                <span class="text-warning fw-bold">Pendiente</span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><strong>Método de Pago:</strong></div>
                            <div class="col-7">{{ $paymentData->payment_method_id ?? 'No especificado' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5"><strong>Monto:</strong></div>
                            <div class="col-7 text-warning fw-bold">
                                ${{ number_format($paymentData->transaction_amount, 2) }}
                            </div>
                        </div>
                        @if(isset($paymentData->status_detail))
                        <div class="row mb-3">
                            <div class="col-5"><strong>Detalle:</strong></div>
                            <div class="col-7 text-muted">{{ $paymentData->status_detail }}</div>
                        </div>
                        @endif
                    </div>
                    
                    <hr class="my-4">
                    @endif

                    <!-- Información de la reserva pendiente -->
                    @if(isset($datosReserva))
                    <div class="mb-4">
                        <div class="row mb-2">
                            <div class="col-5"><strong>Referencia:</strong></div>
                            <div class="col-7 text-muted">#{{ $datosReserva['external_reference'] ?? 'No disponible' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><strong>Máquina:</strong></div>
                            <div class="col-7">Máquina #{{ $datosReserva['maquina_id'] ?? 'No especificada' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><strong>Fecha de Inicio:</strong></div>
                            <div class="col-7">
                                {{ isset($datosReserva['fecha_inicio']) ? \Carbon\Carbon::parse($datosReserva['fecha_inicio'])->format('d/m/Y H:i') : 'No disponible' }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><strong>Fecha de Fin:</strong></div>
                            <div class="col-7">
                                {{ isset($datosReserva['fecha_fin']) ? \Carbon\Carbon::parse($datosReserva['fecha_fin'])->format('d/m/Y H:i') : 'No disponible' }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5"><strong>Monto Total:</strong></div>
                            <div class="col-7 text-warning fw-bold">
                                ${{ isset($datosReserva['monto_total']) ? number_format($datosReserva['monto_total'], 2) : '0.00' }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Información adicional -->
                    <div class="alert alert-warning" role="alert">
                        <small>
                            <strong>Nota:</strong> Tu reserva se confirmará automáticamente una vez que se apruebe el pago. 
                            Mantén esta ventana abierta o revisa tu email para actualizaciones.
                        </small>
                    </div>

                    <!-- Botones de acción -->
                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg px-4">
                            Volver al Inicio
                        </a>
                    </div>
                </div>
                
                <!-- Parte inferior del recibo con efecto cortado -->
                <div class="recibo-bottom"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .recibo-card {
        border-radius: 10px 10px 0 0;
        overflow: visible;
        position: relative;
        background: white;
    }
    
    .recibo-bottom {
        height: 20px;
        background: white;
        position: relative;
        margin-top: -1px;
    }
    
    .recibo-bottom::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 20px;
        background: linear-gradient(90deg, 
            transparent 0px, 
            transparent 10px, 
            white 10px, 
            white 20px, 
            transparent 20px, 
            transparent 30px, 
            white 30px, 
            white 40px,
            transparent 40px, 
            transparent 50px, 
            white 50px, 
            white 60px,
            transparent 60px, 
            transparent 70px, 
            white 70px, 
            white 80px,
            transparent 80px, 
            transparent 90px, 
            white 90px, 
            white 100px,
            transparent 100px, 
            transparent 110px, 
            white 110px, 
            white 120px,
            transparent 120px, 
            transparent 130px, 
            white 130px, 
            white 140px,
            transparent 140px, 
            transparent 150px, 
            white 150px, 
            white 160px,
            transparent 160px, 
            transparent 170px, 
            white 170px, 
            white 180px,
            transparent 180px, 
            transparent 190px, 
            white 190px, 
            white 200px,
            transparent 200px
        );
        background-size: 20px 20px;
        background-repeat: repeat-x;
    }
    
    .card-header {
        border-bottom: none;
        background: #ffc107 !important;
    }
    
    .btn {
        transition: all 0.3s ease;
        border-radius: 25px;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    
    .row {
        align-items: center;
    }
    
    .row .col-5 {
        color: #6c757d;
    }
    
    .text-warning {
        color: #856404 !important;
    }
</style>
@endpush