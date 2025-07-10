@extends('layouts.app')
@push('scripts')
<script>
$(document).ready(function() {
    $('#nombre_proveedor').on('keyup', function() {
        let query = $(this).val();
        if (query.length >= 2) {
            $.ajax({
                url: '/buscar-proveedor',
                data: { q: query },
                success: function(data) {
                    let lista = $('#lista_proveedores').empty();
                    if (data.length === 0) {
                        lista.append('<div class="list-group-item disabled">No se encontraron resultados</div>');
                    } else {
                        data.forEach(function(proveedor) {
                            lista.append(`<button type="button" class="list-group-item list-group-item-action" data-codigo="${proveedor.codigo}" data-nombre="${proveedor.nombre}">${proveedor.nombre}</button>`);
                        });
                    }
                    lista.show();
                }
            });
        } else {
            $('#lista_proveedores').hide();
        }
    });

    $('#lista_proveedores').on('click', 'button', function() {
        let nombre = $(this).data('nombre');
        let codigo = $(this).data('codigo');
        $('#nombre_proveedor').val(nombre);
        $('#codigo_proveedor').val(codigo);
        $('#lista_proveedores').hide();
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('#nombre_proveedor, #lista_proveedores').length) {
            $('#lista_proveedores').hide();
        }
    });
});
</script>
@endpush
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
                            <label class="form-label">Total:</label>
                            <input type="number" name="total" class="form-control" value="{{ old('total', $factura->total) }}" min="0" step="0.01" required>
                            @error('total') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3 position-relative">
                            <label class="form-label">Proveedor:</label>
                            <input type="text" name="nombre_proveedor" id="nombre_proveedor" class="form-control" autocomplete="off" required>
                            <input type="hidden" name="codigo_proveedor" id="codigo_proveedor">
                            <div id="lista_proveedores" class="list-group position-absolute w-100" style="z-index: 1000;"></div>
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