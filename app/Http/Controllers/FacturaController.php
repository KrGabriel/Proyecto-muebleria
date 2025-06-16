<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Factura;

class FacturaController extends Controller
{
    /**
     * Muestra una lista de facturas
     */
    public function index()
    {
        $facturas = Factura::orderBy('codigo_proveedor')->orderBy('fecha', 'desc')->paginate(5);
        return view('facturas.index', compact('facturas'));
    }

    /**
     * Muestra un formulario para crear una nueva factura
     */
    public function create()
    {
        $proveedores = \App\Models\Proveedor::orderBy('nombre')->get();
        return view('facturas.create', compact('proveedores'));
    }

    /**
     * Guarda en la base de datos la factura recién creada
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'numero' => 'required|max:50',
            'neto' => 'required|numeric|min:0',
            'tasa' => 'required|numeric|min:0',
            'sobretasa' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'codigo_proveedor' => 'required|exists:proveedores,codigo'
        ]);

        // Crear la nueva factura con los datos validados
        Factura::create($validated);

        // Redirige con mensaje de éxito
        $proveedores = \App\Models\Proveedor::orderBy('nombre')->get();
        return redirect()->route('facturas.index', compact('proveedores'));
    }

    /**
     * Muestra factura específica
     */
    public function show(string $id)
    {
        $factura = Factura::findOrFail($id);
        return view('facturas.show', compact('factura'));
    }

    /**
     * Muestra el formulario para editar una factura seleccionada
     */
    public function edit(string $id)
{
    $factura = Factura::findOrFail($id);
    $proveedores = \App\Models\Proveedor::orderBy('nombre')->get();
    return view('facturas.edit', compact('factura', 'proveedores'));
}

    /**
     * Actualiza la factura que se editó en el formulario anterior
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'numero' => 'required|max:50',
            'neto' => 'required|numeric|min:0',
            'tasa' => 'required|numeric|min:0',
            'sobretasa' => 'nullable|numeric|min:0',
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