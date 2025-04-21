<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Mail\OrderShipped;
use App\Models\Order;
use Illuminate\Validation\Rule;
use App\Mail\AppointmentCreatedMail;
use App\Mail\AppointmentAcceptedMail;
use App\Mail\AppointmentRejectedMail;
use App\Notifications\AppointmentAccepted;
class AppointmentController extends Controller
{
    public function create()
    {
        return view('appointments.create', [
            'doctors' => User::where('role', 'doctor')->get()
        ]);
    }

public function reject(Appointment $appointment)
{
    $appointment->update(['status' => 'canceled']);

    // Send rejection email to patient
    \Mail::to($appointment->patient->email)->send(new \App\Mail\AppointmentRejectedMail(
        $appointment->patient->name,
        $appointment->doctor->name,
        $appointment->appointment_date
    ));

    return back()->with('success', 'Appointment canceled and patient notified.');
}
public function dashboard()
{
    if (auth()->user()->role === 'doctor') {
        // If logged-in user is a doctor, show their schedule
        $appointments = Appointment::where('doctor_id', auth()->id())->get();
        return view('doctor.dashboard', compact('appointments'));
    } else {
        // If logged-in user is a patient, show all doctors
        $doctors = User::where('role', 'doctor')->get();
        return view('patient.dashboard', compact('doctors'));
    }
}

public function doctor()
{
    return $this->belongsTo(User::class, 'doctor_id');
}

public function show(Appointment $appointment)
{
    return view('appointments.index', compact('appointment'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'doctor_id' => ['required', 'exists:users,id'],
        'appointment_date' => ['required', 'date', 'after:today'],
        'duration' => ['required', 'integer', 'min:10'],
        'notes' => 'nullable|string|max:500',
    ]);

    $appointment = Appointment::create([
        'doctor_id' => $validated['doctor_id'],
        'patient_id' => Auth::id(),
        'appointment_date' => $validated['appointment_date'],
        'duration' => $validated['duration'],
        'status' => 'pending',
        'notes' => $validated['notes'],
    ]);

    // Send email notification to doctor
    \Mail::to($appointment->doctor->email)->send(new \App\Mail\AppointmentCreatedMail(
        $appointment->doctor->name,
        $appointment->patient->name,
        $appointment->appointment_date,
        $appointment->duration
    ));

    return redirect()->back()->with('success', 'Appointment created and doctor notified!');
}

public function accept(Appointment $appointment)
{
    $appointment->update(['status' => 'booked']);

    // Send email notification using Laravel's native Resend integration
    \Illuminate\Support\Facades\Mail::to($appointment->patient->email)
        ->send(new \App\Mail\AppointmentAcceptedMail(
            $appointment->patient->name,
            $appointment->doctor->name,
            $appointment->appointment_date,
            $appointment->duration
        ));

    return redirect()->back()->with('success', 'Appointment accepted and patient notified!');
}

}

