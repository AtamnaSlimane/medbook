<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDBook - Doctor Profile</title>

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
        // Tab functionality
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons and contents
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                // Add active class to clicked button
                this.classList.add('active');

                // Show the corresponding content
                const tabId = this.getAttribute('data-tab');
                document.getElementById(`${tabId}-tab`).classList.add('active');
            });
        });
function deleteAppointment(appointmentId) {
            if (confirm('Are you sure you want to delete this appointment?')) {
                // Create a form and submit it to delete the appointment
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/appointments/${appointmentId}`;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Example function for opening a modal to add a new medical note
        function openNewNoteModal() {
            const modal = document.getElementById('new-note-modal');
            modal.classList.remove('hidden');
        }

        // Example function for closing a modal
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('hidden');
        }

        // Function to toggle patient allergies section
        function toggleAllergies() {
            const allergiesSection = document.getElementById('allergies-section');
            allergiesSection.classList.toggle('hidden');

            const allergiesToggle = document.getElementById('allergies-toggle');
            if (allergiesSection.classList.contains('hidden')) {
                allergiesToggle.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                `;
            } else {
                allergiesToggle.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                `;
            }
        }

        // Function to toggle medical history section
        function toggleMedicalHistory() {
            const medicalHistorySection = document.getElementById('medical-history-section');
            medicalHistorySection.classList.toggle('hidden');

            const medicalHistoryToggle = document.getElementById('medical-history-toggle');
            if (medicalHistorySection.classList.contains('hidden')) {
                medicalHistoryToggle.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                `;
            } else {
                medicalHistoryToggle.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                `;
            }
        }
    </script>
</body>
</html>
