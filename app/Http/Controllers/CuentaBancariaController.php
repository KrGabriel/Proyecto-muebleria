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
        $bancos = Banco::all();
        return view('cuentas.index', compact('cuentas', 'bancos'));
    }

    public function show($id)
    {
        $cuenta = CuentaBancaria::findOrFail($id);
        return response()->json($cuenta);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_banco' => 'required|exists:bancos,id',
            'numero' => 'required|string|max:50|unique:cuenta_bancarias,numero',
            'tipo' => 'required|string|max:50',
        ]);
        $cuenta = CuentaBancaria::create($validated);
        return response()->json($cuenta);
    }

    public function update(Request $request, $id)
    {
        $cuenta = CuentaBancaria::findOrFail($id);
        $validated = $request->validate([
            'codigo_banco' => 'required|exists:bancos,id',
            'numero' => 'required|string|max:50|unique:cuenta_bancarias,numero,' . $id,
            'tipo' => 'required|string|max:50',
        ]);
        $cuenta->update($validated);
        return response()->json($cuenta);
    }

    public function destroy($id)
    {
        $cuenta = CuentaBancaria::findOrFail($id);
        $cuenta->delete();
        return response()->json(['success' => true]);
    }
}