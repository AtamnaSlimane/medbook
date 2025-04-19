<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDBook - Doctor Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .medical-badge {
            background: rgba(40, 40, 40, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            border-radius: 12px;
        }
        .medical-badge:hover {
            box-shadow: 0 15px 30px rgba(0, 204, 204, 0.1);
            transform: translateY(-2px);
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
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }
        .status-badge:hover {
            transform: translateY(-1px);
        }
        .action-btn {
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .action-btn:hover {
            transform: translateY(-1px);
        }
        .progress-bar {
            height: 6px;
            border-radius: 3px;
            overflow: hidden;
            background: rgba(75, 85, 99, 0.3);
            margin-top: 0.5rem;
        }
        .progress-value {
            height: 100%;
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 3px;
        }
        .avatar-container {
            position: relative;
        }
[x-cloak] { display: none !important; }
        .avatar-container::after {
            content: "";
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            border-radius: 9999px;
            border: 2px solid rgba(0, 204, 204, 0.3);
            opacity: 0;
            transition: all 0.3s ease;
        }
        .avatar-container:hover::after {
            opacity: 1;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            border: 2px solid rgba(0, 204, 204, 0.6);
        }
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(40, 40, 40, 0.3);
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(0, 204, 204, 0.5);
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 204, 204, 0.7);
        }
        table {
            border-collapse: separate;
            border-spacing: 0;
        }
        thead {
            background: rgba(40, 40, 40, 0.7);
        }
        th {
            padding: 1rem 1.5rem;
            color: #00CCCC;
            font-weight: 600;
        }
        tbody tr {
            position: relative;
        }
        tbody tr:hover {
            z-index: 1;
        }
        tbody tr:hover::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 0.5rem;
            z-index: -1;
        }
        tbody tr td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="text-gray-100 min-h-screen" x-data="{ openSection: 'stats' }">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 p-6 flex flex-col">
            <div class="mb-10">
                <a href="#" class="flex items-center">
                    <span class="med-teal text-3xl font-bold logo-pulse">MED</span><span class="text-3xl font-bold text-white">Book</span>
                </a>
            </div>
            <nav class="flex-1">
                <a href="{{route('doctor.dashboard')}}" class="sidebar-link active">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{route('doctor.appointments')}}" class="sidebar-link">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    My Appointments
                </a>
                <a href="{{route('doctor.schedule')}}" class="sidebar-link">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    My Schedule
                </a>
                <a href="{{route('doctor.patients')}}" class="sidebar-link">
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
    @if($user->profile_picture)
        <img src="{{ asset('storage/' . $user->profile_picture) }}"
             alt="Profile Picture"
             class="h-10 w-10 rounded-full object-cover" />
    @else
        <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center text-white font-semibold">
            Dr
        </div>
    @endif

    <div class="ml-3">
        <div class="font-medium">Dr. {{ $user->name }}</div>
        <div class="text-sm text-gray-400">Doctor</div>
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
        <div class="flex-1 p-8 overflow-y-auto">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">Dashboard</h1>
                        <p class="text-gray-400 mt-1">Welcome back, Dr. {{$user->name}}</p>
                    </div>
                </div>
            </div>

            <!-- Dashboard Controls -->

<div class="mb-10">
    <div class="flex flex-col md:flex-row gap-5">
        <button
            @click="openSection = 'stats'"
            :class="[
                'px-7 py-4 rounded-2xl font-semibold transition-all duration-300 flex items-center gap-3 backdrop-blur-xl relative overflow-hidden group',
                openSection === 'stats'
                    ? 'bg-gradient-to-br from-teal-700/80 to-teal-900/70 text-teal-100 shadow-lg shadow-teal-500/40 ring-2 ring-teal-400/40 border-b border-teal-300/30'
                    : 'bg-gradient-to-br from-slate-800/90 to-slate-900/80 text-slate-300 hover:bg-slate-700/80 hover:text-teal-100 hover:shadow-lg hover:shadow-teal-800/20 border-b border-slate-700/50'
            ]">
            <div class="absolute inset-0 bg-gradient-to-t from-transparent to-white/5 opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
            <i class="fas fa-chart-bar text-teal-300 text-lg"></i>
            <span class="tracking-wide">Statistics</span>
        </button>

        <button
            @click="openSection = 'patients'"
            :class="[
                'px-7 py-4 rounded-2xl font-semibold transition-all duration-300 flex items-center gap-3 backdrop-blur-xl relative overflow-hidden group',
                openSection === 'patients'
                    ? 'bg-gradient-to-br from-teal-700/80 to-teal-900/70 text-teal-100 shadow-lg shadow-teal-500/40 ring-2 ring-teal-400/40 border-b border-teal-300/30'
                    : 'bg-gradient-to-br from-slate-800/90 to-slate-900/80 text-slate-300 hover:bg-slate-700/80 hover:text-teal-100 hover:shadow-lg hover:shadow-teal-800/20 border-b border-slate-700/50'
            ]">
            <div class="absolute inset-0 bg-gradient-to-t from-transparent to-white/5 opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
            <i class="fas fa-users text-teal-300 text-lg"></i>
            <span class="tracking-wide">Patients</span>
        </button>
    </div>
