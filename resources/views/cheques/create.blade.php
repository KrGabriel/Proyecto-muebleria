@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Cheque</h2>
    <form action="{{ route('cheques.update', $cheque->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Cuenta Bancaria:</label>
            <select name="codigo_cuenta" class="form-select">
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
            <input type="text" name="numero" class="form-control" value="{{ old('numero', $cheque->numero) }}">
            @error('numero') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Debe:</label>
            <input type="number" name="debe" class="form-control" value="{{ old('debe', $cheque->debe) }}">
            @error('debe') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Haber:</label>
            <input type="number" name="haber" class="form-control" value="{{ old('haber', $cheque->haber) }}">
            @error('haber') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha Emisión:</label>
            <input type="date" name="fecha_emision" class="form-control" value="{{ old('fecha_emision', $cheque->fecha_emision) }}">
            @error('fecha_emision') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha Pago:</label>
            <input type="date" name="fecha_pago" class="form-control" value="{{ old('fecha_pago', $cheque->fecha_pago) }}">
            @error('fecha_pago') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('cheques.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection