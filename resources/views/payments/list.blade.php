@extends('layouts.main')

@section('title', 'Mis Pagos')

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
<div class="container mt-5" style="margin-bottom: 50px;"> 
    <div class="card shadow-lg p-4">
        <div class="card-header bg-transparent d-flex justify-content-center position-relative">
            <h2 class="mb-0 text-center w-100">Mis Pagos</h2>
            <button class="btn btn-primary position-absolute end-0" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                Añadir Pago</button>
        </div>

        <!-- Sección de Pagos -->
        <div class="card-body">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Contador</th>
                        <th>Monto</th>
                        <th>Método</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Archivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->accountant->name ?? 'N/A' }}</td>
                        <td>${{ number_format($payment->amount, 2) }}</td>
                        <td>{{ ucfirst($payment->method) }}</td>
                        <td>
                        <span class="badge bg-{{ 
                                $payment->status == 'Pendiente' ? 'warning' : 
                                ($payment->status == 'Rechazado' ? 'danger' : 
                                ($payment->status == 'Aceptado' ? 'success' : 'secondary')) 
                            }}">
                            {{ ucfirst($payment->status) ?: "Estado Desconocido" }}
                        </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y H:i') }}</td>
                        <td>
                            @if ($payment->file)
                                <a href="#" class="open-payment-modal" data-file-path="{{ asset('storage/' . $payment->file) }}">
                                    <i class="fas fa-image"></i>
                                </a>
                            @else
                                No Disponible
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-warning edit-payment-modal" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editPaymentModal" 
                                    data-payment-id="{{ $payment->id }}" 
                                    data-amount="{{ $payment->amount }}" 
                                    data-method="{{ $payment->method }}">
                                <i class="fa-solid fa-pen-to-square"></i> 
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No tienes pagos registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para añadir un pago -->
<div class="modal fade" id="addPaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Nuevo Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="appointment_id" class="form-label">Cita</label>
                        <select class="form-select" name="appointment_id" required>
                            @foreach($appointment as $appointment)
                                <option value="{{ $appointment->id }}">
                                    {{ $appointment->date }} - {{ $appointment->accountant->name ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Monto</label>
                        <input type="number" class="form-control" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="method" class="form-label">Método de Pago</label>
                        <select class="form-select" name="method" required>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Transferencia">Transferencia</option>
                            <option value="Efectivo">Efectivo</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Comprobante de pago (Opcional)</label>
                        <input type="file" class="form-control" name="file" accept="image/*">
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Guardar Pago</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver la foto -->
<div class="modal fade" id="viewPaymentFileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> <!-- Centrar el modal y ajustar su tamaño -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ver Comprobante de Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <!-- Imagen cargada dinámicamente aquí -->
                    <img id="paymentFileImage" src="" alt="Comprobante de Pago" class="img-fluid" style="max-width: 100%; max-height: 100%;">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar un pago -->
<div class="modal fade" id="editPaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPaymentForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_amount" class="form-label">Monto</label>
                        <input type="number" class="form-control" id="edit_amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_method" class="form-label">Método de Pago</label>
                        <select class="form-select" id="edit_method" name="method" required>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Transferencia">Transferencia</option>
                            <option value="Efectivo">Efectivo</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_file" class="form-label">Nuevo Comprobante (Opcional)</label>
                        <input type="file" class="form-control" id="edit_file" name="file" accept="image/*">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Guardar</button>
                        <button type="button" class="btn btn-danger me-2" id="delete-button" data-bs-toggle="modal"
                                data-bs-target="#deleteFileModal" data-payment-id="">
                                Comprobante
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Eliminación de Comprobante de Pago -->
<div class="modal fade" id="deleteFileModal" tabindex="-1" aria-labelledby="deleteFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteFileModalLabel">Confirmar Eliminación de Comprobante de Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="delete-file-form" method="POST" action="{{ route('payments.deleteFile', ['payment' => $payment->id]) }}">
                @csrf
                @method('DELETE')
                <p>¿Estás seguro de que deseas eliminar tu Comprobante de Pago?</p>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Sí, eliminar foto</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<!-- Script para editar un pago -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.edit-payment-modal').forEach(button => {
        button.addEventListener('click', function() {
            const paymentId = this.dataset.paymentId;
            const amount = this.dataset.amount;
            const method = this.dataset.method;
            console.log("Monto obtenido:", amount); // Para verificar si se está capturando bien
            // Asignar los valores al formulario del modal
            document.getElementById('edit_amount').value = amount ? parseFloat(amount) : ''; 
            document.getElementById('edit_method').value = method;
            document.getElementById('editPaymentForm').action = `/pagos/${paymentId}`;
        });
    });
});
</script>

<!-- Script para ver la imagen del comprobante de pago -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const viewButtons = document.querySelectorAll('.open-payment-modal');
        viewButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Evita que el enlace recargue la página
                const filePath = this.dataset.filePath;  // Obtiene la imagen
                document.getElementById('paymentFileImage').src = filePath;  // Actualiza el modal
                const modal = new bootstrap.Modal(document.getElementById('viewPaymentFileModal')); 
                modal.show(); // Abre el modal
            });
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-payment-file').forEach(button => {
        button.addEventListener('click', function() {
            const paymentId = this.dataset.paymentId;
            if (paymentId) {
                // Actualiza la acción del formulario con el ID del pago
                document.getElementById('delete-file-form').action = `/pagos/${paymentId}/delete-file`;
            }
        });
    });
});

</script>
@endsection
