<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <h2>Refugio rechazado</h2>
    <p>Hola <strong>{{ $shelter->user->name }}</strong>,</p>
    <p>Lamentamos informarte que tu refugio <strong>{{ $shelter->name }}</strong> ha sido <strong style="color: red;">rechazado</strong> por el administrador.</p>
    <p>Si crees que esto es un error, por favor contacta al administrador del sistema para más información.</p>
    <br>
    <p>Saludos,<br>El equipo de Adopciones Mascotas</p>
</body>
</html>
