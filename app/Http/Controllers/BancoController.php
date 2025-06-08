<?php

namespace App\Http\Controllers;

use App\Models\banco;
use Illuminate\Http\Request;

class BancoController extends Controller
{
    public function index()
    {
        return response()->json(banco::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:bancos,nombre',
        ]);
        $banco = banco::create($validated);
        return response()->json($banco, 201);
    }

    public function show(banco $banco)
    {
        return response()->json($banco);
    }

    public function update(Request $request, banco $banco)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:bancos,nombre,' . $banco->id,
        ]);
        $banco->update($validated);
        return response()->json($banco);
    }

    public function destroy(banco $banco)
    {
        $banco->delete();
        return response()->json(null, 204);
    }
}