</div>

            <!-- Stats Section -->
            <div x-show="openSection === 'stats'" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    class="space-y-8">

                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold med-teal">Pending's Appointments</h3>
                            <div class="w-10 h-10 rounded-full bg-teal-900/50 flex items-center justify-center">
                                <i class="fas fa-calendar-check text-xl text-teal-300"></i>
                            </div>
                        </div>
                        <p class="text-3xl font-bold">{{$pendingAppointments}}</p>

                    </div>

                    <div class="card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold med-teal">New Patients</h3>
                            <div class="w-10 h-10 rounded-full bg-teal-900/50 flex items-center justify-center">
                                <i class="fas fa-user-plus text-xl text-teal-300"></i>
                            </div>
                        </div>
                        <p class="text-3xl font-bold">{{$newPatients}}</p>
                        <div class="flex items-center gap-2 mt-2 text-sm">
                            <span class="px-2 py-1 bg-green-400/20 text-green-400 rounded-full flex items-center gap-1">
                                <i class="fas fa-arrow-up text-xs"></i>
                                {{$newPatientsComparison->change}}%
                            </span>
                            <span class="text-gray-400">this month</span>
                        </div>
                    </div>

                    <div class="card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold med-teal">Cancellation Rate</h3>
                            <div class="w-10 h-10 rounded-full bg-teal-900/50 flex items-center justify-center">
                                <i class="fas fa-times-circle text-xl text-red-400"></i>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-red-400">{{$doctorStats['cancellationRate']}}%</p>
                        <div class="flex items-center gap-2 mt-2 text-sm">
                            <span class="px-2 py-1 bg-green-400/20 text-green-400 rounded-full flex items-center gap-1">
                                <i class="fas fa-arrow-up text-xs"></i>
                                {{$cancellationRateComparison->change}}%
                            </span>
                            <span class="text-gray-400">vs last month</span>
                        </div>
                    </div>
                </div>

<!-- Patient Insights -->
<div class="card rounded-lg shadow-2xl bg-gradient-to-r from-teal-700 via-teal-800 to-slate-900 p-6 space-y-8">
    <h3 class="text-3xl font-bold text-teal-400 flex items-center gap-3 border-b-4 border-teal-600 pb-4">
        <i class="fas fa-users text-teal-300"></i> Patient Insights Dashboard
    </h3>
    <p class="text-slate-300 text-lg">
        Comprehensive analytics of patient demographics, appointment metrics, and trends.
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mt-8">
        <!-- Gender Distribution -->
        <div class="bg-slate-800 rounded-xl p-6 shadow-2xl border-2 border-teal-600 hover:bg-teal-900 transition transform hover:scale-105 duration-300">
            <h4 class="text-xl font-semibold text-purple-400 flex items-center gap-3 mb-6">
                <i class="fas fa-venus-mars text-purple-300"></i> Gender Distribution
            </h4>
            <div class="chart-container" style="position: relative; height: 280px;">
                <canvas id="genderChart"></canvas>
            </div>
        </div>

        <!-- Age Groups -->
        <div class="bg-slate-800 rounded-xl p-6 shadow-2xl border-2 border-teal-600 hover:bg-teal-900 transition transform hover:scale-105 duration-300">
            <h4 class="text-xl font-semibold text-teal-400 flex items-center gap-3 mb-6">
                <i class="fas fa-hourglass-half text-teal-300"></i> Age Groups
            </h4>
            <div class="chart-container" style="position: relative; height: 280px;">
                <canvas id="ageChart"></canvas>
            </div>
        </div>

        <!-- Appointment Statuses -->
        <div class="bg-slate-800 rounded-xl p-6 shadow-2xl border-2 border-teal-600 hover:bg-teal-900 transition transform hover:scale-105 duration-300">
            <h4 class="text-xl font-semibold text-indigo-400 flex items-center gap-3 mb-6">
                <i class="fas fa-calendar-check text-indigo-300"></i> Appointment Statuses
            </h4>
            <div class="chart-container" style="position: relative; height: 280px;">
                <canvas id="appointmentStatusChart"></canvas>
            </div>
        </div>

        <!-- Appointments Per Day -->
        <div class="bg-slate-800 rounded-xl p-6 shadow-2xl border-2 border-teal-600 hover:bg-teal-900 transition transform hover:scale-105 duration-300">
            <h4 class="text-xl font-semibold text-blue-400 flex items-center gap-3 mb-6">
                <i class="fas fa-chart-line text-blue-300"></i> Appointments (30 Days)
            </h4>
            <div class="chart-container" style="position: relative; height: 280px;">
                <canvas id="appointmentsPerDayChart"></canvas>
            </div>
        </div>
    </div>
</div>

</div>
           <!-- Patients Section -->
<div
    x-show="openSection === 'patients'"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    class="space-y-8"
>
                <!-- Patient Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="card p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-300 mb-1">New Patients</p>
                                <p class="text-3xl font-bold text-green-400">{{$newPatients}}</p>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-green-400/10 flex items-center justify-center">
                                <i class="fas fa-user-plus text-3xl text-green-400/60"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-300 mb-1">Active Patients</p>
                                <p class="text-3xl font-bold text-red-400">{{$activePatients}}</p>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-red-400/10 flex items-center justify-center">
                                <i class="fas fa-heartbeat text-3xl text-red-400/60"></i>
                            </div>
                        </div>
                    </div>
                </div>
<!-- Appointments Table -->
<div class="card p-6 mt-8">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold med-teal flex items-center gap-3">
            <i class="fas fa-calendar-alt"></i>
            Upcoming Appointments
        </h3>
        <div class="flex items-center gap-4 text-sm">
            <div class="flex items-center gap-2 bg-gray-800/70 px-4 py-2 rounded-full">
                <div class="w-3 h-3 bg-teal-400 rounded-full"></div>
                <span>Booked: {{ $bookedAppointments }}</span>
            </div>
            <div class="flex items-center gap-2 bg-gray-800/70 px-4 py-2 rounded-full">
                <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                <span>Pending: {{ $pendingAppointments }}</span>
            </div>
        </div>
    </div>

    <!-- Added table structure -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="text-gray-400 text-sm font-medium border-b border-gray-700/60">
                    <th class="pb-4 px-2 text-left">Patient</th>
                    <th class="pb-4 px-2 text-left">Date & Time</th>
                    <th class="pb-4 px-2 text-left">Status</th>
                    <th class="pb-4 px-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($upcomingAppointments as $appointment)
                    <tr class="border-b border-gray-700/60 last:border-0 hover:bg-gray-800/20 transition-colors">
                        <td class="py-4 px-2">
                            <div class="flex items-center gap-4">
                                <div class="avatar-container">
