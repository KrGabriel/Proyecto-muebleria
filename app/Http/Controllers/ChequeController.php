<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\CuentaBancaria;
use App\Models\Factura;
use Illuminate\Http\Request;
use App\Models\Proveedor;

class ChequeController extends Controller
{
    public function index(Request $request)
    {
        $query = Cheque::with(['factura.proveedor', 'cuenta.banco']);

        if ($request->filled('fecha_desde')) {
            $query->where('fecha', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fecha', '<=', $request->fecha_hasta);
        }

        if ($request->filled('proveedor')) {
            $query->whereHas('factura.proveedor', function ($q) use ($request) {
                $q->where('codigo', $request->proveedor);
            });
        }

        if ($request->filled('numero_factura')) {
            $query->whereHas('factura', function ($q) use ($request) {
                $q->where('numero', 'like', '%' . $request->numero_factura . '%');
            });
        }

        if ($request->filled('numero_cuenta')) {
            $query->whereHas('cuenta', function ($q) use ($request) {
                $q->where('numero_cuenta', 'like', '%' . $request->numero_cuenta . '%');
            });
        }

        $cheques = $query->orderBy('fecha', 'desc')->paginate(15);
        $proveedores = Proveedor::orderBy('nombre')->get();

        return view('cheques.index', compact('cheques', 'proveedores'));
    }

    public function create()
    {
        $cuentas = CuentaBancaria::all();
        $facturas = Factura::with('proveedor')->get();
        return view('cheques.create', compact('cuentas', 'facturas'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'entro' => 'nullable|boolean',
            'codigo_cuenta' => 'required|exists:cuentas,codigo',
            'numero_cheque' => 'required|string|max:50|unique:cheques,numero_cheque',
            'fecha' => 'required|date',
            'debe' => 'required|numeric|min:0',
            'haber' => 'required|numeric|min:0',
            'codigo_factura' => 'required|exists:facturas,id',  // obligatorio
        ]);

        Cheque::create($validated);
        return redirect()->route('cheques.index')->with('success', 'Cheque creado correctamente.');
    }

    public function edit(Cheque $cheque)
    {
        $cuentas = CuentaBancaria::all();
        $facturas = Factura::all();
        return view('cheques.edit', compact('cheque', 'cuentas', 'facturas'));
    }

    public function update(Request $request, Cheque $cheque)
    {
        $validated = $request->validate([
            'entro' => 'nullable|boolean',
            'codigo_cuenta' => 'required|exists:cuentas,codigo', // corregido
            'numero_cheque' => 'required|string|max:50|unique:cheques,numero_cheque,' . $cheque->id . ',id',
            'fecha' => 'required|date',
            'debe' => 'required|numeric|min:0',
            'haber' => 'required|numeric|min:0',
            'codigo_factura' => 'required|exists:facturas,id', // obligatorio
        ]);
        $cheque->update($validated);

        return redirect()->route('cheques.index')->with('success', 'Cheque actualizado correctamente.');
    }

    public function destroy(Cheque $cheque)
    {
        $cheque->delete();
        return redirect()->route('cheques.index')->with('success', 'Cheque eliminado correctamente.');
    }
}