<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MEDBook - Doctor Profile</title>
    <script src="https://unpkg.com/alpinejs" defer></script>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        :root {
            --med-teal: #00CCCC;
            --med-teal-hover: #00B3B3;
            --med-teal-light: rgba(0, 204, 204, 0.15);
            --dark-bg: #121212;
            --card-bg: rgba(40, 40, 40, 0.7);
            --input-bg: rgba(51, 51, 51, 0.8);
            --sidebar-bg: #111827;
            --card-hover: #2A2A2A;
        }

        body {
            background-color: var(--dark-bg);
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
        /* Sidebar */
        .sidebar {
            background-color: var(--sidebar-bg);
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.2);
            z-index: 10;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            color: #E5E7EB;
        }

        .sidebar-link:hover, .sidebar-link.active {
            background-color: rgba(0, 204, 204, 0.1);
            color: white;
        }

        .sidebar-link.active {
            border-left: 3px solid var(--med-teal);
            background-color: rgba(0, 204, 204, 0.15);
        }

       .profile-pic-wrapper {
            width: 150px;
            height: 150px;
            position: relative;
            overflow: hidden;
            border-radius: 50%;
            margin: 0 auto;
            border: 3px solid rgba(0, 204, 204, 0.5);
            box-shadow: 0 0 15px rgba(0, 204, 204, 0.3);
        }
        .profile-pic {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #00CCCC;
            margin-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 0.5rem;
        }
        .tab-button {
            padding: 10px 20px;
            background-color: rgba(51, 51, 51, 0.8);
            border-radius: 8px 8px 0 0;
            transition: all 0.3s ease;
        }
        .tab-button.active {
            background-color: #00CCCC;
            color: #121212;
            font-weight: 600;
        }
        .tab-button:hover:not(.active) {
            background-color: rgba(0, 204, 204, 0.2);
        }
        .tab-content {
            display: none;
            padding: 24px;
            background-color: rgba(40, 40, 40, 0.7);
            border-radius: 0 8px 8px 8px;
        }
        .tab-content.active {
            display: block;
        }
        .logo-pulse {
            animation: pulse 2s infinite;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .badge-primary {
            background-color: rgba(0, 204, 204, 0.2);
            color: #00CCCC;
        }
        .badge-success {
            background-color: rgba(52, 211, 153, 0.2);
            color: #34D399;
        }
        .badge-warning {
            background-color: rgba(251, 191, 36, 0.2);
            color: #FBBF24;
        }
        .badge-danger {
            background-color: rgba(239, 68, 68, 0.2);
            color: #EF4444;
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

        /* New styling for time slots */
        .time-slot {
            background-color: rgba(40, 40, 40, 0.7);
            border: 1px solid rgba(0, 204, 204, 0.3);
            transition: all 0.3s ease;
        }

        .time-slot:hover {
            background-color: rgba(0, 204, 204, 0.2);
        }

        .time-slot.selected {
            background-color: var(--med-teal);
            color: white;
        }

        /* Booking form transition */
        .booking-form {
            max-height: 0;
            transition: max-height 0.5s ease-in-out;
            overflow: hidden;
        }

        .error-message {
            color: #EF4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: none;
        }

        .error-message.active {
            display: block;
        }

        /* Loading spinner animation */
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading-spinner {
            animation: spin 1s linear infinite;
        }

        /* Toggle button active state */
        .toggle-booking-btn.active {
            background-color: var(--med-teal-hover);
        }

        /* Animation for notification */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }

        /* Input field styling */
        .input-field {
            background-color: var(--input-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }

        .input-field:focus {
            border-color: var(--med-teal);
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 204, 204, 0.2);
        }
    </style>
</head>

<body>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="sidebar w-64 p-6 flex flex-col">
            <div class="mb-10">
                <a href="{{ route('home') }}" class="flex items-center">
                    <span class="med-teal text-3xl font-bold logo-pulse">MED</span><span class="text-3xl font-bold text-white">Book</span>
                </a>
                <p class="text-gray-400 text-sm mt-1">Healthcare made simple</p>
            </div>
            <nav class="flex-1">
                <a href="{{ route('patient.dashboard') }}" class="sidebar-link">
                    <i class="fas fa-home w-5 h-5 mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('patient.appointments') }}" class="sidebar-link">
                    <i class="fas fa-calendar-alt w-5 h-5 mr-3"></i>
                    My Appointments
                </a>
                <a href="{{route('patient.appointments')}}" class="sidebar-link">
                    <i class="fas fa-heart w-5 h-5 mr-3"></i>
                    My Favorites
                </a>
                <a href="{{ route('patient.explore') }}" class="sidebar-link active">
                    <i class="fas fa-user-md w-5 h-5 mr-3 med-teal"></i>
                    Explore Doctors
                </a>
                <a href="{{ route('profile.view') }}" class="sidebar-link">
                    <i class="fas fa-user w-5 h-5 mr-3"></i>
                    Profile
                </a>
            </nav>
            <div class="mt-auto pt-6 border-t border-gray-800">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center text-white font-semibold">
                        {{ substr($patient->name, 0, 2) }}
                    </div>
                    <div class="ml-3">
                        <div class="font-medium">{{$patient->name}}</div>
                        <div class="text-sm text-gray-400">Patient</div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full btn-teal py-2 rounded-lg text-sm font-medium flex items-center justify-center">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>

       <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">Doctor Profile</h1>
                        <p class="text-gray-400 mt-1">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
                    </div>
                    <a href="{{route('patient.explore')}}" class="px-4 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 text-white transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Doctors
                    </a>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Column - Doctor Info -->
                <div class="lg:w-1/3">
                    <div class="card p-6">
                        <div class="flex flex-col items-center">
                            <div class="profile-pic-wrapper mb-6">
                                @if($doctor->user->profile_picture)
                                    <img src="{{ asset('storage/' . $doctor->user->profile_picture) }}" alt="Profile Picture" class="profile-pic">
                                @else
                                    <div class="profile-pic flex items-center justify-center bg-gray-700 text-white text-5xl font-bold">
                                        {{ substr($doctor->user->name, 0, 2) }}
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-lg font-semibold">{{ $doctor->user->name }}</h3>
                            <p class="text-gray-400">{{ $doctor->user->email }}</p>
                            <div class="mt-4 flex">
                                <span class="badge badge-primary">
                                    Doctor #{{ $doctor->id }}
                                </span>
                            </div>

                            <div class="w-full mt-6">
                                <div class="section-title">Patient Information</div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-400">Age</span>
                                    <span>{{ $doctor->age }} years</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-400">Sex</span>
                                    <span class="capitalize">{{ $doctor->sex ?? 'Not specified' }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-400">Phone</span>
                                    <span>{{ $doctor->user->phone ?? 'Not provided' }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-400">Joined since</span>
                                    <span>{{ $doctor->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>

                            <div class="w-full mt-6">
                                <div class="section-title">Medical Overview</div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-400">Total appointments</span>
                                    <span>{{ $appointments->total() }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-400">Last visit</span>
                                    <span>
                                        @if($appointments->count() > 0)
                                            {{ $appointments->first()->appointment_date->format('M d, Y') }}
                                        @else
                                            No visits yet
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Patient Tabs -->
                <div class="lg:w-2/3">
                    <div class="mb-6">
                        <div class="flex">
                            <button type="button" class="tab-button active" data-tab="appointments">Appointment History</button>
                        </div>
                        <div class="mt-6 flex flex-col md:flex-row md:items-center justify-between">
                            <button type="button" id="toggle-booking-btn" class="toggle-booking-btn btn-teal px-6 py-3 rounded-lg text-sm font-medium flex items-center gap-2 transition-all hover:scale-105">
                                <i class="fas fa-calendar-plus"></i>
                                <span>Book Appointment</span>
                                <i class="fas fa-chevron-down toggle-chevron ml-1"></i>
                            </button>
                        </div>

                        <!-- Booking Form -->
                        <div id="booking-form" class="booking-form mt-6 border-t border-gray-700 pt-6 overflow-hidden transition-all duration-500 ease-in-out">
                            <form action="{{ route('appointments.book') }}" method="POST" class="appointment-form p-4 bg-gray-800/50 rounded-xl border border-gray-700">
                                @csrf
                                <input type="hidden" name="doctor_id" value="{{ $doctor->user->id }}" data-doctor-id="{{ $doctor->user->id }}">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="appointment_date_{{ $doctor->id }}" class="block text-sm mb-2 text-gray-300 font-medium">
                                            <i class="fas fa-calendar-alt text-teal-400 mr-2"></i> Select Date:
                                        </label>

                                        <input type="date"
                                            id="appointment_date_{{ $doctor->user->id }}"
                                            name="appointment_date"
                                            class="w-full px-4 py-3 rounded-lg input-field bg-gray-900 border border-gray-700 focus:border-teal-400 focus:ring focus:ring-teal-400/20"
                                            required
                                            min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <label class="block text-sm mb-2 text-gray-300 font-medium">
                                        <i class="fas fa-clock text-teal-400 mr-2"></i> Available Time Slots:
                                    </label>
                                    <div class="time-slots grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-3 mt-2">
                                        <!-- Time slots will be dynamically loaded here -->
                                    </div>
                                    <div class="error-message mt-2 text-red-500"></div>
                                    <input type="hidden" name="appointment_time" value="">
                                </div>

                                <div class="mt-6">
                                    <label for="appointment_notes_{{ $doctor->id }}" class="block text-sm mb-2 text-gray-300 font-medium">
                                        <i class="fas fa-comment-medical text-teal-400 mr-2"></i> Notes (Optional):
                                    </label>
                                    <textarea
                                        id="appointment_notes_{{ $doctor->id }}"
                                        name="notes"
                                        rows="2"
                                        class="w-full px-4 py-3 rounded-lg input-field bg-gray-900 border border-gray-700 focus:border-teal-400 focus:ring focus:ring-teal-400/20"
                                        placeholder="Any specific concerns or information you'd like the doctor to know"></textarea>
                                </div>

                                <button type="submit" class="w-full btn-teal py-3 rounded-lg font-medium flex items-center justify-center mt-6">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    Confirm Appointment
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Appointment History Tab -->
                    <div class="tab-content active" id="appointments-tab">
                        @if($appointments->count() > 0)
                            <div class="overflow-x-auto bg-black rounded-lg shadow-md">
                                <table class="w-full text-sm text-white">
                                    <thead>
                                        <tr class="text-left bg-gray-900 border-b border-gray-700">
                                            <th class="py-3 pl-4">Date</th>
                                            <th class="py-3 px-6">Time</th>
                                            <th class="py-3 px-6">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($appointments as $appointment)
                                            <tr class="border-b border-gray-800 hover:bg-gray-800 transition-colors">
                                                <td class="py-4 pl-4">{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                                <td class="px-6">{{ $appointment->appointment_date->format('h:i A') }}</td>
                                                <td class="px-6">
                                                    @if($appointment->status == 'completed')
                                                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-green-600 text-white rounded-full">
                                                            Completed
                                                        </span>
                                                    @elseif($appointment->status == 'booked')
                                                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-blue-600 text-white rounded-full">
                                                            Booked
                                                        </span>
                                                    @elseif($appointment->status == 'canceled')
                                                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-red-600 text-white rounded-full">
                                                            Cancelled
                                                        </span>
                                                    @else
                                                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-purple-600 text-white rounded-full">
                                                            ℹ️ {{ ucfirst($appointment->status) }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-6 text-center">
                                {{ $appointments->links() }}
                            </div>
                        @else
                            <div class="text-center py-10 bg-gray-900 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h3 class="text-xl font-semibold text-white">No appointments yet</h3>
                                <p class="text-gray-500 mt-2">This patient hasn't had any appointments with you yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
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
        <!-- Booking Form -->
                        <div id="booking-form" class="booking-form mt-6 border-t border-gray-700 pt-6 overflow-hidden transition-all duration-500 ease-in-out">
                            <form action="{{ route('appointments.book') }}" method="POST" class="appointment-form p-4 bg-gray-800/50 rounded-xl border border-gray-700">
                                @csrf
                                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}" data-doctor-id="{{ $doctor->id }}">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>console.log(data); // Add this
                                        <label for="appointment_date_{{ $doctor->user_id }}" class="block text-sm mb-2 text-gray-300 font-medium">
                                            <i class="fas fa-calendar-alt text-teal-400 mr-2"></i> Select Date:
                                        </label>

                                        <input type="date"
                                            id="appointment_date_{{ $doctor->id }}"
                                            name="appointment_date"
                                            class="w-full px-4 py-3 rounded-lg input-field bg-gray-900 border border-gray-700 focus:border-teal-400 focus:ring focus:ring-teal-400/20"
                                            required
                                            min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <label class="block text-sm mb-2 text-gray-300 font-medium">
                                        <i class="fas fa-clock text-teal-400 mr-2"></i> Available Time Slots:
                                    </label>
                                    <div class="time-slots grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-3 mt-2">
                                        <!-- Time slots will be dynamically loaded here -->
                                    </div>
                                    <div class="error-message mt-2 text-red-500"></div>
                                    <input type="hidden" name="appointment_time" value="">
                                </div>

                                <div class="mt-6">
                                    <label for="appointment_notes_{{ $doctor->id }}" class="block text-sm mb-2 text-gray-300 font-medium">
                                        <i class="fas fa-comment-medical text-teal-400 mr-2"></i> Notes (Optional):
                                    </label>
                                    <textarea
                                        id="appointment_notes_{{ $doctor->id }}"
                                        name="notes"
                                        rows="2"
                                        class="w-full px-4 py-3 rounded-lg input-field bg-gray-900 border border-gray-700 focus:border-teal-400 focus:ring focus:ring-teal-400/20"
                                        placeholder="Any specific concerns or information you'd like the doctor to know"></textarea>
                                </div>

                                <button type="submit" class="w-full btn-teal py-3 rounded-lg font-medium flex items-center justify-center mt-6">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    Confirm Appointment
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Appointment History Tab -->
                    <div class="tab-content active" id="appointments-tab">
                        @if($appointments->count() > 0)
                            <div class="overflow-x-auto bg-black rounded-lg shadow-md">
                                <table class="w-full text-sm text-white">
                                    <thead>
                                        <tr class="text-left bg-gray-900 border-b border-gray-700">
                                            <th class="py-3 pl-4">Date</th>
                                            <th class="py-3 px-6">Time</th>
                                            <th class="py-3 px-6">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($appointments as $appointment)
                                            <tr class="border-b border-gray-800 hover:bg-gray-800 transition-colors">
                                                <td class="py-4 pl-4">{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                                <td class="px-6">{{ $appointment->appointment_date->format('h:i A') }}</td>
                                                <td class="px-6">
                                                    @if($appointment->status == 'completed')
                                                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-green-600 text-white rounded-full">
                                                            Completed
                                                        </span>
                                                    @elseif($appointment->status == 'booked')
                                                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-blue-600 text-white rounded-full">
                                                            Booked
                                                        </span>
                                                    @elseif($appointment->status == 'canceled')
                                                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-red-600 text-white rounded-full">
                                                            Cancelled
                                                        </span>
                                                    @else
                                                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-purple-600 text-white rounded-full">
                                                            ℹ️ {{ ucfirst($appointment->status) }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-6 text-center">
                                {{ $appointments->links() }}
                            </div>
                        @else
                            <div class="text-center py-10 bg-gray-900 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h3 class="text-xl font-semibold text-white">No appointments yet</h3>
                                <p class="text-gray-500 mt-2">This patient hasn't had any appointments with you yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
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
    // Initialize DOM references
    const bookingFormElement = document.getElementById('booking-form');
    const toggleBookingBtn = document.getElementById('toggle-booking-btn');

    // Time formatting utility
    function formatTime(time) {
        const [hours, minutes] = time.split(':');
        const parsedHours = parseInt(hours, 10);
        const ampm = parsedHours >= 12 ? 'PM' : 'AM';
        const twelveHour = parsedHours % 12 || 12;
        return `${twelveHour}:${minutes} ${ampm}`;
    }

    // Toggle booking form with proper state management
    function handleBookingToggle() {
        const wasExpanded = bookingFormElement.style.maxHeight && bookingFormElement.style.maxHeight !== '0px';

        // Toggle current form
        bookingFormElement.style.maxHeight = wasExpanded ? '0' : `${bookingFormElement.scrollHeight}px`;
        toggleBookingBtn.classList.toggle('active', !wasExpanded);

        // Toggle chevron icon if it exists
        const toggleChevron = toggleBookingBtn.querySelector('.toggle-chevron');
        if (toggleChevron) {
            toggleChevron.classList.toggle('fa-chevron-down', wasExpanded);
            toggleChevron.classList.toggle('fa-chevron-up', !wasExpanded);
        }
    }

    // Date change handler with error handling
    async function handleDateChange(e) {
        const input = e.target;
        const form = input.closest('form');
const doctorId = @json($doctor->user_id);
        const timeSlotsContainer = form.querySelector('.time-slots');
        const errorMessage = form.querySelector('.error-message');

        // Validate date is not a Friday (day 5)
        const selectedDate = new Date(input.value);
        if (selectedDate.getDay() === 5) { // 5 = Friday
            errorMessage.textContent = "Appointments cannot be booked on Fridays. Please select another day.";
            errorMessage.classList.add('active');
            input.value = ""; // Clear the invalid date
            timeSlotsContainer.innerHTML = '';
            return;
        }

        errorMessage.classList.remove('active');

        try {
            timeSlotsContainer.innerHTML = `
                <div class="col-span-full text-center py-4">
                    <div class="loading-spinner inline-block w-6 h-6 border-2 border-teal-400 border-t-transparent rounded-full"></div>
                </div>`;

            const response = await fetch(`/doctors/${doctorId}/available-times?date=${input.value}`);

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

            const slots = await response.json();
            timeSlotsContainer.innerHTML = '';

            if (slots.length === 0) {
                errorMessage.textContent = 'No available slots for this date';
                errorMessage.classList.add('active');
                return;
            }

            slots.forEach(slot => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'time-slot text-sm px-3 py-2 rounded-lg';
                btn.textContent = formatTime(slot);

                btn.addEventListener('click', () => {
                    form.querySelectorAll('.time-slot').forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');
                    form.querySelector('input[name="appointment_time"]').value = slot;
                });

                timeSlotsContainer.appendChild(btn);
            });

            // Update form height after loading slots
            bookingFormElement.style.maxHeight = `${bookingFormElement.scrollHeight}px`;

        } catch (error) {
            errorMessage.textContent = 'Failed to load time slots. Please try again later.';
            errorMessage.classList.add('active');
            console.error('Date change error:', error);
        }
    }

    // Form submission handler
    async function handleFormSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalHtml = submitBtn.innerHTML;
        const errorMessage = form.querySelector('.error-message');

        // Validate time slot is selected
        const selectedTime = form.querySelector('input[name="appointment_time"]').value;
        if (!selectedTime) {
            errorMessage.textContent = 'Please select a time slot';
            errorMessage.classList.add('active');
            return;
        }

        try {
            submitBtn.innerHTML = `
                <div class="loading-spinner inline-block w-5 h-5 border-2 border-white border-t-transparent rounded-full"></div>
                Booking...
            `;
            submitBtn.disabled = true;

            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            });

            const data = await response.json();
console.log(data); // Add this
            if (!response.ok) {
                throw new Error(data.message || 'Booking failed');
            }

            // Show success notification
            const notification = document.createElement('div');
            notification.className = 'bg-green-600 text-white p-4 rounded-lg mb-6 shadow-lg animate-fade-in';
            notification.textContent = data.message || 'Appointment booked successfully!';
            form.parentElement.insertAdjacentElement('beforebegin', notification);

            // Reset form state
            form.reset();
            bookingFormElement.style.maxHeight = '0';
            toggleBookingBtn.classList.remove('active');
            form.querySelector('.time-slots').innerHTML = '';

            // Remove notification after delay
            setTimeout(() => notification.remove(), 5000);

        } catch (error) {
            errorMessage.textContent = error.message || 'An error occurred. Please try again.';
            errorMessage.classList.add('active');
        } finally {
            submitBtn.innerHTML = originalHtml;
            submitBtn.disabled = false;
        }
    }

    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const tabId = button.getAttribute('data-tab');

            // Update active states
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            button.classList.add('active');
            document.getElementById(`${tabId}-tab`).classList.add('active');
        });
    });

    // Event listener setup
    if (toggleBookingBtn) {
        toggleBookingBtn.addEventListener('click', handleBookingToggle);
    }

    document.querySelectorAll('input[type="date"]').forEach(input => {
        input.addEventListener('change', handleDateChange);
    });

document.querySelectorAll('.appointment-form').forEach(form => {
    form.addEventListener('submit', (e) => {
        e.preventDefault(); // Prevent native browser form submit
        handleFormSubmit(e); // Your async logic
    });
});
});
    </script>
</body>
</html>
