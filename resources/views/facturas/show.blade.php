@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0"><i class="bi bi-receipt"></i> Detalle de Factura</h4>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">ID</dt>
                        <dd class="col-sm-8">{{ $factura->id }}</dd>

                        <dt class="col-sm-4">Proveedor</dt>
                        <dd class="col-sm-8">{{ $factura->proveedor ? $factura->proveedor->nombre : '-' }}</dd>

                        <dt class="col-sm-4">Fecha</dt>
                        <dd class="col-sm-8">{{ $factura->fecha }}</dd>

                        <dt class="col-sm-4">Neto</dt>
                        <dd class="col-sm-8">${{ number_format($factura->neto, 2, ',', '.') }}</dd>

                        <dt class="col-sm-4">Tasa</dt>
                        <dd class="col-sm-8">${{ number_format($factura->tasa, 2, ',', '.') }}</dd>

                        <dt class="col-sm-4">Sobretasa</dt>
                        <dd class="col-sm-8">${{ number_format($factura->sobretasa, 2, ',', '.') }}</dd>

                        <dt class="col-sm-4">Total</dt>
                        <dd class="col-sm-8">${{ number_format($factura->total, 2, ',', '.') }}</dd>
                    </dl>
                    <a href="{{ route('facturas.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection