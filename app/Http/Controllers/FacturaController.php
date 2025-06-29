<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Proveedor;

class FacturaController extends Controller
{
    /**
     * Muestra una lista de facturas
     */
    public function index(Request $request)
    {
        $query = Factura::with('proveedor');

        if ($request->filled('fecha_desde')) {
            $query->where('fecha', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->where('fecha', '<=', $request->fecha_hasta);
        }
        if ($request->filled('proveedor')) {
            $query->where('codigo_proveedor', $request->proveedor);
        }
        if ($request->filled('numero_factura')) {
            $query->where('numero', 'like', '%' . $request->numero_factura . '%');
        }

        $facturas = $query->orderBy('fecha', 'desc')->paginate(15);
        $proveedores = \App\Models\Proveedor::where('activo', true)->orderBy('nombre')->get();

        return view('facturas.index', compact('facturas', 'proveedores'));
    }

    public function create()
    {
        $proveedores = \App\Models\Proveedor::where('activo', true)->orderBy('nombre')->get();
        return view('facturas.create', compact('proveedores'));
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

        return redirect()->route('cheques.create', ['factura_id' => $factura->id])
            ->with('success', 'Factura creada. Ahora agregue los cheques.');
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
        $factura->update($request->all());

        return redirect()->route('facturas.index')
            ->with('success', 'Factura actualizada de manera exitosa.');
    }

    /**
     * Elimina una factura especificada
     */
    public function destroy(string $id)
    {
        $factura = Factura::findOrFail($id);
        $factura->delete();

        return redirect()->route('facturas.index')
            ->with('success', 'Factura eliminada de manera exitosa.');
    }
}