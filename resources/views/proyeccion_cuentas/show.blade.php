@extends('layout.app')

@section('content')
<div class="container">
    <h1>Detalle del Proveedor</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $proveedor->nombre }}</h5>
            <p class="card-text"><strong>Dirección:</strong> {{ $proveedor->direccion }}</p>
            <p class="card-text"><strong>Teléfono:</strong> {{ $proveedor->telefono }}</p>
            <p class="card-text"><strong>Localidad:</strong> {{ $proveedor->localidad }}</p>
            <p class="card-text"><strong>Provincia:</strong> {{ $proveedor->provincia }}</p>
            <p class="card-text"><strong>Última Compra:</strong> {{ $proveedor->fecha_ultima_compra }}</p>
        </div>
    </div>

    <a href="{{ route('proveedores.index') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection