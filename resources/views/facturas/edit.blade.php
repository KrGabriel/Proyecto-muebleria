@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Editar Factura</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('facturas.update', $factura->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Fecha:</label>
                            <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $factura->fecha) }}" required>
                            @error('fecha') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Número:</label>
                            <input type="text" name="numero" class="form-control" value="{{ old('numero', $factura->numero) }}" required>
                            @error('numero') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Neto:</label>
                            <input type="number" name="neto" class="form-control" value="{{ old('neto', $factura->neto) }}" min="0" step="0.01" required>
                            @error('neto') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total:</label>
                            <input type="number" name="total" class="form-control" value="{{ old('total', $factura->total) }}" min="0" step="0.01" required>
                            @error('total') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Proveedor:</label>
                            <select name="codigo_proveedor" class="form-select" required>
                                <option value="">Seleccione un proveedor</option>
                                @foreach($proveedores as $proveedor)
                                    <option value="{{ $proveedor->codigo }}" {{ old('codigo_proveedor', $factura->codigo_proveedor) == $proveedor->codigo ? 'selected' : '' }}>
                                        {{ $proveedor->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('codigo_proveedor') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-save"></i> Actualizar
                            </button>
                            <a href="{{ route('facturas.index') }}" class="btn btn-secondary btn-lg">
                                <i class="bi bi-arrow-left"></i> Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection