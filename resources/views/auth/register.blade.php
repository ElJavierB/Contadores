@extends('layouts.main')

@section('title', 'Register')

@section('content')
<!-- Section: Design Block -->
<section class="background-radial-gradient overflow-hidden">
  <div class="container py-5 px-4 px-md-5 text-center my-5">
    <div class="row gx-lg-5 justify-content-center mb-5">
      <div class="col-lg-8 mb-5 mb-lg-0 position-relative">
        <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
        <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

        <div class="card mx-auto shadow-5-strong bg-body-tertiary" style="
              margin-top: -100px;
              margin-bottom: -150px;
              backdrop-filter: blur(30px);
              max-width: 900px;
              ">
          <div class="card-body py-4 px-md-4">
            <div class="row d-flex justify-content-center">
              <div class="col-lg-10">
                <h2 class="fw-bold mb-4">Registrate</h2>
                <form method="POST" action="{{ route('register') }}">
                  @csrf

                  <!-- Nombre y Email -->
                  <div class="row mb-3">
                    <div class="col-md-6 form-floating mb-3 mb-md-0">
                      <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus />
                      <label for="name">Nombre</label>
                      @error('name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="col-md-6 form-floating">
                      <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" />
                      <label for="email">Email</label>
                      @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>

                  <!-- Contraseña y Confirmar Contraseña -->
                  <div class="row mb-3">
                    <div class="col-md-6 form-floating mb-3 mb-md-0">
                      <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" />
                      <label for="password">Contraseña</label>
                      @error('password')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="col-md-6 form-floating">
                      <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autocomplete="new-password" />
                      <label for="password-confirm">Confirmar Contraseña</label>
                    </div>
                  </div>

                  <!-- Teléfono y Fecha de Nacimiento -->
                  <div class="row mb-3">
                    <div class="col-md-6 form-floating mb-3 mb-md-0">
                      <input type="text" id="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" />
                      <label for="phone">Teléfono</label>
                      @error('phone')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="col-md-6 form-floating">
                      <input type="date" id="birth" class="form-control @error('birth') is-invalid @enderror" name="birth" value="{{ old('birth') }}" />
                      <label for="birth">Fecha de Nacimiento</label>
                      @error('birth')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>

                  <!-- Botón de Registro -->
                  <button type="submit" class="btn btn-primary btn-block mb-3">
                    Registrarse
                  </button>

                  <!-- Botones de Registro con Redes Sociales -->
                  <div class="text-center">
                    <p>Registrarse con:</p>
                    <button type="button" class="btn btn-link btn-floating mx-1">
                      <i class="fab fa-facebook-f"></i>
                    </button>

                    <button type="button" class="btn btn-link btn-floating mx-1">
                      <i class="fab fa-google"></i>
                    </button>

                    <button type="button" class="btn btn-link btn-floating mx-1">
                      <i class="fab fa-twitter"></i>
                    </button>

                    <button type="button" class="btn btn-link btn-floating mx-1">
                      <i class="fab fa-github"></i>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Section: Design Block -->
@endsection