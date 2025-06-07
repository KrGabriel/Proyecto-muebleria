@extends('layouts.app')

@section('content')
@php use Carbon\Carbon; @endphp

<div class="container">
    <h2 class="mb-4">Proyecciones</h2>

    @php
        $proyecciones = $proyecciones ?? [
            (object)[ 'codigo' => 1, 'fecha' => '2025-06-01', 'concepto' => 'Cheque *', 'debito' => '$50000', 'haber' => '$0', 'banco' => 'nación' ],
            (object)[ 'codigo' => 2, 'fecha' => '2025-06-02', 'concepto' => 'Cheque *', 'debito' => '$50000', 'haber' => '$0', 'banco' => 'nación' ],
            (object)[ 'codigo' => 3, 'fecha' => '2025-06-03', 'concepto' => 'Cheque *', 'debito' => '$50000', 'haber' => '$0', 'banco' => 'nación' ],
            (object)[ 'codigo' => 4, 'fecha' => '2025-06-04', 'concepto' => 'Cheque *', 'debito' => '$50000', 'haber' => '$0', 'banco' => 'macro' ],
            (object)[ 'codigo' => 5, 'fecha' => '2025-06-05', 'concepto' => 'Cheque *', 'debito' => '$50000', 'haber' => '$0', 'banco' => 'macro' ],
            (object)[ 'codigo' => 6, 'fecha' => '2025-06-06', 'concepto' => 'Cheque *', 'debito' => '$50000', 'haber' => '$0', 'banco' => 'santander' ],
            (object)[ 'codigo' => 7, 'fecha' => '2025-06-07', 'concepto' => 'Cheque *', 'debito' => '$50000', 'haber' => '$0', 'banco' => 'santander' ],
            (object)[ 'codigo' => 8, 'fecha' => '2025-06-08', 'concepto' => 'Cheque *', 'debito' => '$50000', 'haber' => '$0', 'banco' => 'santander' ],
        ];

        $bancoFiltro = request('banco');
        $desde = request('desde');
        $hasta = request('hasta');
        $pagina = request('pagina', 1);
        $porPagina = 4;

        if ($bancoFiltro) {
            $proyecciones = array_filter($proyecciones, fn($p) => $p->banco === $bancoFiltro);
        }

        if ($desde || $hasta) {
            $proyecciones = array_filter($proyecciones, function ($p) use ($desde, $hasta) {
                $fecha = Carbon::parse($p->fecha);
                $valido = true;

                if ($desde) {
                    $valido = $valido && $fecha >= Carbon::parse($desde);
                }

                if ($hasta) {
                    $valido = $valido && $fecha <= Carbon::parse($hasta);
                }

                return $valido;
            });
        }

        $total = count($proyecciones);
        $proyecciones = array_slice($proyecciones, ($pagina - 1) * $porPagina, $porPagina);
        $totalPaginas = ceil($total / $porPagina);
    @endphp

    <form method="GET" class="row mb-3">
        <div class="col-auto">
            <label for="desde">Desde:</label>
            <input type="date" name="desde" value="{{ request('desde') }}" class="form-control">
        </div>
        <div class="col-auto">
            <label for="hasta">Hasta:</label>
            <input type="date" name="hasta" value="{{ request('hasta') }}" class="form-control">
        </div>
        <div class="col-auto d-flex align-items-end">
            <button type="submit" class="btn btn-secondary">Filtrar</button>
        </div>
    </form>

    <div class="mb-3">
        <a href="{{ url()->current() }}" class="btn btn-outline-secondary {{ !$bancoFiltro ? 'active' : '' }}">Todos</a>
        <a href="?banco=nación&desde={{ $desde }}&hasta={{ $hasta }}" class="btn btn-outline-primary {{ $bancoFiltro === 'nación' ? 'active' : '' }}">Nación</a>
        <a href="?banco=macro&desde={{ $desde }}&hasta={{ $hasta }}" class="btn btn-outline-success {{ $bancoFiltro === 'macro' ? 'active' : '' }}">Macro</a>
        <a href="?banco=santander&desde={{ $desde }}&hasta={{ $hasta }}" class="btn btn-outline-danger {{ $bancoFiltro === 'santander' ? 'active' : '' }}">Santander</a>
        <a href="#" class="btn btn-success float-end">Agregar nuevo banco</a>
    </div>

    {{-- Tabla --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Concepto</th>
                <th>Débito</th>
                <th>Haber</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($proyecciones as $proyeccion)
                <tr>
                    <td>{{ $proyeccion->fecha }}</td>
                    <td>{{ $proyeccion->concepto }}</td>
                    <td>{{ $proyeccion->debito }}</td>
                    <td>{{ $proyeccion->haber }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary">Editar</a>
                        <form action="#" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este registro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No hay proyecciones cargadas.</td></tr>
            @endforelse
        </tbody>
    </table>

    <nav>
        <ul class="pagination justify-content-center">
            @for ($i = 1; $i <= $totalPaginas; $i++)
                <li class="page-item {{ $i == $pagina ? 'active' : '' }}">
                    <a class="page-link" href="?banco={{ $bancoFiltro }}&desde={{ $desde }}&hasta={{ $hasta }}&pagina={{ $i }}">{{ $i }}</a>
                </li>
            @endfor
        </ul>
    </nav>

    <form action="{{ url('/proyecciones/pdf') }}" method="GET" target="_blank" class="d-inline">
        <input type="hidden" name="banco" value="{{ $bancoFiltro }}">
        <input type="hidden" name="desde" value="{{ $desde }}">
        <input type="hidden" name="hasta" value="{{ $hasta }}">
        
        <button type="submit" class="btn btn-outline-dark">
            Imprimir cheques filtrados
        </button>
    </form>

</div>
@endsection
