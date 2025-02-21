<!-- filepath: resources/views/layouts/main.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="{{ url('/') }}"> Castores</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('services') ? 'active' : '' }}" href="{{ route('services') }}">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('reviews') ? 'active' : '' }}" href="{{ route('reviews.index') }}">Review</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Mi Cuenta
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                        @guest
                            @if (Route::has('login'))
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('login') }}">
                                    <i class="fa-solid fa-right-to-bracket me-2"></i> {{ __('Login') }}
                                </a>
                            @endif
                            @if (Route::has('register'))
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('register') }}">
                                    <i class="fa-solid fa-user-plus me-2"></i> {{ __('Register') }}
                                </a>
                            @endif
                        @else
                            <!-- Nombre del usuario con foto -->
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('users.index') }}">
                                <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : 
                                asset('/images/default-user.png') }}" alt="Foto de perfil" class="rounded-circle me-2" 
                                style="width: 30px; height: 30px;">
                                {{ Auth::user()->name }}
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('home') }}">
                                <i class="fa-solid fa-house me-2"></i> {{ __('Home') }}
                            </a>

                            <!-- Opciones basadas en el nivel del usuario -->
                            @if(Auth::user() instanceof App\Models\User)
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('reviews.list') }}">
                                    <i class="fa-solid fa-star me-2"></i> {{ __('Mis Reseñas') }}
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('payments.list') }}">
                                    <i class="fa-brands fa-cc-visa me-2"></i> {{ __('Mis Pagos') }}
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="">
                                    <i class="fa-solid fa-calendar-check me-2"></i> {{ __('Mis Citas') }}
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="">
                                    <i class="fa-solid fa-user-group me-2"></i> {{ __('Contadores') }}
                                </a>
                                <button type="button" class="dropdown-item d-flex align-items-center text-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                    <i class="fas fa-trash-alt me-2"></i> Eliminar Cuenta
                                </button>

                            <!-- Opciones basadas en el nivel del contador -->
                            @elseif(Auth::user() instanceof App\Models\Accountant)
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('clients.list') }}">
                                    <i class="fa-solid fa-user-group me-2"></i> {{ __('Clientes') }}
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="">
                                    <i class="fa-solid fa-calendar-check me-3"></i> {{ __('Citas') }}
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="">
                                    <i class="fa-brands fa-cc-visa me-2"></i> {{ __('Pagos Recibidos') }}
                                </a>

                            <!-- Opciones basadas en el nivel del admin -->
                            @elseif(Auth::user() instanceof App\Models\Admin)
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('reviews.index') }}">
                                    <i class="fa-solid fa-star me-2"></i> {{ __('Reseñas') }}
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="">
                                    <i class="fa-brands fa-cc-visa me-2"></i> {{ __('Pagos') }}
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="">
                                    <i class="fa-solid fa-calendar-check me-3"></i> {{ __('Citas') }}
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="">
                                    <i class="fa-solid fa-briefcase me-2"></i> {{ __('Contadores') }}
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('users.trashed') }}">
                                    <i class="fa-solid fa-user-group me-2"></i> {{ __('Eliminados') }}
                                </a>
                            @endif
                                <!-- Opción de cerrar sesión -->
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i> {{ __('Cerrar Sesión') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                        @endguest
                    </div>
                </li>
            </ul>
            
        </div>
    </nav>

    <div class="wrapper">
        <div class="content">
            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>

    <footer>
        <p>© Copyright &copy; 2025</p>
    </footer>

    <!-- Modal de Confirmación de Eliminación de Cuenta -->
    @auth
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Confirmar Eliminación de Cuenta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="delete-account-form" action="{{ route('users.destroy', Auth::user()->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="mb-3">
                            <label for="password" class="form-label">Introduce tu contraseña si deseas eliminar tu cuenta</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-danger">Sí, eliminar cuenta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</body>
</html>