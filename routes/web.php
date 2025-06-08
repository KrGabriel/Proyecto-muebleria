<?php
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

use App\Http\Controllers\BancoController;
use App\Http\Controllers\CuentaBancariaController;
use App\Http\Controllers\ChequeController;

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

Route::get('/banco', function () {
    return view('bancos/index');
});

Route::get('/cuenta', function () {
    return view('cuentas/index');
});

Route::get('/cheque', function () {
    return view('cheques/index');
});

// Bancos
Route::get('/bancos', [BancoController::class, 'index'])->name('bancos.index');
Route::get('/bancos/{id}', [BancoController::class, 'show']);
Route::post('/bancos', [BancoController::class, 'store']);
Route::post('/bancos/{id}', [BancoController::class, 'update']);
Route::delete('/bancos/{id}', [BancoController::class, 'destroy']);

// Cuentas
Route::get('/cuentas', [CuentaBancariaController::class, 'index'])->name('cuentas.index');
Route::get('/cuentas/{id}', [CuentaBancariaController::class, 'show']);
Route::post('/cuentas', [CuentaBancariaController::class, 'store']);
Route::post('/cuentas/{id}', [CuentaBancariaController::class, 'update']);
Route::delete('/cuentas/{id}', [CuentaBancariaController::class, 'destroy']);

// Cheques
Route::get('/cheques', [ChequeController::class, 'index'])->name('cheques.index');
Route::get('/cheques/{id}', [ChequeController::class, 'show']);
Route::post('/cheques', [ChequeController::class, 'store']);
Route::post('/cheques/{id}', [ChequeController::class, 'update']);
Route::delete('/cheques/{id}', [ChequeController::class, 'destroy']);
