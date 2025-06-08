<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use Illuminate\Http\Request;

class ChequeController extends Controller
{
    public function index()
    {
        return response()->json(
            Cheque::with(['cuenta', 'factura'])->get()
        );
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
        $cheque = Cheque::create($validated);
        return response()->json($cheque, 201);
    }

    public function show(Cheque $cheque)
    {
        return response()->json(
            $cheque->load(['cuenta', 'factura'])
        );
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
        return response()->json($cheque);
    }

    public function destroy(Cheque $cheque)
    {
        $cheque->delete();
        return response()->json(null, 204);
    }
}