@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-receipt"></i> Facturas</h2>
        <a href="{{ route('facturas.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Nueva Factura
        </a>
    </div>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form para filtro de facturas -->
     <form method="GET" action="{{ route('facturas.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label>Desde:</label>
            <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Hasta:</label>
            <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Proveedor:</label>
            <input type="text" name="proveedor" value="{{ request('proveedor') }}" class="form-control" placeholder="Buscar proveedor">
        </div>
        <div class="col-md-3">
            <label>Número de Factura:</label>
            <input type="text" name="numero_factura" value="{{ request('numero_factura') }}" class="form-control">
        </div>
        <div class="col-md-12 text-end">
            <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
            <a href="{{ route('facturas.index') }}" class="btn btn-secondary mt-2">Limpiar</a>
        </div>
    </form>

    <div class="card shadow">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Numero Factura</th>
                        <th>Proveedor</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($facturas as $factura)
                        <tr>
                        <td>{{ $factura->numero }}</td>
                        <td>{{ $factura->proveedor ? $factura->proveedor->nombre : '-' }}</td>
                        <td>{{ $factura->fecha }}</td>
                        <td>${{ number_format($factura->total, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-info btn-sm" title="Ver">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('facturas.edit', $factura->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('facturas.destroy', $factura->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta factura?')" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            <button class="btn btn-outline-secondary btn-sm ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#chequesFactura{{ $factura->id }}">
                                <i class="bi bi-chevron-down"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="collapse" id="chequesFactura{{ $factura->id }}">
                        <td colspan="5" class="bg-light">
                            @if ($factura->cheques->count())
                                <table class="table table-sm table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>¿Entró?</th>
                                            <th>Número</th>
                                            <th>Banco</th>
                                            <th>Cuenta</th>
                                            <th>Fecha de Pago</th>
                                            <th>Importe</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($factura->cheques as $cheque)
                                        <tr>
                                            <td>
                                                @if($cheque->entro)
                                                    <span class="badge bg-success">Sí</span>
                                                @else
                                                    <span class="badge bg-danger">No</span>
                                                @endif
                                            </td>
                                            <td>{{ $cheque->numero_cheque }}</td>

                                            <td>
                                                {{ $cheque->cuenta->banco->nombre ?? 'Sin Banco' }}
                                            </td>
                                            <td>{{ $cheque->cuenta->numero_cuenta ?? 'Sin Cuenta' }}</td>
                                            <td>{{ $cheque->fecha }}</td>

                                            <td>${{ number_format($cheque->debe, 2, ',', '.') }}</td>

                                            <td>
                                                <a href="{{ route('cheques.edit', $cheque->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('cheques.destroy', $cheque->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este cheque?')" title="Eliminar">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="p-2 text-muted">No hay cheques asociados a esta factura.</div>
                            @endif

                            <a href="{{ route('cheques.create', ['factura' => $factura->id]) }}" class="btn btn-success mt-2">
                                <i class="bi bi-plus-circle"></i> Agregar Cheque
                            </a>
                        </td>
                    </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay facturas cargadas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@php
    $currentPage = $facturas->currentPage();
    $lastPage = $facturas->lastPage();
@endphp

<nav>
    <ul class="pagination justify-content-center mt-4">
        @for ($i = 1; $i <= $lastPage; $i++)
            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                <a class="page-link" href="{{ $facturas->url($i) }}">
                    {{ $i }}
                </a>
            </li>
        @endfor
    </ul>
</nav>
@endsection