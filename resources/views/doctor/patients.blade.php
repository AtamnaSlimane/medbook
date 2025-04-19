<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDBook - Doctor Appointments</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
        .search-input {
            background: rgba(30, 30, 30, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 10px 16px;
            color: white;
            transition: all 0.3s ease;
        }
        .search-input:focus {
            border-color: rgba(0, 204, 204, 0.5);
            box-shadow: 0 0 0 2px rgba(0, 204, 204, 0.2);
            outline: none;
        }
        .sort-btn {
            background: rgba(30, 30, 30, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ccc;
            transition: all 0.3s ease;
        }
        .sort-btn:hover, .sort-btn.active {
            border-color: rgba(0, 204, 204, 0.5);
            color: #00CCCC;
        }
        .sort-btn.active {
            background: rgba(0, 204, 204, 0.1);
        }
        .filter-btn {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .filter-btn.active {
            background: rgba(0, 204, 204, 0.1);
            border-color: rgba(0, 204, 204, 0.5);
            color: #00CCCC;
        }
        .date-input {
            background: rgba(30, 30, 30, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 10px 16px;
            color: white;
            transition: all 0.3s ease;
        }
        .date-input:focus {
            border-color: rgba(0, 204, 204, 0.5);
            box-shadow: 0 0 0 2px rgba(0, 204, 204, 0.2);
            outline: none;
        }
        .clear-btn {
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
        }
        .clear-btn:hover {
            color: #00CCCC;
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
                <a href="{{route('doctor.dashboard')}}" class="sidebar-link">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
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

<a href="{{ route('doctor.patients') }}" class="sidebar-link active">
    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857
                 M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857
                 m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0
                 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
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
                        <h1 class="text-3xl font-bold">Appointments</h1>
                        <p class="text-gray-400 mt-1">Your Patients, Dr. {{$user->name}}</p>
                    </div>
                </div>
            </div>

            <!-- Appointments Table -->

            <div class="card p-6 mt-8">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold med-teal flex items-center gap-3">
                        <i class="fas fa-calendar-alt"></i>
All Patients
                    </h3>
<!-- Replace this stats section -->
<div class="flex items-center gap-4 text-sm">
    <!-- Replace with patient stats like: -->
    <div class="flex items-center gap-2 bg-gray-800/70 px-4 py-2 rounded-full">
        <div class="w-3 h-3 bg-blue-400 rounded-full"></div>
        <span>Total Patients: {{ $totalPatients }}</span>
    </div>
    <div class="flex items-center gap-2 bg-gray-800/70 px-4 py-2 rounded-full">
        <div class="w-3 h-3 bg-green-400 rounded-full"></div>
        <span>Active: {{ $activePatients }}</span>
    </div>
    <div class="flex items-center gap-2 bg-gray-800/70 px-4 py-2 rounded-full">
        <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
        <span>New This Month: {{ $newPatients }}</span>
    </div>
</div>
               </div>

                <!-- Search and Filter Controls -->
                <div class="mb-6" x-data="{ showFilters: false }">
                    <div class="flex flex-wrap gap-4">
                        <div class="flex-1 min-w-[300px]">
                            <form action="{{ route('doctor.patients') }}" method="GET" class="flex gap-2">
                                <div class="relative flex-1">
                                    <input type="text" name="search" placeholder="     Search patients..." class="search-input w-full pl-10" value="{{ request('search') }}">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </div>
                                <button type="submit" class="btn-teal px-4 py-2 rounded-lg">
                                    Search
                                </button>
                                @if(request()->has('search') || request()->has('status') || request()->has('date_from') || request()->has('date_to') || request()->has('sort_by'))
                                    <a href="{{ route('doctor.patients') }}" class="flex items-center justify-center px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg clear-btn">
                                        <i class="fas fa-times mr-2"></i> Clear
                                    </a>
                                @endif
                            </form>
                        </div>

                        <button @click="showFilters = !showFilters" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 rounded-lg flex items-center gap-2 transition-colors">
                            <i class="fas fa-filter"></i>
                            <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'"></span>
                        </button>
                    </div>

                    <!-- Advanced Filters (collapsible) -->
                    <div x-show="showFilters" x-transition class="mt-4 p-4 bg-gray-800/50 rounded-lg border border-gray-700">
                        <form action="{{ route('doctor.patients') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif


                            <!-- Date Range Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">From Date</label>
                                <input type="date" name="date_from" class="date-input w-full" value="{{ request('date_from') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">To Date</label>
                                <input type="date" name="date_to" class="date-input w-full" value="{{ request('date_to') }}">
                            </div>

                            <!-- Sort Options -->
<div class="md:col-span-3 mt-2">
    <label class="block text-sm font-medium text-gray-400 mb-2">Sort By</label>
    <div class="flex flex-wrap gap-2">
        @foreach([
            'date_asc' => 'Date (Oldest First)',
            'date_desc' => 'Date (Newest First)',
            'patient_name' => 'Patient Name (A-Z)',
            'patient_name_desc' => 'Patient Name (Z-A)'
        ] as $value => $label)
            <button
                type="submit"
                name="sort_by"
                value="{{ $value }}"
                data-loading
                class="sort-btn px-3 py-1.5 bg-gray-700 rounded-lg text-sm {{ request('sort_by') === $value ? 'active' : '' }}"
            >
                {{ $label }}
            </button>
        @endforeach
    </div>
</div>
                            <div class="md:col-span-3">
                                <button type="submit" class="btn-teal px-6 py-2 rounded-lg" data-loading>
                                    Apply Filters
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Table with sort headers -->
                <div class="overflow-x-auto">
                    <table class="w-full">
<thead>
    <tr class="text-gray-400 text-sm font-medium border-b border-gray-700/60">
        <th class="pb-4 px-2 text-left">
            <div class="flex items-center gap-2">
                Patient Name
                <a href="{{ route('doctor.patients', array_merge(request()->except('sort_by'), ['sort_by' => request('sort_by') === 'name' ? 'name_desc' : 'name'])) }}"
                   class="text-gray-400 hover:text-teal-400 transition-colors">
                    <i class="fas {{ request('sort_by') === 'name' ? 'fa-sort-up' : (request('sort_by') === 'name_desc' ? 'fa-sort-down' : 'fa-sort') }}"></i>
                </a>
            </div>
        </th>
        <th class="pb-4 px-2 text-left">Contact Info</th>
        <th class="pb-4 px-2 text-left">
            <div class="flex items-center gap-2">
                Registration Date
                <a href="{{ route('doctor.patients', array_merge(request()->except('sort_by'), ['sort_by' => request('sort_by') === 'date_asc' ? 'date_desc' : 'date_asc'])) }}"
                   class="text-gray-400 hover:text-teal-400 transition-colors">
                    <i class="fas {{ request('sort_by') === 'date_asc' ? 'fa-sort-up' : (request('sort_by') === 'date_desc' ? 'fa-sort-down' : 'fa-sort') }}"></i>
                </a>
            </div>
        </th>
        <th class="pb-4 px-2 text-left">Last Visit</th>
        <th class="pb-4 px-2 text-left">Actions</th>
    </tr>
</thead>

<tbody>
    @forelse ($patients as $patient)
        <tr class="border-b border-gray-700/60 last:border-0 hover:bg-gray-800/20 transition-colors">
            <td class="py-4 px-2">
                <div class="flex items-center gap-4">
                    <div class="avatar-container">
                        <div class="w-12 h-12 rounded-full bg-teal-900/50 flex items-center justify-center border-2 border-teal-400/20 overflow-hidden">
                            @if($patient->profile_picture)
                                <img src="{{ asset('storage/' . $patient->profile_picture) }}"
                                     alt="Profile"
                                     class="w-full h-full object-cover">
                            @else
                                <span class="text-teal-400 font-medium text-lg">
                                    {{ strtoupper(substr($patient->name, 0, 1)) }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p class="font-medium text-white hover:text-teal-300 transition-colors">
                            {{ $patient->name }}
                        </p>
                        <p class="text-sm text-gray-400 mt-1">ID: {{ $patient->id }}</p>
                    </div>
                </div>
            </td>
            <td class="py-4 px-2">
                <div class="flex flex-col">
                    <span class="text-sm text-gray-300">
                        <i class="fas fa-phone text-xs text-teal-400 mr-2"></i> {{ $patient->phone ?? 'No phone' }}
                    </span>
                    <span class="text-sm text-gray-300 mt-1">
                        <i class="fas fa-envelope text-xs text-teal-400 mr-2"></i> {{ $patient->email ?? 'No email' }}
                    </span>
                </div>
            </td>
            <td class="py-4 px-2">
                <span class="font-medium text-white">
                    {{ \Carbon\Carbon::parse($patient->created_at)->format('M d, Y') }}
                </span>
            </td>
            <td class="py-4 px-2">
                <span class="text-gray-300">
                         {{ $patient->last_visit_date ? \Carbon\Carbon::parse($patient->last_visit_date)->diffForHumans() : 'N/A' }}
                </span>
            </td>
            <td class="py-4 px-2">
                <div class="flex gap-3">
                    <a href="{{ route('doctor.patient.profile', $patient->id) }}" class="action-btn bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 px-4 py-1.5 rounded-lg transition-colors">
                        <i class="fas fa-eye"></i>
                        View
                    </a>

                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="py-8 text-center text-gray-400">
                <div class="flex flex-col items-center justify-center">
                    <svg class="w-16 h-16 text-gray-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="text-lg font-medium">No patients found</p>
                    <p class="text-sm mt-1">No patients match your current filters.</p>
                </div>
            </td>
        </tr>
    @endforelse
</tbody>
                   </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $showingpatients->appends(request()->except('page'))->links() }}
                </div>
            </div>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('filterSection', () => ({
        showFilters: false,
        init() {
            // Persist filter state across page changes
            if(localStorage.getItem('showFilters') === 'true') {
                this.showFilters = true;
            }
            this.$watch('showFilters', value => localStorage.setItem('showFilters', value));
        }
    }));
});

// Search Debouncing
let searchTimeout;
document.querySelector('[name="search"]').addEventListener('input', (e) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        e.target.form.submit();
    }, 500);
});

