@extends('layouts.main')
@section('title', 'Citas por Mes')
@section('content')
<div class="container mt-5" style="margin-bottom: 50px;">
    <div class="card shadow-lg p-4">
        <div class="card-header bg-transparent d-flex justify-content-center position-relative">
            <h2 class="mb-0 text-center w-100">
                <!-- <label for="monthPicker">Mes Actual</label> -->
                <button id="prevMonth" class="btn btn-secondary me-3"><i class="fas fa-chevron-left"></i></button>
                <span id="currentMonthName"></span>
                <button id="nextMonth" class="btn btn-secondary ms-3"><i class="fas fa-chevron-right"></i></button>
                <a href="{{ route('appointments.index') }}" class="btn btn-primary">Año</a>
            </h2>
        </div>
        <div class="card-body">
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
                    <tbody id="monthDaysContainer">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const monthNames = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];
    let selectedDay = null; // Variable global para recordar el día seleccionado

    function showMonthView(year, month) {
        let firstDay = new Date(year, month, 1).getDay();
        let daysInMonth = new Date(year, month + 1, 0).getDate();
        let monthDaysContainer = document.getElementById('monthDaysContainer');
        let currentMonthName = document.getElementById('currentMonthName');

        // Fecha actual para comparar
        let today = new Date();
        let currentDay = today.getDate();
        let currentMonth = today.getMonth();
        let currentYear = today.getFullYear();

        // Actualizar el nombre del mes
        currentMonthName.innerText = `${monthNames[month]} ${year}`;
        currentMonthName.dataset.month = month;
        currentMonthName.dataset.year = year;

        // Limpiar la tabla antes de llenar los días
        monthDaysContainer.innerHTML = '';

        let day = 1;
        for (let i = 0; i < 6; i++) {
            let row = document.createElement('tr');

            for (let j = 0; j < 7; j++) {
                let cell = document.createElement('td');

                if (i === 0 && j < firstDay) {
                    cell.innerHTML = '';
                } else if (day > daysInMonth) {
                    cell.innerHTML = '';
                } else {
                    let cellContent = document.createElement('div');
                    cellContent.classList.add('day-number');
                    cellContent.innerText = day;

                    // Mantener el día activo cuando el usuario hace clic
                    if (selectedDay === day) {
                        cellContent.classList.add('active-day');
                    }

                    // Resaltar el día actual automáticamente si no hay día seleccionado
                    if (day === currentDay && month === currentMonth && year === currentYear && selectedDay === null) {
                        cellContent.classList.add('active-day');
                        selectedDay = day;
                    }

                    // Si hay citas, agregar bolitas de colores
                    if (appointments[day]) {
                        let statusContainer = document.createElement('div');
                        statusContainer.classList.add('status-container');

                        appointments[day].forEach(status => {
                            let statusDot = document.createElement('span');
                            statusDot.classList.add('status-dot');

                            // Asignar color según el estado
                            switch (status) {
                                case 'Pendiente': statusDot.classList.add('pendiente'); break;
                                case 'Confirmada': statusDot.classList.add('confirmada'); break;
                                case 'Completada': statusDot.classList.add('completada'); break;
                                case 'Cancelada': statusDot.classList.add('cancelada'); break;
                            }

                            statusContainer.appendChild(statusDot);
                        });

                        cellContent.appendChild(statusContainer);
                    }

                    // Evento para cambiar el día activo al hacer clic
                    cell.addEventListener('click', function () {
                        document.querySelectorAll('.active-day').forEach(el => el.classList.remove('active-day'));
                        cellContent.classList.add('active-day');
                        selectedDay = day;
                    });

                    cell.appendChild(cellContent);
                    day++;
                }

                row.appendChild(cell);
            }

            monthDaysContainer.appendChild(row);
        }
    }

    // Mostrar el mes actual al cargar la página
    let today = new Date();
    showMonthView(today.getFullYear(), today.getMonth());

    // Navegación entre meses
    document.getElementById('prevMonth').addEventListener('click', function () {
        let currentMonth = parseInt(document.getElementById('currentMonthName').dataset.month);
        let year = parseInt(document.getElementById('currentMonthName').dataset.year);
        if (currentMonth > 0) {
            currentMonth--;
        } else {
            currentMonth = 11;
            year--;
        }
        showMonthView(year, currentMonth);
    });

    document.getElementById('nextMonth').addEventListener('click', function () {
        let currentMonth = parseInt(document.getElementById('currentMonthName').dataset.month);
        let year = parseInt(document.getElementById('currentMonthName').dataset.year);
        if (currentMonth < 11) {
            currentMonth++;
        } else {
            currentMonth = 0;
            year++;
        }
        showMonthView(year, currentMonth);
    });
});

let appointments = @json($groupedAppointments);

</script>
@endsection
