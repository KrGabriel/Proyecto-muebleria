@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-bank"></i> Bancos</h2>
        <a href="{{ route('bancos.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Nuevo Banco
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @forelse ($bancos as $banco)
        <div class="card mb-3 shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $banco->nombre }}</strong>
                </div>
                <div>
                    <a href="{{ route('bancos.edit', $banco->numero) }}" class="btn btn-warning btn-sm me-1" title="Editar">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="{{ route('bancos.destroy', $banco->numero) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este banco?')" title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    <button class="btn btn-outline-secondary btn-sm ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBanco{{ $banco->numero }}">
                        <i class="bi bi-chevron-down"></i>
                    </button>
                </div>
            </div>

            <div class="collapse" id="collapseBanco{{ $banco->numero }}">
                <div class="card-body">
                    @if ($banco->cuentas->count())
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Número</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banco->cuentas as $cuenta)
                                    <tr>
                                        <td>{{ $cuenta->numero_cuenta }}</td>
                                        <td>
                                            <a href="{{ route('cuentas.edit', $cuenta->codigo) }}" class="btn btn-warning btn-sm" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('cuentas.destroy', $cuenta->codigo) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta cuenta?')" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">No hay cuentas asociadas a este banco.</p>
                    @endif

                    <a href="{{ route('cuentas.create', ['banco' => $banco->numero]) }}" class="btn btn-success mt-2">
                        <i class="bi bi-plus-circle"></i> Agregar Cuenta
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">No hay bancos cargados.</div>
    @endforelse
</div>
@endsection
