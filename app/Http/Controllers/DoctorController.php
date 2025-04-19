<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Mail\AppointmentNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\Patient;
use Carbon\Carbon;
class DoctorController extends Controller
{

public function dashboard()
{
    if (!Auth::check()) {
        \Log::error('No user authenticated');
        return redirect()->route('login')->with('error', 'Please log in');
    }

    $user = Auth::user();
    $userId = $user->id;
    $doctor = Auth::user()->doctor;

    if (!$user->isDoctor()) {
        \Log::warning('Non-doctor user attempting to access doctor dashboard', [
            'user_id' => $userId,
            'user_role' => $user->role
        ]);
        return redirect()->route('home')->with('error', 'Unauthorized access');
    }
$allappointments = $user->appointmentsAsDoctor()
        ->with('patient')
        ->orderBy('appointment_date')
        ->get();
// Count the statuses
$statusCounts = $allappointments->groupBy('status')->map->count();

// Ensure every status is represented, even if there are no appointments for it
$statuses = ['booked', 'completed', 'canceled', 'pending'];
$statusData = [];

foreach ($statuses as $status) {
    $statusData[$status] = $statusCounts->get($status, 0);
}

$appointmentStats = (object) [
    'statusData' => $statusData,
];
    // Fetch appointments with eager loading
    $appointments = $user->appointmentsAsDoctor()
        ->with('patient')
        ->whereIn('status', ['pending', 'booked', 'completed'])
        ->orderBy('appointment_date')
        ->get();

  $appointmentss = $user->appointmentsAsDoctor()
        ->with('patient')
        ->whereIn('status', ['canceled', 'booked', 'completed'])
        ->orderBy('appointment_date')
        ->get();

    $totalAppointments = $appointments->count();
    $pendingAppointments = $appointments->where('status', 'pending')->count();
    $completedAppointments = $appointments->where('status', 'completed')->count();

    $bookedAppointments = $appointments->where('status', 'booked')->count();
    $totalAppointmentss = $appointmentss->count();
    $canceledAppointments = $appointmentss->where('status', 'canceled')->count();
    //$canceledAppointments = Appointment::where('doctor_id', $userId)->where('status', 'canceled')->count();

    $cancellationRate = $totalAppointmentss > 0
        ? round(($canceledAppointments / $totalAppointmentss) * 100, 2)
        : 0;

    // Fetch patients that have at least one booked or completed appointment
$patientsWithBookedOrCompletedAppointments = User::where('role', 'patient')
    ->whereIn('id', function ($query) use ($userId) {
        $query->select('patient_id')
            ->from('appointments')
            ->where('doctor_id', $userId)
            ->whereIn('status', ['booked', 'completed']);
    })
    ->with('patient') // assumes User hasOne Patient
    ->get();

// Calculate gender distribution
$genderDistribution = $patientsWithBookedOrCompletedAppointments->groupBy(function ($user) {
    return $user->patient->sex ?? 'unknown';
})->map(function ($group, $sex) use ($patientsWithBookedOrCompletedAppointments) {
    $percentage = round(($group->count() / $patientsWithBookedOrCompletedAppointments->count()) * 100, 2);
    return (object) [
        'sex' => $sex,
        'percentage' => $percentage,
    ];
});
    // Calculate age distribution
$ageDistribution = [
    '0-18' => 0,
    '19-30' => 0,
    '31-45' => 0,
    '46-60' => 0,
    '60+' => 0,
];

foreach ($patientsWithBookedOrCompletedAppointments as $patient) {
    $age = $patient->patient->date_of_birth ? \Carbon\Carbon::parse($patient->patient->date_of_birth)->age : null;
    if ($age !== null) {
        if ($age <= 18) {
            $ageDistribution['0-18']++;
        } elseif ($age <= 30) {
            $ageDistribution['19-30']++;
        } elseif ($age <= 45) {
            $ageDistribution['31-45']++;
        } elseif ($age <= 60) {
            $ageDistribution['46-60']++;
        } else {
            $ageDistribution['60+']++;
        }
    }
}

$ageDistributionFormatted = [];
$patientCount = $patientsWithBookedOrCompletedAppointments->count();

foreach ($ageDistribution as $range => $count) {
    $percentage = $patientCount > 0 ? round(($count / $patientCount) * 100, 2) : 0;
    $ageDistributionFormatted[] = (object) [
        'age_range' => $range,
        'percentage' => $percentage,
    ];
}

    // Doctor Statistics
    $doctorStats = [
        'averageDuration' => $appointments->avg('duration'),
        'cancellationRate' => $cancellationRate,
        'genderDistribution' => $genderDistribution,
        'ageDistribution' => $ageDistributionFormatted,
'bloodTypeDistribution' => $this->getBloodTypeDistribution($userId)->mapWithKeys(function ($item) {
        return [$item->blood_type ?? 'Unknown' => $item->percentage];
    }),
        'peakHours' => $this->getPeakHours($userId)
    ];

    $upcomingAppointments = Appointment::where('doctor_id', $userId)
        ->whereDate('appointment_date', '>=', now())
        ->whereIn('status', ['booked'])
        ->paginate(10);
    $upcomingAppointmentscount=$upcomingAppointments->count();
    $averageDailyAppointments = $totalAppointments > 0
        ? round($totalAppointments / 30, 2)
        : 0;
    $calendarEvents = $appointments->map(function ($appointment) {
        return [
            'title' => 'Appointment with ' . ($appointment->patient->name ?? 'Unknown'),
            'start' => optional($appointment->appointment_date)->format('Y-m-d\TH:i:s'),
            'url' => route('appointments.show', $appointment->id),
        ];
    })->filter();

    // Patients stats
    $activePatients = User::where('role', 'patient')
        ->whereIn('id', function ($query) {
            $query->select('patient_id')
                ->from('appointments')
                ->whereDate('appointment_date', '>=', now()->subMonths(3));
        })->count();

    $newPatients = User::patients()
        ->whereDate('created_at', '>=', now()->subDays(30))
        ->count();
   $activePatients = User::where('role', 'patient')
        ->whereIn('id', function ($query) use ($userId) {
            $query->select('patient_id')
                ->from('appointments')
                ->where('doctor_id', $userId)
                ->whereDate('appointment_date', '>=', now()->subMonths(3))
                ->whereIn('status', ['booked', 'completed']);
        })
        ->count();
  $newPatients = User::where('role', 'patient')
        ->whereIn('id', function ($query) use ($userId) {
            $query->select('patient_id')
                ->from('appointments')
                ->where('doctor_id', $userId)
                ->whereDate('created_at', '>=', now()->subDays(30));
        })
        ->count();


$newPatientsComparison = $this->getNewPatientsComparison($userId);
$cancellationRateComparison = $this->getCancellationRateComparison($userId);
$peakHours = $this->getPeakHours($userId);
$appointmentsPerDay = Appointment::where('doctor_id', $userId)
    ->whereDate('appointment_date', '>=', now()->subDays(30))
    ->selectRaw('DATE(appointment_date) as date, COUNT(*) as total')
    ->groupBy('date')
    ->orderBy('date')
    ->get()
    ->mapWithKeys(fn($item) => [Carbon::parse($item->date)->format('Y-m-d') => $item->total]);
    // Return view with the doctor stats and other data
    return view('doctor.dashboard', compact(
        'appointments',
        'appointmentss',
        'appointmentsPerDay',
        'doctor',
        'user',
        'pendingAppointments',
        'newPatientsComparison',
        'cancellationRateComparison',
        'completedAppointments',
        'doctorStats',
        'totalAppointments',
        'allappointments',
        'upcomingAppointments',
        'averageDailyAppointments',
        'newPatients',
        'activePatients',
        'bookedAppointments',
        'calendarEvents',
        'appointmentStats',
        'upcomingAppointments'
    ));
}

protected function getCancellationRateComparison($doctorId)
{
    // This Month
    $thisMonthAppointments = Appointment::where('doctor_id', $doctorId)
        ->whereBetween('appointment_date', [now()->startOfMonth(), now()])
        ->get();

    $thisMonthTotal = $thisMonthAppointments->count();
    $thisMonthCanceled = $thisMonthAppointments->where('status', 'canceled')->count();

    $thisMonthRate = $thisMonthTotal > 0
        ? round(($thisMonthCanceled / $thisMonthTotal) * 100, 2)
        : 0;

    // Last Month
    $lastMonthAppointments = Appointment::where('doctor_id', $doctorId)
        ->whereBetween('appointment_date', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
        ->get();

    $lastMonthTotal = $lastMonthAppointments->count();
    $lastMonthCanceled = $lastMonthAppointments->where('status', 'canceled')->count();

    $lastMonthRate = $lastMonthTotal > 0
        ? round(($lastMonthCanceled / $lastMonthTotal) * 100, 2)
        : 0;

    $change = $lastMonthRate > 0
        ? round($thisMonthRate - $lastMonthRate, 2)
        : ($thisMonthRate > 0 ? 100 : 0);

    return (object)[
        'thisMonthRate' => $thisMonthRate,
        'lastMonthRate' => $lastMonthRate,
        'change' => $change,
    ];
}

protected function getNewPatientsComparison($doctorId)
{
    $thisMonth = User::where('role', 'patient')
        ->whereIn('id', function ($query) use ($doctorId) {
            $query->select('patient_id')
                ->from('appointments')
                ->where('doctor_id', $doctorId)
                ->whereBetween('created_at', [now()->startOfMonth(), now()]);
        })->count();

    $lastMonth = User::where('role', 'patient')
        ->whereIn('id', function ($query) use ($doctorId) {
            $query->select('patient_id')
                ->from('appointments')
                ->where('doctor_id', $doctorId)
                ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]);
        })->count();

    $change = $lastMonth > 0
        ? round((($thisMonth - $lastMonth) / $lastMonth) * 100, 2)
        : ($thisMonth > 0 ? 100 : 0); // 100% increase if last month was 0

    return (object)[
        'thisMonth' => $thisMonth,
        'lastMonth' => $lastMonth,
        'change' => $change,
    ];
}
private function getGenderDistribution()
{
    return DB::table('patients')
        ->select('sex', DB::raw('COUNT(*) as count'))
        ->groupBy('sex')
        ->get()
        ->map(function ($item) {
            $total = DB::table('patients')->count();
            $item->percentage = round(($item->count / $total) * 100, 2);
            return $item;
        });
}

private function getAgeDistribution()
{
    return DB::table('patients')
        ->selectRaw('CASE
            WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 18 AND 30 THEN "18-30"
            WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 31 AND 45 THEN "31-45"
            WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 46 AND 60 THEN "46-60"
            ELSE "60+"
        END as age_range,
        COUNT(*) as count')
        ->groupBy('age_range')
        ->get()
        ->map(function ($item) {
            $total = User::patients()->count();
            $item->percentage = round(($item->count / $total) * 100, 2);
            return $item;
        });
}

private function getBloodTypeDistribution($doctorId)
{
    return DB::table('patients')
        ->join('users', 'patients.user_id', '=', 'users.id')
        ->whereIn('users.id', function ($query) use ($doctorId) {
            $query->select('patient_id')
                ->from('appointments')
                ->where('doctor_id', $doctorId)
                ->whereIn('status', ['booked', 'completed']);
        })
        ->select('blood_type', DB::raw('COUNT(*) as count'))
        ->groupBy('blood_type')
        ->get()
        ->map(function ($item) use ($doctorId) {
            $total = DB::table('patients')
                ->join('users', 'patients.user_id', '=', 'users.id')
                ->whereIn('users.id', function ($query) use ($doctorId) {
                    $query->select('patient_id')
                        ->from('appointments')
                        ->where('doctor_id', $doctorId)
                        ->whereIn('status', ['booked', 'completed']);
                })->count();

            $item->percentage = $total > 0 ? round(($item->count / $total) * 100, 2) : 0;
            return $item;
        });
}


private function getPeakHours($doctorId)
{
    $peak = Appointment::where('doctor_id', $doctorId)
        ->selectRaw('HOUR(appointment_date) as hour, COUNT(*) as count')
        ->groupBy('hour')
        ->orderByDesc('count')
        ->first();

    return $peak ? sprintf('%02d:00 - %02d:00', $peak->hour, $peak->hour + 1) : 'No data available';
}
    public function updateStatus(Appointment $appointment, Request $request)
    {
        abort_unless($appointment->doctor_id === Auth::id(), 403);

        $request->validate([
            'status' => 'required|in:completed,canceled'
        ]);

        $appointment->update(['status' => $request->status]);
        return back()->with('success', 'Status updated');
    }



public function getAppointmentEvents()
{
    $user=Auth::user();
$appointments = Appointment::with('patient')
    ->where('doctor_id', auth()->id())
    ->where('status', '!=', 'canceled') // ✅ Exclude cancelled here
    ->get();
$events = $appointments
    ->map(function ($appointment) {
        return [
            'id' => $appointment->id,
            'title' => $appointment->patient->name,
            'start' => $appointment->appointment_date,
            'end' => \Carbon\Carbon::parse($appointment->appointment_date)
                ->addMinutes($appointment->duration)
                ->toIso8601String(),
            'status' => $appointment->status,
            'extendedProps' => [
                'patient_id' => $appointment->patient_id
                // removed status here to avoid conflict
            ]
        ];
    });
 $appointments = $user->appointmentsAsDoctor()
        ->with('patient')
        ->whereIn('status', ['pending', 'booked', 'completed'])
        ->orderBy('appointment_date')
        ->get();

    return view('doctor.schedule', ['events' => $events],compact('user'));
}

public function showPatientProfile($id)
{
    $doctorId = auth()->id();

    $appointments = Appointment::where('patient_id', $id)
        ->where('doctor_id', $doctorId)
        ->latest()
        ->paginate(10);

    $patient = Patient::where('user_id', $id)->firstOrFail();
    $patient->age = Carbon::parse($patient->date_of_birth)->age;

    return view('doctor.patient-profile', compact('patient', 'appointments'));
}



public function sendAppointmentEmail($appointment)
{
    // Get relevant appointment data
    $data = [
        'to' => $appointment->patient->email,  // Send to the patient's email
        'name' => $appointment->patient->name, // Patient's name
        'subject' => 'Appointment Confirmation', // Subject of the email
        'message' => "This is a confirmation for your appointment with Dr. " . $appointment->doctor->name .
                     " on " . $appointment->appointment_date->format('Y-m-d') . " at " . $appointment->appointment_date->format('H:i') . "."
    ];

    try {
        // Send email using Brevo via the SendinblueMailer
        Mail::to($data['to'])->send(new SendinblueMailer($data));

        return response()->json(['message' => 'Email sent successfully!']);
    } catch (\Exception $e) {
        // Return error message if email fails
        return response()->json(['error' => 'Failed to send email: ' . $e->getMessage()], 500);
    }
}

public function accept(Appointment $appointment)
{
    if ($appointment->doctor_id !== auth()->id()) {
        abort(403); // Prevent unauthorized updates
    }

    // Update the status to booked
    $appointment->update(['status' => 'booked']);

    // Send appointment confirmation email
   // $this->sendAppointmentEmail($appointment);

    $patient = $appointment->user;
    if ($patient) {
        $patient->notify(new AppointmentStatusNotification($appointment, 'booked'));
    }

    return redirect()->back()->with('success', 'Appointment accepted.');
}

public function reject(Appointment $appointment)
{
    if ($appointment->doctor_id !== auth()->id()) {
        abort(403);
    }

    // Update the status to rejected
    $appointment->update(['status' => 'rejected']);

    // Send rejection email
    $this->sendAppointmentEmail($appointment);

    $patient = $appointment->user;
    if ($patient) {
        $patient->notify(new AppointmentStatusNotification($appointment, 'rejected'));
    }

    return redirect()->back()->with('success', 'Appointment rejected.');
}

public function availability(Doctor $doctor, Request $request)
{
    $request->validate([
        'date' => 'required|date|after_or_equal:today'
    ]);

    return response()->json([
        'available_slots' => $doctor->availableTimeSlots($request->date)
    ]);
}
public function availableTimes(Doctor $doctor, Request $request)
{
    $request->validate([
        'date' => 'required|date_format:Y-m-d'
    ]);

    try {
        // Get doctor's schedule for the selected day
        $schedule = $doctor->schedules()
            ->where('day', strtolower(Carbon::parse($request->date)->englishDayOfWeek))
            ->first();

        if (!$schedule) {
            return response()->json([]);
        }

        // Get existing appointments for the date
        $bookedSlots = $doctor->appointments()
            ->whereDate('appointment_date', $request->date)
            ->pluck('appointment_time')
            ->toArray();

        // Generate available time slots
        $slots = [];
        $start = Carbon::parse($schedule->start_time);
        $end = Carbon::parse($schedule->end_time);

        while ($start < $end) {
            $time = $start->format('H:i');
            if (!in_array($time, $bookedSlots)) {
                $slots[] = $time;
            }
            $start->addMinutes($schedule->appointment_duration);
        }

        return response()->json($slots);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error fetching time slots'
        ], 500);
    }
}
public function appointments(Request $request)
{
    if (!Auth::check()) {
        \Log::error('No user authenticated');
        return redirect()->route('login')->with('error', 'Please log in');
    }

    $user = Auth::user();
    $userId = $user->id;
    $doctor = Auth::user()->doctor;

    if (!$user->isDoctor()) {
        \Log::warning('Non-doctor user attempting to access doctor dashboard', [
            'user_id' => $userId,
            'user_role' => $user->role
        ]);
        return redirect()->route('home')->with('error', 'Unauthorized access');
    }

    // Get all appointments for stats calculations
    $allappointments = $user->appointmentsAsDoctor()
        ->with('patient')
        ->orderBy('appointment_date')
        ->get();

    // Count the statuses
    $statusCounts = $allappointments->groupBy('status')->map->count();

    // Ensure every status is represented, even if there are no appointments for it
    $statuses = ['booked', 'completed', 'canceled', 'pending'];
    $statusData = [];
    foreach ($statuses as $status) {
        $statusData[$status] = $statusCounts->get($status, 0);
    }

    $appointmentStats = (object) [
        'statusData' => $statusData,
    ];

    // Base query for filtered appointments
    $query = $user->appointmentsAsDoctor()->with('patient');

    // Apply search filter
    if ($request->has('search') && !empty($request->search)) {
        $searchTerm = $request->search;
        $query->whereHas('patient', function ($q) use ($searchTerm) {
            $q->where('name', 'like', '%' . $searchTerm . '%')
              ->orWhere('email', 'like', '%' . $searchTerm . '%')
              ->orWhere('phone', 'like', '%' . $searchTerm . '%');
        });
    }

    // Apply status filter
    if ($request->has('status') && !empty($request->status)) {
        $query->where('status', $request->status);
    }

    // Apply date range filters
    if ($request->has('date_from') && !empty($request->date_from)) {
        $query->whereDate('appointment_date', '>=', $request->date_from);
    }

    if ($request->has('date_to') && !empty($request->date_to)) {
        $query->whereDate('appointment_date', '<=', $request->date_to);
    }

    // Apply sorting
    switch ($request->sort_by) {
        case 'date_asc':
            $query->orderBy('appointment_date', 'asc');
            break;
        case 'date_desc':
            $query->orderBy('appointment_date', 'desc');
            break;
        case 'patient_name':
            $query->join('users', 'appointments.patient_id', '=', 'users.id')
                  ->orderBy('users.name', 'asc')
                  ->select('appointments.*');
            break;
        case 'patient_name_desc':
            $query->join('users', 'appointments.patient_id', '=', 'users.id')
                  ->orderBy('users.name', 'desc')
                  ->select('appointments.*');
            break;
        default:
            $query->orderBy('appointment_date', 'asc'); // Default sort
    }

    // Paginate the filtered appointments
    $showingAppointments = $query->paginate(10)->withQueryString();

    // Get appointments for different stats (unfiltered)
    $appointments = $user->appointmentsAsDoctor()
        ->with('patient')
        ->whereIn('status', ['pending', 'booked', 'completed'])
        ->orderBy('appointment_date')
        ->get();

    $appointmentss = $user->appointmentsAsDoctor()
        ->with('patient')
        ->whereIn('status', ['canceled', 'booked', 'completed'])
        ->orderBy('appointment_date')
        ->get();

    $totalAppointments = $appointments->count();
    $pendingAppointments = $appointments->where('status', 'pending')->count();
    $completedAppointments = $appointments->where('status', 'completed')->count();
    $bookedAppointments = $appointments->where('status', 'booked')->count();
    $totalAppointmentss = $appointmentss->count();
    $canceledAppointments = $appointmentss->where('status', 'canceled')->count();

       // Fetch patients that have at least one booked or completed appointment
    $patientsWithBookedOrCompletedAppointments = User::where('role', 'patient')
        ->whereIn('id', function ($query) use ($userId) {
            $query->select('patient_id')
                ->from('appointments')
                ->where('doctor_id', $userId)
                ->whereIn('status', ['booked', 'completed']);
        })
        ->with('patient') // assumes User hasOne Patient
        ->get();



    $patientCount = $patientsWithBookedOrCompletedAppointments->count();


    $upcomingAppointments = Appointment::where('doctor_id', $userId)
        ->whereDate('appointment_date', '>=', now())
        ->whereIn('status', ['booked'])
        ->paginate(10);

    $upcomingAppointmentscount = $upcomingAppointments->count();

    $averageDailyAppointments = $totalAppointments > 0
        ? round($totalAppointments / 30, 2)
        : 0;

    $calendarEvents = $appointments->map(function ($appointment) {
        return [
            'title' => 'Appointment with ' . ($appointment->patient->name ?? 'Unknown'),
            'start' => optional($appointment->appointment_date)->format('Y-m-d\TH:i:s'),
            'url' => route('appointments.show', $appointment->id),
        ];
    })->filter();

    // Patients stats
    $activePatients = User::where('role', 'patient')
        ->whereIn('id', function ($query) use ($userId) {
            $query->select('patient_id')
                ->from('appointments')
                ->where('doctor_id', $userId)
                ->whereDate('appointment_date', '>=', now()->subMonths(3))
                ->whereIn('status', ['booked', 'completed']);
        })
        ->count();

    $newPatients = User::where('role', 'patient')
        ->whereIn('id', function ($query) use ($userId) {
            $query->select('patient_id')
                ->from('appointments')
                ->where('doctor_id', $userId)
                ->whereDate('created_at', '>=', now()->subDays(30));
        })
        ->count();

    $newPatientsComparison = $this->getNewPatientsComparison($userId);
    $cancellationRateComparison = $this->getCancellationRateComparison($userId);
    $peakHours = $this->getPeakHours($userId);

    $appointmentsPerDay = Appointment::where('doctor_id', $userId)
        ->whereDate('appointment_date', '>=', now()->subDays(30))
        ->selectRaw('DATE(appointment_date) as date, COUNT(*) as total')
        ->groupBy('date')
        ->orderBy('date')
        ->get()
        ->mapWithKeys(fn($item) => [Carbon::parse($item->date)->format('Y-m-d') => $item->total]);

    // Return view with the doctor stats and other data
    return view('doctor.appointments', compact(
        'appointments',
        'appointmentss',
        'appointmentsPerDay',
        'doctor',
        'user',
        'pendingAppointments',
        'newPatientsComparison',
        'cancellationRateComparison',
        'completedAppointments',
        'totalAppointments',
        'allappointments',
        'upcomingAppointments',
        'averageDailyAppointments',
        'newPatients',
        'activePatients',
        'bookedAppointments',
        'calendarEvents',
        'appointmentStats',
        'showingAppointments',
        'canceledAppointments',
        'upcomingAppointments'
    ));
}
public function patients(Request $request)
{
    // Check authentication
    if (!Auth::check()) {
        \Log::error('No user authenticated');
        return redirect()->route('login')->with('error', 'Please log in');
    }

    $user = Auth::user();
    $userId = $user->id;
    $doctor = $user->doctor;

    // Verify the user is a doctor
    if (!$user->isDoctor()) {
        \Log::warning('Non-doctor user attempting to access doctor dashboard', [
            'user_id' => $userId,
            'user_role' => $user->role
        ]);
        return redirect()->route('home')->with('error', 'Unauthorized access');
    }

    // Build base patient query with latest appointment date
    $patientsQuery = User::where('role', 'patient')
        ->whereIn('users.id', function ($query) use ($userId) {
            $query->select('patient_id')
                ->from('appointments')
                ->where('doctor_id', $userId)
                ->whereIn('status', ['booked', 'completed']);
        })
        ->with('patient')
        ->leftJoin('appointments', function ($join) use ($userId) {
            $join->on('users.id', '=', 'appointments.patient_id')
                ->where('appointments.doctor_id', '=', $userId);
        })
        ->select('users.*', DB::raw('MAX(appointments.appointment_date) as last_visit_date'))
->groupBy('users.id', 'users.name', 'users.email', 'users.email_verified_at', 'users.password', 'users.role', 'users.phone', 'users.remember_token', 'users.created_at', 'users.updated_at', 'users.profile_picture', 'users.last_login');

    // Apply search filters
    if ($request->filled('search')) {
        $patientsQuery->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%');
        });
    }

    // Apply status filters
    if ($request->has('status') && !empty($request->status)) {
        if ($request->status === 'active') {
            $patientsQuery->whereIn('users.id', function ($subquery) use ($userId) {
                $subquery->select('patient_id')
                    ->from('appointments')
                    ->where('doctor_id', $userId)
                    ->whereDate('appointment_date', '>=', now()->subMonths(3));
            });
        } elseif ($request->status === 'inactive') {
            $patientsQuery->whereIn('users.id', function ($subquery) use ($userId) {
                $subquery->select('patient_id')
                    ->from('appointments')
                    ->where('doctor_id', $userId)
                    ->whereDate('appointment_date', '<', now()->subMonths(3));
            });
        }
    }

    // Apply date filters
    if ($request->has('date_from') && !empty($request->date_from)) {
        $patientsQuery->whereDate('users.created_at', '>=', $request->date_from);
    }
    if ($request->has('date_to') && !empty($request->date_to)) {
        $patientsQuery->whereDate('users.created_at', '<=', $request->date_to);
    }

    // Apply sorting
    $sortBy = $request->sort_by ?? 'name';
    switch ($sortBy) {
        case 'name':
            $patientsQuery->orderBy('name', 'asc');
            break;
        case 'name_desc':
            $patientsQuery->orderBy('name', 'desc');
            break;
        case 'date_asc':
            $patientsQuery->orderBy('users.created_at', 'asc');
            break;
        case 'date_desc':
            $patientsQuery->orderBy('users.created_at', 'desc');
            break;
        case 'last_visit_asc':
            $patientsQuery->orderBy('last_visit_date', 'asc');
            break;
        case 'last_visit_desc':
            $patientsQuery->orderBy('last_visit_date', 'desc');
            break;
        default:
            $patientsQuery->orderBy('name', 'asc');
    }

    // Execute query with pagination
    $showingpatients = $patientsQuery->paginate(10);

    $patients = $patientsQuery->get();

    // Get total patients count (without pagination)
    $totalPatients = $patientsQuery->count();

    // Get all appointments for various statistics
    $appointments = $user->appointmentsAsDoctor()
        ->with('patient')
        ->orderBy('appointment_date')
        ->get();

    // Calculate appointment statistics
    $pendingAppointments = $appointments->where('status', 'pending')->count();
    $bookedAppointments = $appointments->where('status', 'booked')->count();
    $completedAppointments = $appointments->where('status', 'completed')->count();
    $canceledAppointments = $appointments->where('status', 'canceled')->count();

    $relevantAppointments = $appointments->whereIn('status', ['pending', 'booked', 'completed']);
    $totalAppointments = $relevantAppointments->count();

    $totalAppointmentsWithCanceled = $appointments->count();
    $cancellationRate = $totalAppointmentsWithCanceled > 0
        ? round(($canceledAppointments / $totalAppointmentsWithCanceled) * 100, 2)
        : 0;

    // Calculate patient statistics
    $activePatients = User::where('role', 'patient')
        ->whereIn('users.id', function ($query) use ($userId) {
            $query->select('patient_id')
                ->from('appointments')
                ->where('doctor_id', $userId)
                ->whereDate('appointment_date', '>=', now()->subMonths(3))
                ->whereIn('status', ['booked', 'completed']);
        })
        ->count();

    $newPatients = User::where('role', 'patient')
        ->whereIn('users.id', function ($query) use ($userId) {
            $query->select('patient_id')
                ->from('appointments')
                ->where('doctor_id', $userId)
                ->whereDate('created_at', '>=', now()->subDays(30));
        })
        ->count();

    // Get comparison metrics
    $newPatientsComparison = $this->getNewPatientsComparison($userId);
    $cancellationRateComparison = $this->getCancellationRateComparison($userId);

    // Get appointments per day for the last 30 days
    $appointmentsPerDay = Appointment::where('doctor_id', $userId)
        ->whereDate('appointment_date', '>=', now()->subDays(30))
        ->selectRaw('DATE(appointment_date) as date, COUNT(*) as total')
        ->groupBy('date')
        ->orderBy('date')
        ->get()
        ->mapWithKeys(fn($item) => [Carbon::parse($item->date)->format('Y-m-d') => $item->total]);

    // Return view with the doctor stats and other data
    return view('doctor.patients', compact(
        'showingpatients',
        'totalPatients',
        'appointments',
        'pendingAppointments',
        'bookedAppointments',
        'completedAppointments',
        'canceledAppointments',
        'totalAppointments',
        'cancellationRate',
        'activePatients',
        'newPatients',
        'newPatientsComparison',
        'cancellationRateComparison',
        'patients',
        'appointmentsPerDay',
        'doctor',
        'user'
    ));
}

}
