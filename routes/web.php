<?php
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

use App\Http\Controllers\BancoController;
use App\Http\Controllers\CuentaBancariaController;
use App\Http\Controllers\ChequeController;
use App\Http\Controllers\ProyeccionesController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/proyecciones', [ProyeccionesController::class, 'index'])->name('proyecciones.index');

Route::get('/proveedores', function () {
    return view('proveedores/index');
});

Route::get('/proyecciones/pdf', [ProyeccionesController::class, 'exportarPDF']);

Route::resource('bancos', BancoController::class);
Route::resource('cuentas', CuentaBancariaController::class);
Route::resource('cheques', ChequeController::class);
