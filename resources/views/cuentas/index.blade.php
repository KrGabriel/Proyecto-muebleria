@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-credit-card-2-front"></i> Cuentas Bancarias</h2>
        <a href="{{ route('cuentas.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Nueva Cuenta
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
                        <th>Banco</th>
                        <th>Número</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cuentas as $cuenta)
                        <tr>
                            <td>{{ $cuenta->banco->nombre }}</td>
                            <td>{{ $cuenta->numero }}</td>
                            <td>{{ $cuenta->tipo }}</td>
                            <td>
                                <a href="{{ route('cuentas.edit', $cuenta->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('cuentas.destroy', $cuenta->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta cuenta?')" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay cuentas cargadas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection