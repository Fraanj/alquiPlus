<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargo por Retraso en Devolución - Manny Maquinarias</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .header {
            background-color: #f39c12;
            color: white;
            padding: 30px 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        .content {
            background-color: #fff;
            padding: 30px;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .warning-box {
            background-color: #fff3cd;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #ffc107;
        }
        .reservation-details {
            background-color: #f8f9fa;
            border: 2px solid #dee2e6;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .reservation-details h3 {
            margin-top: 0;
            color: #2c3e50;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .charge-box {
            background-color: #ffe6e6;
            border: 1px solid #ffb3b3;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #dc3545;
        }
        .charge-box h3 {
            margin-top: 0;
            color: #721c24;
        }
        .delay-info {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .delay-info strong {
            color: #856404;
        }
        .calculation-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .calculation-table th,
        .calculation-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .calculation-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .calculation-table .total-row {
            background-color: #fff3cd;
            font-weight: bold;
        }
        .contact-box {
            background-color: #e8f4f8;
            border: 1px solid #bee5eb;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #17a2b8;
        }
        .contact-box h3 {
            margin-top: 0;
            color: #0c5460;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
            padding: 20px;
        }
        .footer a {
            color: #2c3e50;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .highlight {
            background-color: #fff2cc;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚜 Manny Maquinarias</h1>
        <p>Notificación de Cargo por Retraso</p>
    </div>
    
    <div class="content">
        <div class="warning-box">
            <h2>Estimado/a {{ $reserva->usuario->name }},</h2>
            <p>Le informamos que se ha detectado un retraso en la devolución de la maquinaria correspondiente a su reserva. De acuerdo a nuestros términos y condiciones, se ha aplicado un cargo adicional.</p>
        </div>

        <div class="reservation-details">
            <h3>📋 Detalles de la Reserva</h3>
            <div class="detail-row">
                <strong>Número de Reserva:</strong>
                <span>#{{ $reserva->id }}</span>
            </div>
            <div class="detail-row">
                <strong>Maquinaria:</strong>
                <span>{{ $reserva->maquinaria->nombre }} - {{ $reserva->maquinaria->modelo }}</span>
            </div>
            <div class="detail-row">
                <strong>Fecha de Inicio:</strong>
                <span>{{ \Carbon\Carbon::parse($reserva->fecha_inicio)->format('d/m/Y') }}</span>
            </div>
            <div class="detail-row">
                <strong>Fecha de Fin Original:</strong>
                <span>{{ \Carbon\Carbon::parse($reserva->fecha_fin)->format('d/m/Y') }}</span>
            </div>
            <div class="detail-row">
                <strong>Fecha de Devolución Real:</strong>
                <span>{{ \Carbon\Carbon::today()->format('d/m/Y') }}</span>
            </div>
        </div>

        <div class="delay-info">
            <strong>⏰ Información del Retraso:</strong>
            <p>La maquinaria debía ser devuelta el <strong>{{ \Carbon\Carbon::parse($reserva->fecha_fin)->format('d/m/Y') }}</strong>, pero fue devuelta el <strong>{{ \Carbon\Carbon::today()->format('d/m/Y') }}</strong>.</p>
            <p>Esto representa un retraso de <span class="highlight">{{ $diasAtrasados }} {{ $diasAtrasados == 1 ? 'día' : 'días' }}</span>.</p>
        </div>

        <div class="charge-box">
            <h3>💰 Cálculo del Cargo Adicional</h3>
            <table class="calculation-table">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Cantidad</th>
                        <th>Tarifa de Penalización</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Monto Original de la Reserva</td>
                        <td>-</td>
                        <td>-</td>
                        <td>${{ number_format($reserva->monto_total, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Días de Retraso</td>
                        <td>{{ $diasAtrasados }} {{ $diasAtrasados == 1 ? 'día' : 'días' }}</td>
                        <td>${{ number_format($reserva->maquinaria->precio_por_dia / 2, 2) }} <small>(50% del precio/día)</small></td>
                        <td>${{ number_format($extra, 2) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3"><strong>TOTAL A PAGAR</strong></td>
                        <td><strong>${{ number_format($reserva->monto_total + $extra, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
            
            <p><strong>Cargo adicional aplicado:</strong> ${{ number_format($extra, 2) }}</p>
            <p><strong>Detalle del cálculo:</strong> {{ $diasAtrasados }} {{ $diasAtrasados == 1 ? 'día' : 'días' }} × ${{ number_format($reserva->maquinaria->precio_por_dia / 2, 2) }} (50% del precio diario) = ${{ number_format($extra, 2) }}</p>
            <p><strong>Método de cobro:</strong> El cargo se aplicará al mismo método de pago utilizado en la reserva original.</p>
        </div>

        <div class="contact-box">
            <h3>📞 ¿Tiene Alguna Consulta?</h3>
            <p>Si considera que este cargo es incorrecto o tiene alguna pregunta sobre el mismo, no dude en contactarnos:</p>
            <ul>
                <li>📧 Email: <a href="mailto:MannyMaquinarias@gmail.com">MannyMaquinarias@gmail.com</a></li>
                <li>📞 Teléfono: <a href="tel:+542215922204">+54 221 592 2204</a></li>
                <li>💬 Responda directamente a este correo</li>
            </ul>
            <p><strong>Horario de atención:</strong> Lunes a Viernes de 8:00 a 18:00 hs</p>
        </div>

        <h3>📋 Términos y Condiciones</h3>
        <p>Este cargo se aplica de acuerdo a los términos y condiciones aceptados al momento de realizar la reserva. <strong>La penalización por retraso equivale al 50% del valor de alquiler diario</strong> por cada día de demora en la devolución de la maquinaria.</p>
        
        <p>Agradecemos su comprensión y esperamos seguir brindándole nuestros servicios en el futuro.</p>
        
        <p><strong>Atentamente,<br>
        Departamento de Facturación<br>
        Manny Maquinarias</strong></p>
    </div>
    
    <div class="footer">
        <p>© {{ date('Y') }} Manny Maquinarias. Todos los derechos reservados.</p>
        <p>Contacto: <a href="mailto:innovadev@alquiplus.com">innovadev@alquiplus.com</a> | Tel: <a href="tel:+542215922204">+54 221 592 2204</a></p>
        <p>Dirección: La Plata 21, Buenos Aires, Argentina</p>
        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 11px; color: #999;">
            Este correo es generado automáticamente por nuestro sistema de facturación.
            Cargo aplicado por retraso en devolución de maquinaria.
        </p>
    </div>
</body>
</html>