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
