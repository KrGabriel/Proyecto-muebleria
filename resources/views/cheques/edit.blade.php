@extends('layouts.app')
@push('scripts')
<script>
$(document).ready(function() {
    $('#numero').on('keyup', function() {
        let query = $(this).val();
        if (query.length >= 2) {
            $.ajax({
                url: '/buscar-factura',
                data: { q: query },
                success: function(data) {
                    let lista = $('#lista_facturas').empty();
                    if (data.length === 0) {
                        lista.append('<div class="list-group-item disabled">No se encontraron facturas</div>');
                    } else {
                        data.forEach(function(factura) {
                            let text = factura.numero + ' - ' + (factura.nombre_proveedor ?? 'Sin proveedor');
                            lista.append(`<button type="button" class="list-group-item list-group-item-action" data-codigo="${factura.id}" data-texto="${text}">${text}</button>`);
                        });
                    }
                    lista.show();
                }
            });
        } else {
            $('#lista_facturas').hide();
        }
    });

    $('#lista_facturas').on('click', 'button', function() {
        let texto = $(this).data('texto');
        let codigo = $(this).data('codigo');
        $('#numero').val(texto);
        $('#codigo_factura').val(codigo);
        $('#lista_facturas').hide();
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('#numero_factura, #lista_facturas').length) {
            $('#lista_facturas').hide();
        }
    });
});
</script>
@endpush
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
                                <option value="{{ $cuenta->codigo }}" @if($cheque->codigo_cuenta == $cuenta->codigo) selected @endif>
                                    {{ $cuenta->numero_cuenta }}
                                </option>
                            @endforeach
                        </select>
                        @error('codigo_cuenta') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3 position-relative">
                        <label class="form-label">Factura:</label>
                        <input 
                            type="text" 
                            name="numero" 
                            id="numero" 
                            class="form-control" 
                            autocomplete="off" 
                            placeholder="Buscar factura por número o proveedor" 
                            required
                            value="{{ $cheque->factura ? $cheque->factura->numero . ' - ' . ($cheque->factura->proveedor->nombre ?? 'Sin proveedor') : '' }}"
                        >
                        <input 
                            type="hidden" 
                            name="codigo_factura" 
                            id="codigo_factura" 
                            value="{{ $cheque->codigo_factura }}"
                        >
                        <div id="lista_facturas" class="list-group position-absolute w-100" style="z-index: 1000; max-height: 200px; overflow-y: auto;"></div>
                        @error('codigo_factura') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número Cheque:</label>
                        <input type="text" name="numero_cheque" class="form-control" value="{{ old('numero_cheque', $cheque->numero_cheque) }}" required>
                        @error('numero_cheque') <div class="text-danger">{{ $message }}</div> @enderror
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
                    <div class="mb-3">
                        <label class="form-label">Fecha:</label>
                        <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $cheque->fecha) }}" required>
                        @error('fecha') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="entro" class="form-check-input" value="1" {{ old('entro', $cheque->entro) ? 'checked' : '' }}>
                        <label class="form-check-label">¿Entró?</label>
                        @error('entro') <div class="text-danger">{{ $message }}</div> @enderror
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