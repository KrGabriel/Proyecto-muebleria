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

    <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
        <form method="GET">
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#filtroModal">
                Filtrar
            </button>
        </form>

        @if(request()->hasAny(['desde', 'hasta', 'banco', 'solo_si']))
            <div class="p-2 border rounded bg-light small d-flex flex-wrap align-items-center gap-2">
                <strong class="me-2">Parámetros:</strong>
                @if(request('desde'))
                    <span>Desde: {{ request('desde') }}</span>
                @endif
                @if(request('hasta'))
                    <span>Hasta: {{ request('hasta') }}</span>
                @endif
                @if(request('banco'))
                    <span>Banco: {{ ucfirst(request('banco')) }}</span>
                @endif
                @if(request()->filled('solo_si'))
                    <span>Solo si: {{ request('solo_si') == '1' ? 'Sí' : 'No' }}</span>
                @endif
            </div>
        @endif
    </div>

    <div class="modal fade" id="filtroModal" tabindex="-1" aria-labelledby="filtroModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="GET" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filtroModalLabel">Filtrar Proyecciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="desde" class="form-label">Desde</label>
                    <input type="date" name="desde" value="{{ request('desde') }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="hasta" class="form-label">Hasta</label>
                    <input type="date" name="hasta" value="{{ request('hasta') }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Banco</label>
                    <select name="banco" class="form-select">
                        <option value="">Todos</option>
                        @foreach ($bancos as $banco)
                            <option value="{{ $banco->nombre }}" {{ request('banco') === $banco->nombre ? 'selected' : '' }}>
                                {{ ucfirst($banco->nombre) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">¿Solo si?</label>
                    <input type="checkbox" name="solo_si" value="1" {{ request('solo_si') ? 'checked' : '' }}>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
            </form>
        </div>
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


    <form action="{{ url('/proyecciones/exportar-pdf') }}" method="GET" target="_blank" class="mt-3">
        <input type="hidden" name="banco" value="{{ $bancoFiltro }}">
        <input type="hidden" name="desde" value="{{ $desde }}">
        <input type="hidden" name="hasta" value="{{ $hasta }}">
        @if(request('solo_si'))
            <input type="hidden" name="solo_si" value="1">
        @endif

        <button type="submit" class="btn btn-outline-dark">
            🖨️ Imprimir cheques filtrados
        </button>
    </form>
</div>
@endsection
