@extends('layouts.main')

@section('title', 'Home')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card" style="height: 400px;">
                <div class="card-header">Gráfica de Ganancias</div>
                <div class="card-body">
                    <canvas id="gananciasChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card" style="height: 400px;">
                <div class="card-header">Gráfica de Pastel de Aportes</div>
                <div class="card-body">
                    <canvas id="aportesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card" style="height: 200px;">
                <div class="card-header">Ultimo Pago</div>
                <div class="card-body">
                    Contenido de la tarjeta 1.
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card" style="height: 200px;">
                <div class="card-header">Ultima Cita</div>
                <div class="card-body">
                    Contenido de la tarjeta 2.
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card" style="height: 300px;">
                <div class="card-header">Ultima Reseña</div>
                <div class="card-body">
                    Contenido de la tarjeta 3.
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card" style="height: 300px;">
                <div class="card-header">Contadores Destacados</div>
                <div class="card-body">
                    Contenido de la tarjeta 4.
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-4">
            <div class="card" style="height: 250px;">
                <div class="card-header">Tarjeta 5</div>
                <div class="card-body">
                    Contenido de la tarjeta 5.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
