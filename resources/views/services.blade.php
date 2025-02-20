<!-- filepath: /c:/wamp64/www/laravel/Salon/resources/views/servicios.blade.php -->
@extends('layouts.main')

@section('title', 'Servicios')

@section('content')
<div class="container mt-5">    
    <!-- Tarjeta de Presentación -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card h-100">
                <img src="path/to/presentation-image.jpg" class="card-img-top" alt="Presentación">
                <div class="card-body">
                    <h5 class="card-title">Presentación</h5>
                    <p class="card-text">Descripción de la empresa o despacho de contadores. Aquí puedes incluir información sobre la misión, visión y valores de la empresa, así como una breve introducción a los servicios ofrecidos.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Carruseles para dispositivos móviles -->
    <div id="services-carousel-1" class="carousel slide d-md-none mb-4" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="card h-100">
                    <img src="path/to/image1.jpg" class="card-img-top" alt="Servicio 1">
                    <div class="card-body">
                        <h5 class="card-title">Servicio 1</h5>
                        <p class="card-text">Descripción del servicio 1. Este servicio incluye...</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card h-100">
                    <img src="path/to/image2.jpg" class="card-img-top" alt="Servicio 2">
                    <div class="card-body">
                        <h5 class="card-title">Servicio 2</h5>
                        <p class="card-text">Descripción del servicio 2. Este servicio incluye...</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card h-100">
                    <img src="path/to/image3.jpg" class="card-img-top" alt="Servicio 3">
                    <div class="card-body">
                        <h5 class="card-title">Servicio 3</h5>
                        <p class="card-text">Descripción del servicio 3. Este servicio incluye...</p>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#services-carousel-1" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#services-carousel-1" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div id="services-carousel-2" class="carousel slide d-md-none mb-4" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="card h-100">
                    <img src="path/to/image4.jpg" class="card-img-top" alt="Servicio 4">
                    <div class="card-body">
                        <h5 class="card-title">Servicio 4</h5>
                        <p class="card-text">Descripción del servicio 4. Este servicio incluye...</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card h-100">
                    <img src="path/to/image5.jpg" class="card-img-top" alt="Servicio 5">
                    <div class="card-body">
                        <h5 class="card-title">Servicio 5</h5>
                        <p class="card-text">Descripción del servicio 5. Este servicio incluye...</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card h-100">
                    <img src="path/to/image6.jpg" class="card-img-top" alt="Servicio 6">
                    <div class="card-body">
                        <h5 class="card-title">Servicio 6</h5>
                        <p class="card-text">Descripción del servicio 6. Este servicio incluye...</p>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#services-carousel-2" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#services-carousel-2" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div id="services-carousel-3" class="carousel slide d-md-none mb-4" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="card h-100">
                    <img src="path/to/image7.jpg" class="card-img-top" alt="Servicio 7">
                    <div class="card-body">
                        <h5 class="card-title">Servicio 7</h5>
                        <p class="card-text">Descripción del servicio 7. Este servicio incluye...</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card h-100">
                    <img src="path/to/image8.jpg" class="card-img-top" alt="Servicio 8">
                    <div class="card-body">
                        <h5 class="card-title">Servicio 8</h5>
                        <p class="card-text">Descripción del servicio 8. Este servicio incluye...</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="card h-100">
                    <img src="path/to/image9.jpg" class="card-img-top" alt="Servicio 9">
                    <div class="card-body">
                        <h5 class="card-title">Servicio 9</h5>
                        <p class="card-text">Descripción del servicio 9. Este servicio incluye...</p>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#services-carousel-3" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#services-carousel-3" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- Servicios en cuadrícula para dispositivos más grandes -->
    <div class="row d-none d-md-flex">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="path/to/image1.jpg" class="card-img-top" alt="Servicio 1">
                <div class="card-body">
                    <h5 class="card-title">Servicio 1</h5>
                    <p class="card-text">Descripción del servicio 1. Este servicio incluye...</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="path/to/image2.jpg" class="card-img-top" alt="Servicio 2">
                <div class="card-body">
                    <h5 class="card-title">Servicio 2</h5>
                    <p class="card-text">Descripción del servicio 2. Este servicio incluye...</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="path/to/image3.jpg" class="card-img-top" alt="Servicio 3">
                <div class="card-body">
                    <h5 class="card-title">Servicio 3</h5>
                    <p class="card-text">Descripción del servicio 3. Este servicio incluye...</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="path/to/image4.jpg" class="card-img-top" alt="Servicio 4">
                <div class="card-body">
                    <h5 class="card-title">Servicio 4</h5>
                    <p class="card-text">Descripción del servicio 4. Este servicio incluye...</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="path/to/image5.jpg" class="card-img-top" alt="Servicio 5">
                <div class="card-body">
                    <h5 class="card-title">Servicio 5</h5>
                    <p class="card-text">Descripción del servicio 5. Este servicio incluye...</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="path/to/image6.jpg" class="card-img-top" alt="Servicio 6">
                <div class="card-body">
                    <h5 class="card-title">Servicio 6</h5>
                    <p class="card-text">Descripción del servicio 6. Este servicio incluye...</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="path/to/image7.jpg" class="card-img-top" alt="Servicio 7">
                <div class="card-body">
                    <h5 class="card-title">Servicio 7</h5>
                    <p class="card-text">Descripción del servicio 7. Este servicio incluye...</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="path/to/image8.jpg" class="card-img-top" alt="Servicio 8">
                <div class="card-body">
                    <h5 class="card-title">Servicio 8</h5>
                    <p class="card-text">Descripción del servicio 8. Este servicio incluye...</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="path/to/image9.jpg" class="card-img-top" alt="Servicio 9">
                <div class="card-body">
                    <h5 class="card-title">Servicio 9</h5>
                    <p class="card-text">Descripción del servicio 9. Este servicio incluye...</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection