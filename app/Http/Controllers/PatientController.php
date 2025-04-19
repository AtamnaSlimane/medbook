<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\Factory;
class PatientController extends Controller
{
public function dashboard()
{
    $userId=Auth::id();
    // Fetch all doctors
$patient=Auth::user();
    // Fetch all appointments for the logged-in patient
    $appointments = Auth::user()->appointmentsAsPatient()
        ->with('doctor') // Load doctor details
        ->orderBy('appointment_date')
        ->get();
$sort = request()->get('sort', 'name');
    $order = request()->get('order', 'asc');

    $doctors = User::where('role', 'doctor')
        ->when($sort, function ($query) use ($sort, $order) {
            $query->orderBy($sort, $order);
        })
        ->get();
   $totalAppointments = Appointment::where('patient_id', $userId)->count();
    $pendingAppointments = Appointment::where('patient_id', $userId)->where('status', 'pending')->count();
    $completedAppointments = Appointment::where('patient_id', $userId)->where('status', 'completed')->count();
    $canceledAppointments = Appointment::where('patient_id', $userId)->where('status', 'canceled')->count();
$upcomingAppointments = Appointment::where('patient_id', $userId)
    ->where('appointment_date', '>=', now())
    ->orderBy('appointment_date')
    ->paginate(5);
$totalUpcoming = $upcomingAppointments->count();
$confirmedUpcoming = $upcomingAppointments->where('status', 'booked')->count();
$lastAppointment = Appointment::where('patient_id', $userId)
    ->orderBy('appointment_date', 'desc')
    ->first();
    // Debugging output
    //dd($appointments); // This will stop execution and show appointments data

    return view('patient.dashboard', compact('doctors', 'appointments','patient','totalAppointments','pendingAppointments','completedAppointments','canceledAppointments','sort','order','lastAppointment','confirmedUpcoming','totalUpcoming','upcomingAppointments'));
}

public function appointments(Request $request)
{
    $user = Auth::user();
    $userId = $user->id;
    $patient = $user->patient;

    // Default values for filtering, sorting, and date range
    $search = request('search');
    $filter = $request->get('filter', 'all');
    $sort = $request->get('sort', 'appointment_date');
    $order = in_array($request->get('order'), ['asc', 'desc']) ? $request->get('order') : 'asc';
    $dateFrom = $request->get('date_from');
    $dateTo = $request->get('date_to');

    // Fetch appointments based on filters, sorting, and search query
    $appointments = $user->appointmentsAsPatient()
        ->with('doctor.doctorProfile')
        ->when($filter !== 'all', fn($q) => $q->where('status', $filter))
        ->when($sort === 'appointment_date', fn($q) => $q->orderBy('appointment_date', $order))
        ->when($sort === 'doctor', function ($q) use ($order) {
            $q->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
                ->orderBy('doctors.name', $order)
                ->select('appointments.*'); // Ensure selecting appointments fields correctly
        })
        ->when($dateFrom, fn($q) => $q->whereDate('appointment_date', '>=', $dateFrom))
        ->when($dateTo, fn($q) => $q->whereDate('appointment_date', '<=', $dateTo))
        ->when($search, function ($q) use ($search) {
            $q->whereHas('doctor', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhereHas('doctorProfile', function ($subQuery) use ($search) {
                        $subQuery->where('specialty', 'like', "%$search%");
                    });
            });
        })
        ->paginate(10);

    // Fetch other data for the view
    $doctors = User::where('role', 'doctor')->orderBy('name', $order)->get();

    $totalAppointments = Appointment::where('patient_id', $userId)->count();
    $pendingAppointments = Appointment::where('patient_id', $userId)->where('status', 'pending')->count();
    $completedAppointments = Appointment::where('patient_id', $userId)->where('status', 'completed')->count();
    $canceledAppointments = Appointment::where('patient_id', $userId)->where('status', 'canceled')->count();

    $upcomingAppointments = Appointment::where('patient_id', $userId)
        ->where('appointment_date', '>=', now())
        ->orderBy('appointment_date')
        ->get();

    $totalUpcoming = $upcomingAppointments->count();
    $confirmedUpcoming = $upcomingAppointments->where('status', 'booked')->count();

    $lastAppointment = Appointment::where('patient_id', $userId)
        ->orderBy('appointment_date', 'desc')
        ->first();

    return view('patient.appointments', compact(
        'doctors',
        'user',
        'appointments',
        'patient',
        'totalAppointments',
        'pendingAppointments',
        'completedAppointments',
        'canceledAppointments',
        'sort',
        'order',
        'lastAppointment',
        'confirmedUpcoming',
        'totalUpcoming',
        'upcomingAppointments',
        'dateFrom',
        'dateTo'
    ));
}

