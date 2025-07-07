<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelación de Reserva - Manny Maquinarias</title>
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
            background-color: #e74c3c;
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
        .apology-box {
            background-color: #ffeaa7;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #fdcb6e;
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
        .refund-box {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        .refund-box h3 {
            margin-top: 0;
            color: #155724;
        }
        .maintenance-info {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .maintenance-info strong {
            color: #856404;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>🚜 Manny Maquinarias</h1>
        <p>Cancelación de Reserva por Mantenimiento</p>
    </div>
    
    <div class="content">
        <div class="apology-box">
            <h2>Estimado/a {{ $reserva->usuario->name }},</h2>
            <p>Lamentamos informarle que debido a una situación imprevista, nos vemos obligados a cancelar su reserva.</p>
        </div>

        <div class="reservation-details">
            <h3>📋 Detalles de la Reserva Cancelada</h3>
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
                <strong>Fecha de Fin:</strong>
                <span>{{ \Carbon\Carbon::parse($reserva->fecha_fin)->format('d/m/Y') }}</span>
            </div>
            <div class="detail-row">
                <strong>Monto Total:</strong>
                <span>${{ number_format($reserva->monto_total, 2) }}</span>
            </div>
        </div>

        <div class="maintenance-info">
            <strong>🔧 Motivo de la Cancelación:</strong>
            <p>La maquinaria <strong>{{ $reserva->maquinaria->nombre }}</strong> requiere mantenimiento preventivo urgente para garantizar su correcto funcionamiento y seguridad. Esta medida es necesaria para mantener nuestros estándares de calidad y seguridad.</p>
        </div>

        <div class="refund-box">
            <h3>💰 Información sobre el Reembolso</h3>
            <p><strong>Monto a reembolsar:</strong> ${{ number_format($reserva->monto_total, 2) }}</p>
            <p><strong>Método de reembolso:</strong> El dinero será devuelto al mismo método de pago utilizado en la reserva original.</p>
            <p><strong>Tiempo estimado:</strong> El reembolso se procesará en un plazo de 3 a 5 días hábiles.</p>
            <p><strong>Estado:</strong> ✅ Procesado automáticamente</p>
        </div>

        <h3>📞 ¿Necesita una Alternativa?</h3>
        <p>Si necesita una maquinaria similar para las mismas fechas, nuestro equipo estará encantado de ayudarle a encontrar una alternativa que se ajuste a sus necesidades.</p>
        
        <p>Puede contactarnos a través de:</p>
        <ul>
            <li>📧 Email: <a href="mailto:MannyMaquinarias@gmail.com">MannyMaquinarias@gmail.com</a></li>
            <li>📞 Teléfono: <a href="tel:+542215922204">+54 221 592 2204</a></li>
        </ul>
        
        <p>Pedimos disculpas por cualquier inconveniente que esta cancelación pueda causarle. Valoramos su comprensión y esperamos poder servirle en futuras ocasiones.</p>
        
        <p><strong>Atentamente,<br>
        Equipo de Manny Maquinarias</strong></p>
    </div>
    
    <div class="footer">
        <p>© {{ date('Y') }} Manny Maquinarias. Todos los derechos reservados.</p>
        <p>Contacto: <a href="mailto:innovadev@alquiplus.com">innovadev@alquiplus.com</a> | Tel: <a href="tel:+542215922204">+54 221 592 2204</a></p>
        <p>Dirección: La Plata 21, Buenos Aires, Argentina</p>
        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 11px; color: #999;">
            Este correo es generado automáticamente por nuestro sistema de reservas.
        </p>
    </div>
</body>
</html>