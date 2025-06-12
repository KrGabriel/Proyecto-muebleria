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
        $cheques = Cheque::with(['cuenta', 'factura'])->get();
        return view('cheques.index', compact('cheques'));
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
            'codigo_cuenta' => 'required|exists:cuenta_bancarias,id',
            'codigo_factura' => 'nullable|exists:facturas,id',
            'numero' => 'required|string|max:50|unique:cheques,numero',
            'debe' => 'required|numeric|min:0',
            'haber' => 'required|numeric|min:0',
            'fecha_emision' => 'required|date',
            'fecha_pago' => 'required|date|after_or_equal:fecha_emision',
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
            'codigo_cuenta' => 'required|exists:cuenta_bancarias,id',
            'codigo_factura' => 'nullable|exists:facturas,id',
            'numero' => 'required|string|max:50|unique:cheques,numero,' . $cheque->id,
            'debe' => 'required|numeric|min:0',
            'haber' => 'required|numeric|min:0',
            'fecha_emision' => 'required|date',
            'fecha_pago' => 'required|date|after_or_equal:fecha_emision',
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