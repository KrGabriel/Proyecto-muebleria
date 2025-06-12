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
                        <select name="codigo_banco" class="form-select" required>
                            @foreach($bancos as $banco)
                                <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                            @endforeach
                        </select>
                        @error('codigo_banco') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número:</label>
                        <input type="text" name="numero" class="form-control" value="{{ old('numero') }}" placeholder="Número de cuenta" required>
                        @error('numero') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo:</label>
                        <input type="text" name="tipo" class="form-control" value="{{ old('tipo') }}" placeholder="Tipo de cuenta" required>
                        @error('tipo') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-save"></i> Guardar
                        </button>
                        <a href="{{ route('cuentas.index') }}" class="btn btn-secondary btn-lg">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection