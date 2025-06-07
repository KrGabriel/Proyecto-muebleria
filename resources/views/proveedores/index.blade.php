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
            @foreach ($proveedores as $proveedor)
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
            @endforeach
        </tbody>
    </table>
</div>
@endsection
