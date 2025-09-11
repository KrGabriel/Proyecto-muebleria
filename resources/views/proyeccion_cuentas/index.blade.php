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
        {{-- ... El contenido de tu modal de filtros no necesita cambios ... --}}
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
                    <select name="banco" id="bancoSelect" class="form-select">
                        <option value="">Todos</option>
                        @foreach ($bancos as $banco)
                            <option value="{{ $banco->nombre }}" {{ request('banco') === $banco->nombre ? 'selected' : '' }}>
                                {{ ucfirst($banco->nombre) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cuenta</label>
                    <select name="cuenta" id="cuentaSelect" class="form-select">
                        <option value="">Todas</option>
                        @foreach ($bancos as $banco)
                            @foreach ($banco->cuentas as $cuenta)
                                <option value="{{ $cuenta->codigo }}" data-banco="{{ $banco->nombre }}"
                                    {{ request('cuenta') == $cuenta->codigo ? 'selected' : '' }}>
                                    {{ $cuenta->numero_cuenta }}
                                </option>
                            @endforeach
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
                    <th scope="col">¿Entro?</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Concepto</th>
                    <th scope="col" class="text-end">Débito</th>
                    <th scope="col" class="text-end">Haber</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($proyecciones as $cheque)
                    <tr>
                        <td>{{ $cheque->entro ? "Sí" : "No" }}</td>
                        <td>{{ $cheque->fecha->format('d/m/Y') }}</td>
                        
                        <!-- CAMBIO AQUÍ: Se añade el NÚMERO y nombre del proveedor al concepto -->
                        <td>
                            Cheque * {{ $cheque->numero_cheque }}
                            <br>
                            <small class="text-muted">
                                @php
                                    // Asignamos el proveedor a una variable para que el código sea más limpio y legible
                                    $proveedor = optional($cheque->factura)->proveedor;
                                @endphp
                                @if ($proveedor)
                                    Nº {{ $proveedor->codigo }} - {{ $proveedor->nombre }}
                                @else
                                    Sin Proveedor
                                @endif
                            </small>
                        </td>

                        <td class="text-end">${{ number_format($cheque->debe, 2, ',', '.') }}</td>
                        <td class="text-end">${{ number_format($cheque->haber, 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">No hay proyecciones que coincidan con los filtros.</td></tr>
                @endforelse
            </tbody>
            
            <tfoot class="table-group-divider fw-bold">
                <tr>
                    <td colspan="3" class="text-end">TOTALES:</td>
                    <td class="text-end">${{ number_format($totalDebe, 2, ',', '.') }}</td>
                    <td class="text-end">${{ number_format($totalHaber, 2, ',', '.') }}</td>
                </tr>
                <tr class="table-light">
                    <td colspan="3" class="text-end">NETO TOTAL (Débito - Haber):</td>
                    <td colspan="2" class="text-center fs-5">${{ number_format($totalNeto, 2, ',', '.') }}</td>
                </tr>
            </tfoot>

        </table>
    </div>

    @if ($proyecciones->hasPages())
    <nav>
        <ul class="pagination justify-content-center mt-4">
            {{ $proyecciones->links() }}
        </ul>
    </nav>
    @endif

    {{-- El formulario de exportación no se toca --}}
    <form action="{{ url('/proyecciones/exportar-pdf') }}" method="GET" target="_blank" class="mt-3">
        <input type="hidden" name="banco" value="{{ request('banco') }}">
        <input type="hidden" name="cuenta" value="{{ request('cuenta') }}">
        <input type="hidden" name="desde" value="{{ request('desde') }}">
        <input type="hidden" name="hasta" value="{{ request('hasta') }}">
        @if(request('solo_si'))
            <input type="hidden" name="solo_si" value="1">
        @endif

        <button type="submit" class="btn btn-outline-dark">
            Imprimir cheques filtrados
        </button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bancoSelect = document.getElementById('bancoSelect');
        const cuentaSelect = document.getElementById('cuentaSelect');
        const cuentaOptions = Array.from(cuentaSelect.options);

        function filtrarCuentas() {
            const bancoSeleccionado = bancoSelect.value;
            let currentCuentaValue = cuentaSelect.value;

            cuentaSelect.innerHTML = '';
            
            cuentaSelect.appendChild(cuentaOptions.find(opt => opt.value === ''));

            cuentaOptions.forEach(opt => {
                if (opt.value && (bancoSeleccionado === '' || opt.dataset.banco === bancoSeleccionado)) {
                    cuentaSelect.appendChild(opt);
                }
            });

            if (cuentaSelect.querySelector(`option[value="${currentCuentaValue}"]`)) {
                cuentaSelect.value = currentCuentaValue;
            } else {
                cuentaSelect.value = '';
            }
        }

        bancoSelect.addEventListener('change', filtrarCuentas);
        
        filtrarCuentas(); 
    });
</script>
@endsection