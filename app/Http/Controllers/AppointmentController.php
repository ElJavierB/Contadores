<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class AppointmentController extends Controller
{
    public function index()
    {
        // $appointments = Appointment::with(['user', 'accountant'])->get();
        // return view('appointments.appointments', compact('appointments'));
    }

    public function myAppointments()
    {
        // Obtener las citas del usuario logueado
        $appointments = Appointment::where('user_id', Auth::id())->get();

        // Agrupar las citas por mes y año
        $groupedAppointments = $appointments->groupBy(function ($date) {
            return Carbon::parse($date->date)->format('Y-m'); // Agrupamos por año y mes
        });

        // Obtener el año actual
        $currentYear = Carbon::now()->year;

        return view('appointments.appointments', compact('groupedAppointments', 'currentYear'));
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
