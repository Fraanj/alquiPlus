<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail de Prueba</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        .content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚜 Manny Maquinarias</h1>
        <p>Mail de Prueba</p>
    </div>
    
    <div class="content">
        <h2>¡Hola!</h2>
        <p>Este es un mail de prueba enviado desde el sistema de Manny Maquinarias.</p>
        <p>Si estás recibiendo este mensaje, significa que la configuración de email está funcionando correctamente.</p>
        <p>¡Gracias por usar nuestro sistema!</p>
    </div>
    
    <div class="footer">
        <p>© {{ date('Y') }} Manny Maquinarias. Todos los derechos reservados.</p>
        <p>Contacto: innovadev@alquiplus.com | Tel: +54 221 592 2204</p>
    </div>
</body>
</html>
