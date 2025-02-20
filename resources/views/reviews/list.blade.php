@extends('layouts.main')

@section('title', 'Mis Reseñas')

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
            <h2 class="mb-0 text-center w-100">{{ session('title', 'Mis Reseñas') }}</h2>
            <!-- Botón para abrir el modal -->
            <button class="btn btn-primary position-absolute end-0" data-bs-toggle="modal" data-bs-target="#addReviewModal">
                <i class="fa-solid fa-comment-medical fa-beat"></i>
                Añadir
            </button>
        </div>

        <!-- Sección de reseñas -->
        <div class="card-body">
        <div class="row">
            @forelse ($reviews as $review)
                <div class="col-md-4 mb-4">
                    <div class="card shadow rounded h-100">
                        <!-- Foto del contador -->
                        <div class="text-center p-3 bg-light">
                            <img src="{{ $review->accountant?->photo ? asset('storage/'.$review->accountant->photo) : 'https://via.placeholder.com/150' }}" 
                                class="rounded-circle" 
                                alt="{{ $review->accountant?->name ?? 'Contador Desconocido' }}" 
                                width="100" 
                                height="100">
                        </div>

                        <!-- Información del contador -->
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $review->accountant?->name ?? 'Contador Desconocido' }}</h5>
                            <p class="card-text"><strong>Teléfono:</strong> {{ $review->accountant?->phone ?? 'No disponible' }}</p>
                        </div>

                        <!-- Reseña del usuario -->
                        <div class="card-footer bg-white text-center">
                            <p class="text-muted review-text">
                                "{{ Str::limit($review->comment, 100) }}"
                            </p>
                            @if (strlen($review->comment) > 100)
                                <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $review->id }}">Ver Completa</a>
                            @endif

                            <p class="text-warning mt-2">
                                <strong>Calificación:</strong> 
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                @endfor
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Modal para mostrar la reseña completa -->
                <div class="modal fade" id="reviewModal{{ $review->id }}" tabindex="-1" aria-labelledby="reviewModalLabel{{ $review->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reviewModalLabel{{ $review->id }}">Reseña Completa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted">"{{ $review->comment }}"</p>
                                <p class="text-warning">
                                    <strong>Calificación:</strong> 
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                    @endfor
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No has realizado ninguna reseña aún.</p>
                </div>
            @endforelse
        </div>
    </div>

<!-- Modal para agregar reseña -->
<div class="modal fade" id="addReviewModal" tabindex="-1" aria-labelledby="addReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReviewModalLabel">Añadir Reseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <!-- Selección del contador -->
                    <div class="mb-3">
                        <label for="accountant_id" class="form-label">Selecciona un Contador:</label>
                        <select class="form-select" id="accountant_id" name="accountant_id" required>
                            @foreach ($accountants as $accountant)
                                <option value="{{ $accountant->id }}">{{ $accountant->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Comentario -->
                    <div class="mb-3">
                        <label for="comment" class="form-label">Tu Reseña:</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                    </div>

                    <!-- Calificación -->
                    <div class="mb-3 text-center">
                        <label class="form-label"><strong>Calificación:</strong></label>
                        <div class="rating">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required />
                                <label for="star{{ $i }}" class="fas fa-star"></label>
                            @endfor
                        </div>
                    </div>


                    <!-- Botón Guardar -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Guardar Reseña</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
