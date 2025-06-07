@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Proyecciones</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    @php
        $proyecciones = $proyecciones ?? [
            (object)[
                'codigo' => 1,
                'fecha' => 'Proveedor Ejemplo',
                'concepto' => 'Cheque *',
                'debito' => '$50000',
                'haber' => '$0',
            ],
        ];
    @endphp

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Concepto</th>
                <th>Debito</th>
                <th>Haber</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($proyecciones as $proyeccion)
                <tr>
                    <td>{{ $proyeccion->fecha }}</td>
                    <td>{{ $proyeccion->concepto }}</td>
                    <td>{{ $proyeccion->debito }}</td>
                    <td>{{ $proyeccion->haber }}</td>
                    <td>
                        <a>Editar</a>
                        <form action="">
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No hay proveedores cargados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
