@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">📋 Proyecciones</h2>
    </div>

    @php
        use Carbon\Carbon;

        $bancoFiltro = request('banco');
        $desde = request('desde');
        $hasta = request('hasta');
        $pagina = request('pagina', 1);
        $totalPaginas = $proyecciones->lastPage();
    @endphp

    <form method="GET" class="row g-3 mb-4 align-items-end">
        <div class="col-md-3">
            <label for="desde" class="form-label">Desde</label>
            <input type="date" name="desde" value="{{ request('desde') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label for="hasta" class="form-label">Hasta</label>
            <input type="date" name="hasta" value="{{ request('hasta') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-outline-secondary w-100">Filtrar</button>
        </div>
    </form>

    <div class="mb-4">
        <div class="btn-group" role="group">
            @php
                $params = request()->except('page', 'banco');
            @endphp

            <a href="{{ url()->current() }}?{{ http_build_query($params) }}" 
            class="btn btn-outline-secondary {{ !$bancoFiltro ? 'active' : '' }}">
                Todos
            </a>

            @foreach ($bancos as $banco)
                <a href="{{ url()->current() }}?{{ http_build_query(array_merge($params, ['banco' => $banco->nombre])) }}" 
                class="btn btn-outline-primary {{ $bancoFiltro === $banco->nombre ? 'active' : '' }}">
                    {{ ucfirst($banco->nombre) }}
                </a>
            @endforeach
        </div>
        <a href="bancos" class="btn btn-success mx-2">+ Agregar nuevo banco</a>
    </div>


    {{-- Tabla --}}
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Concepto</th>
                    <th scope="col">Débito</th>
                    <th scope="col">Haber</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($proyecciones as $cheque)
                    <tr>
                        <td>{{ $cheque->fecha }}</td>
                        <td>Cheque * {{ $cheque->numero_cheque }}</td>
                        <td>${{ number_format($cheque->debe, 2, ',', '.') }}</td>
                        <td>${{ number_format($cheque->haber, 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">No hay proyecciones cargadas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @php
        $currentPage = $proyecciones->currentPage();
        $lastPage = $proyecciones->lastPage();
    @endphp

    <nav>
        <ul class="pagination justify-content-center mt-4">
            @for ($i = 1; $i <= $lastPage; $i++)
                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="{{ $proyecciones->url($i) }}">
                        {{ $i }}
                    </a>
                </li>
            @endfor
        </ul>
    </nav>


    <form action="{{ url('/proyecciones/pdf') }}" method="GET" target="_blank" class="mt-3">
        <input type="hidden" name="banco" value="{{ $bancoFiltro }}">
        <input type="hidden" name="desde" value="{{ $desde }}">
        <input type="hidden" name="hasta" value="{{ $hasta }}">

        <button type="submit" class="btn btn-outline-dark">
            🖨️ Imprimir cheques filtrados
        </button>
    </form>
</div>
@endsection
