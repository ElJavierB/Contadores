@extends('layouts.main')

@section('title', 'Landing')

@section('content')
<div class="bg" id="background"></div>
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
<div id="content">
    <!-- Sección 1: Logotipo de la empresa -->
    <section id="logo-section" style="text-align: center; margin-bottom: 20px;">
        <img src="path/to/logo.png" alt="Logotipo de la empresa" style="max-width: 200px;">
    </section>

    <!-- Sección 2: Carrusel de fotos y texto -->
    <section id="carousel-text-section" style="display: flex; gap: 20px; margin-bottom: 20px;">
        <!-- Carrusel de fotos -->
        <div id="photo-carousel" style="flex: 1;">
            <!-- Placeholder para el carrusel -->
            <div style="width: 100%; height: 200px; background: #ccc; display: flex; justify-content: center; align-items: center;">
                <span>Carrusel de fotos</span>
            </div>
        </div>

        <!-- Sección de texto -->
        <div id="text-section" style="flex: 1;">
            <p>Aquí va el texto descriptivo de la empresa o servicio.</p>
        </div>
    </section>

    <!-- Sección 3: Reseñas -->
    <section id="reviews-section" style="margin-bottom: 20px;">
        <h2>Reseñas</h2>
        <div style="background: #f9f9f9; padding: 10px;">
            <p>"Excelente servicio, muy recomendado."</p>
            <p>"Gran experiencia, repetiría sin duda."</p>
        </div>
    </section>

    <!-- Sección 4: Contacto, ubicación y redes sociales -->
    <section id="contact-map-social" class="d-none d-md-flex" style="display: flex; gap: 20px;">
        <!-- Formulario de contacto -->
        <div id="contact-form" style="flex: 1;">
            <h3>Contáctanos</h3>
            <form>
                <input type="text" placeholder="Nombre" style="width: 100%; margin-bottom: 10px;">
                <input type="email" placeholder="Correo Electrónico" style="width: 100%; margin-bottom: 10px;">
                <textarea placeholder="Mensaje" style="width: 100%; margin-bottom: 10px;"></textarea>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>

        <!-- Ubicación con Google Maps -->
        <div id="google-maps" style="flex: 1;">
            <h3>Ubicación</h3>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d111576.06334567789!2d-111.07071594642244!3d29.083473154206565!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x86ce84687adfaee5%3A0xb33d5395e9887ff9!2sHermosillo%2C%20Son.!5e0!3m2!1ses-419!2smx!4v1737410413368!5m2!1ses-419!2smx" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <!-- Redes sociales -->
        <div id="social-media" style="flex: 1;">
            <h3>Redes Sociales</h3>
            <ul style="list-style: none; padding: 0;">
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">Instagram</a></li>
            </ul>
        </div>
    </section>

    <!-- Carrusel para dispositivos móviles -->
    <div id="contact-carousel" class="carousel slide d-md-none" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div id="contact-form" style="padding: 20px;">
                    <h3>Contáctanos</h3>
                    <form>
                        <input type="text" placeholder="Nombre" style="width: 100%; margin-bottom: 10px;">
                        <input type="email" placeholder="Correo Electrónico" style="width: 100%; margin-bottom: 10px;">
                        <textarea placeholder="Mensaje" style="width: 100%; margin-bottom: 10px;"></textarea>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
            </div>
            <div class="carousel-item">
                <div id="google-maps" style="padding: 20px;">
                    <h3>Ubicación</h3>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d111576.06334567789!2d-111.07071594642244!3d29.083473154206565!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x86ce84687adfaee5%3A0xb33d5395e9887ff9!2sHermosillo%2C%20Son.!5e0!3m2!1ses-419!2smx!4v1737410413368!5m2!1ses-419!2smx" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="carousel-item">
                <div id="social-media" style="padding: 20px;">
                    <h3>Redes Sociales</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Instagram</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#contact-carousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#contact-carousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </a>
    </div>
</div>
@endsection