<div class="w-12 h-12 rounded-full bg-teal-900/50 flex items-center justify-center border-2 border-teal-400/20 overflow-hidden">
                                        @if($appointment->patient->profile_picture)
                                            <img src="{{ asset('storage/' . $appointment->patient->profile_picture) }}"
                                                 alt="Profile"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <span class="text-teal-400 font-medium text-lg">
                                                {{ strtoupper(substr($appointment->patient->name, 0, 1)) }}
                                            </span>
                                        @endif
                                    </div>
                                                                    </div>
                                <div>
                                    <p class="font-medium text-white hover:text-teal-300 transition-colors">
                                        {{ $appointment->patient->name }}
                                    </p>
                                    <p class="text-sm text-gray-400 mt-1">{{ $appointment->patient->phone ?? 'No phone' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-2">
                            <div class="flex flex-col">
                                <span class="font-medium text-white">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                </span>
                                <span class="text-sm text-gray-400 mt-1 flex items-center gap-2">
                                    <i class="fas fa-clock text-xs text-teal-400"></i>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('g:i A') }}
                                </span>
                            </div>
                        </td>
                        <td class="py-4 px-2">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-400/20 text-yellow-400',
                                    'booked' => 'bg-blue-400/20 text-blue-400',
                                    'completed' => 'bg-teal-400/20 text-green-400',
                                    'canceled' => 'bg-red-400/20 text-red-400'
                                ];
                            @endphp
                            <span class="status-badge {{ $statusColors[$appointment->status] ?? 'bg-gray-400/20 text-gray-400' }} px-3 py-1.5 rounded-full text-sm">
                                <i class="fas {{
                                    $appointment->status === 'pending' ? 'fa-clock' :
                                    ($appointment->status === 'completed' ? 'fa-check-circle' :
                                    'fa-calendar-check') }} mr-2"></i>
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                        <td class="py-4 px-2">
                            @if ($appointment->status === 'pending')
                                <div class="flex gap-3">
                                    <form method="POST" action="{{ route('appointments.accept', $appointment->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="action-btn bg-green-500/20 hover:bg-green-500/30 text-green-400 px-4 py-1.5 rounded-lg transition-colors">
                                            <i class="fas fa-check-circle"></i>
                                            Accept
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('appointments.reject', $appointment->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="action-btn bg-red-500/20 hover:bg-red-500/30 text-red-400 px-4 py-1.5 rounded-lg transition-colors">
                                            <i class="fas fa-times-circle"></i>
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="text-gray-300 text-sm flex items-center gap-2 bg-gray-700/40 px-3 py-2 rounded-lg">
                                    <i class="fas fa-check text-teal-400"></i>
                                    Action completed
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-400 py-6">No upcoming appointments</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

<div class="mt-6 flex justify-center">
    {{ $upcomingAppointments->links('vendor.pagination.custom-black') }}
</div>

            </div>
 </div>
</div>
        <!-- Scripts -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Tab switching functionality
                const tabButtons = document.querySelectorAll('[data-tab]');
                tabButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const tabId = button.getAttribute('data-tab');
                        document.querySelectorAll('.tab-content').forEach(tab => {
                            tab.classList.remove('active');
                        });
                        document.getElementById(`${tabId}-tab`).classList.add('active');
                    });
                });
            });
        </script>
<script>
    // Gender Chart
    const genderLabels = {!! json_encode($doctorStats['genderDistribution']->pluck('sex')->map(fn($g) => ucfirst($g ?? 'Unknown'))->toArray()) !!};
    const genderData = {!! json_encode($doctorStats['genderDistribution']->pluck('percentage')->toArray()) !!};
    const genderColors = genderLabels.map(label => {
        const lower = label.toLowerCase();
        if (lower === 'male') return 'rgba(96, 165, 250, 0.8)';
        if (lower === 'female') return 'rgba(244, 114, 182, 0.8)';
        return 'rgba(156, 163, 175, 0.8)';
    });

new Chart(document.getElementById('genderChart'), {
    type: 'doughnut',
    data: {
        labels: genderLabels,
        datasets: [{
            data: genderData,
            backgroundColor: genderColors,
            borderColor: '#0f172a', // Dark border to blend with dark theme
            borderWidth: 3,
            hoverOffset: 20,
            hoverBorderWidth: 4,
        }]
    },
    options: {
        maintainAspectRatio: false,
        cutout: '50%',
        layout: {
            padding: 20
        },
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: '#f1f5f9', // Light text
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    padding: 20,
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(30, 41, 59, 0.95)', // Dark slate
                titleColor: '#e2e8f0',
                bodyColor: '#cbd5e1',
                borderColor: '#64748b',
                borderWidth: 1,
                padding: 12,
                displayColors: true,
                cornerRadius: 6
            }
        },
        animation: {
            animateRotate: true,
            duration: 1200,
            easing: 'easeOutBounce'
        }
    }
});
    // Age Chart
const ageLabels = {!! json_encode(array_column($doctorStats['ageDistribution'], 'age_range')) !!};
const ageData = {!! json_encode(array_column($doctorStats['ageDistribution'], 'percentage')) !!};

new Chart(document.getElementById('ageChart'), {
    type: 'bar',
    data: {
        labels: ageLabels,
        datasets: [{
            label: 'Age Distribution (%)',
            data: ageData,
            backgroundColor: (ctx) => {
                const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(34, 211, 238, 0.85)'); // cyan-400
                gradient.addColorStop(1, 'rgba(20, 184, 166, 0.7)'); // teal-500
                return gradient;
            },
            borderColor: 'rgba(13, 148, 136, 1)', // teal-600
            borderWidth: 2,
            borderRadius: {
                topLeft: 10,
                topRight: 10,
                bottomLeft: 2,
                bottomRight: 2
            },
            barPercentage: 0.6,
            categoryPercentage: 0.7,
            hoverBorderColor: '#facc15', // yellow-400
            hoverBorderWidth: 3
        }]
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        layout: {
            padding: {
                top: 10,
                left: 10,
                right: 10,
                bottom: 10
            }
        },
        scales: {
            x: {
                ticks: {
                    color: '#cbd5e1',
                    font: {
                        size: 13,
                        weight: '500'
                    }
                },
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#cbd5e1',
                    font: {
                        size: 13
                    },
                    callback: (value) => `${value}%`
                },
                grid: {
                    color: 'rgba(100, 116, 139, 0.2)',
                    borderDash: [4, 4]
                }
            }
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(15, 23, 42, 0.95)',
                titleColor: '#f1f5f9',
                bodyColor: '#e2e8f0',
                borderColor: '#64748b',
                borderWidth: 1,
                padding: 12,
                cornerRadius: 6,
                callbacks: {
                    label: context => `${context.parsed.y}%`
                }
            },
            title: {
                display: true,
                text: 'Age Distribution of Patients',
                color: '#e2e8f0',
                font: {
                    size: 18,
                    weight: 'bold'
                },
                padding: {
                    bottom: 20
                }
            }
        },
        animation: {
            duration: 1200,
            easing: 'easeOutQuart'
        }
    }
});
    // Appointment Status Chart

const statusLabels = {!! json_encode(array_keys($appointmentStats->statusData)) !!};
const statusData = {!! json_encode(array_values($appointmentStats->statusData)) !!};

new Chart(document.getElementById('appointmentStatusChart'), {
    type: 'pie',
    data: {
        labels: statusLabels,
        datasets: [{
            label: 'Appointments',
            data: statusData,
            backgroundColor: [
                'rgba(96, 165, 250, 0.85)',   // blue-400
                'rgba(34, 197, 94, 0.85)',    // green-500
                'rgba(220, 38, 38, 0.85)',    // red-600
                'rgba(255, 159, 64, 0.85)'    // orange
            ],
            hoverOffset: 10,
            borderColor: 'rgba(15, 23, 42, 1)', // slate-900
            borderWidth: 3,
        }]
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        layout: {
            padding: 10
        },
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: '#cbd5e1',
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    padding: 20,
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            title: {
                display: true,
                text: 'Appointment Status Breakdown',
                color: '#e2e8f0',
                font: {
                    size: 18,
                    weight: 'bold'
                },
                padding: {
                    bottom: 20
                }
            },
            tooltip: {
                backgroundColor: 'rgba(15, 23, 42, 0.95)',
                titleColor: '#f1f5f9',
                bodyColor: '#e2e8f0',
                borderColor: '#64748b',
                borderWidth: 1,
                padding: 12,
                cornerRadius: 6,
                callbacks: {
                    label: (ctx) => {
                        const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                        const value = ctx.parsed;
                        const percentage = ((value / total) * 100).toFixed(1);
                        return ` ${ctx.label}: ${value} (${percentage}%)`;
                    }
                }
            }
        },
        animation: {
            animateScale: true,
            animateRotate: true,
            duration: 1200,
            easing: 'easeOutQuart'
        }
    }
});
    // Appointments Per Day

const appointmentDates = {!! json_encode($appointmentsPerDay->keys()) !!};
const appointmentCounts = {!! json_encode($appointmentsPerDay->values()) !!};

new Chart(document.getElementById('appointmentsPerDayChart'), {
    type: 'line',
    data: {
        labels: appointmentDates,
        datasets: [{
            label: 'Appointments',
            data: appointmentCounts,
            borderColor: 'rgba(59, 130, 246, 1)', // blue-500
            backgroundColor: (ctx) => {
                const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
                gradient.addColorStop(1, 'rgba(59, 130, 246, 0.05)');
                return gradient;
            },
            tension: 0.4,
            pointRadius: 4,
            pointHoverRadius: 7,
            pointBackgroundColor: '#3b82f6',
            pointBorderColor: '#0f172a',
            pointHoverBorderColor: '#facc15', // yellow highlight on hover
            pointBorderWidth: 2,
            fill: true,
        }]
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        layout: {
            padding: {
                top: 10,
                bottom: 10,
                left: 0,
                right: 10
            }
        },
        plugins: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Appointments Per Day',
                color: '#e2e8f0',
                font: {
                    size: 18,
                    weight: 'bold'
                },
                padding: {
                    bottom: 20
                }
            },
            tooltip: {
                backgroundColor: 'rgba(15, 23, 42, 0.95)',
                titleColor: '#f1f5f9',
                bodyColor: '#e2e8f0',
                borderColor: '#64748b',
                borderWidth: 1,
                padding: 12,
                cornerRadius: 6,
                callbacks: {
                    label: context => ` ${context.parsed.y} appointments`
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: '#cbd5e1',
                    maxRotation: 45,
                    minRotation: 45,
                    font: {
                        size: 12
                    }
                },
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#cbd5e1',
                    font: {
                        size: 12
                    }
                },
                grid: {
                    color: 'rgba(100, 116, 139, 0.15)',
                    borderDash: [4, 4]
                }
            }
        },
        animation: {
            duration: 1500,
            easing: 'easeOutCubic'
        },
        elements: {
            line: {
                borderWidth: 3
            },
            point: {
                hoverBorderWidth: 3
            }
        }
    }
});
    // Blood Type Chart

const bloodLabels = {!! json_encode(array_keys($doctorStats['bloodTypeDistribution']->toArray())) !!};
const bloodData = {!! json_encode(array_values($doctorStats['bloodTypeDistribution']->toArray())) !!};

new Chart(document.getElementById('bloodChart'), {
    type: 'bar',
    data: {
        labels: bloodLabels,
        datasets: [{
            label: 'Blood Type (%)',
            data: bloodData,
            backgroundColor: 'rgba(239, 68, 68, 0.8)', // red-500
            borderColor: 'rgba(220, 38, 38, 1)', // red-600
            borderWidth: 2,
            borderRadius: {
                topLeft: 8,
                topRight: 8
            },
            barPercentage: 0.6,
            categoryPercentage: 0.6
        }]
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        layout: {
            padding: {
                top: 10,
                bottom: 10,
                left: 0,
                right: 10
            }
        },
        plugins: {
            title: {
                display: true,
                text: 'Blood Type Distribution',
                color: '#f87171',
                font: {
                    size: 18,
                    weight: 'bold'
                },
                padding: {
                    bottom: 20
                }
            },
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(15, 23, 42, 0.95)',
                titleColor: '#fca5a5',
                bodyColor: '#fef2f2',
                borderColor: '#dc2626',
                borderWidth: 1,
                padding: 12,
                cornerRadius: 6,
                callbacks: {
                    label: context => ` ${context.parsed.y}%`
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: '#fca5a5',
                    font: {
                        size: 12
                    }
                },
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#fca5a5',
                    font: {
                        size: 12
                    },
                    callback: value => `${value}%`
                },
                grid: {
                    color: 'rgba(239, 68, 68, 0.1)',
                    borderDash: [4, 4]
                }
            }
        },
        animation: {
            duration: 1400,
            easing: 'easeOutBack'
        },
        elements: {
            bar: {
                hoverBackgroundColor: 'rgba(252, 165, 165, 0.9)',
                hoverBorderColor: '#b91c1c'
            }
        }
    }
});

</script>

    </div>
</body>
</html>
