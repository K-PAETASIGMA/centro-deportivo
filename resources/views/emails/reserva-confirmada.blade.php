<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e5e7eb; border-radius: 12px; }
        .header { background-color: #2563eb; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
        .footer { font-size: 12px; text-align: center; color: #6b7280; margin-top: 20px; }
        .total { font-size: 20px; font-weight: bold; color: #16a34a; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Reserva Confirmada</h1>
        </div>
        <div class="content">
            <p>Hola <strong>{{ auth()->user()->name }}</strong>,</p>
            <p>Tu pago ha sido procesado correctamente. Aquí tienes los detalles de tu cita:</p>
            
            <ul>
                <li><strong>Instalación:</strong> {{ $reserva->cancha->nombre }}</li>
                <li><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($reserva->fecha_inicio)->format('d/m/Y') }}</li>
                <li><strong>Hora:</strong> {{ \Carbon\Carbon::parse($reserva->fecha_inicio)->format('H:i') }}</li>
            </ul>

            <p>Monto Total Pagado: <span class="total">${{ number_format($reserva->total, 2) }}</span></p>
            
            <p>¡Gracias por preferirnos! Te recomendamos llegar 10 minutos antes de tu hora.</p>
        </div>
        <div class="footer">
            Este es un correo automático, por favor no respondas a este mensaje.
        </div>
    </div>
</body>
</html>