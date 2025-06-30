<?php

namespace App\Http\Controllers;

use App\Models\CuentaBancaria;
use App\Models\Banco;
use Illuminate\Http\Request;

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
            'numero_banco' => 'required|exists:bancos,numero',
            'numero_cuenta' => 'required|string|max:255',
        ]);
        CuentaBancaria::create($validated);
        return redirect()->route('bancos.index')->with('success', 'Cuenta creada correctamente.');
    }

    public function edit(CuentaBancaria $cuenta)
    {
        $bancos = Banco::all();
        return view('cuentas.edit', compact('cuenta', 'bancos'));
    }

    public function update(Request $request, CuentaBancaria $cuenta)
    {
        $validated = $request->validate([
            'numero_banco' => 'required|exists:bancos,numero',
            'numero_cuenta' => 'required|string|max:255',
            'alias' => 'nullable|string|max:255'
        ]);
        $cuenta->update($validated);
        return redirect()->route('bancos.index')->with('success', 'Cuenta actualizada correctamente.');
    }

    public function destroy(CuentaBancaria $cuenta)
    {
        $cuenta->delete();
        return redirect()->route('bancos.index')->with('success', 'Cuenta eliminada correctamente.');
    }
}