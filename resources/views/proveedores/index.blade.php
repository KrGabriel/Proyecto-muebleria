@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Lista de Proveedores</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('proveedores.create') }}" class="btn btn-primary mb-3">Nuevo Proveedor</a>

    @php
        // Datos simulados por si estás trabajando sin base de datos
        $proveedores = $proveedores ?? [
            (object)[
                'codigo' => 1,
                'nombre' => 'Proveedor Ejemplo',
                'direccion' => 'Calle Falsa 123',
                'telefono' => '123456789',
                'localidad' => 'Ciudad X',
                'provincia' => 'Provincia Y',
                'fecha_ultima_compra' => '2025-06-01',
            ],
        ];
    @endphp

    <table class="table table-striped">
        <thead>
            <tr>
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
                    <td>{{ $proveedor->nombre }}</td>
                    <td>{{ $proveedor->direccion }}</td>
                    <td>{{ $proveedor->telefono }}</td>
                    <td>{{ $proveedor->localidad }}</td>
                    <td>{{ $proveedor->provincia }}</td>
                    <td>{{ $proveedor->fecha_ultima_compra }}</td>
                    <td>
                        <a href="{{ route('proveedores.edit', $proveedor->codigo) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('proveedores.destroy', $proveedor->codigo) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">Eliminar</button>
                        </form>
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
@endsection