public function bookAppointment(Request $request)
{
    // Common validation rules
    $rules = [
        'doctor_id' => [
            'required',
            Rule::exists('users', 'id')->where('role', 'doctor'),
        ],
        'appointment_date' => 'required|date|after_or_equal:today',
        'appointment_time' => 'required|date_format:H:i',
    ];

    // Validate request
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return $request->wantsJson()
            ? response()->json(['errors' => $validator->errors()], 422)
            : redirect()->back()->withErrors($validator)->withInput();
    }

    // Check for conflicts (date and time)
    $datetime = $request->appointment_date . ' ' . $request->appointment_time;
    $conflict = Appointment::where('doctor_id', $request->doctor_id)
        ->whereDate('appointment_date', $request->appointment_date)  // Check only the date
        ->whereTime('appointment_date', $request->appointment_time)  // Check only the time
        ->whereIn('status', ['pending', 'booked'])
        ->exists();

    if ($conflict) {
        return $request->wantsJson()
            ? response()->json(['errors' => ['appointment_time' => 'This time slot is already booked']], 409)
            : redirect()->back()->withErrors(['appointment_time' => 'This time slot is already booked.'])->withInput();
    }

    // Create appointment
    $appointment = Appointment::create([
        'patient_id' => auth()->id(),
        'doctor_id' => $request->doctor_id,
        'appointment_date' => $datetime,
        'status' => 'pending',
    ]);

    // Return appropriate response based on request type
    if ($request->wantsJson() || $request->ajax() || $request->isJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Appointment booked successfully!',
            'appointment' => $appointment
        ], 201);
    } else {
        return redirect()->route('patient.appointments')
            ->with('success', 'Appointment booked successfully!');
    }
}


public function cancel(Appointment $appointment)
{
    if ($appointment->patient_id !== auth()->id()) {
        abort(403); // Prevent unauthorized cancellations
    }

    $appointment->update(['status' => 'canceled']);

    return redirect()->back()->with('success', 'Appointment canceled.');
}

public function showDoctorProfile($id)
{
    $patient = Auth::user();
    $appointments = Appointment::where('doctor_id', $id)->latest()->paginate(10);

    $doctor = Doctor::where('user_id', $id)->firstOrFail();

    $doctor->age = Carbon::parse($doctor->date_of_birth)->age;

    $hasAppointment = $doctor->appointmentsAsDoctor()
        ->where('patient_id', $patient->id)
        ->exists();

    return view('patient.doctor-profile', compact('doctor', 'appointments', 'patient', 'hasAppointment'));
}
public function getAvailableTimes(User $doctor, Request $request)
{
    $request->validate([
        'date' => 'required|date|after_or_equal:today',
    ]);

    if ($doctor->role !== 'doctor') abort(404);

    $date = $request->input('date');

    // Get booked times
    $bookedTimes = Appointment::where('doctor_id', $doctor->id)
        ->whereDate('appointment_date', $date)
        ->whereIn('status', ['booked'])
        ->get()
        ->map(function ($appointment) {
            return \Carbon\Carbon::parse($appointment->appointment_date)->format('H:i');
        })
        ->toArray();

    // Generate all possible time slots
    $slots = [];
    $start = \Carbon\Carbon::createFromTime(9, 0);
    $end = \Carbon\Carbon::createFromTime(16, 0);

    while ($start <= $end) {
        $time = $start->format('H:i');
        if (!in_array($time, $bookedTimes)) {
            $slots[] = $time;
        }
        $start->addMinutes(30);
    }

    return response()->json($slots);
}
public function explore(Request $request)
{
    $user=Auth::user();
    $patient = Auth::user()->patient;

    // Get request parameters
    $specialtyFilter = $request->get('specialty', 'all');
    $sort = $request->get('sort', 'name');
    $order = $request->get('order', 'asc');
    $search = $request->get('search');
$alldoctors=Doctor::count();
    // Base query for doctors with eager loading
    $doctorsQuery = User::where('role', 'doctor')
        ->with(['doctorProfile'])
        ->whereHas('doctorProfile');

    // Apply search filter
    if ($search) {
        $doctorsQuery->where(function($query) use ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhereHas('doctorProfile', function($q) use ($search) {
                      $q->where('specialty', 'LIKE', "%{$search}%");
                  });
        });
    }

    // Apply specialty filter
    if ($specialtyFilter !== 'all') {
        $doctorsQuery->whereHas('doctorProfile', function($q) use ($specialtyFilter) {
            $q->where('specialty', 'LIKE', "%{$specialtyFilter}%");
        });
    }

    // Apply sorting
    switch ($sort) {
        case 'name':
            $doctorsQuery->orderBy('name', $order);
            break;

        case 'experience':
            $doctorsQuery->orderBy(
                DoctorProfile::select('experience')
                    ->whereColumn('doctor_profiles.user_id', 'users.id'),
                $order
            );
            break;

        case 'rating':
            $doctorsQuery->orderBy(
                DoctorProfile::select('rating')
                    ->whereColumn('doctor_profiles.user_id', 'users.id'),
                $order
            );
            break;
    }

    // Get unique specialties from doctor profiles
    $specialties = Doctor::select('specialty')
        ->distinct()
        ->get()
        ->flatMap(function($profile) {
            return array_map('trim', explode(',', $profile->specialty));
        })
        ->unique()
        ->filter()
        ->values();

    // Paginate results
    $doctors = $doctorsQuery->paginate(10)
        ->appends($request->query());
$doctorscount=$doctorsQuery->count();
    return view('patient.explore', [
        'doctors' => $doctors,
        'user'=>$user,
        'alldoctors' => $alldoctors,
        'patient' => $patient,
        'currentSpecialty' => $specialtyFilter,
        'sort' => $sort,
        'doctorscount'=>$doctorscount,
        'order' => $order,
        'specialties' => $specialties,
        'search' => $search
    ]);
}


}
