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

$('#numero_factura').on('keyup', function() {
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
                        let text = factura.numero + ' - ' + (factura.proveedor_nombre ?? 'Sin proveedor');
                        lista.append(`<button type="button" class="list-group-item list-group-item-action" data-codigo="${factura.id}" data-numero="${factura.numero}" data-proveedor="${factura.proveedor_nombre}">${text}</button>`);
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
    let numero = $(this).data('numero');
    let codigo = $(this).data('codigo');
    let proveedor = $(this).data('proveedor');
    $('#numero_factura').val(numero + (proveedor ? ' - ' + proveedor : ''));
    $('#codigo_factura').val(codigo);
    $('#lista_facturas').hide();
});

$(document).on('click', function(e) {
    if (!$(e.target).closest('#numero_factura, #lista_facturas').length) {
        $('#lista_facturas').hide();
    }
});
</script>
@endpush
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
                    {{-- ... otros campos del formulario ... --}}
                    <div class="mb-3">
                        <label class="form-label">Cuenta Bancaria:</label>
                        <select name="codigo_cuenta" class="form-select" required>
                            @foreach($cuentas as $cuenta)
                                <option value="{{ $cuenta->codigo }}">
                                    {{ $cuenta->numero_cuenta }} ({{ $cuenta->banco->nombre ?? 'Sin banco' }})
                                </option>
                            @endforeach
                        </select>
                        @error('codigo_cuenta') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3 position-relative">
                        <label class="form-label pt-3">Factura:</label>
                        <input type="text" name="numero" id="numero" class="form-control" autocomplete="off"
                            placeholder="Buscar factura por número o proveedor" required
                            value="{{ old('numero') ?? (isset($facturaSeleccionadaId) ? optional($facturas->firstWhere('id', $facturaSeleccionadaId))->numero . ' - ' . optional($facturas->firstWhere('id', $facturaSeleccionadaId))->proveedor->nombre : '') }}">
                        <input type="hidden" name="codigo_factura" id="codigo_factura" value="{{ old('codigo_factura', $facturaSeleccionadaId) }}">
                        <div id="lista_facturas" class="list-group position-absolute w-100" style="z-index: 1000; max-height: 200px; overflow-y: auto;"></div>
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
                            <input type="number" name="debe" class="form-control" value="{{ old('debe', 0) }}" min="0" step="0.01" required onfocus="if(this.value==0)this.value='';" onblur="if(this.value=='')this.value=0;">
                            @error('debe') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Haber:</label>
                            <input type="number" name="haber" class="form-control" value="{{ old('haber', 0) }}" min="0" step="0.01" required onfocus="if(this.value=='')this.value=0;">
                            @error('haber') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha de Emisión:</label>
                        <input type="date" name="fecha" class="form-control" value="{{ old('fecha', date('Y-m-d')) }}" required>
                        @error('fecha') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fecha de Entrada (Opcional):</label>
                        <input type="date" name="fecha_entrada" class="form-control" value="{{ old('fecha_entrada') }}">
                        @error('fecha_entrada') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="entro" class="form-check-input" value="1" {{ old('entro') ? 'checked' : '' }}>
                        <label class="form-check-label">¿Entró?</label>
                        @error('entro') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="submit" name="continuar" value="0" class="btn btn-success btn-lg">
                            <i class="bi bi-save"></i> Guardar
                        </button>
                        <button type="submit" name="continuar" value="1" class="btn btn-primary btn-lg">
                            <i class="bi bi-plus-circle"></i> Guardar y crear otro
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