@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Nueva Cuenta Bancaria</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('cuentas.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Banco:</label>
                        <select name="numero_banco" class="form-select" required>
                            @foreach($bancos as $banco)
                                <option value="{{ $banco->numero }}">{{ $banco->nombre }}</option>
                            @endforeach
                        </select>
                        @error('numero_banco') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número de Cuenta:</label>
                        <input type="text" name="numero_cuenta" class="form-control" value="{{ old('numero') }}" required>
                        @error('numero') <div class="text-danger">{{ $message }}</div> @enderror
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
@endsection