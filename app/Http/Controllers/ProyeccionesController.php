<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cheque;
use App\Models\Banco;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;

class ProyeccionesController extends Controller
{
    private function buildFilteredQuery(Request $request): Builder
    {
        // CAMBIO AQUÍ: Añadimos with() para cargar las relaciones
        $query = Cheque::with(['factura.proveedor']);

        if ($request->filled('banco')) {
            $bancoFiltro = $request->banco;
            $query->whereHas('cuenta.banco', function ($q) use ($bancoFiltro) {
                $q->where('nombre', $bancoFiltro);
            });
        }

        if ($request->filled('cuenta')) {
            $query->whereHas('cuenta', function ($q) use ($request) {
                $q->where('codigo', $request->cuenta);
            });
        }

        if ($request->filled('desde')) {
            $query->whereDate('fecha', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('fecha', '<=', $request->hasta);
        }

        if ($request->boolean('solo_si')) {
            $query->where('entro', true);
        }

        if ($request->filled('cuenta_id')) {
            $query->where('cuenta_id', $request->cuenta_id);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $bancos = Banco::with('cuentas')->orderBy('nombre')->get();
        $query = $this->buildFilteredQuery($request);

        $queryForTotals = clone $query;
        $totalDebe = $queryForTotals->sum('debe');
        $totalHaber = $queryForTotals->sum('haber');
        $totalNeto = $totalDebe - $totalHaber;

        $proyecciones = $query->orderBy('fecha', 'asc')->paginate(10)->appends($request->query());

        return view('proyeccion_cuentas.index', [
            'proyecciones' => $proyecciones,
            'bancos' => $bancos,
            'totalDebe' => $totalDebe,
            'totalHaber' => $totalHaber,
            'totalNeto' => $totalNeto,
        ]);
    }

    public function exportarPDF(Request $request)
    {
        $query = $this->buildFilteredQuery($request);
        $bancoNombre = $request->input('banco', 'Todos');

        $queryForTotals = clone $query;
        $totalDebe = $queryForTotals->sum('debe');
        $totalHaber = $queryForTotals->sum('haber');
        $totalNeto = $totalDebe - $totalHaber;

        $proyecciones = $query->orderBy('fecha', 'asc')->get();

        $data = [
            'proyecciones' => $proyecciones,
            'bancoNombre' => $bancoNombre,
            'totalDebe' => $totalDebe,
            'totalHaber' => $totalHaber,
            'totalNeto' => $totalNeto,
        ];

        $pdf = Pdf::loadView('proyeccion_cuentas.pdf', $data);

        return $pdf->download('proyecciones_filtradas-' . $bancoNombre . '.pdf');
    }
}