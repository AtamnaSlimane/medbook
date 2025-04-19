<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MEDBook - Explore Doctors</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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

        /* Theme colors */
        .med-teal { color: var(--med-teal); }
        .bg-med-teal { background-color: var(--med-teal); }

        .btn-teal {
            background-color: var(--med-teal);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-teal:hover {
            background-color: var(--med-teal-hover);
            box-shadow: 0 4px 15px rgba(0, 204, 204, 0.5);
            transform: translateY(-2px);
        }

        /* Card styles */
        .card {
            background: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.4s ease;
            border-radius: 16px;
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

        /* Form elements */
        .input-field {
            background-color: var(--input-bg);
            border: 1px solid #444;
            color: white;
            transition: all 0.3s ease;
            padding: 10px 16px;
            border-radius: 8px;
            width: 100%;
        }

        .input-field:focus {
            border-color: var(--med-teal);
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 204, 204, 0.2);
        }

        /* Filter buttons */
        .filter-btn {
            background-color: #2A2A2A;
            color: #E5E7EB;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.875rem;
        }

        .filter-btn.active {
            background-color: var(--med-teal);
            color: #121212;
            font-weight: 600;
        }

        .filter-btn:hover:not(.active) {
            background-color: #333333;
            transform: translateY(-1px);
        }

        /* Logo animation */
        .logo-pulse {
            animation: gentle-pulse 3s infinite;
        }

        @keyframes gentle-pulse {
            0% { text-shadow: 0 0 5px rgba(0, 204, 204, 0.5); }
            50% { text-shadow: 0 0 15px rgba(0, 204, 204, 0.8); }
            100% { text-shadow: 0 0 5px rgba(0, 204, 204, 0.5); }
        }

        /* Doctor cards */
        .doctor-card {
            background-color: #1E1E1E;
            border-radius: 16px;
            margin-bottom: 20px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .doctor-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            border-color: rgba(0, 204, 204, 0.3);
        }

        /* Specialty tags */
        .specialty-tag {
            background-color: var(--med-teal-light);
            color: var(--med-teal);
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            margin-right: 8px;
            margin-bottom: 8px;
            display: inline-block;
            letter-spacing: 0.5px;
        }

        /* Booking form */
        .booking-form {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: rgba(25, 25, 25, 0.6);
            border-radius: 12px;
        }

        /* Time slots */
        .time-slots {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            grid-gap: 8px;
            margin-bottom: 16px;
        }

        .time-slot {
            padding: 8px 4px;
            text-align: center;
            border-radius: 8px;
            background-color: #2A2A2A;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.85rem;
        }

        .time-slot:hover {
            background-color: rgba(0, 204, 204, 0.2);
        }

        .time-slot.selected {
            background-color: var(--med-teal);
            color: #121212;
            font-weight: 600;
        }

        /* Animation utilities */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Loading spinner */
        .loading-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Toggle button */
        .toggle-chevron {
            transition: transform 0.3s ease;
        }

        .toggle-booking-btn.active .toggle-chevron {
            transform: rotate(180deg);
        }

        /* Profile picture */
        .profile-pic {
            object-fit: cover;
            border: 2px solid rgba(0, 204, 204, 0.6);
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 30px;
        }

        .pagination a, .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 10px;
            border-radius: 8px;
            background-color: #2A2A2A;
            color: #E5E7EB;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background-color: #333333;
        }

        .pagination .active {
            background-color: var(--med-teal);
            color: #121212;
            font-weight: 600;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1a1a1a;
        }

        ::-webkit-scrollbar-thumb {
            background: #444;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Filter dropdown */
        .specialty-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #2A2A2A;
            min-width: 200px;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            max-height: 300px;
            overflow-y: auto;
        }

        .specialty-dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-item {
            padding: 12px 16px;
            display: block;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: rgba(0, 204, 204, 0.1);
        }

        /* Rating stars */
        .rating {
            color: #FFD700;
        }

        /* Header title styling */
        .page-title {
            position: relative;
            display: inline-block;
            margin-bottom: 12px;
        }

        .page-title:after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -6px;
            height: 3px;
            width: 60px;
            background-color: var(--med-teal);
            border-radius: 2px;
        }

        /* Doctor profile link hover effect */
        .doctor-name {
            position: relative;
            transition: all 0.3s ease;
        }

        .doctor-name:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: var(--med-teal);
            transition: width 0.3s ease;
        }

        .doctor-name:hover:after {
            width: 100%;
        }

        /* Alerts */
        .alert {
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            position: relative;
            animation: slideDown 0.5s ease-in-out;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.2);
            border-left: 4px solid #10B981;
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.2);
            border-left: 4px solid #EF4444;
        }

        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Improved filter section */
        .filter-section {
            background-color: rgba(30, 30, 30, 0.7);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Top doctors badge */
        .top-badge {
            background-color: rgba(245, 158, 11, 0.2);
            color: #F59E0B;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            margin-left: 8px;
        }
    </style>
</head>
<body>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
<!-- Sidebar -->
        <div class="w-64 bg-gray-900 p-6 flex flex-col">
            <div class="mb-10">
                <a href="{{ route('home') }}" class="flex items-center">
                    <span class="med-teal text-3xl font-bold logo-pulse">MED</span><span class="text-3xl font-bold text-white">Book</span>
                </a>
            </div>

            <nav class="flex-1">
                <a href="{{ route('patient.dashboard') }}" class="sidebar-link">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{route('patient.appointments')}}" class="sidebar-link ">
                    <svg class="h-5 w-5 mr-3 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    My Appointments
                </a>
                <a href="#favorites" class="sidebar-link">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    My Favorites
                </a>

<a href="{{ route('patient.explore') }}" class="sidebar-link active">
    <svg class="h-5 w-5 mr-3 med-teal" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
    @if($user->profile_picture)
        <img src="{{ asset('storage/' . $user->profile_picture) }}"
             alt="Profile Picture"
             class="h-10 w-10 rounded-full object-cover" />
    @else
 @php
        $nameParts = explode(' ', $user->name);
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
        <div class="font-medium">{{ $user->name }}</div>
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
    <!-- Notification Alerts -->
    @if(session('success'))
        <div class="alert alert-success animate-fade-in">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger animate-fade-in">
            <i class="fas fa-exclamation-circle mr-2"></i>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold page-title flex items-center">
                    <i class="fas fa-user-md text-teal-400 mr-3"></i>
                    Explore Doctors
                </h1>
                <p class="text-gray-400 mt-3 flex items-center">
                    <i class="fas fa-calendar-day mr-2"></i>
                    {{ \Carbon\Carbon::now()->format('l, F j, Y') }} •
                    <i class="fas fa-map-marker-alt mx-2"></i>
                    Setif, Algeria
                </p>
            </div>
                    </div>
    </div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <!-- Total Doctors -->
    <div class="bg-gray-900 rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow stat-card">
        <div class="text-gray-400 text-sm mb-2">Total Doctors</div>
        <div class="flex justify-between items-end">
            <div class="text-3xl font-extrabold text-white">{{ $alldoctors }}</div>
            <div class="text-sm text-gray-500 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                All time
            </div>
        </div>
    </div>

    <!-- My Doctors -->
    <div class="bg-gray-900 rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow stat-card">
        <div class="text-gray-400 text-sm mb-2">My Doctors</div>
        <div class="flex justify-between items-end">
            <div class="text-3xl font-extrabold text-white">{{ $doctorscount }}</div>
        </div>
    </div>

</div>
    <!-- Search and Filter Controls -->
    <div class="mb-6" x-data="{ showFilters: false }">
        <div class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[300px]">
                <form action="{{ route('patient.explore') }}" method="GET" class="flex gap-2">
                    <div class="relative flex-1">
                        <input type="text" name="search" placeholder="Search by name, specialty, or condition..."
                            class="search-input w-full pl-12 py-3 rounded-lg bg-black border border-gray-700 focus:border-teal-400 focus:ring focus:ring-teal-400/20 transition-all"
                            value="{{ request('search') }}">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <i class="fas fa-search text-teal-400"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn-teal px-5 py-3 rounded-lg font-medium flex items-center">
                        <i class="fas fa-search mr-2"></i> Search
                    </button>
                    @if(request()->has('search') || request()->has('specialty') ||  request()->has('sort_by'))
                        <a href="{{ route('patient.explore') }}" class="flex items-center justify-center px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition-all">
                            <i class="fas fa-times mr-2"></i> Clear
                        </a>
                    @endif
                </form>
            </div>

            <button @click="showFilters = !showFilters" class="px-5 py-3 bg-gray-800 hover:bg-gray-700 rounded-lg flex items-center gap-2 transition-colors border border-gray-700">
                <i class="fas fa-sliders-h text-teal-400"></i>
                <span x-text="showFilters ? 'Hide Filters' : 'Show Filters'"></span>
            </button>
        </div>

        <!-- Advanced Filters (collapsible) -->
        <div x-show="showFilters" x-transition class="mt-6 p-6 bg-gray-800/50 rounded-xl border border-gray-700 shadow-lg">
            <form action="{{ route('patient.explore') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <!-- Specialty Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                        <i class="fas fa-tag text-teal-400 mr-2"></i> Specialty
                    </label>
                    <select name="specialty" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-3 focus:border-teal-400 focus:ring focus:ring-teal-400/20 transition-all">
                        <option value="">All Specialties</option>
                        @foreach(['Cardiology', 'Dermatology', 'Neurology', 'Pediatrics', 'Psychology'] as $spec)
                            <option value="{{ Str::slug($spec) }}" {{ request('specialty') == Str::slug($spec) ? 'selected' : '' }}>
                                {{ $spec }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Rating Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                        <i class="fas fa-star text-teal-400 mr-2"></i> Minimum Rating
                    </label>
                    <div class="flex items-center space-x-4 mt-2">
                        @foreach([3, 4, 5] as $rating)
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="rating" value="{{ $rating }}" {{ request('rating') == $rating ? 'checked' : '' }}
                                    class="form-radio text-teal-400 focus:ring focus:ring-teal-400/20">
                                <span class="ml-2 flex items-center">
                                    @for($i = 1; $i <= $rating; $i++)
                                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                                    @endfor
                                    @for($i = $rating + 1; $i <= 5; $i++)
                                        <i class="far fa-star text-gray-500 text-sm"></i>
                                    @endfor
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>



                <!-- Sort Options -->
                <div class="md:col-span-3 mt-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2 flex items-center">
                        <i class="fas fa-sort text-teal-400 mr-2"></i> Sort Results By
                    </label>
                    <div class="flex flex-wrap gap-3">
                        @foreach([
                            'rating_desc' => 'Highest Rated',
                            'experience_desc' => 'Most Experienced',
                            'doctor_name' => 'Name (A-Z)',
                            'doctor_name_desc' => 'Name (Z-A)'
                        ] as $value => $label)
                            <button
                                type="submit"
                                name="sort_by"
                                value="{{ $value }}"
                                class="sort-btn px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-sm transition-all border border-transparent {{ request('sort_by') === $value ? 'active bg-teal-500 text-gray-900 font-medium' : '' }}"
                            >
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="md:col-span-3 flex justify-between mt-6 pt-6 border-t border-gray-700">
                    <button type="reset" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition-all">
                        <i class="fas fa-redo-alt mr-2"></i> Reset Filters
                    </button>
                    <button type="submit" class="btn-teal px-8 py-3 rounded-lg font-medium flex items-center">
                        <i class="fas fa-check mr-2"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Filter Pills -->
    <div class="mb-8">
        <div class="flex flex-wrap items-center gap-3">
@php
    $specialties = [
        'Cardiology', 'Dermatology', 'Endocrinology', 'Family Medicine', 'Gastroenterology',
        'Hematology', 'Internal Medicine', 'Neurology', 'Obstetrics and Gynecology', 'Oncology',
        'Ophthalmology', 'Orthopedics', 'Otolaryngology', 'Pediatrics', 'Psychiatry',
        'Pulmonology', 'Rheumatology', 'Urology'
    ];
@endphp
            <!-- Desktop Filters -->
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('patient.explore', ['specialty' => 'all']) }}"
                    class="filter-btn px-4 py-2 rounded-full text-sm border border-gray-700 transition-all {{ request()->get('specialty') == 'all' || !request()->has('specialty') ? 'active bg-teal-500 text-gray-900 border-transparent' : 'hover:border-teal-400' }}">
                    <i class="fas fa-th-large mr-1"></i> All
                </a>
                @foreach ($specialties as $specialty)
                    <a href="{{ route('patient.explore', ['specialty' => Str::slug($specialty)]) }}"
                        class="filter-btn px-4 py-2 rounded-full text-sm border border-gray-700 transition-all {{ request()->get('specialty') == Str::slug($specialty) ? 'active bg-teal-500 text-gray-900 border-transparent' : 'hover:border-teal-400' }}">
                        {{ $specialty }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Results Info & Sort Dropdown -->
    <div class="mb-6 flex flex-wrap items-center justify-between">
        <p class="text-gray-300">
            <span class="font-medium text-white">{{ $doctors->total() }}</span> doctors found
            @if(request('search'))
                for "<span class="text-teal-400">{{ request('search') }}</span>"
            @endif
            @if(request('specialty') && request('specialty') != 'all')
                in <span class="text-teal-400">{{ ucfirst(request('specialty')) }}</span>
            @endif
        </p>

        <div class="mt-3 md:mt-0">
            <form method="GET" id="sortForm" class="flex items-center">
                <label for="sortDoctors" class="mr-3 text-sm text-gray-400">Sort by:</label>
                <select id="sortDoctors" name="sort"
                    class="rounded-lg text-sm p-2 pr-10 bg-gray-800 border border-gray-700 cursor-pointer focus:border-teal-400 focus:ring focus:ring-teal-400/20 transition-all">
                    <option value="name_asc" {{ request()->get('sort') == 'name' && request()->get('order') == 'asc' ? 'selected' : '' }}>Name: A-Z</option>
                    <option value="name_desc" {{ request()->get('sort') == 'name' && request()->get('order') == 'desc' ? 'selected' : '' }}>Name: Z-A</option>
                    <option value="rating_desc" {{ request()->get('sort') == 'rating' && request()->get('order') == 'desc' ? 'selected' : '' }}>Rating: Highest First</option>
                    <option value="experience_desc" {{ request()->get('sort') == 'experience' && request()->get('order') == 'desc' ? 'selected' : '' }}>Experience: Most First</option>
                </select>
            </form>
        </div>
    </div>

    <!-- View Toggle -->
<div x-data="{ view: 'list' }">

    <!-- Doctors List -->

    <div class="mb-12">
        <div class="doctor-list flex flex-col gap-6">
            @foreach($doctors as $doctor)
            <div class="doctor-card group hover:border-teal-400/30" data-specialties="{{ strtolower($doctor->specialties) }}">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-start justify-between">
                        <!-- Doctor Info Section -->
                        <div class="flex items-start">
                            <div class="h-20 w-20 rounded-full bg-gray-700 flex items-center justify-center mr-5 overflow-hidden border-2 border-teal-400/30 group-hover:border-teal-400 transition-all shadow-md">
                                @if($doctor->profile_picture)
                                    <img src="{{ asset('storage/' . $doctor->profile_picture) }}" class="h-20 w-20 object-cover" alt="{{ $doctor->name }}">
                                @else
                                    <span class="text-white font-semibold text-xl">{{ strtoupper(substr($doctor->name, 0, 2)) }}</span>
                                @endif
                            </div>
                            <div>
                                                                <a href="{{route('patient.doctor.profile', $doctor->id)}}" class="group/name">
                                    <h3 class="text-2xl font-semibold doctor-name group-hover/name:text-teal-400 transition-colors">
                                        Dr. {{ $doctor->name }}
                                    </h3>
                                </a>

                                @if($doctor->doctorProfile && $doctor->doctorProfile->specialty)
                                    <p class="text-gray-400 text-sm mt-1">
                                        {{ $doctor->doctorProfile->specialty }}
                                    </p>
                                @endif


                                <div class="mt-3 flex items-center">
                                    <div class="rating flex items-center">
                                        @php
                                            $rating = 4.5; // Example rating - use actual rating from database
                                        @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($rating))
                                                <i class="fas fa-star text-yellow-400"></i>
                                            @elseif($i - 0.5 <= $rating)
                                                <i class="fas fa-star-half-alt text-yellow-400"></i>
                                            @else
                                                <i class="far fa-star text-gray-500"></i>
                                            @endif
                                        @endfor
                                        <span class="ml-2 font-medium">{{ $rating }}</span>
                                        <span class="text-gray-400 text-sm ml-1">({{ rand(10, 150) }} reviews)</span>
                                    </div>

                                    @if($rating >= 4.5)
                                        <span class="top-badge ml-3">
                                            <i class="fas fa-award mr-1"></i> Top Rated
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Price & Quick Actions -->
                        <div class="mt-4 md:mt-0 md:ml-4 flex flex-col items-end">
                            <div class="text-right mb-3">
                                <span class="text-sm text-gray-400">Consultation Fee</span>
                                <div class="text-2xl font-semibold text-white">${{ $doctor->doctorProfile->fee  }}</div>
                            </div>

