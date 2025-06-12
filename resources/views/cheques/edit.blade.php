@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Editar Cheque</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('cheques.update', $cheque->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Cuenta Bancaria:</label>
                        <select name="codigo_cuenta" class="form-select" required>
                            @foreach($cuentas as $cuenta)
                                <option value="{{ $cuenta->id }}" @if($cheque->codigo_cuenta == $cuenta->id) selected @endif>{{ $cuenta->numero }}</option>
                            @endforeach
                        </select>
                        @error('codigo_cuenta') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Factura:</label>
                        <select name="codigo_factura" class="form-select">
                            <option value="">Sin factura</option>
                            @foreach($facturas as $factura)
                                <option value="{{ $factura->id }}" @if($cheque->codigo_factura == $factura->id) selected @endif>{{ $factura->numero }}</option>
                            @endforeach
                        </select>
                        @error('codigo_factura') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número:</label>
                        <input type="text" name="numero" class="form-control" value="{{ old('numero', $cheque->numero) }}" placeholder="Ej: 00012345" required>
                        @error('numero') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Debe:</label>
                            <input type="number" name="debe" class="form-control" value="{{ old('debe', $cheque->debe) }}" min="0" step="0.01" required>
                            @error('debe') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Haber:</label>
                            <input type="number" name="haber" class="form-control" value="{{ old('haber', $cheque->haber) }}" min="0" step="0.01" required>
                            @error('haber') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha Emisión:</label>
                            <input type="date" name="fecha_emision" class="form-control" value="{{ old('fecha_emision', $cheque->fecha_emision) }}" required>
                            @error('fecha_emision') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha Pago:</label>
                            <input type="date" name="fecha_pago" class="form-control" value="{{ old('fecha_pago', $cheque->fecha_pago) }}" required>
                            @error('fecha_pago') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-save"></i> Actualizar
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