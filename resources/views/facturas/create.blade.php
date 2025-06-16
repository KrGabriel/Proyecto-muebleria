@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Nueva Factura</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('facturas.store') }}" method="POST" id="facturaForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Fecha:</label>
                            <input type="date" name="fecha" class="form-control" value="{{ old('fecha') }}" required>
                            @error('fecha') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Número:</label>
                            <input type="text" name="numero" class="form-control" value="{{ old('numero') }}" required>
                            @error('numero') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Neto:</label>
                            <input type="number" name="neto" id="neto" class="form-control" value="{{ old('neto') }}" min="0" step="0.01" required>
                            @error('neto') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tasa (%):</label>
                            <input type="number" name="tasa" id="tasa" class="form-control" value="{{ old('tasa') }}" min="0" step="0.01" required>
                            @error('tasa') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sobretasa (%):</label>
                            <input type="number" name="sobretasa" id="sobretasa" class="form-control" value="{{ old('sobretasa') }}" min="0" step="0.01">
                            @error('sobretasa') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total:</label>
                            <input type="number" name="total" id="total" class="form-control" value="{{ old('total') }}" min="0" step="0.01" readonly>
                            @error('total') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Proveedor:</label>
                            <select name="codigo_proveedor" class="form-select" required>
                                <option value="">Seleccione un proveedor</option>
                                @foreach($proveedores as $proveedor)
                                    <option value="{{ $proveedor->codigo }}" {{ old('codigo_proveedor') == $proveedor->codigo ? 'selected' : '' }}>
                                        {{ $proveedor->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('codigo_proveedor') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-save"></i> Guardar
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

@push('scripts')
<script>
function calcularTotal() {
    let neto = parseFloat(document.getElementById('neto').value) || 0;
    let tasa = parseFloat(document.getElementById('tasa').value) || 0;
    let sobretasa = parseFloat(document.getElementById('sobretasa').value) || 0;
    let total = neto + (neto * tasa / 100) + (neto * sobretasa / 100);
    document.getElementById('total').value = total.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('neto').addEventListener('input', calcularTotal);
    document.getElementById('tasa').addEventListener('input', calcularTotal);
    document.getElementById('sobretasa').addEventListener('input', calcularTotal);
    calcularTotal();
});
</script>
@endpush