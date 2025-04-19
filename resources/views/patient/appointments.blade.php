<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDBook - My Appointments</title>
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
        .badge-completed {
            background-color: rgba(0, 128, 255, 0.2);
            color: #0080FF;
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
        .filter-btn {
            background-color: #2A2A2A;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        .filter-btn.active {
            background-color: #00CCCC;
            color: #121212;
            font-weight: 600;
        }
        .filter-btn:hover:not(.active) {
            background-color: #333333;
        }
        .stat-card {
            background: rgba(40, 40, 40, 0.7);
            border-radius: 12px;
            padding: 24px;
            border: 1px solid rgba(255, 255, 255, 0.05);
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
        .sort-icon {
            transition: transform 0.3s ease;
        }
        .sort-icon.asc {
            transform: rotate(0deg);
        }
        .sort-icon.desc {
            transform: rotate(180deg);
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
                <a href="{{ route('patient.dashboard') }}" class="sidebar-link">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{route('patient.appointments')}}" class="sidebar-link active">
                    <svg class="h-5 w-5 mr-3 med-teal" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
            <!-- Header -->
            <div class="mb-10">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">My Appointments</h1>
                        <p class="text-gray-400 mt-1">{{ \Carbon\Carbon::now()->format('l, F j, Y') }} • Setif, Algeria</p>
                    </div>
                    <a href="{{ route('patient.dashboard') }}#doctors" class="btn-teal px-5 py-2 rounded-lg text-sm font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Book New
                    </a>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                <div class="stat-card">
                    <div class="text-gray-400 text-sm mb-1">Total appointments</div>
                    <div class="flex justify-between items-end">
                        <div class="text-3xl font-bold">{{ $totalAppointments }}</div>
                        <div class="text-sm text-gray-400 flex items-center">
                            <span class="mr-1">All time</span>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="text-gray-400 text-sm mb-1">Upcoming</div>
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
                    <div class="text-gray-400 text-sm mb-1">Pending</div>
                    <div class="flex justify-between items-end">
                        <div class="text-3xl font-bold">{{ $pendingAppointments }}</div>
                        <div class="text-sm text-yellow-400 flex items-center">
                            <span class="mr-1">Awaiting confirmation</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="text-gray-400 text-sm mb-1">Completed</div>
                    <div class="flex justify-between items-end">
                        <div class="text-3xl font-bold">{{ $completedAppointments }}</div>
                        <div class="text-sm text-red-400 flex items-center">
                            <span class="mr-1">{{ $canceledAppointments }} Canceled</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

<!-- Filter, Sort & Date Range -->
<div class="mb-6 bg-black border border-gray-800 p-4 rounded-xl shadow-sm">
    <form method="GET" action="{{ route('patient.appointments') }}" id="filterForm" class="flex flex-wrap gap-4 items-center w-full">

        <!-- Status Filters -->
        <div class="flex flex-wrap gap-2">
            @php $activeFilter = request()->get('filter', 'all'); @endphp
            @foreach ([
                'all' => 'All',
                'pending' => 'Pending',
                'booked' => 'Booked',
                'completed' => 'Completed',
                'canceled' => 'Canceled'
            ] as $key => $label)
                <a href="{{ route('patient.appointments', array_merge(request()->except('page'), ['filter' => $key])) }}"
                   class="px-4 py-2 rounded-full text-sm font-medium transition
                          {{ $activeFilter == $key ? 'bg-gray-700 text-white' : 'bg-gray-900 text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <!-- Date Range -->
        <div class="flex flex-wrap gap-2 items-center">
            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                   class="bg-gray-900 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-gray-600 focus:border-gray-500"
                   placeholder="From" />
            <span class="text-gray-500">to</span>
            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                   class="bg-gray-900 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-gray-600 focus:border-gray-500"
                   placeholder="To" />

            @if(request('date_from') || request('date_to'))
            <button type="button"
                    onclick="clearDateFilters()"
                    class="text-gray-400 hover:text-white bg-gray-800 hover:bg-gray-700 px-2 py-2 rounded-full transition shadow-sm"
                    title="Clear Date Filter">
                <i data-lucide="undo" class="w-4 h-4"></i>
            </button>
            @endif
        </div>

        <!-- Sort Dropdown -->
        <div class="ml-auto">
            <select id="sortDropdown" name="sort_order"
                    class="bg-gray-900 text-gray-300 border border-gray-700 rounded-lg px-3 py-2 text-sm focus:ring-gray-600 focus:border-gray-500">
                <option value="appointment_date|asc" {{ request('sort') == 'appointment_date' && request('order') == 'asc' ? 'selected' : '' }}>
                    Date: Oldest First
                </option>
                <option value="appointment_date|desc" {{ request('sort') == 'appointment_date' && request('order') == 'desc' ? 'selected' : '' }}>
                    Date: Newest First
                </option>
                <option value="doctor|asc" {{ request('sort') == 'doctor' && request('order') == 'asc' ? 'selected' : '' }}>
                    Doctor: A-Z
                </option>
                <option value="doctor|desc" {{ request('sort') == 'doctor' && request('order') == 'desc' ? 'selected' : '' }}>
                    Doctor: Z-A
                </option>
            </select>
        </div>

        <!-- Hidden sort/order fields for submission -->
        <input type="hidden" name="sort" id="sortInput" value="{{ request('sort', 'appointment_date') }}">
        <input type="hidden" name="order" id="orderInput" value="{{ request('order', 'asc') }}">

        <!-- Submit button -->
        <button type="submit"
                class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
            <i data-lucide="filter" class="w-4 h-4 inline mr-1"></i> Filter
        </button>
    </form>
</div>

<!-- Search bar -->
<form method="GET" action="{{ route('patient.appointments') }}" class="mb-8 relative">
    <input type="text" id="searchAppointments" name="search" value="{{ request('search') }}"
           placeholder="Search by doctor name or specialty..."
           class="w-full px-4 py-3 rounded-lg bg-gray-900 text-gray-200 border border-gray-700 pl-12 focus:ring-gray-600 focus:border-gray-500 shadow-sm">
    <i data-lucide="search" class="w-5 h-5 text-gray-500 absolute left-4 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>

    <!-- Preserve current filters -->
    <input type="hidden" name="filter" value="{{ request('filter','all') }}">
    <input type="hidden" name="sort" value="{{ request('sort') }}">
    <input type="hidden" name="order" value="{{ request('order') }}">
    <input type="hidden" name="date_from" value="{{ request('date_from') }}">
    <input type="hidden" name="date_to" value="{{ request('date_to') }}">
</form>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    // Initialize Lucide icons
    lucide.createIcons();

    $(document).ready(function() {
        // Sort dropdown functionality using jQuery
        $('#sortDropdown').change(function() {
            const selectedValue = $(this).val();
            let [sort, order] = selectedValue.split('|');

            let url = new URL(window.location.href);
            url.searchParams.set('sort', sort);
            url.searchParams.set('order', order);

            // Navigate to the new URL; this reloads the page
            window.location.href = url.toString();
        });

        // Search functionality: filter appointment cards on keyup
        $('#searchAppointments').on('keyup', function() {
            const searchValue = $(this).val().toLowerCase().trim();

            $('.appointment-card').each(function() {
                const doctorName = $(this).find('h3').text().toLowerCase();
                const specialty = $(this).find('.doctor-specialty').text().toLowerCase().trim();

                if (doctorName.includes(searchValue) || specialty.includes(searchValue)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            // Optionally handle empty results here...
        });
    });

    // Clear Date Filters using URL manipulation (keeps session intact)
    function clearDateFilters() {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.delete('date_from');
        urlParams.delete('date_to');

        const newUrl = window.location.pathname + '?' + urlParams.toString();
        window.history.pushState({}, '', newUrl);
        location.reload();
    }
</script>

<!-- Appointments List -->

<div class="overflow-x-auto border border-gray-800 rounded-xl">
    <table class="min-w-full bg-[#111] text-gray-300 text-sm">

<thead class="bg-black border-b border-gray-800 text-left text-gray-400">
    <tr>
        @php
            $currentSort = request('sort', 'appointment_date');
            $currentOrder = request('order', 'asc');
            $isActive = $currentSort === 'appointment_date';
            $newOrder = $isActive && $currentOrder === 'asc' ? 'desc' : 'asc';
            $icon = $isActive
                ? ($currentOrder === 'asc' ? '▲' : '▼')
                : '';
            $query = http_build_query(array_merge(request()->except('page'), ['sort' => 'appointment_date', 'order' => $newOrder]));
        @endphp

        <!-- Sortable Date -->
        <th class="px-6 py-4 cursor-pointer whitespace-nowrap">
            <a href="?{{ $query }}" class="{{ $isActive ? 'text-white font-semibold' : '' }}">
                Date {!! $icon !!}
            </a>
        </th>

        <!-- Static Time -->
        <th class="px-6 py-4 whitespace-nowrap">Time</th>

        <!-- Static Doctor -->
        <th class="px-6 py-4 whitespace-nowrap">Doctor</th>

        <!-- Static Specialty -->
        <th class="px-6 py-4 whitespace-nowrap">Specialty</th>

        <!-- Static Status -->
        <th class="px-6 py-4 whitespace-nowrap">Status</th>

        <!-- Actions -->
        <th class="px-6 py-4 whitespace-nowrap">Actions</th>
    </tr>
</thead>

        <tbody>
            @foreach($appointments as $appointment)
                @php
                    $date = \Carbon\Carbon::parse($appointment->appointment_date);
                    $isFuture = $date->isFuture();
                    $status = $appointment->status;

                    $badgeClasses = match($status) {
                        'pending' => 'bg-yellow-600',
                        'booked' => 'bg-blue-600',
                        'completed' => 'bg-green-600',
                        'canceled', 'cancelled', 'rejected' => 'bg-red-600',
                        default => 'bg-gray-600'
                    };
                @endphp
                <tr class="border-t border-gray-800 hover:bg-gray-900 transition">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $date->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $date->format('H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->doctor->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->doctor->doctorProfile->specialty }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-block px-3 py-1 rounded-full text-white font-medium text-xs {{ $badgeClasses }}">
                            {{ ucfirst($status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
                        <a href="{{ route('patient.doctor.profile', $appointment->doctor_id) }}"
                           class="bg-gray-700 hover:bg-gray-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                            Profile
                        </a>

                        @if(in_array($status, ['pending', 'booked']) && $isFuture)
                            <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                    Cancel
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination here -->
<div class="mt-6 flex justify-center">
    {{ $appointments->appends(request()->all())->links('vendor.pagination.custom-black') }}

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

    <!-- JavaScript for interactivity -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</body>
</html>
