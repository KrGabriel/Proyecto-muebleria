@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Nuevo Cheque</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('cheques.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Cuenta Bancaria:</label>
                        <select name="codigo_cuenta" class="form-select" required>
                            @foreach($cuentas as $cuenta)
                                <option value="{{ $cuenta->codigo }}">{{ $cuenta->numero_cuenta }}</option>
                            @endforeach
                        </select>
                        @error('codigo_cuenta') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Factura:</label>
                        <select name="codigo_factura" class="form-select">
                            <option value="">Sin factura</option>
                            @foreach($facturas as $factura)
                                <option value="{{ $factura->id }}">{{ $factura->id }}</option>
                            @endforeach
                        </select>
                        @error('codigo_factura') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número Cheque:</label>
                        <input type="text" name="numero_cheque" class="form-control" value="{{ old('numero_cheque') }}" required>
                        @error('numero_cheque') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Debe:</label>
                            <input type="number" name="debe" class="form-control" value="{{ old('debe') }}" min="0" step="0.01" required>
                            @error('debe') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Haber:</label>
                            <input type="number" name="haber" class="form-control" value="{{ old('haber') }}" min="0" step="0.01" required>
                            @error('haber') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha:</label>
                        <input type="date" name="fecha" class="form-control" value="{{ old('fecha') }}" required>
                        @error('fecha') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="entro" class="form-check-input" value="1" {{ old('entro') ? 'checked' : '' }}>
                        <label class="form-check-label">¿Entró?</label>
                        @error('entro') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-save"></i> Guardar
                        </button>
                        <a href="{{ route('cheques.index') }}" class="btn btn-secondary btn-lg">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection