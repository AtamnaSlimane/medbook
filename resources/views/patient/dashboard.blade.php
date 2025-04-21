<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDBook - Doctors & Appointments</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: white;
        }
        .med-teal {
            color: #00CCCC;
        }
        .btn-teal {
            background-color: #00CCCC;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-teal:hover {
            box-shadow: 0 4px 15px rgba(0, 204, 204, 0.5);
            transform: translateY(-2px);
        }
        .card {
            background: rgba(40, 40, 40, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.4s ease;
            border-radius: 16px;
        }
        .card:hover {
            box-shadow: 0 15px 40px rgba(0, 204, 204, 0.15);
            transform: translateY(-5px);
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background-color: rgba(0, 204, 204, 0.1);
        }
        .sidebar-link.active {
            border-left: 3px solid #00CCCC;
        }
        .input-field {
            background-color: rgba(51, 51, 51, 0.8);
            border-color: #666666;
            color: white;
            transition: all 0.3s ease;
        }
        .input-field:focus {
            border-color: #00CCCC;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 204, 204, 0.2);
        }
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .badge-confirmed {
            background-color: rgba(0, 200, 81, 0.2);
            color: #00C851;
        }
        .badge-pending {
            background-color: rgba(255, 187, 51, 0.2);
            color: #FFBB33;
        }
        .badge-cancelled {
            background-color: rgba(255, 75, 75, 0.2);
            color: #FF4B4B;
        }
        .appointment-card {
            background-color: #1E1E1E;
            border-radius: 12px;
            margin-bottom: 16px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .date-indicator {
            background-color: #2A2A2A;
            padding: 12px;
            text-align: center;
        }
        .time-select {
            background-color: rgba(51, 51, 51, 0.8);
            border-color: #666666;
            color: white;
            appearance: none;
            padding-right: 2rem;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='white'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.5rem center;
            background-size: 1.5em 1.5em;
        }
        .stat-card {
            background: rgba(40, 40, 40, 0.7);
            border-radius: 12px;
            padding: 24px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .doctor-specialty {
            display: inline-block;
            padding: 4px 10px;
            background-color: rgba(0, 204, 204, 0.1);
            border-radius: 20px;
            font-size: 0.8rem;
            margin-bottom: 12px;
        }
        .logo-pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% {
                text-shadow: 0 0 5px rgba(0, 204, 204, 0.5);
            }
            50% {
                text-shadow: 0 0 20px rgba(0, 204, 204, 0.8);
            }
            100% {
                text-shadow: 0 0 5px rgba(0, 204, 204, 0.5);
            }
        }
    </style>
</head>

<body>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 p-6 flex flex-col">
            <div class="mb-10">
                <a href="{{ route('home') }}" class="flex items-center">
                    <span class="med-teal text-3xl font-bold logo-pulse">MED</span><span class="text-3xl font-bold text-white">Book</span>
                </a>
            </div>

            <nav class="flex-1">
                <a href="{{ route('patient.dashboard') }}" class="sidebar-link active">
                    <svg class="h-5 w-5 mr-3 med-teal" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{route('patient.appointments')}}" class="sidebar-link">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    My Appointments
                </a>
<a href="{{route('patient.favorites')}}" class="sidebar-link">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    My Favorites
                </a>
<a href="{{ route('patient.explore') }}" class="sidebar-link ">
    <svg class="h-5 w-5 mr-3 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
    </svg>
    Explore Doctors
</a>
               <a href="{{ route('profile.view') }}" class="sidebar-link">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profile
                </a>
            </nav>

<div class="mt-auto pt-6 border-t border-gray-800">

<div class="flex items-center">
    @if($patient->profile_picture)
        <img src="{{ asset('storage/' . $patient->profile_picture) }}"
             alt="Profile Picture"
             class="h-10 w-10 rounded-full object-cover" />
    @else
 @php
        $nameParts = explode(' ', $patient->name);
        $initials = '';
        foreach ($nameParts as $part) {
            $initials .= strtoupper(mb_substr($part, 0, 1));
        }
        $initials = mb_substr($initials, 0, 2); // Limit to 2 characters
    @endphp
    <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center text-white font-semibold">
        {{ $initials }}
    </div>
    @endif

    <div class="ml-3">
        <div class="font-medium">{{ $patient->name }}</div>
        <div class="text-sm text-gray-400">Patient</div>
    </div>
</div>

<form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                <button type="submit" class="w-full btn-teal py-2 rounded-lg text-sm font-medium flex items-center justify-center mt-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </button>
                </form>
            </div>

            </div>
               <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Header -->
            <div class="mb-10">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">Hello, {{$patient->name}}</h1>
                        <p class="text-gray-400 mt-1">{{ \Carbon\Carbon::now()->format('l, F j, Y') }} • Setif, Algeria</p>
                    </div>

                </div>
            </div>

            <!-- Stats -->

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

                <div class="stat-card">
 <div class="text-gray-400 text-sm mb-1">Upcoming appointments</div>
    <div class="flex justify-between items-end">
        <div class="text-3xl font-bold">{{ $totalUpcoming }}</div>
        <div class="text-sm text-green-400 flex items-center">
            <span class="mr-1">{{ $confirmedUpcoming }} Confirmed</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
    </div>
               </div>
                <div class="stat-card">

@if ($lastAppointment)
    <div class="text-gray-400 text-sm mb-1">Last appointment</div>
    <div class="flex justify-between items-end">
        <div class="text-3xl font-bold">
            {{ \Carbon\Carbon::parse($lastAppointment->appointment_date)->diffForHumans() }}
        </div>
        <div class="text-sm flex items-center
            @if($lastAppointment->status === 'cancelled') text-red-400
            @elseif($lastAppointment->status === 'completed') text-green-400
            @elseif($lastAppointment->status === 'pending') text-yellow-400
            @else text-gray-400 @endif">
            <span class="mr-1">{{ ucfirst($lastAppointment->status) }}</span>

            @if($lastAppointment->status === 'cancelled')
                <!-- Cancelled icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />
                </svg>
            @elseif($lastAppointment->status === 'completed')
                <!-- Completed checkmark icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7" />
                </svg>
            @elseif($lastAppointment->status === 'pending')
                <!-- Pending clock icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            @endif
        </div>
    </div>
@else
    <div class="text-gray-400 text-sm mb-1">Last appointment</div>
    <div class="text-gray-500 text-sm">No appointment found.</div>
@endif
               </div>
                <div class="stat-card">
                    <div class="text-gray-400 text-sm mb-1">Appointments count</div>
                    <div class="flex justify-between items-end">
                        <div class="text-3xl font-bold">{{$totalAppointments}}</div>
                        <div class="text-sm text-yellow-400 flex items-center">
                            <span class="mr-1">{{$pendingAppointments}} are pending</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Upcoming Appointments -->
                <div class="lg:col-span-2">
                    <div class="flex justify-between items-center mb-6" id="appointments">
                        <h2 class="text-xl font-bold">Upcoming appointments</h2>
                        <a href="{{route('patient.explore')}}" class="btn-teal px-4 py-2 rounded-lg text-sm font-medium">Book New</a>
                    </div>

                    @if($appointments->isEmpty())
                        <div class="bg-gray-800 bg-opacity-50 rounded-lg p-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-300 text-lg">You have no scheduled appointments.</p>
                            <p class="text-gray-400 mt-2">Book your first appointment from the available doctors below.</p>
                        </div>
                    @else
                        <!-- Appointment Cards -->
                        @foreach($upcomingAppointments as $appointment)

                        <div class="appointment-card flex">
                            <div class="date-indicator flex flex-col justify-center items-center w-24">
                                <div class="text-gray-400 text-sm">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M') }}</div>
                                <div class="text-2xl font-bold">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d') }}</div>
                            </div>
                            <div class="flex-1 p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold">{{ $appointment->doctor->name }}</h3>
                                        <p class="text-gray-400">{{ $appointment->doctor->specialty }}</p>
                                        <p class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('h:i A') }}</p>
                                    </div>
                                    @if($appointment->status == 'pending')
                                        <span class="status-badge badge-pending">Pending</span>
                                    @elseif($appointment->status == 'booked')
                                        <span class="status-badge badge-confirmed">Confirmed</span>
                                    @elseif($appointment->status == 'rejected')
                                        <span class="status-badge badge-cancelled">Rejected</span>
                                    @else
                                        <span class="status-badge bg-gray-600 text-white">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    @endif
                                </div>
                                @if($appointment->status == 'pending')
                                    <div class="mt-4 flex justify-end">
                                        <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Cancel
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach

<div class="mt-6 flex justify-center">
    {{ $upcomingAppointments->links('vendor.pagination.custom-black') }}
</div>

                    @endif

                </div>

<!-- Right Column: Favorites -->
<div id="favorites">
    <h2 class="text-xl font-bold mb-6">Favorite Doctors</h2>

    @forelse($favoriteDoctors as $doctor)
        <div class="card p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <!-- Display the doctor's initial or image if available -->
                    <div class="h-12 w-12 rounded-full bg-gray-700 flex items-center justify-center text-white font-semibold mr-4">
                        @if($doctor->profile_picture)
                            <img src="{{ asset('storage/' . $doctor->profile_picture) }}" class="h-12 w-12 rounded-full object-cover" alt="{{ $doctor->name }}">
                        @else
                            {{ strtoupper($doctor->name[0]) }} <!-- Initial if no picture available -->
                        @endif
                    </div>

                    <div>
                        <h5 class="font-semibold">{{ $doctor->name }}</h5>
                        <p class="text-sm text-gray-400">
                            {{ optional($doctor->doctorProfile)->specialty ?? 'Specialty not available' }}
                        </p>
                    </div>
                </div>

                <!-- Link to doctor's profile -->
                <a href="{{ route('patient.doctor.profile', $doctor->id) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    @empty
        <p>No favorite doctors added yet.</p>
    @endforelse
</div>

            <!-- Footer -->
            <footer class="py-12 mt-16 border-t border-gray-800">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-6 md:mb-0">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <span class="med-teal text-2xl font-bold logo-pulse">MED</span><span class="text-2xl font-bold text-white">Book</span>
                        </a>
                        <p class="text-gray-400 mt-2">Your health, our priority</p>
                    </div>
                    <div class="flex space-x-6">
                        <a href="#" class="text-white hover:text-teal-300 transition-colors">Contact</a>
                        <a href="#" class="text-white hover:text-teal-300 transition-colors">About us</a>
                        <a href="#" class="text-white hover:text-teal-300 transition-colors">Privacy Policy</a>
                    </div>
                </div>
                <div class="text-center mt-8 text-gray-500 text-sm">
                    © 2025 MEDBook. All rights reserved.
                </div>
            </footer>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            function formatTime(time) {
                const [hours, minutes] = time.split(':');
                const parsedHours = parseInt(hours, 10);
                const ampm = parsedHours >= 12 ? 'PM' : 'AM';
                const twelveHour = parsedHours % 12 || 12;
                return `${twelveHour}:${minutes} ${ampm}`;
            }
document.querySelectorAll('.your-selector')?.forEach(element => {
  element.addEventListener('click', yourHandler);
});
const element = document.querySelector('.your-selector');
if (element) {
  element.addEventListener('click', yourHandler);
}
            document.querySelectorAll('input[name="appointment_date"]').forEach(dateInput => {
                dateInput.addEventListener('change', function() {
                    console.log('Date changed detected');
                    const form = this.closest('form');
                    console.log('Form elements:', form.elements);
                    const doctorId = form.querySelector('input[name="doctor_id"]').value;
                    const timeSelect = form.querySelector('select[name="appointment_time"]');
                    const date = this.value;

                    console.log('Selected Doctor ID:', doctorId);
                    console.log('Selected Date:', this.value);

                    if (!date) {
                        timeSelect.innerHTML = '<option value="" disabled selected>Select a date first</option>';
                        timeSelect.disabled = true;
                        return;
                    }

                    fetch(`/doctors/${doctorId}/available-times?date=${date}`)
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(slots => {
                            timeSelect.innerHTML = '<option value="" disabled selected>Select a time</option>';
                            if (slots.length === 0) {
                                timeSelect.innerHTML = '<option value="" disabled selected>No available slots</option>';
                                timeSelect.disabled = true;
                            } else {
                                slots.forEach(slot => {
                                    const option = document.createElement('option');
                                    option.value = slot;
                                    option.textContent = formatTime(slot);
                                    timeSelect.appendChild(option);
                                });
                                timeSelect.disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            timeSelect.innerHTML = '<option value="" disabled selected>Error loading slots</option>';
                            timeSelect.disabled = true;
                        });
                });
            });
        });
    </script>
</body>
</html>

