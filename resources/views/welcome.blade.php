<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="proyecciones">Mi App</a>
        </nav>

        <div class="container mt-4">
            @yield('content')
        </div>

        <footer class="text-center mt-5 mb-3">
            <small>© 2025 Sistema de Augeka</small>
        </footer>
    </body>
</html>
