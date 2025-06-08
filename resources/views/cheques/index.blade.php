@extends('layouts.app')

@section('content')
<h1>Cheques</h1>

<!-- Alertas -->
<div id="alert-container"></div>

<!-- Botón con tooltip -->
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#chequeModal" id="btnNuevoCheque" title="Crear nuevo cheque">
    Nuevo Cheque
</button>

<!-- Búsqueda -->
<input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar...">

<table class="table" id="chequesTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cuenta</th>
            <th>Factura</th>
            <th>Número</th>
            <th>Debe</th>
            <th>Haber</th>
            <th>Fecha Emisión</th>
            <th>Fecha Pago</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach($cheques as $cheque)
        <tr data-id="{{ $cheque->id }}">
            <td>{{ $cheque->id }}</td>
            <td>{{ $cheque->cuenta->numero }}</td>
            <td>{{ $cheque->factura ? $cheque->factura->numero : '-' }}</td>
            <td>{{ $cheque->numero }}</td>
            <td>{{ $cheque->debe }}</td>
            <td>{{ $cheque->haber }}</td>
            <td>{{ $cheque->fecha_emision }}</td>
            <td>{{ $cheque->fecha_pago }}</td>
            <td>
                <button class="btn btn-sm btn-warning btn-edit" data-id="{{ $cheque->id }}" title="Editar cheque" data-bs-toggle="tooltip">
                    Editar
                </button>
                <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $cheque->id }}" title="Eliminar cheque" data-bs-toggle="tooltip">
                    Eliminar
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<!-- Crear/Editar Cheque -->
<div class="modal fade" id="chequeModal" tabindex="-1" aria-labelledby="chequeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="chequeModalLabel">Cheque</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="chequeForm">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="id" id="chequeId">
            <div class="mb-3">
                <label class="form-label">Cuenta Bancaria:</label>
                <select name="codigo_cuenta" id="codigo_cuenta" class="form-select">
                    @foreach($cuentas as $cuenta)
                        <option value="{{ $cuenta->id }}">{{ $cuenta->numero }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Factura:</label>
                <select name="codigo_factura" id="codigo_factura" class="form-select">
                    <option value="">Sin factura</option>
                    @foreach($facturas as $factura)
                        <option value="{{ $factura->id }}">{{ $factura->numero }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Número:</label>
                <input type="text" name="numero" id="numero" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Debe:</label>
                <input type="number" name="debe" id="debe" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Haber:</label>
                <input type="number" name="haber" id="haber" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Fecha Emisión:</label>
                <input type="date" name="fecha_emision" id="fecha_emision" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Fecha Pago:</label>
                <input type="date" name="fecha_pago" id="fecha_pago" class="form-control">
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

<!-- Confirmación para eliminar -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas eliminar este cheque?
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
// Tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
tooltipTriggerList.forEach(function (tooltipTriggerEl) {
  new bootstrap.Tooltip(tooltipTriggerEl)
})

// Búsqueda
document.getElementById('searchInput').addEventListener('keyup', function() {
    let value = this.value.toLowerCase();
    document.querySelectorAll('#chequesTable tbody tr').forEach(function(row) {
        row.style.display = row.textContent.toLowerCase().includes(value) ? '' : 'none';
    });
});

// Variables globales para el cheque a eliminar
let chequeIdToDelete = null;

// Abrir crear cheque
document.getElementById('btnNuevoCheque').addEventListener('click', function() {
    limpiarFormulario();
    document.getElementById('chequeModalLabel').innerText = 'Nuevo Cheque';
    document.getElementById('formMethod').value = 'POST';
});

// Abrir editar cheque
document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function() {
        let id = this.getAttribute('data-id');
        fetch(`/cheques/${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('chequeModalLabel').innerText = 'Editar Cheque';
                document.getElementById('formMethod').value = 'PUT';
                document.getElementById('chequeId').value = data.id;
                document.getElementById('codigo_cuenta').value = data.codigo_cuenta;
                document.getElementById('codigo_factura').value = data.codigo_factura || '';
                document.getElementById('numero').value = data.numero;
                document.getElementById('debe').value = data.debe;
                document.getElementById('haber').value = data.haber;
                document.getElementById('fecha_emision').value = data.fecha_emision;
                document.getElementById('fecha_pago').value = data.fecha_pago;
                var chequeModal = new bootstrap.Modal(document.getElementById('chequeModal'));
                chequeModal.show();
            });
    });
});

// Enviar formulario por AJAX
document.getElementById('chequeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let spinner = document.getElementById('formSpinner');
    spinner.classList.remove('d-none');
    let formData = new FormData(this);
    let method = document.getElementById('formMethod').value;
    let id = document.getElementById('chequeId').value;
    let url = method === 'POST' ? '/cheques' : `/cheques/${id}`;
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
            mostrarAlerta('success', 'Cheque guardado correctamente');
            location.reload();
        }
    })
    .catch(() => {
        spinner.classList.add('d-none');
        mostrarAlerta('danger', 'Error al guardar');
    });
});

// Abrir confirmación para eliminar
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function() {
        chequeIdToDelete = this.getAttribute('data-id');
        var deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        deleteModal.show();
    });
});

// Confirmar eliminación
document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    fetch(`/cheques/${chequeIdToDelete}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        mostrarAlerta('success', 'Cheque eliminado correctamente');
        location.reload();
    })
    .catch(() => {
        mostrarAlerta('danger', 'Error al eliminar');
    });
});

// Función para limpiar el formulario
function limpiarFormulario() {
    document.getElementById('chequeForm').reset();
    document.getElementById('chequeId').value = '';
}

// Función para mostrar alertas
function mostrarAlerta(tipo, mensaje) {
    let alertContainer = document.getElementById('alert-container');
    alertContainer.innerHTML = `<div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>`;
}
</script>
@endpush