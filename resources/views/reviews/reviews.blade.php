@extends('layouts.main')

@section('title', 'Reseñas')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Reseñas</h1>
    
    <!-- Contadores y Reseñas -->
    <div id="contadores-container">
        @foreach ($reviews as $review)
            <div class="contador-card mb-5">
                <!-- Información del Contador -->
                <div class="contador-info text-center">
                    <!-- Imagen del contador o una imagen genérica si no hay -->
                    <img src="{{ $review->accountant->photo ? asset('storage/'.$review->accountant->photo) : 'https://via.placeholder.com/150' }}" 
                        class="rounded-circle mb-3" 
                        alt="{{ $review->accountant->name }}" 
                        width="80" 
                        height="80">
                    <h4>{{ $review->accountant->name }}</h4>
                    <p><strong>{{ $review->accountant->specialty }}</strong></p>
                </div>
                
                <!-- Reseñas para cada Contador -->
                <div class="reviews-container">
                    <div class="review-card">
                        <p><strong>{{ $review->user->name }}</strong></p>
                        <p class="review-text">{{ $review->comment }}</p>
                        <div class="mb-3 text-center">
                            <label class="form-label"><strong>Calificación:</strong></label>
                            <div class="rating-display">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection