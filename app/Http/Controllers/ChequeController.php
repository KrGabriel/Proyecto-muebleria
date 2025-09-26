<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\CuentaBancaria;
use App\Models\Factura;
use Illuminate\Http\Request;
use App\Models\Proveedor;

class ChequeController extends Controller
{
    public function index(Request $request)
    {
        $query = Cheque::with(['factura.proveedor', 'cuenta.banco']);

        if ($request->filled('fecha_desde')) {
            $query->where('fecha', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fecha', '<=', $request->fecha_hasta);
        }

        if ($request->filled('proveedor')) {
            $query->whereHas('factura.proveedor', function ($q) use ($request) {
                $q->where('codigo', $request->proveedor);
            });
        }

        if ($request->filled('numero_factura')) {
            $query->whereHas('factura', function ($q) use ($request) {
                $q->where('numero', 'like', '%' . $request->numero_factura . '%');
            });
        }

        if ($request->filled('numero_cuenta')) {
            $query->whereHas('cuenta', function ($q) use ($request) {
                $q->where('numero_cuenta', 'like', '%' . $request->numero_cuenta . '%');
            });
        }

        $cheques = $query->orderBy('fecha', 'desc')->paginate(15);
        $proveedores = Proveedor::orderBy('nombre')->get();

        return view('cheques.index', compact('cheques', 'proveedores'));
    }

    public function create(Request $request)
    {
        $cuentas = CuentaBancaria::all();
        $facturas = Factura::with('proveedor')->get();

        $numeroFactura = $request->input('numero_factura');
        $facturaSeleccionadaId = null;
        $proveedorSeleccionado = null;

        if ($request->has('factura')) {
            $facturaId = $request->input('factura');
            $factura = Factura::find($facturaId);
            if ($factura) {
                $facturaSeleccionadaId = $factura->id;
                $proveedorSeleccionado = $factura->codigo_proveedor;
            }
        } elseif ($numeroFactura) {
            $factura = Factura::where('numero', $numeroFactura)->first();
            if ($factura) {
                $facturaSeleccionadaId = $factura->id;
                $proveedorSeleccionado = $factura->codigo_proveedor;
            }
        } else {
            $proveedorSeleccionado = $request->input('proveedor');
            $facturaSeleccionadaId = $request->input('factura_id');
        }

        $cuentaSeleccionada = $request->input('cuenta');

        return view('cheques.create', compact(
            'cuentas',
            'facturas',
            'proveedorSeleccionado',
            'cuentaSeleccionada',
            'facturaSeleccionadaId'
        ));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'entro' => 'nullable|boolean',
            'fecha_entrada' => 'nullable|date',
            'codigo_cuenta' => 'required|exists:cuentas,codigo',
            'numero_cheque' => 'required|string|max:50', 
            'fecha' => 'required|date',
            'debe' => 'required|numeric|min:0',
            'haber' => 'required|numeric|min:0',
            'codigo_factura' => 'required|exists:facturas,id',
        ]);

        $validated['entro'] = $request->has('entro');

        if ($validated['entro'] && empty($validated['fecha_entrada'])) {
            $validated['fecha_entrada'] = now()->toDateString();
        }

        $cheque = Cheque::create($validated);

        if ($request->input('continuar') == '1') {
            if (!session()->has('cheque_return_url')) {
                session(['cheque_return_url' => $request->input('previous_url', route('facturas.index'))]);
            }
            
            return redirect()->route('cheques.create', [
                'proveedor' => optional($cheque->factura)->codigo_proveedor,
                'cuenta' => $cheque->codigo_cuenta,
                'factura_id' => $cheque->codigo_factura,
            ])->with('success', 'Cheque guardado. Ahora podés cargar otro.');
        }

        $returnUrl = session('cheque_return_url', route('facturas.index'));
        session()->forget('cheque_return_url');
        
        return redirect($returnUrl)
            ->with('success', 'Cheque creado correctamente.');
    }

    public function edit(Cheque $cheque)
    {
        $cuentas = CuentaBancaria::all();
        $facturas = Factura::with('proveedor')->get();
        return view('cheques.edit', compact('cheque', 'cuentas', 'facturas'));
    }

    public function update(Request $request, Cheque $cheque)
    {
        $validated = $request->validate([
            'entro' => 'nullable|boolean',
            'fecha_entrada' => 'nullable|date',
            'codigo_cuenta' => 'required|exists:cuentas,codigo',
            'numero_cheque' => 'required|string|max:50',
            'fecha' => 'required|date',
            'debe' => 'required|numeric|min:0',
            'haber' => 'required|numeric|min:0',
            'codigo_factura' => 'required|exists:facturas,id',
        ]);
        
        $validated['entro'] = $request->has('entro');
        
        if ($validated['entro'] && !$cheque->entro) {
            $validated['fecha_entrada'] = now()->toDateString();
        }

        elseif (!$validated['entro'] && $cheque->entro) {
            $validated['fecha_entrada'] = null;
        }

        else {
            $validated['fecha_entrada'] = $cheque->fecha_entrada;
        }

        $cheque->update($validated);

        $redirectUrl = $request->input('previous_url', route('cheques.index'));
        return redirect($redirectUrl)->with('success', 'Cheque actualizado correctamente.');
    }

    public function destroy(Cheque $cheque)
    {
        $cheque->delete();
        return redirect()->back()->with('success', 'Cheque eliminado correctamente.');
    }
}