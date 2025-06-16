<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProveedorController extends Controller
{
    /**
     * Muestra una lista de proveedores
     */
    public function index()
    {
        $proveedores = Proveedor::orderBy('nombre')->paginate(5); // o la cantidad que prefieras
        return view('proveedores.index', compact('proveedores'));
    }

    /**
     * Muestra un formulario para crear un nuevo proveedor
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Guarda en la base de datos el proveedor recién creado
     */
    public function store(Request $request)
    {
        //Valida los datos que se ingresan
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:30',
            'localidad' => 'nullable|string|max:50',
            'provincia' => 'nullable|string|max:50',
            'fecha_ultima_compra' => 'nullable|date',
        ]);

        //Crear el nuevo proveedor con los datos validados
        Proveedor::create($validated);

        //Redirige con un mensaje de exito
        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor creado de manera correcta');
    }

    /**
     * Mostrar un proveedor
     */
    public function show(string $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.show', compact('proveedor'));
    }

    /**
     * Muestra el formulario para editar a un proveedor seleccionado
     */
    public function edit(string $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.edit', compact('proveedor'));
    }

    /**
     * Actualiza el proveedor que se editó en el formulario anterior
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:30',
            'localidad' => 'nullable|string|max:50',
            'provincia' => 'nullable|string|max:50',
            'fecha_ultima_compra' => 'nullable|date'
        ]);
        
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado.');
    }

    /**
     * Elimina un proveedor especifico
     */
    public function destroy(string $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado');
    }



}