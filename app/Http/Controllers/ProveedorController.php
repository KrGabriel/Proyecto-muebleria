<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    /**
     * Muestra una lista de proveedores
     */
    public function index()
    {
        $proveedores = Proveedor::where('activo', true)->orderBy('nombre')->paginate(15); // o la cantidad que se te cante el culo
        return view('proveedores.index', compact('proveedores'));
    }

    /**
     * Muestra un formulario para crear un nuevo proveedor
     */
    public function create()
    {
        $ultimoNumero = \App\Models\Proveedor::max('numero_proveedor');
        $siguienteNumero = $ultimoNumero ? $ultimoNumero + 1 : 1; // Si no hay proveedores, empieza desde 1
        return view('proveedores.create', compact('siguienteNumero'));
    }

    /**
     * Guarda en la base de datos el proveedor recién creado
     */
    public function store(Request $request)
    {
        //Valida los datos que se ingresan
        $validated = $request->validate([
            'numero_proveedor' => 'required|string|max:50|unique:proveedores,numero_proveedor',
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

    public function buscar(Request $request)
    {
        $query = $request->input('q');

        $proveedores = DB::table('proveedores')
            ->where('nombre', 'ILIKE', "%{$query}%")
            ->where('activo', true)
            ->limit(10)
            ->get(['codigo', 'nombre']);

        return response()->json($proveedores);
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
        $proveedor->activo = false; // Desactiva el proveedor en lugar de eliminarlo
        $proveedor->save();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado.');
    }



}