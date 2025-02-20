@extends('layouts.main')

@section('title', 'Accountants')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Reseñas</h1>
    <div class="row">
        @for ($i = 0; $i < 10; $i++)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://i.pravatar.cc/150?img={{ $i + 1 }}" class="rounded-circle mr-3" alt="User Photo" width="50" height="50">
                            <h5 class="card-title mb-0">Usuario {{ $i + 1 }}</h5>
                        </div>
                        <p class="card-text">Esta es una reseña de ejemplo para el usuario {{ $i + 1 }}. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>
@endsection