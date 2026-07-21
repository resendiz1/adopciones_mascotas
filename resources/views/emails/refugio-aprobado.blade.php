<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <h2>Refugio aprobado</h2>
    <p>Hola <strong>{{ $shelter->user->name }}</strong>,</p>
    <p>Tu refugio <strong>{{ $shelter->name }}</strong> ha sido <strong style="color: green;">aprobado</strong> por el administrador.</p>
    <p>Ya puedes gestionar tus mascotas, recibir solicitudes de adopción y administrar adopciones.</p>
    <p>
        <a href="{{ route('dashboard.refugio') }}" style="display: inline-block; padding: 10px 20px; background-color: #485fc7; color: #fff; text-decoration: none; border-radius: 4px;">
            Ir a mi dashboard
        </a>
    </p>
    <br>
    <p>Saludos,<br>El equipo de Adopciones Mascotas</p>
</body>
</html>
