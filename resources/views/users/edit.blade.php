@extends('layouts.main')

@section('title', 'Editar Perfil')

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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Editar Perfil de {{ $user->name }}</h4>
                </div>
                <div class="card-body">
                    <form id="profile-form" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-12 text-center">
                                <!-- Mostrar la foto actual de perfil -->
                                <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('/images/default-user.png') }}" alt="Foto de Perfil" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                                <input type="file" class="form-control" id="profile_photo" name="profile_photo">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control text-center" id="name" name="name" value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control text-center" id="email" name="email" value="{{ $user->email }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Teléfono</label>
                                    <input type="text" class="form-control text-center" id="phone" name="phone" value="{{ $user->phone }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="birth">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control text-center" id="birth" name="birth" value="{{ $user->birth }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Nueva Contraseña</label>
                                    <input type="password" class="form-control text-center" id="password" name="password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Contraseña</label>
                                    <input type="password" class="form-control text-center" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-success me-2">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                            <a href="{{ route('clients.list') }}" class="btn btn-danger">
                                <i class="fas fa-times"></i> Cancelar Cambios
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