<div class="flex gap-2">
    <form action="{{ route('favorites.toggle', ['doctorId' => $doctor->id]) }}" method="POST">
        @csrf
        <button type="submit" class="w-10 h-10 rounded-full bg-gray-800 border border-gray-700 hover:border-teal-400 flex items-center justify-center transition-all" title="Add to favorites">
            <i class="far fa-heart text-teal-400"></i>
        </button>
    </form>
</div>
                       </div>
                    </div>

                    <!-- Specialties -->
                    <div class="mt-4">
                        @if($doctor->doctorProfile && $doctor->doctorProfile->specialty)
                            <div class="specialties-list">
                                @foreach(explode(',', $doctor->doctorProfile->specialty) as $specialty)
                                    <div class="specialty-tag">
                                        <i class="fas fa-stethoscope mr-1"></i> {{ ucfirst(trim($specialty)) }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Next Available & Book Button -->
                    <div class="mt-6 flex flex-col md:flex-row md:items-center justify-between">

                        <button type="button" class="toggle-booking-btn btn-teal px-6 py-3 rounded-lg text-sm font-medium flex items-center gap-2 transition-all hover:scale-105">
                            <i class="fas fa-calendar-plus"></i>
                            <span>Book Appointment</span>
                            <i class="fas fa-chevron-down toggle-chevron ml-1"></i>
                        </button>
                    </div>

                    <!-- Booking Form -->
                    <div class="booking-form mt-6 border-t border-gray-700 pt-6 overflow-hidden transition-all duration-500 ease-in-out" style="max-height: 0;">
                        <form action="{{ route('appointments.book') }}" method="POST" class="appointment-form p-4 bg-gray-800/50 rounded-xl border border-gray-700">
                            @csrf
                            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}" data-doctor-id="{{ $doctor->id }}">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="appointment_date_{{ $doctor->id }}" class="block text-sm mb-2 text-gray-300 font-medium">
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
                                        <div class="error-message"></div>
                                        <input type="hidden" name="appointment_time" value="01:00 PM">
                                    </div>

                                    <div class="mb-4">
                                        <label for="appointment_notes_{{ $doctor->id }}" class="block text-sm mb-2 text-gray-300 font-medium">
                                            <i class="fas fa-comment-medical mr-2"></i> Notes (Optional):
                                        </label>
                                        <textarea
                                            id="appointment_notes_{{ $doctor->id }}"
                                            name="notes"
                                            rows="2"
                                            class="w-full px-4 py-3 rounded-lg input-field"
                                            placeholder="Any specific concerns or information you'd like the doctor to know"></textarea>
                                    </div>

                                    <button type="submit" class="w-full btn-teal py-3 rounded-lg font-medium flex items-center justify-center">
                                        <i class="fas fa-calendar-check mr-2"></i>
                                        Confirm Appointment
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Pagination -->
                @if($doctors)
                <div class="mt-8">
                    {{ $doctors->appends(request()->query())->links() }}
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
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Initialize DOM references
    const doctorCards = document.querySelectorAll('.doctor-card');
    const searchInput = document.getElementById('searchDoctors');
    const sortSelect = document.getElementById('sortDoctors');

    // Time formatting utility
    function formatTime(time) {
        const [hours, minutes] = time.split(':');
        const parsedHours = parseInt(hours, 10);
        const ampm = parsedHours >= 12 ? 'PM' : 'AM';
        const twelveHour = parsedHours % 12 || 12;
        return `${twelveHour}:${minutes} ${ampm}`;
    }

    // Toggle booking form with proper state management
    function handleBookingToggle(e) {
        const button = e.currentTarget;
        const card = button.closest('.doctor-card');
        const form = card.querySelector('.booking-form');
        const wasExpanded = form.style.maxHeight && form.style.maxHeight !== '0px';

        // Collapse other cards
        doctorCards.forEach(otherCard => {
            if (otherCard !== card) {
                otherCard.querySelector('.booking-form').style.maxHeight = '0';
                otherCard.querySelector('.toggle-booking-btn').classList.remove('active');
            }
        });

        // Toggle current card
        form.style.maxHeight = wasExpanded ? '0' : `${form.scrollHeight}px`;
        button.classList.toggle('active', !wasExpanded);
    }

    // Date change handler with error handling
    async function handleDateChange(e) {
    const input = e.target;
    const form = input.closest('form');
    const doctorId = form.querySelector('input[name="doctor_id"]').dataset.doctorId;
    const timeSlotsContainer = form.querySelector('.time-slots');
    const errorMessage = form.querySelector('.error-message');
    const bookingForm = form.closest('.booking-form');

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
        bookingForm.style.maxHeight = `${bookingForm.scrollHeight}px`;

    } catch (error) {
        errorMessage.textContent = 'Failed to load time slots. Please try again later.';
        errorMessage.classList.add('active');
        console.error('Date change error:', error);
    }
}


    // Search functionality
    function handleSearch() {
        const term = this.value.toLowerCase().trim();
        doctorCards.forEach(card => {
            const name = card.querySelector('h3')?.textContent.toLowerCase() || '';
            card.style.display = name.includes(term) ? 'block' : 'none';
        });
    }

    // Sort functionality
    function handleSortChange() {
        const [sort, order] = this.value.split('_');
        const url = new URL(window.location.href);
        url.searchParams.set('sort', sort);
        url.searchParams.set('order', order);
        window.location.href = url.toString();
    }

    // Form submission handler
    async function handleFormSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalHtml = submitBtn.innerHTML;

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

            if (!response.ok) {
                throw new Error(data.message || 'Booking failed');
            }

            // Show success notification
            const notification = document.createElement('div');
            notification.className = 'bg-green-600 text-white p-4 rounded-lg mb-6 shadow-lg animate-fade-in';
            notification.textContent = data.message || 'Appointment booked successfully!';
            form.closest('.mb-10')?.after(notification);

            // Reset form state
            form.reset();
            form.closest('.doctor-card').querySelector('.booking-form').style.maxHeight = '0';
            form.closest('.doctor-card').querySelector('.toggle-booking-btn').classList.remove('active');

            // Remove notification after delay
            setTimeout(() => notification.remove(), 5000);

        } catch (error) {
            const errorDiv = form.querySelector('.error-message');
            errorDiv.textContent = error.message || 'An error occurred. Please try again.';
            errorDiv.classList.add('active');
        } finally {
            submitBtn.innerHTML = originalHtml;
            submitBtn.disabled = false;
        }
    }

    // Event listener setup
    document.querySelectorAll('.toggle-booking-btn').forEach(button => {
        button.addEventListener('click', handleBookingToggle);
    });

    document.querySelectorAll('input[type="date"]').forEach(input => {
        input.addEventListener('change', handleDateChange);
    });

    if (searchInput) searchInput.addEventListener('input', handleSearch);
    if (sortSelect) sortSelect.addEventListener('change', handleSortChange);

    document.querySelectorAll('.appointment-form').forEach(form => {
        form.addEventListener('submit', handleFormSubmit);
    });

});
</script>



</body>
</html>
