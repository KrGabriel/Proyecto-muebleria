@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-cash-coin"></i> Cheques</h2>
        <a href="{{ route('cheques.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Nuevo Cheque
        </a>
    </div>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

     <form method="GET" action="{{ route('cheques.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label>Desde:</label>
            <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Hasta:</label>
            <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="form-control">
        </div>
            <div class="col-md-3">
            <label>Número de Cuenta Bancaria:</label>
            <input type="text" name="numero_cuenta" value="{{ request('numero_cuenta') }}" class="form-control" placeholder="Buscar cuenta bancaria">
        </div>
        <div class="col-md-3">
            <label>Número de factura:</label>
            <input type="text" name="numero_factura" value="{{ request('numero_factura') }}" class="form-control" placeholder="Buscar factura">
        </div>
        <div class="col-md-12 text-end">
            <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
            <a href="{{ route('cheques.index') }}" class="btn btn-secondary mt-2">Limpiar</a>
        </div>
    </form>
    
    <div class="card shadow">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>¿Entro?</th>
                        <th>Cuenta</th>
                        <th>Factura</th>
                        <th>Número Cheque</th>
                        <th>Debe</th>
                        <th>Haber</th>
                        <!-- CAMBIO 1: Se renombró "Fecha" y se añadió "Fecha Entrada" -->
                        <th>Fecha Emisión</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cheques as $cheque)
                        <tr>
                            <td>
                                @if($cheque->entro)
                                    <span class="badge bg-success">Sí</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td>{{ $cheque->cuenta ? $cheque->cuenta->numero_cuenta : '-' }}</td>
                            <td>{{ $cheque->factura ? $cheque->factura->numero : '-' }}</td>
                            <td>{{ $cheque->numero_cheque }}</td>
                            <td>${{ number_format($cheque->debe, 2, ',', '.') }}</td>
                            <td>${{ number_format($cheque->haber, 2, ',', '.') }}</td>

                            <!-- CAMBIO 2: Se formateó la fecha para quitar la hora -->
                            <td>{{ $cheque->fecha->format('d/m/Y') }}</td>
                            


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
                    @empty
                        <tr>
                            <!-- CAMBIO 4: Se actualizó el colspan para coincidir con el número de columnas -->
                            <td colspan="9" class="text-center">No hay cheques cargados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- La paginación se puede simplificar usando el método links() --}}
@if ($cheques->hasPages())
<nav class="mt-4">
    <ul class="pagination justify-content-center">
        {{ $cheques->links() }}
    </ul>
</nav>
@endif

@endsection