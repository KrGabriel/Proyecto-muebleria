<?php

namespace App\Http\Controllers;

use App\Models\banco;
use Illuminate\Http\Request;

class BancoController extends Controller
{
    public function index()
    {
        $bancos = banco::all();
        return view('bancos.index', compact('bancos'));
    }

    public function create()
    {
        return view('bancos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:bancos,nombre',
        ]);
        banco::create($validated);
        return redirect()->route('bancos.index')->with('success', 'Banco creado correctamente.');
    }

    public function edit(banco $banco)
    {
        return view('bancos.edit', compact('banco'));
    }

    public function update(Request $request, banco $banco)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:bancos,nombre,' . $banco->id,
        ]);
        $banco->update($validated);
        return redirect()->route('bancos.index')->with('success', 'Banco actualizado correctamente.');
    }

    public function destroy(banco $banco)
    {
        $banco->delete();
        return redirect()->route('bancos.index')->with('success', 'Banco eliminado correctamente.');
    }
}