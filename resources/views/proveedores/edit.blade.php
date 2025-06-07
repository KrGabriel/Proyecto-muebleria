@extends('layout.app')

@section('content')
<div class = "container">
    <h1> Editar proveedor</h1>

    @if ($errors-> any/())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<form action="{{ route('proveedores.update', $proveedor->codigo) }}" method = "POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="{{ old('nombre', $proveedor->nombre) }}" class= form-control" required>
    </div>

    <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" value="{{ old('direccion', $proveedor->direccion) }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" value="{{ old('telefono', $proveedor->telefono) }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="localidad">Localidad:</label>
            <input type="text" name="localidad" value="{{ old('localidad', $proveedor->localidad) }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="provincia">Provincia:</label>
            <input type="text" name="provincia" value="{{ old('provincia', $proveedor->provincia) }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="fecha_ultima_compra">Fecha Última Compra:</label>
            <input type="date" name="fecha_ultima_compra" value="{{ old('fecha_ultima_compra', $proveedor->fecha_ultima_compra) }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection