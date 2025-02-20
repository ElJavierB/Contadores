@extends('layouts.main')

@section('title', 'Usuarios Eliminados')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Usuarios Eliminados</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($deletedUsers as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('users.restore', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Restaurar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $deletedUsers->links() }}
</div>
@endsection
