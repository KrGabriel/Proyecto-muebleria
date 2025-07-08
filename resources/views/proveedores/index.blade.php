@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-truck"></i> Proveedores</h2>
        <a href="{{ route('proveedores.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Nuevo Proveedor
        </a>
    </div>

    {{-- Formulario de búsqueda --}}
    <form method="GET" action="{{ route('proveedores.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Buscar por nombre, dirección, teléfono, etc." value="{{ old('q', $query ?? '') }}">
            <button type="submit" class="btn btn-outline-secondary">Buscar</button>
            @if(!empty($query))
                <a href="{{ route('proveedores.index') }}" class="btn btn-outline-danger">Limpiar</a>
            @endif
        </div>
    </form>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tabla de proveedores --}}
    <div class="card shadow">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Numero</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Localidad</th>
                        <th>Provincia</th>
                        <th>Última Compra</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($proveedores as $proveedor)
                        <tr>
                            <td>{{ $proveedor->numero_proveedor}}
                            <td>{{ $proveedor->nombre }}</td>
                            <td>{{ $proveedor->direccion }}</td>
                            <td>{{ $proveedor->telefono }}</td>
                            <td>{{ $proveedor->localidad }}</td>
                            <td>{{ $proveedor->provincia }}</td>
                            <td>{{ $proveedor->fecha_ultima_compra }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('proveedores.edit', $proveedor->codigo) }}" class="btn btn-warning btn-sm" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('proveedores.destroy', $proveedor->codigo) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este proveedor?')" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay proveedores cargados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginación --}}
    @php
        $currentPage = $proveedores->currentPage();
        $lastPage = $proveedores->lastPage();
    @endphp

    <nav>
        <ul class="pagination justify-content-center mt-4">
            @for ($i = 1; $i <= $lastPage; $i++)
                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="{{ $proveedores->url($i) }}&q={{ urlencode($query ?? '') }}">
                        {{ $i }}
                    </a>
                </li>
            @endfor
        </ul>
    </nav>
</div>
@endsection
