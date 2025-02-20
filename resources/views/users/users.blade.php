@extends('layouts.main')

@section('title', 'Perfil')

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
                    <h4>Perfil de {{ Auth::user()->name}}</h4>
                </div>
                <div class="card-body">
                    <form id="profile-form" action="{{ route('users.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-12 text-center">
                            <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('/images/default-user.png') }}" alt="Profile Photo" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                            <input type="file" class="form-control" id="profile_photo" name="profile_photo" style="display: none;">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control text-center" id="name" name="name" value="{{ Auth::user()->name }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control text-center" id="email" name="email" value="{{ Auth::user()->email }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Teléfono</label>
                                    <input type="text" class="form-control text-center" id="phone" name="phone" value="{{ Auth::user()->phone }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="birth">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control text-center" id="birth" name="birth" value="{{ Auth::user()->birth }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input type="password" class="form-control text-center" id="password" name="password" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Contraseña</label>
                                    <input type="password" class="form-control text-center" id="password_confirmation" name="password_confirmation" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="button" class="btn btn-primary me-2" id="edit-button">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button type="submit" class="btn btn-success me-2" id="save-button" style="display: none;">
                                <i class="fas fa-save"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-secondary me-2" id="cancel-button" style="display: none;">
                                <i class="fas fa-times"></i> Cancelar
                            </button>
                            <button type="button" class="btn btn-danger me-2" id="delete-button" data-bs-toggle="modal" data-bs-target="#deletePhotoModal" >
                                <i class="fas fa-trash-alt"></i> Foto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Eliminación de Foto de Perfil -->
@auth
    <div class="modal fade" id="deletePhotoModal" tabindex="-1" aria-labelledby="deletePhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePhotoModalLabel">Confirmar Eliminación de Foto de Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="delete-photo-form" action="{{ route('users.deletePhoto', Auth::user()->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <p>¿Estás seguro de que deseas eliminar tu foto de perfil?</p>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger">Sí, eliminar foto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endauth

<script>
    document.getElementById('edit-button').addEventListener('click', function() {
        document.getElementById('name').disabled = false;
        document.getElementById('email').disabled = false;
        document.getElementById('phone').disabled = false;
        document.getElementById('birth').disabled = false;
        document.getElementById('password').disabled = false;
        document.getElementById('password_confirmation').disabled = false;
        document.getElementById('profile_photo').style.display = 'block';
        document.getElementById('edit-button').style.display = 'none';
        document.getElementById('save-button').style.display = 'inline-block';
        document.getElementById('cancel-button').style.display = 'inline-block';
        document.getElementById('delete-button').style.display = 'none';
    });

    document.getElementById('cancel-button').addEventListener('click', function() {
        document.getElementById('name').disabled = true;
        document.getElementById('email').disabled = true;
        document.getElementById('phone').disabled = true;
        document.getElementById('birth').disabled = true;
        document.getElementById('password').disabled = true;
        document.getElementById('password_confirmation').disabled = true;
        document.getElementById('profile_photo').style.display = 'none';
        document.getElementById('edit-button').style.display = 'inline-block';
        document.getElementById('save-button').style.display = 'none';
        document.getElementById('cancel-button').style.display = 'none';
        document.getElementById('delete-button').style.display = 'inline-block';

        // Restaurar los valores originales
        document.getElementById('name').value = "{{ Auth::user()->name }}";
        document.getElementById('email').value = "{{ Auth::user()->email }}";
        document.getElementById('phone').value = "{{ Auth::user()->phone }}";
        document.getElementById('birth').value = "{{ Auth::user()->birth }}";
        document.getElementById('password').value = '';
        document.getElementById('password_confirmation').value = '';
    });

    document.getElementById('delete-photo-button').addEventListener('click', function() {
        if (confirm('¿Estás seguro de que deseas eliminar tu foto de perfil?')) {
            document.getElementById('delete-photo-form').submit();
        }
    });
</script>
@endsection