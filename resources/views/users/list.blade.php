@php
    $url = route('users.list');
@endphp

@extends('layouts.main')

@section('title', 'Lista de Usuarios')

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
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Lista de Usuarios</h4>
                    </div>
                    <div class="card-body">
                        <!-- Botones de acciones -->
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex">
                                <form id="searchForm" class="d-flex" method="GET" action="{{ route('clients.list') }}">
                                    <div class="input-group me-2" style="width: 300px;">
                                        <input type="text" id="searchInput" name="search" class="form-control" placeholder="Buscar..." value="{{ request('search') }}">
                                        <button class="btn btn-success" type="submit">
                                            <i class="fa-solid fa-magnifying-glass fa-beat"></i>
                                        </button>
                                    </div>
                                </form>
                                <div class="btn-group me-3">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-sort fa-bounce"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><h6 class="dropdown-header">Ordenar por</h6></li>
                                        <li><a class="dropdown-item" href="{{ route('users.list', ['sort_by' => 'name', 'order' => 'asc']) }}">Nombre A-Z</a></li>
                                        <li><a class="dropdown-item" href="{{ route('users.list', ['sort_by' => 'name', 'order' => 'desc']) }}">Nombre Z-A</a></li>
                                        <li><a class="dropdown-item" href="{{ route('users.list', ['sort_by' => 'email', 'order' => 'asc']) }}">Email A-Z</a></li>
                                        <li><a class="dropdown-item" href="{{ route('users.list', ['sort_by' => 'email', 'order' => 'desc']) }}">Email Z-A</a></li>
                                        <li><a class="dropdown-item" href="{{ route('users.list', ['sort_by' => 'phone', 'order' => 'asc']) }}">Teléfono 0-9</a></li>
                                        <li><a class="dropdown-item" href="{{ route('users.list', ['sort_by' => 'phone', 'order' => 'desc']) }}">Teléfono 9-0</a></li>
                                        <li><a class="dropdown-item" href="{{ route('users.list', ['sort_by' => 'birth', 'order' => 'asc']) }}">Cumpleaños A-Z</a></li>
                                        <li><a class="dropdown-item" href="{{ route('users.list', ['sort_by' => 'birth', 'order' => 'desc']) }}">Cumpleaños Z-A</a></li>
                                    </ul>
                                </div>
                                <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ $url }}'">
                                <i class="fa-solid fa-arrows-rotate fa-spin"></i>
                                </button>
                                <button type="button" class="btn btn-success ms-2" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                    <i class="fa-solid fa-user-plus fa-shake"></i>
                                </button>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="me-2">{{ $users->count() }} usuarios de {{ $users->total() }}</span>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Mostrar
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('users.list', ['per_page' => 5]) }}">5</a></li>
                                        <li><a class="dropdown-item" href="{{ route('users.list', ['per_page' => 10]) }}">10</a></li>
                                        <li><a class="dropdown-item" href="{{ route('users.list', ['per_page' => 15]) }}">15</a></li>
                                        <li><a class="dropdown-item" href="{{ route('users.list', ['per_page' => 20]) }}">20</a></li>
                                        <li><a class="dropdown-item" href="{{ route('users.list', ['per_page' => 25]) }}">25</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered" id="usersTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Foto</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Fecha de Nacimiento</th>
                                    <!-- <th style="width: 100px;">Acciones</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            @if($user->profile_photo)
                                                <img 
                                                    src="{{ asset('storage/' . $user->profile_photo) }}" 
                                                    alt="Foto de {{ $user->name }}" 
                                                    class="img-thumbnail" 
                                                    style="width: 50px; height: 50px; cursor: pointer;" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#photoModal{{ $user->id }}"
                                                >
                                                <!-- Modal para la previsualización -->
                                                <div class="modal fade" id="photoModal{{ $user->id }}" tabindex="-1" aria-labelledby="photoModalLabel{{ $user->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="photoModalLabel{{ $user->id }}">Foto de {{ $user->name }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <img 
                                                                    src="{{ asset('storage/' . $user->profile_photo) }}" 
                                                                    alt="Foto de {{ $user->name }}" 
                                                                    class="img-fluid"
                                                                >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span>Sin foto</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->birth }}</td>
                                        <!-- <td>
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td> -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Paginación -->
                        <div class="d-flex justify-content-center">
                            {{ $users->appends(request()->query())->links('pagination::custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para añadir usuario -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Añadir Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf                    
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="birth" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="birth" name="birth">
                        </div>
                        <div class="mb-3">
                            <label for="profile_photo" class="form-label">Foto de Perfil</label>
                            <input type="file" class="form-control" id="profile_photo" name="profile_photo">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function searchTable() {
            // Obtener el valor de búsqueda
            var input = document.getElementById("searchInput");
            var filter = input.value.toLowerCase();
            var table = document.getElementById("usersTable");
            var tr = table.getElementsByTagName("tr");

            // Recorrer todas las filas de la tabla y ocultar las que no coincidan con la búsqueda
            for (var i = 1; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName("td");
                var match = false;
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        if (td[j].innerText.toLowerCase().indexOf(filter) > -1) {
                            match = true;
                            break;
                        }
                    }
                }
                if (match) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    </script>
@endsection