document.querySelector('[name="search"]').addEventListener('input', (e) => {
    e.target.form.submit();
});
// Date Validation
document.querySelectorAll('.date-input').forEach(input => {
    input.addEventListener('change', (e) => {
        const dateFrom = document.querySelector('[name="date_from"]');
        const dateTo = document.querySelector('[name="date_to"]');
        if(dateFrom.value && dateTo.value && dateFrom.value > dateTo.value) {
            alert('End date cannot be earlier than start date');
            e.target.value = '';
        }
    });
});

// Sort Indicator Animation
document.querySelectorAll('[name="sort_by"]').forEach(button => {
    button.addEventListener('click', (e) => {
        button.classList.add('animate-pulse');
        setTimeout(() => button.classList.remove('animate-pulse'), 500);
    });
});

// Filter Persistence
window.addEventListener('load', () => {
    const params = new URLSearchParams(window.location.search);
    if(params.get('status')) {
        document.querySelectorAll('.filter-btn').forEach(btn => {
            if(btn.value === params.get('status')) btn.classList.add('active');
        });
    }
    if(params.get('sort_by')) {
        document.querySelectorAll('.sort-btn').forEach(btn => {
            if(btn.value === params.get('sort_by')) btn.classList.add('active');
        });
    }
});

// Form Submission Handling
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', (e) => {
        const loadingElement = form.querySelector('[data-loading]');
        if(loadingElement) {
            loadingElement.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        }
    });
});

// Action Confirmations
document.querySelectorAll('[data-confirm]').forEach(button => {
    button.addEventListener('click', (e) => {
        if(!confirm(button.dataset.confirm)) {
            e.preventDefault();
            e.stopImmediatePropagation();
        }
    });
});

// Responsive Table Handling
function handleTableResponsive() {
    const tables = document.querySelectorAll('table');
    tables.forEach(table => {
        if(window.innerWidth < 768) {
            table.classList.add('block');
            table.classList.add('overflow-x-auto');
            table.classList.add('whitespace-nowrap');
        } else {
            table.classList.remove('block');
            table.classList.remove('overflow-x-auto');
            table.classList.remove('whitespace-nowrap');
        }
    });
}
window.addEventListener('resize', handleTableResponsive);
handleTableResponsive();
</script>
</body>
</html>
