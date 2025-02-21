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
                            @if($payment->file)
                                <button class="btn btn-sm btn-primary view-payment-file" 
                                        data-file-path="{{ asset('storage/' . $payment->file) }}"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewPaymentFileModal">Ver</button>
                            @else
                                <span class="text-muted">No disponible</span>
                            @endif
                        </td>
                        <td>
                        <button class="btn btn-sm btn-warning edit-payment" 
                                data-payment-id="{{ $payment->id }}" 
                                data-amount="{{ $payment->amount }}" 
                                data-method="{{ $payment->method }}" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editPaymentModal">
                            Editar
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ver Comprobante de Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <!-- Imagen cargada dinámicamente aquí -->
                    <img id="paymentFileImage" src="" alt="Comprobante de Pago" class="img-fluid">
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

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Editar el pago
    const editButtons = document.querySelectorAll('.edit-payment');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const paymentId = this.dataset.paymentId;
            const amount = this.dataset.amount;
            const method = this.dataset.method;

            const modal = new bootstrap.Modal(document.getElementById('editPaymentModal'));

            // Asignar los valores al formulario del modal
            document.getElementById('edit_amount').value = amount;
            document.getElementById('edit_method').value = method;
            document.getElementById('editPaymentForm').action = '/pagos/' + paymentId; // Asegúrate que esta URL sea correcta para tu ruta de update

            // Mostrar el modal
            modal.show();
        });
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const viewButtons = document.querySelectorAll('.view-payment-file');
        
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filePath = this.dataset.filePath;  // Obtener el archivo
                const modal = new bootstrap.Modal(document.getElementById('viewPaymentFileModal'));  // Obtener el modal
                document.getElementById('paymentFileImage').src = filePath;  // Establecer la fuente de la imagen
                modal.show();
            });
        });

        // Asegurarse de cerrar correctamente el modal al hacer clic en la X
        const closeButton = document.querySelector('.btn-close');  // Botón de cerrar modal
        closeButton.addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('viewPaymentFileModal'));
            modal.hide();  // Cerrar el modal explícitamente
        });
    });
</script>


@endsection
