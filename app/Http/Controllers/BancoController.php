<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;

class BancoController extends Controller
{
public function index()
    {
        $bancos = Banco::with('cuentas')->get(); // Eager loading
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
            'comentario' => 'nullable|string',
        ]);
        Banco::create($validated);
        return redirect()->route('bancos.index')->with('success', 'Banco creado correctamente.');
    }

    public function edit(Banco $banco)
    {
        return view('bancos.edit', compact('banco'));
    }

    public function update(Request $request, Banco $banco)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:bancos,nombre,' . $banco->numero . ',numero',
            'comentario' => 'nullable|string',
        ]);
        $banco->update($validated);
        return redirect()->route('bancos.index')->with('success', 'Banco actualizado correctamente.');
    }

    public function destroy(Banco $banco)
    {
        $banco->delete();
        return redirect()->route('bancos.index')->with('success', 'Banco eliminado correctamente.');
    }
}