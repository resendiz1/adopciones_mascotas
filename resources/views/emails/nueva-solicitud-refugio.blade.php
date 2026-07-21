<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <h2>Nueva solicitud de aprobación de refugio</h2>
    <p>Se ha registrado un nuevo refugio y está esperando tu aprobación:</p>
    <ul>
        <li><strong>Nombre:</strong> {{ $shelter->name }}</li>
        <li><strong>Email:</strong> {{ $shelter->user->email }}</li>
        <li><strong>Teléfono:</strong> {{ $shelter->phone ?? 'Sin especificar' }}</li>
        <li><strong>Ciudad:</strong> {{ $shelter->ciudad ?? 'Sin especificar' }}</li>
        <li><strong>Estado:</strong> {{ $shelter->estado ?? 'Sin especificar' }}</li>
    </ul>
    <p>
        <a href="{{ route('admin.refugios') }}" style="display: inline-block; padding: 10px 20px; background-color: #485fc7; color: #fff; text-decoration: none; border-radius: 4px;">
            Revisar refugios
        </a>
    </p>
    <br>
    <p>Saludos,<br>El equipo de Adopciones Mascotas</p>
</body>
</html>
