<?php
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/proyecciones', function () {
    return view('proyeccion_cuentas/index');
});

Route::get('/proveedores', function () {
    return view('proveedores/index');
});

Route::get('/proyecciones/pdf', function () {
    $banco = request('banco');
    $desde = request('desde');
    $hasta = request('hasta');

    $proyecciones = [
        (object)[ 'codigo' => 1, 'fecha' => '2025-06-01', 'concepto' => 'Cheque *', 'debito' => '$50000', 'haber' => '$0', 'banco' => 'nación' ],
        (object)[ 'codigo' => 2, 'fecha' => '2025-06-02', 'concepto' => 'Cheque *', 'debito' => '$50000', 'haber' => '$0', 'banco' => 'macro' ],
        (object)[ 'codigo' => 3, 'fecha' => '2025-06-03', 'concepto' => 'Cheque *', 'debito' => '$50000', 'haber' => '$0', 'banco' => 'santander' ],
    ];

    $proyecciones = array_filter($proyecciones, function ($p) use ($banco, $desde, $hasta) {
        $ok = true;

        if ($banco) {
            $ok = $ok && $p->banco === $banco;
        }

        if ($desde) {
            $ok = $ok && Carbon::parse($p->fecha) >= Carbon::parse($desde);
        }

        if ($hasta) {
            $ok = $ok && Carbon::parse($p->fecha) <= Carbon::parse($hasta);
        }

        return $ok;
    });

    $pdf = Pdf::loadView('proyeccion_cuentas.pdf', compact('proyecciones'));

    return $pdf->download('proyecciones_filtradas.pdf');
});