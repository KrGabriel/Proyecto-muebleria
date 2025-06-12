<!DOCTYPE html>
<html>
<head>
    <title>Sistema para marquez</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    body {
        min-height: 100vh;
        position: relative;
    }
    footer {
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
    }
</style>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ url('/') }}">Mi App</a>
    </nav>

    <div class="container mt-4">
        <main>
            @yield('content')
        </main>
    </div>

    <footer class="text-center mt-5 mb-3">
        <small>© 2025 AUGEKA</small>
    </footer>

    <!-- Bootstrap bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>