@extends('layouts.private')

@section('content')
    <style>
        .payment-wrapper {
            font-family: Arial, sans-serif;
            max-width: 1400px;
            margin: 20px auto;
            padding: 20px;
        }
        
        .payment-main {
            width: 100%;
            background: white;
            padding: 0;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .payment-header {
            background-color: #6c757d;
            color: white;
            padding: 15px 30px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        
        .payment-header h2 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }
        
        .payment-content {
            padding: 20px 30px;
        }
        
        .payment-sidebar {
            position: relative;
            width: 50%;
            margin: 0 auto;
            background: #2c2c2c;
            color: white;
            padding: 0;
            border-radius: 0 0 10px 10px;
            height: 0;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            transition: all 0.3s ease-in-out;
            z-index: 1000;
        }
        
        .payment-sidebar.show {
            height: auto;
            padding: 30px;
        }
        
        .machine-image {
            width: 250px;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 25px;
            float: left;
        }
        
        .no-image {
            width: 250px;
            height: 160px;
            background-color: #f8f9fa;
            border: 2px dashed #ddd;
            border-radius: 8px;
            margin-right: 25px;
            float: left;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
        }
        
        .product-info {
            margin-bottom: 15px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        
        .pay-button {
            background-color: #FF6B35;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
            width: 100%;
            text-align: center;
        }
        
        .pay-button:hover {
            background-color: #e55a2b;
        }
        
        .summary-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #444;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 10px;
        }
        
        .summary-item.total {
            font-size: 18px;
            font-weight: bold;
            border-top: 1px solid #444;
            padding-top: 15px;
            margin-top: 20px;
        }
        
        .machine-details {
            margin-bottom: 15px;
            overflow: hidden;
        }
        
        .machine-content {
            margin-left: 0;
            overflow: hidden;
        }
        
        .machine-details h3 {
            color: #333;
            margin-bottom: 8px;
            font-size: 22px;
        }
        
        .price-section {
            text-align: right;
            margin-top: 15px;
            clear: both;
        }
        
        .price-tag {
            color: #FF6B35;
            font-size: 18px;
            font-weight: bold;
        }
        
        .machine-info-row {
            display: flex;
            gap: 25px;
            margin: 8px 0;
        }
        
        .machine-info-row p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }
        
        .machine-details p {
            margin: 4px 0;
            color: #666;
        }
        
        .machine-specs {
            display: flex;
            gap: 10px;
            margin: 8px 0;
        }
        
        .spec-badge {
            background-color: #007bff;
            color: white;
            padding: 4px 8px;
            border-radius: 15px;
            font-size: 12px;
        }
        
        .spec-badge.available {
            background-color: #28a745;
        }
        
        @media (max-width: 768px) {
            .payment-wrapper {
                flex-direction: column;
                padding: 10px;
            }
        }
    </style>

    <div class="payment-wrapper">
        <div class="payment-main">
            <div class="payment-header">
                <h2>Confirmar Pago</h2>
            </div>
            <div class="payment-content">
            <!-- Detalles de la máquina -->
            <div class="machine-details">
                <!-- Imagen de la máquina -->
                @if($maquina->imagen)
                    <img src="{{ asset('images/' . $maquina->imagen) }}" alt="{{ $maquina->nombre }}" class="machine-image">
                @else
                    <div class="no-image">
                        <span>Sin imagen disponible</span>
                    </div>
                @endif
                
                <div class="machine-content">
                    <h3>{{ $maquina->nombre }}</h3>
                    
                    <div class="machine-info-row">
                        <p><strong>Estilo:</strong> {{ $maquina->tipo->nombre }}</p>
                        <p><strong>Año:</strong> {{ $maquina->anio_produccion }}</p>
                    </div>
                    
                    <p><strong>Descripción:</strong> {{ $maquina->descripcion }}</p>
                    
                    <div class="machine-specs">
                        <span class="spec-badge">{{ $maquina->tipo->nombre }}</span>
                        <span class="spec-badge">{{ $maquina->anio_produccion }}</span>
                    </div>
                    
                    @if(isset($reserva->fecha_inicio) && isset($reserva->fecha_fin))
                    <p><strong>Período de alquiler:</strong> {{ $reserva->fecha_inicio }} - {{ $reserva->fecha_fin }}</p>
                    @endif
                </div>
                
                <div class="price-section">
                    <span class="price-tag">${{ number_format($reserva->monto_total, 2) }}</span>
                </div>
            </div>

            <!-- Botón de pago -->
            <a href="{{ $preference->init_point }}" class="pay-button" onmouseover="showSidebar()" onmouseout="hideSidebar()">
                Pagar con MercadoPago
            </a>
            
            <!-- Panel lateral con resumen -->
            <div class="payment-sidebar" id="payment-sidebar" onmouseover="showSidebar()" onmouseout="hideSidebar()">
                <div class="summary-title">RESUMEN</div>
                
                <div class="summary-item">
                    <span>{{ $maquina->nombre }}</span>
                    <span>${{ number_format($reserva->monto_total, 2) }}</span>
                </div>
                
                <div class="summary-item">
                    <span>Precio por día</span>
                    <span>${{ number_format($maquina->precio_por_dia, 2) }}</span>
                </div>
                
                @if(isset($reserva->fecha_inicio) && isset($reserva->fecha_fin))
                <?php
                    $fecha_inicio = new DateTime($reserva->fecha_inicio);
                    $fecha_fin = new DateTime($reserva->fecha_fin);
                    $dias = $fecha_inicio->diff($fecha_fin)->days + 1;
                ?>
                <div class="summary-item">
                    <span>Días de alquiler</span>
                    <span>{{ $dias }} días</span>
                </div>
                @endif
                
                <div class="summary-item total">
                    <span>TOTAL</span>
                    <span>${{ number_format($reserva->monto_total, 2) }}</span>
                </div>
            </div>
            </div>
        </div>
        
    </div>

    <script>
        function showSidebar() {
            document.getElementById('payment-sidebar').classList.add('show');
        }
        
        function hideSidebar() {
            document.getElementById('payment-sidebar').classList.remove('show');
        }
    </script>
@endsection