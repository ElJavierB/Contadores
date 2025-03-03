<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class AppointmentController extends Controller
{
    public function index()
    {
        // $appointments = Appointment::with(['user', 'accountant'])->get();
        // return view('appointments.appointments', compact('appointments'));
    }
    public function myAppointments(Request $request)
    {
        // Obtener el año seleccionado o el año actual por defecto
        $year = $request->input('year', Carbon::now()->year);
    
        // Obtener las citas del usuario logueado para el año seleccionado
        $appointments = Appointment::where('user_id', Auth::id())
            ->whereYear('date', $year)
            ->get();
    
        // Agrupar las citas por mes y día
        $groupedAppointments = $appointments->groupBy(function ($date) {
            return Carbon::parse($date->date)->format('Y-m-d'); // Agrupamos por día
        });
    
        // Definir los nombres de los meses
        $months = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
    
        return view('appointments.appointments', compact('groupedAppointments', 'year', 'months'));
    }
    

    public function myAppointmentsByMonth(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);
    
        $appointments = Appointment::where('user_id', Auth::id())
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();
    
        // Agrupar citas por día
        $groupedAppointments = [];
        foreach ($appointments as $appointment) {
            $day = Carbon::parse($appointment->date)->format('j'); // Día sin ceros iniciales
            if (!isset($groupedAppointments[$day])) {
                $groupedAppointments[$day] = [];
            }
            $groupedAppointments[$day][] = $appointment->status; // Guardar solo el estado
        }
    
        Log::info('Citas enviadas al frontend:', $groupedAppointments); // 🔎 Revisión en logs
    
        return view('appointments.months', compact('groupedAppointments', 'year', 'month'));
    }
    
    

    public function store(Request $request)
    {
        $appointment = Appointment::create($request->all());
        return response()->json($appointment, 201);
    }

    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        return response()->json($appointment);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());
        return response()->json($appointment);
    }

    public function destroy($id)
    {
        Appointment::destroy($id);
        return response()->json(null, 204);
    }
}
