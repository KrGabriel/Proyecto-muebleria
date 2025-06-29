<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cheque;
use App\Models\Banco;
use Barryvdh\DomPDF\Facade\Pdf;

class ProyeccionesController extends Controller
{
    public function index(Request $request)
    {
        $bancos = Banco::orderBy('nombre')->get();

        $query = Cheque::query();

        if ($request->filled('banco')) {
            $bancoFiltro = $request->banco;
            $query->whereHas('cuenta.banco', function ($q) use ($bancoFiltro) {
                $q->where('nombre', $bancoFiltro);
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

        $proyecciones = $query->orderBy('fecha', 'asc')->paginate(10)->appends($request->query());

        return view('proyeccion_cuentas.index', compact('proyecciones', 'bancos'));
    }

    
    public function exportarPDF(Request $request)
    {
        $query = Cheque::query();
        $bancoNombre = null;

        if ($request->filled('banco')) {
            $bancoFiltro = $request->banco;
            $bancoNombre = $bancoFiltro;
            $query->whereHas('cuenta.banco', function ($q) use ($bancoFiltro) {
                $q->where('nombre', $bancoFiltro);
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

        $proyecciones = $query->orderBy('fecha', 'asc')->get();

        $pdf = Pdf::loadView('proyeccion_cuentas.pdf', compact('proyecciones', 'bancoNombre'));
        
        if($bancoNombre == null)
        {
            $bancoNombre = 'Todos';
        }

        return $pdf->download('proyecciones_filtradas-' . $bancoNombre . '.pdf');
    }

}
