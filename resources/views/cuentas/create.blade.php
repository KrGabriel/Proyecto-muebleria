@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-credit-card"></i> Nueva Cuenta Bancaria</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('cuentas.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="numero_banco" class="form-label">Banco</label>
                            <select name="numero_banco" id="numero_banco" class="form-select" required>
                                <option value="">Seleccione un banco</option>
                                @foreach($bancos as $banco)
                                    <option value="{{ $banco->numero }}" 
                                        {{ old('numero_banco', $bancoSeleccionado) == $banco->numero ? 'selected' : '' }}>
                                        {{ $banco->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('numero_banco')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="numero_cuenta" class="form-label">Número de Cuenta</label>
                            <input type="text" name="numero_cuenta" id="numero_cuenta" 
                                   class="form-control" value="{{ old('numero_cuenta') }}" 
                                   placeholder="Ingrese el número de cuenta" required>
                            @error('numero_cuenta')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alias" class="form-label">Alias (Opcional)</label>
                            <input type="text" name="alias" id="alias" 
                                   class="form-control" value="{{ old('alias') }}" 
                                   placeholder="Alias para la cuenta">
                            @error('alias')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-save"></i> Guardar
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
</div>
@endsection