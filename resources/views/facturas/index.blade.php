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
    <div class="card shadow">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Proveedor</th>
                        <th>Fecha</th>
                        <th>Neto</th>
                        <th>Tasa</th>
                        <th>Sobretasa</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($facturas as $factura)
                        <tr>
                            <td>{{ $factura->id }}</td>
                            <td>{{ $factura->proveedor ? $factura->proveedor->nombre : '-' }}</td>
                            <td>{{ $factura->fecha }}</td>
                            <td>${{ number_format($factura->neto, 2, ',', '.') }}</td>
                            <td>${{ number_format($factura->tasa, 2, ',', '.') }}</td>
                            <td>${{ number_format($factura->sobretasa, 2, ',', '.') }}</td>
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
                            <td colspan="8" class="text-center">No hay facturas cargadas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection