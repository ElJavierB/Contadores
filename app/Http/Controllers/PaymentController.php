<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class PaymentController extends Controller
{
    public function index()
    {
        $payments =  Payment::with(['user', 'accountant'])->get(); // Obtén todos los pagos
        return view('payments.index', compact('payments')); // Pasa los pagos a la vista
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_id' => ['required', 'integer', 'exists:appointments,id'],
            'amount' => ['required', 'numeric'],
            'method' => ['required', 'string', 'max:255'],
            'file' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('payments', 'public');
        }

        Payment::create([
            'user_id' => Auth::id(),
            'appointment_id' => $request->appointment_id,
            'amount' => $request->amount,
            'method' => (string) $request->method,
            'status' => 'Pendiente', // Se establece por defecto
            'payment_date' => now(),
            'file' => $filePath,
        ]);

        return redirect()->route('payments.list')->with('success', 'Pago registrado correctamente.');
    }

    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return response()->json($payment);
    }

    
    public function update(Request $request, Payment $payment)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'method' => 'required|string|max:255',
            'file' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['amount', 'method',]);

        // Manejo de archivos
        if ($request->hasFile('file')) {
            if ($payment->file) {
                Storage::disk('public')->delete($payment->file);
            }
            $filePath = $request->file('file')->store('payments', 'public');
            $data['file'] = $filePath;
        }

        $payment->update($data);

        return redirect()->route('payments.list')->with('success', 'Pago actualizado exitosamente.');
    }

    public function destroy($id)
    {
        Payment::destroy($id);
        return response()->json(null, 204);
    }

    // En PaymentController.php
    public function myPayments()
    {
        // Obtener los pagos del usuario logueado junto con los detalles de las citas
        $payments = Payment::with('appointment') // Obtener datos de las citas relacionados
                            ->where('user_id', Auth::id()) // Filtrar por el usuario logueado
                            ->get();

        // Obtener todas las citas disponibles
        $appointment = Appointment::all();

        // Retorna la vista con los pagos y lss citas
        return view('payments.list', compact('payments', 'appointment'));
    }

}
