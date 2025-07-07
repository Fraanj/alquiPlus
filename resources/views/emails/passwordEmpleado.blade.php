<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credenciales de Acceso - Manny Maquinarias</title>
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
            background-color: #2c3e50;
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
        .welcome-box {
            background-color: #e8f5e8;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #27ae60;
        }
        .credentials-box {
            background-color: #f8f9fa;
            border: 2px solid #dee2e6;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .credentials-box h3 {
            margin-top: 0;
            color: #2c3e50;
        }
        .password-field {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 12px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 16px;
            font-weight: bold;
            color: #e74c3c;
            word-break: break-all;
        }
        .important-note {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .important-note strong {
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
        <p>Bienvenido al equipo</p>
    </div>
    
    <div class="content">
        <div class="welcome-box">
            <h2>¡Bienvenido!</h2>
            <p>Es un placer darte la bienvenida al equipo de Manny Maquinarias. Esperamos que tengas una excelente experiencia trabajando con nosotros.</p>
        </div>

        <div class="credentials-box">
            <h3>📧 Credenciales de Acceso al Sistema</h3>
            <p><strong>Contraseña temporal:</strong></p>
            <div class="password-field">{{ $password }}</div>
        </div>

        <div class="important-note">
            <strong>⚠️ Importante:</strong>
            <ul>
                <li>Esta es una contraseña temporal generada automáticamente</li>
                <li>Te recomendamos cambiarla por una de tu elección una vez que ingreses al sistema</li>
                <li>Mantén esta información segura y no la compartas con nadie</li>
                <li>Si tienes problemas para acceder, contacta con el administrador</li>
            </ul>
        </div>

        <p>Para acceder al sistema, dirígete a nuestra plataforma web <a href="{{ route('home') }}">aquí</a> e ingresa con las credenciales proporcionadas.</p>

        <p>Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos.</p>
        
        <p>¡Bienvenido/a al equipo!</p>
        
        <p><strong>Equipo de Manny Maquinarias</strong></p>
    </div>
    
    <div class="footer">
        <p>© {{ date('Y') }} Manny Maquinarias. Todos los derechos reservados.</p>
        <p>Contacto: <a href="mailto:MannyMaquinarias@gmail.com">MannyMaquinarias@gmail.com</a> | Tel: <a href="tel:+542215922204">+54 221 592 2204</a></p>
        <p>Dirección: La Plata 21, Buenos Aires, Argentina</p>
        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 11px; color: #999;">
            Este correo contiene información confidencial.
        </p>
    </div>
</body>
</html>