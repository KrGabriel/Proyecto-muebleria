<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mueblería Marquez</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .marquez-anim {
            font-size: 2rem;
            font-weight: bold;
            color: #1976d2;
            letter-spacing: 0.1em;
            animation: marquez-glow 2s infinite alternate;
            text-shadow: 0 0 10px #1976d2, 0 0 20px #1976d2;
            cursor: pointer;
            transition: color 0.2s;
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
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            background: #f8fafc;
        }
        body {
            min-height: 100vh;
        }
        .main-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1 0 auto;
        }
        footer {
            flex-shrink: 0;
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-light px-2" style="padding-left:10px; padding-right:10px;">
            <div class="container-fluid p-0">
                <a class="navbar-brand marquez-anim" href="{{ route('dashboard') }}" style="margin-left:10px;">
                    Marquez
                </a>
                <div class="ms-auto" style="margin-right:10px;">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    @else
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-danger" type="submit">
                                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="container mt-4 mb-5">
            @yield('content')
        </main>

        <footer class="text-center py-3 bg-light">
            <small>© 2025 AUGEKA</small>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>