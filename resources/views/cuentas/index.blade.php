@extends('layouts.app')

@section('content')
<h1>Cuentas Bancarias</h1>

<div id="alert-container"></div>

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#cuentaModal" id="btnNuevaCuenta" title="Crear nueva cuenta">
    Nueva Cuenta
</button>

<input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar...">

<table class="table" id="cuentasTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Banco</th>
            <th>Número</th>
            <th>Tipo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach($cuentas as $cuenta)
        <tr data-id="{{ $cuenta->id }}">
            <td>{{ $cuenta->id }}</td>
            <td>{{ $cuenta->banco->nombre }}</td>
            <td>{{ $cuenta->numero }}</td>
            <td>{{ $cuenta->tipo }}</td>
            <td>
                <button class="btn btn-sm btn-warning btn-edit" data-id="{{ $cuenta->id }}" title="Editar cuenta" data-bs-toggle="tooltip">
                    Editar
                </button>
                <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $cuenta->id }}" title="Eliminar cuenta" data-bs-toggle="tooltip">
                    Eliminar
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<!-- Crear/Editar Cuenta -->
<div class="modal fade" id="cuentaModal" tabindex="-1" aria-labelledby="cuentaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cuentaModalLabel">Cuenta Bancaria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="cuentaForm">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="id" id="cuentaId">
            <div class="mb-3">
                <label class="form-label">Banco:</label>
                <select name="codigo_banco" id="codigo_banco" class="form-select">
                    @foreach($bancos as $banco)
                        <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Número:</label>
                <input type="text" name="numero" id="numero" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Tipo:</label>
                <input type="text" name="tipo" id="tipo" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">
                Guardar
                <span class="spinner-border spinner-border-sm d-none" id="formSpinner"></span>
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Confirmar Eliminar -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas eliminar esta cuenta?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
tooltipTriggerList.forEach(function (tooltipTriggerEl) {
  new bootstrap.Tooltip(tooltipTriggerEl)
})

document.getElementById('searchInput').addEventListener('keyup', function() {
    let value = this.value.toLowerCase();
    document.querySelectorAll('#cuentasTable tbody tr').forEach(function(row) {
        row.style.display = row.textContent.toLowerCase().includes(value) ? '' : 'none';
    });
});

let cuentaIdToDelete = null;

document.getElementById('btnNuevaCuenta').addEventListener('click', function() {
    limpiarFormulario();
    document.getElementById('cuentaModalLabel').innerText = 'Nueva Cuenta Bancaria';
    document.getElementById('formMethod').value = 'POST';
});

document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function() {
        let id = this.getAttribute('data-id');
        fetch(`/cuentas/${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('cuentaModalLabel').innerText = 'Editar Cuenta Bancaria';
                document.getElementById('formMethod').value = 'PUT';
                document.getElementById('cuentaId').value = data.id;
                document.getElementById('codigo_banco').value = data.codigo_banco;
                document.getElementById('numero').value = data.numero;
                document.getElementById('tipo').value = data.tipo;
                var cuentaModal = new bootstrap.Modal(document.getElementById('cuentaModal'));
                cuentaModal.show();
            });
    });
});

document.getElementById('cuentaForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let spinner = document.getElementById('formSpinner');
    spinner.classList.remove('d-none');
    let formData = new FormData(this);
    let method = document.getElementById('formMethod').value;
    let id = document.getElementById('cuentaId').value;
    let url = method === 'POST' ? '/cuentas' : `/cuentas/${id}`;
    fetch(url, {
        method: method === 'POST' ? 'POST' : 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        spinner.classList.add('d-none');
        if (data.errors) {
            mostrarAlerta('danger', Object.values(data.errors).join('<br>'));
        } else {
            mostrarAlerta('success', 'Cuenta guardada correctamente');
            location.reload();
        }
    })
    .catch(() => {
        spinner.classList.add('d-none');
        mostrarAlerta('danger', 'Error al guardar');
    });
});

document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
        cuentaIdToDelete = this.getAttribute('data-id');
        var deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        deleteModal.show();
    });
});

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    fetch(`/cuentas/${cuentaIdToDelete}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        mostrarAlerta('success', 'Cuenta eliminada correctamente');
        location.reload();
    })
    .catch(() => {
        mostrarAlerta('danger', 'Error al eliminar');
    });
});

function limpiarFormulario() {
    document.getElementById('cuentaForm').reset();
    document.getElementById('cuentaId').value = '';
}

function mostrarAlerta(tipo, mensaje) {
    let alertContainer = document.getElementById('alert-container');
    alertContainer.innerHTML = `<div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>`;
}
</script>
@endpush