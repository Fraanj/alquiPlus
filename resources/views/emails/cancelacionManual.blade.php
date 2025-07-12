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
            background-color: #e67e22;
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
            background-color: #fee2e2;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #f87171;
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
        .availability-info {
            background-color: #fef3c7;
            border: 1px solid #fbbf24;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .availability-info strong {
            color: #92400e;
        }
        .alternatives-box {
            background-color: #eff6ff;
            border: 1px solid #93c5fd;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #3b82f6;
        }
        .alternatives-box h3 {
            margin-top: 0;
            color: #1e40af;
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
        <p>Cancelación Manual de Reserva</p>
    </div>
    
    <div class="content">
        <div class="apology-box">
            <h2>Estimado/a {{ $reserva->usuario->name }},</h2>
            <p>Lamentamos informarle que nos vemos en la necesidad de cancelar su reserva debido a problemas inesperados con la disponibilidad de la maquinaria solicitada.</p>
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

        <div class="availability-info">
            <strong>❗ Motivo de la Cancelación:</strong>
            <p>Debido a circunstancias imprevistas relacionadas con la disponibilidad de la maquinaria <strong>{{ $reserva->maquinaria->nombre }}</strong>, no podemos garantizar su entrega en las fechas programadas. Esta situación ha sido detectada y gestionada manualmente por nuestro equipo para evitar inconvenientes mayores.</p>
        </div>

        <div class="refund-box">
            <h3>💰 Información sobre el Reembolso</h3>
            <p><strong>Monto a reembolsar:</strong> ${{ number_format($reserva->monto_total, 2) }}</p>
            <p><strong>Método de reembolso:</strong> El dinero será devuelto al mismo método de pago utilizado en la reserva original.</p>
            <p><strong>Tiempo estimado:</strong> El reembolso se procesará en un plazo de 3 a 5 días hábiles.</p>
            <p><strong>Estado:</strong> ✅ Procesado automáticamente</p>
        </div>

        <div class="alternatives-box">
            <h3>🔄 Opciones Alternativas</h3>
            <p>Entendemos que esta cancelación puede afectar sus planes. Nuestro equipo está trabajando para ofrecerle las siguientes alternativas:</p>
            <ul>
                <li><strong>Maquinaria similar:</strong> Podemos buscar una máquina con características similares</li>
                <li><strong>Fechas alternativas:</strong> Disponibilidad en fechas cercanas a las originalmente solicitadas</li>
                <li><strong>Descuento especial:</strong> Ofrecemos un 10% de descuento en su próxima reserva como disculpa por el inconveniente</li>
            </ul>
        </div>

        <h3>📞 Contacto Inmediato</h3>
        <p>Para gestionar cualquier alternativa o resolver sus dudas, nuestro equipo está disponible para atenderle:</p>
        
        <ul>
            <li>📧 Email: <a href="mailto:MannyMaquinarias@gmail.com">MannyMaquinarias@gmail.com</a></li>
            <li>📞 Teléfono: <a href="tel:+542215922204">+54 221 592 2204</a></li>
            <li>💬 Responda directamente a este correo para atención prioritaria</li>
        </ul>
        
        <p>Valoramos su confianza en nuestros servicios y trabajaremos para encontrar la mejor solución para sus necesidades. Pedimos sinceras disculpas por los inconvenientes ocasionados.</p>
        
        <p><strong>Atentamente,<br>
        Equipo de Gestión de Reservas<br>
        Manny Maquinarias</strong></p>
    </div>
    
    <div class="footer">
        <p>© {{ date('Y') }} Manny Maquinarias. Todos los derechos reservados.</p>
        <p>Contacto: <a href="mailto:innovadev@alquiplus.com">innovadev@alquiplus.com</a> | Tel: <a href="tel:+542215922204">+54 221 592 2204</a></p>
        <p>Dirección: La Plata 21, Buenos Aires, Argentina</p>
        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 11px; color: #999;">
            Este correo es generado automáticamente por nuestro sistema de gestión de reservas.
            Cancelación procesada manualmente por el equipo de administración.
        </p>
    </div>
</body>
</html>