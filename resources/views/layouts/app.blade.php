<!DOCTYPE html>
<html>
<head>
    <title>Sistema para marquez</title>
    <!-- Bootstrap CSS y JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="proveedores">Mi App</a>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <footer class="text-center mt-5 mb-3">
        <small>© 2025 Sistema de Augkegab</small>
    </footer>
</body>
</html>