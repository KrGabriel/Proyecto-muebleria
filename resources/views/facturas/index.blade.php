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
            <select name="proveedor" class="form-control">
                <option value="">-- Todos --</option>
                @foreach($proveedores as $proveedor)
                    <option value="{{ $proveedor->codigo }}" {{ request('proveedor') == $proveedor->codigo ? 'selected' : '' }}>
                        {{ $proveedor->nombre }}
                    </option>
                @endforeach
            </select>
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