@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nuevo Proveedor</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Ups!</strong> Ocurrió un error.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('proveedores.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-3">
            <label>Número de Proveedor:</label>
            <input type="number" name="numero_proveedor" class="form-control" value="{{ old('numero_proveedor', $siguienteNumero) }}" readonly required>
        </div>

        <div class="mb-3">
            <label>Dirección:</label>
            <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}">
        </div>

        <div class="mb-3">
            <label>Teléfono:</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
        </div>

        <div class="mb-3">
            <label>Localidad:</label>
            <input type="text" name="localidad" class="form-control" value="{{ old('localidad') }}">
        </div>

        <div class="mb-3">
            <label>Provincia:</label>
            <input type="text" name="provincia" class="form-control" value="{{ old('provincia') }}">
        </div>

        <div class="mb-3">
            <label>Fecha Última Compra:</label>
            <input type="date" name="fecha_ultima_compra" class="form-control" value="{{ old('fecha_ultima_compra') }}">
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
