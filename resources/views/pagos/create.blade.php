<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .payment-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .pay-button {
            background-color: #009EE3;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        .pay-button:hover {
            background-color: #0080c7;
        }
        .product-info {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <h2>Confirmar Pago</h2>
        
        <div class="product-info">
            <h3>Resumen de tu reserva</h3>
            <p><strong>Maquinaria:</strong> {{ $maquina->nombre }}</p>
            <p><strong>Descripción:</strong> {{ $maquina->descripcion }}</p>
            <p><strong>Monto:</strong> ${{ number_format($reserva->monto_total, 2) }}</p>
            @if(isset($reserva->fecha_inicio) && isset($reserva->fecha_fin))
            <p><strong>Período:</strong> {{ $reserva->fecha_inicio }} - {{ $reserva->fecha_fin }}</p>
            @endif
        </div>

        <!-- Botón directo a MercadoPago -->
        <a href="{{ $preference->init_point }}" class="pay-button">
            Pagar con MercadoPago
        </a>
        
        <p style="margin-top: 20px; color: #666; font-size: 14px;">
            Serás redirigido a MercadoPago para completar el pago de forma segura.
        </p>
    </div>
</body>
</html>