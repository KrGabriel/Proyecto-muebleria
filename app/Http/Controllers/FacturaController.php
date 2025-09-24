<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    /**
     * Muestra una lista de facturas
     */
    public function index(Request $request)
    {
        $query = Factura::with(['proveedor', 'cheques']);

        if ($request->filled('fecha_desde')) {
            $query->where('fecha', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->where('fecha', '<=', $request->fecha_hasta);
        }

        if ($request->filled('proveedor')) {
            $query->whereHas('proveedor', function ($q) use ($request) {
                $q->where('nombre', 'ilike', '%' . $request->proveedor . '%');
            });
}
        if ($request->filled('numero_factura')) {
            $query->where('numero', 'like', '%' . $request->numero_factura . '%');
        }

        $facturas = $query->orderBy('fecha', 'desc')->paginate(15);
        $proveedores = Proveedor::where('activo', true)->orderBy('nombre')->get();

        return view('facturas.index', compact('facturas', 'proveedores'));
    }


    public function create()
    {
        $proveedores = \App\Models\Proveedor::where('activo', true)->orderBy('nombre')->get();
        return view('facturas.create', compact('proveedores'));
    }

    public function buscar(Request $request)
    {   
        $query = $request->input('q');

        $facturas = DB::table('facturas')
            ->join('proveedores', 'facturas.codigo_proveedor', '=', 'proveedores.codigo')
            ->where(function ($q) use ($query) {
                $q->where('facturas.numero', 'ILIKE', "%{$query}%")
                ->orWhere('proveedores.nombre', 'ILIKE', "%{$query}%");
            })
            ->limit(10)
            ->get([
                'facturas.id',
                'facturas.numero',
                'facturas.codigo_proveedor',
                'proveedores.nombre as nombre_proveedor'
            ]);

        return response()->json($facturas);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'numero' => 'required|max:50',            
            'total' => 'required|numeric|min:0',
            'codigo_proveedor' => 'required|exists:proveedores,codigo'
        ]);
        $factura = Factura::create($validated);

        $proveedor = \App\Models\Proveedor::where('codigo', $factura->codigo_proveedor)->first();
        if ($proveedor) {
            $proveedor->fecha_ultima_compra = $factura->fecha;
            $proveedor->save();
        }

        return redirect()->route('facturas.index')
            ->with('success', 'Factura creada correctamente.');
    }

    public function edit($id)
    {
        $factura = Factura::findOrFail($id);
        $proveedores = \App\Models\Proveedor::where('activo', true)->orderBy('nombre')->get();
        return view('facturas.edit', compact('factura', 'proveedores'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'numero' => 'required|max:50',
            'total' => 'required|numeric|min:0',
            'codigo_proveedor' => 'required|exists:proveedores,codigo'
        ]);

        $factura = Factura::findOrFail($id);
        $proveedorAnterior = $factura->codigo_proveedor;
        $factura->update($request->all());

        // Si cambió el proveedor, actualiza ambos
        if ($proveedorAnterior != $factura->codigo_proveedor) {
            // Actualiza el proveedor nuevo
            $proveedorNuevo = \App\Models\Proveedor::where('codigo', $factura->codigo_proveedor)->first();
            if ($proveedorNuevo) {
                $proveedorNuevo->fecha_ultima_compra = $factura->fecha;
                $proveedorNuevo->save();
            }
            // Opcional: recalcula la última compra del proveedor anterior
            $ultimaFactura = \App\Models\Factura::where('codigo_proveedor', $proveedorAnterior)
                ->orderBy('fecha', 'desc')->first();
            $proveedorAnt = \App\Models\Proveedor::where('codigo', $proveedorAnterior)->first();
            if ($proveedorAnt) {
                $proveedorAnt->fecha_ultima_compra = $ultimaFactura ? $ultimaFactura->fecha : null;
                $proveedorAnt->save();
            }
        } else {
            // Si no cambió, solo actualiza la fecha de última compra
            $proveedor = \App\Models\Proveedor::where('codigo', $factura->codigo_proveedor)->first();
            if ($proveedor) {
                $proveedor->fecha_ultima_compra = $factura->fecha;
                $proveedor->save();
            }
        }

        return redirect()->route('facturas.index')
            ->with('success', 'Factura actualizada de manera exitosa.');
    }

    /**
     * Elimina una factura especificada
     */
    public function destroy(string $id)
    {
        $factura = Factura::findOrFail($id);
        $factura->cheques()->delete();
        $factura->delete();

        return redirect()->route('facturas.index')
            ->with('success', 'Factura eliminada de manera exitosa.');
    }

    public function show($id)
    {
        $factura = \App\Models\Factura::with('proveedor')->findOrFail($id);
        return view('facturas.show', compact('factura'));
    }
}