<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/proyecciones', function () {
    return view('proyeccion_cuentas/index');
});

Route::get('/proveedores', function () {
    return view('proveedores/index');
});
