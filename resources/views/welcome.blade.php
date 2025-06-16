<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a Marquez</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #e3f0ff 0%, #f8fafc 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .marquez-anim {
            font-size: 4rem;
            font-weight: bold;
            color: #1976d2;
            letter-spacing: 0.1em;
            animation: marquez-glow 2s infinite alternate;
            text-shadow: 0 0 10px #1976d2, 0 0 20px #1976d2;
        }
        @keyframes marquez-glow {
            0% {
                text-shadow: 0 0 10px #1976d2, 0 0 20px #1976d2;
                color: #1976d2;
            }
            100% {
                text-shadow: 0 0 30px #42a5f5, 0 0 60px #42a5f5;
                color: #42a5f5;
            }
        }
        .login-btn {
            font-size: 1.3rem;
            padding: 0.75rem 2.5rem;
        }
    </style>
</head>
<body>
    <div class="text-center w-100">
        <div class="mb-5">
            <span class="marquez-anim">Marquez</span>
        </div>
        <a href="{{ route('login') }}" class="btn btn-primary login-btn shadow">
            <i class="bi bi-person-circle"></i> Ingresar como Admin
        </a>
    </div>
</body>
</html>
