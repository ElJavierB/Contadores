@extends('layouts.main')

@section('title', 'Mis Citas')

@section('content')
<div class="container mt-5" style="margin-bottom: 50px;">
    <div class="card shadow-lg p-4">
        <div class="card-header bg-transparent d-flex justify-content-center position-relative">
            <h2 class="mb-0 text-center w-100">
                <label for="yearPicker">Mis Citas</label>
                <input type="number" id="yearPicker" class="form-control d-inline w-auto" value="{{ $year }}" min="1900" max="2100">
                <button id="btnYear" class="btn btn-primary me-2" style="display: none;">Año</button>
                <button id="btnMonth" class="btn btn-primary">Mes</button>
            </h2>
        </div>

        @php
        use Carbon\Carbon;
        $currentMonth = Carbon::now()->month;
        $currentDay = Carbon::now()->day;
        $months = [
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        @endphp

        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
            </div>
            <div id="calendarContainer">
                <div id="yearView">
                    <div class="row">
                        @foreach ($months as $index => $month)
                        @php
                        $monthNumber = $index + 1;
                        $startOfMonth = Carbon::create($year, $monthNumber, 1);
                        $daysInMonth = $startOfMonth->daysInMonth;
                        $firstDayOfWeek = $startOfMonth->dayOfWeek;
                        $currentYear = Carbon::now()->year;
                        $isCurrentMonth = ($monthNumber == $currentMonth && $year == $currentYear);
                        @endphp

                        <div class="col-md-4 mb-4">
                            <div class="card shadow rounded h-100 {{ $isCurrentMonth ? 'border border-primary' : '' }}">
                                <div class="card-header text-center bg-light {{ $isCurrentMonth ? 'bg-primary text-white' : '' }}">
                                    <h5 class="mb-0 month-name" data-month="{{ $index }}" style="color: black;">{{ $month }}</h5>
                                </div>
                                <div class="card-body text-center">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Dom</th>
                                                    <th>Lun</th>
                                                    <th>Mar</th>
                                                    <th>Mié</th>
                                                    <th>Jue</th>
                                                    <th>Vie</th>
                                                    <th>Sáb</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    @for ($i = 0; $i < $firstDayOfWeek; $i++)
                                                        <td>
                                                        </td>
                                                        @endfor
                                                        @for ($day = 1; $day <= $daysInMonth; $day++)
                                                            @php
                                                            $currentDate="{$year}-" . str_pad($monthNumber, 2, '0' , STR_PAD_LEFT) . "-" . str_pad($day, 2, '0' , STR_PAD_LEFT);
                                                            $isToday=Carbon::today()->format('Y-m-d') == $currentDate;

                                                            // Si es el día actual, aplica un fondo azul completamente
                                                            if ($isToday) {
                                                            $status = 'bg-primary text-white'; // Día actual completamente azul
                                                            } elseif (isset($groupedAppointments[$currentDate])) {
                                                            // Si hay citas en el día, aplica una bolita azul
                                                            $status = 'blue-dot'; // Siempre azul si hay una cita
                                                            } else {
                                                            $status = ''; // No hay cita, no se aplica bolita
                                                            }
                                                            @endphp

                                                            <td class="p-2 {{ $status }}" style="position: relative;">
                                                                {{ $day }}
                                                                @if (!$isToday && isset($groupedAppointments[$currentDate]))
                                                                <div class="dot {{ $status }}"></div>
                                                                @endif
                                                            </td>
                                                            @php
                                                            $currentWeekday = ($firstDayOfWeek + $day - 1) % 7;
                                                            @endphp
                                                            @if ($currentWeekday == 6 && $day < $daysInMonth)
                                                                </tr>
                                                <tr>
                                                    @endif
                                                    @endfor
                                                    @for ($i = ($firstDayOfWeek + $daysInMonth) % 7; $i < 7 && $i> 0; $i++)
                                                        <td></td>
                                                        @endfor
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('yearPicker').addEventListener('change', function() {
        let selectedYear = this.value;
        window.location.href = `?year=${selectedYear}`;
    });

    document.getElementById('btnMonth').addEventListener('click', function() {
        let currentYear = new Date().getFullYear(); // Obtener el año actual
        let currentMonth = new Date().getMonth() + 1; // Obtener mes actual (1-12)

        // Construir la URL usando la ruta de Laravel para redirigir siempre al calendario del año actual
        let url = "{{ route('appointments.months', ['year' => '__YEAR__', 'month' => '__MONTH__']) }}";
        url = url.replace('__YEAR__', currentYear).replace('__MONTH__', currentMonth);

        window.location.href = url; // Redirigir a la vista del calendario del año actual
    });

    function showYearView(year) {
        // Restaurar la vista completa del año con todos los meses
        document.getElementById('yearView').style.display = 'block';
        document.getElementById('monthView').style.display = 'none';

        // Cambiar el valor del input de año
        document.getElementById('yearPicker').value = year;

        // Volver a mostrar los meses del año
        document.getElementById('btnMonth').style.display = 'inline-block';
    }
</script>
@endsection