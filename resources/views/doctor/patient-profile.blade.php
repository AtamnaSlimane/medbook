<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDBook - Patient Profile</title>
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
        <div class="w-64 bg-gray-900 p-6 flex flex-col">
            <div class="mb-10">
                <a href="{{ route('home') }}" class="flex items-center">
                    <span class="med-teal text-3xl font-bold logo-pulse">MED</span><span class="text-3xl font-bold text-white">Book</span>
                </a>
            </div>
            <nav class="flex-1">
                <a href="{{ route('doctor.dashboard') }}" class="sidebar-link">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('doctor.appointments') }}" class="sidebar-link">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    My Appointments
                </a>
                <a href="{{ route('doctor.schedule') }}" class="sidebar-link">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    My Schedule
                </a>
                <a href="" class="sidebar-link active">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    My Patients
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
                    <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center text-white font-semibold">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                    <div class="ml-3">
                        <div class="font-medium">{{ auth()->user()->name }}</div>
                        <div class="text-sm text-gray-400">Doctor</div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full btn-teal py-2 rounded-lg text-sm font-medium flex items-center justify-center">
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
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">Patient Profile</h1>
                        <p class="text-gray-400 mt-1">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
                    </div>
                    <a href="{{route('doctor.patients')}}" class="px-4 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 text-white transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Patients
                    </a>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Column - Patient Info -->
                <div class="lg:w-1/3">
                    <div class="card p-6">
                        <div class="flex flex-col items-center">
                            <div class="profile-pic-wrapper mb-6">
                                @if($patient->user->profile_picture)
                                    <img src="{{ asset('storage/' . $patient->user->profile_picture) }}" alt="Profile Picture" class="profile-pic">
                                @else
                                    <div class="profile-pic flex items-center justify-center bg-gray-700 text-white text-5xl font-bold">
                                        {{ substr($patient->user->name, 0, 2) }}
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-lg font-semibold">{{ $patient->user->name }}</h3>
                            <p class="text-gray-400">{{ $patient->user->email }}</p>
                            <div class="mt-4 flex">
                                <span class="badge badge-primary">
                                    Patient #{{ $patient->id }}
                                </span>
                            </div>

                            <div class="w-full mt-6">
                                <div class="section-title">Patient Information</div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-400">Age</span>
                                    <span>{{ $patient->age }} years</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-400">Sex</span>
                                    <span class="capitalize">{{ $patient->sex ?? 'Not specified' }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-400">Phone</span>
                                    <span>{{ $patient->user->phone ?? 'Not provided' }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-400">Patient since</span>
                                    <span>{{ $patient->created_at->format('M d, Y') }}</span>
                                </div>

<div class="flex justify-between items-center py-2">
    <span class="text-gray-400">Emergency Contact</span>
    <span>{{ $patient->emergency_contact_name ?? 'Not provided' }}</span>
</div>
<div class="flex justify-between items-center py-2">
    <span class="text-gray-400">Emergency Phone</span>
    <span>{{ $patient->emergency_contact_phone ?? 'Not provided' }}</span>
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
                            <button type="button" class="tab-button" data-tab="medical">Medical History</button>
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
<!-- Medical History Tab -->
<div class="tab-content hidden" id="medical-tab">
    @if($patient->medical_history)
        <div class="bg-black text-white p-6 rounded-lg shadow-md">
            <h4 class="text-lg font-semibold mb-4">Medical History</h4>
            <div class="text-gray-300 whitespace-pre-line">
                {{ $patient->medical_history }}
            </div>
        </div>
    @else
        <div class="text-center py-10 bg-gray-900 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m2 0a2 2 0 100-4h-6a2 2 0 100 4h4" />
            </svg>
            <h3 class="text-xl font-semibold text-white">No medical history</h3>
            <p class="text-gray-500 mt-2">This patient has not submitted any medical records yet.</p>
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
