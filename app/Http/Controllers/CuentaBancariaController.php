<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CuentaBancaria;
use App\Models\Banco;

class CuentaBancariaController extends Controller
{
    public function index()
    {
        $cuentas = CuentaBancaria::with('banco')->get();
        return view('cuentas.index', compact('cuentas'));
    }

    public function create()
    {
        $bancos = Banco::all();
        return view('cuentas.create', compact('bancos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_banco' => 'required|exists:bancos,id',
            'numero' => 'required|string|max:50|unique:cuenta_bancarias,numero',
            'tipo' => 'required|string|max:50',
        ]);
        CuentaBancaria::create($validated);
        return redirect()->route('cuentas.index')->with('success', 'Cuenta creada correctamente.');
    }

    public function edit(CuentaBancaria $cuenta)
    {
        $bancos = Banco::all();
        return view('cuentas.edit', compact('cuenta', 'bancos'));
    }

    public function update(Request $request, CuentaBancaria $cuenta)
    {
        $validated = $request->validate([
            'codigo_banco' => 'required|exists:bancos,id',
            'numero' => 'required|string|max:50|unique:cuenta_bancarias,numero,' . $cuenta->id,
            'tipo' => 'required|string|max:50',
        ]);
        $cuenta->update($validated);
        return redirect()->route('cuentas.index')->with('success', 'Cuenta actualizada correctamente.');
    }

    public function destroy(CuentaBancaria $cuenta)
    {
        $cuenta->delete();
        return redirect()->route('cuentas.index')->with('success', 'Cuenta eliminada correctamente.');
    }
}