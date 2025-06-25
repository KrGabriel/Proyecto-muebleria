@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Editar Cuenta Bancaria</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('cuentas.update', $cuenta->codigo) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Banco:</label>
                        <select name="numero_banco" class="form-select" required>
                            @foreach($bancos as $banco)
                                <option value="{{ $banco->numero }}" @if($cuenta->numero_banco == $banco->numero) selected @endif>{{ $banco->nombre }}</option>
                            @endforeach
                        </select>
                        @error('numero_banco') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número de Cuenta:</label>
                        <input type="text" name="numero_cuenta" class="form-control" value="{{ old('numero_cuenta', $cuenta->numero_cuenta) }}" required>
                        @error('numero_cuenta') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-save"></i> Actualizar
                        </button>
                        <a href="{{ route('bancos.index') }}" class="btn btn-secondary btn-lg">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection