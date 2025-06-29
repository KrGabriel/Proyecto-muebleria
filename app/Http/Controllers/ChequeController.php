<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\CuentaBancaria;
use App\Models\Factura;
use Illuminate\Http\Request;

class ChequeController extends Controller
{
    public function index()
    {
        $cheques = Cheque::with(['cuenta', 'factura'])->orderBy('fecha', 'desc')->paginate(5);
        $cuentas = CuentaBancaria::all();
        return view('cheques.index', compact('cheques', 'cuentas'));
    }

    public function create()
    {
        $cuentas = CuentaBancaria::all();
        $facturas = Factura::all();
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
            'codigo_factura' => 'nullable|exists:facturas,id',
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
            'codigo_cuenta' => 'required|exists:cuentas,codigo',
            'numero_cheque' => 'required|string|max:50|unique:cheques,numero_cheque,' . $cheque->id . ',id',
            'fecha' => 'required|date',
            'debe' => 'required|numeric|min:0',
            'haber' => 'required|numeric|min:0',
            'codigo_factura' => 'nullable|exists:facturas,id',
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