<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDBook - Nearby Doctors</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" />
    <style>
        body {
            background-color: #121212;
            background-image: radial-gradient(circle at top right, rgba(0, 204, 204, 0.05) 0%, transparent 70%),
                            radial-gradient(circle at bottom left, rgba(0, 204, 204, 0.05) 0%, transparent 70%);
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: white;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .animate-fade-in-slow {
            animation: fadeIn 1.2s ease-out forwards;
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
            background: linear-gradient(145deg, rgba(40, 40, 40, 0.7), rgba(30, 30, 30, 0.8));
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.4s ease;
            border-radius: 16px;
            backdrop-filter: blur(5px);
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

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .doctor-card {
            background-color: #1E1E1E;
            border-radius: 12px;
            margin-bottom: 16px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .doctor-card:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 204, 204, 0.2);
        }

        .doctor-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .doctor-info img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
        }

        .doctor-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: white;
        }

        .doctor-specialty {
            color: #aaa;
            font-size: 0.875rem;
        }

        .remove-btn {
            background-color: #222;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .remove-btn:hover {
            background-color: #FF4B4B;
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

        /* Map specific styles */
        #map {
            height: 500px;
            width: 100%;
            border-radius: 16px;
            position: relative;
            z-index: 10;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(0, 204, 204, 0.2);
        }

        /* Fix for Leaflet markers appearing behind the map */
        .leaflet-pane {
            z-index: 20;
        }

        .leaflet-top, .leaflet-bottom {
            z-index: 30;
        }

        /* Dark mode style for popups */
        .leaflet-popup-content-wrapper {
            background-color: #2a2a2a;
            color: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(0, 204, 204, 0.2);
        }

        .leaflet-popup-tip {
            background-color: #2a2a2a;
        }

        .doctor-popup {
            padding: 10px;
        }

        .doctor-popup strong {
            color: #00CCCC;
            display: block;
            margin-bottom: 5px;
        }

        /* Enhanced search inputs */
        .search-container {
            position: relative;
            transition: all 0.3s ease;
        }

        .search-container input, .search-container select {
            background: rgba(30, 30, 30, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            padding: 12px 16px;
            font-size: 15px;
            width: 100%;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }

        .search-container input:focus, .search-container select:focus {
            border-color: #00CCCC;
            box-shadow: 0 0 0 2px rgba(0, 204, 204, 0.2);
            outline: none;
        }

        .search-container input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        /* Price slider styling */
        .price-slider {
            padding: 10px 15px;
            background: rgba(30, 30, 30, 0.8);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        input[type="range"] {
            -webkit-appearance: none;
            height: 6px;
            background: linear-gradient(to right, #00CCCC, #4facfe);
            border-radius: 5px;
            flex-grow: 1;
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            background: white;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(0, 204, 204, 0.7);
        }

        input[type="range"]::-moz-range-thumb {
            width: 18px;
            height: 18px;
            background: white;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(0, 204, 204, 0.7);
        }

        .price-value {
            min-width: 90px;
            text-align: center;
            font-weight: 500;
            background: rgba(0, 204, 204, 0.1);
            padding: 4px 8px;
            border-radius: 8px;
            color: #00CCCC;
        }

        /* Animation for doctor markers */
        @keyframes markerPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .icon-container {
            display: flex;
            justify-content: center;
            align-items: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: markerPulse 2s infinite;
        }

        .icon-container:hover {
            transform: scale(1.2) !important;
            box-shadow: 0 4px 15px rgba(0, 204, 204, 0.6);
        }

        /* Page title styling */
        .page-title {
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 24px;
            background: linear-gradient(to right, #00CCCC, #4facfe);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
            padding: 5px 0;
            position: relative;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(to right, #00CCCC, #4facfe);
            border-radius: 3px;
        }

        /* Doctor popup enhanced styles */
        .doctor-popup {
            transition: all 0.3s ease;
        }

        .doctor-popup img {
            border: 2px solid #00CCCC;
            box-shadow: 0 3px 8px rgba(0, 204, 204, 0.3);
        }

        .popup-specialty {
            display: inline-block;
            background-color: rgba(0, 204, 204, 0.1);
            color: #00CCCC;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 12px;
            margin: 5px 0;
        }

        .popup-fee {
            font-weight: 500;
        }

        .popup-view-profile {
            display: inline-block;
            background: linear-gradient(to right, #00CCCC, #4facfe);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            margin-top: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        }

        .popup-view-profile:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(0, 204, 204, 0.3);
        }

        /* Filter tags styling */
        .filter-tags {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .filter-tag {
            background: rgba(0, 204, 204, 0.1);
            border: 1px solid rgba(0, 204, 204, 0.2);
            color: #00CCCC;
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-tag:hover {
            background: rgba(0, 204, 204, 0.2);
        }

        .filter-tag .close {
            font-size: 16px;
            line-height: 1;
        }
    </style>
</head>

<body>
    <div class="flex min-h-screen">
        <!-- Sidebar - kept unchanged as requested -->
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
                <a href="{{route('patient.appointments')}}" class="sidebar-link">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    My Appointments
                </a>
                <a href="{{route('patient.favorites')}}" class="sidebar-link ">
                    <svg class="h-5 w-5 mr-3 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    My Favorites
                </a>
                <a href="{{ route('patient.explore') }}" class="sidebar-link">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                    </svg>
                    Explore Doctors
                </a>

                <a href="{{ route('patient.map') }}" class="sidebar-link active">
                    <svg class="h-5 w-5 mr-3 med-teal" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 22s8-4.5 8-13a8 8 0 10-16 0c0 8.5 8 13 8 13z" />
                    </svg>
                    Doctors Map
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

        <!-- Enhanced main content -->
        <div class="flex-1 p-8 animate-fade-in">
            <div class="max-w-7xl mx-auto">
                <h1 class="page-title">Find Doctors Near You</h1>

                <!-- Enhanced filters -->
                <div class="card p-6 mb-6 animate-fade-in-slow">
                    <div class="mb-4">
                        <h2 class="text-lg font-semibold text-white mb-3">Filter Options</h2>
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="search-container flex-1">
                                <input type="text" id="doctorSearch" placeholder="Search by doctor name..."
                                    class="w-full" />
                            </div>

                            <div class="search-container flex-1">
                                <select id="specialtyFilter" class="w-full appearance-none">
                                    <option value="">All specialties</option>
                                    @foreach (collect($doctors)->pluck('specialty')->unique() as $specialty)
                                        <option value="{{ strtolower($specialty) }}">{{ $specialty }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="price-slider flex-1">
                                <label for="priceRange" class="text-sm text-gray-300">Max Fee:</label>
                                <input type="range" id="priceRange" min="0" max="10000" step="100" value="10000" />
                                <span id="priceValue" class="price-value">10000 DZD</span>
                            </div>
                        </div>
                    </div>

                    <!-- Active filter tags -->
                    <div class="filter-tags" id="activeFilters">
                        <!-- Filter tags will be added here via JavaScript -->
                    </div>
                </div>

                <!-- Map container -->
                <div class="card p-5 mb-8 animate-fade-in-slow">
                    <div id="map" class="h-[500px] rounded-lg overflow-hidden shadow-lg"></div>

                    <div class="flex justify-between items-center mt-4 px-2">
                        <div class="flex items-center">
                            <div class="flex items-center mr-4">
                                <span class="inline-block w-3 h-3 rounded-full bg-blue-500 mr-2"></span>
                                <span class="text-sm text-gray-300">Available Doctors</span>
                            </div>
                            <div class="flex items-center">
                                <span class="inline-block w-3 h-3 rounded-full bg-red-500 mr-2"></span>
                                <span class="text-sm text-gray-300">Favorite Doctors</span>
                            </div>
                        </div>

                        <div class="text-sm text-gray-400" id="doctorCount">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize map with enhanced settings
    const map = L.map('map', {
        zoomControl: true,
        attributionControl: true
    }).setView([36.19, 5.41], 13);

    // Custom styled dark theme tile layer
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 19
    }).addTo(map);

    const doctors = @json($doctors);
    const favoriteDoctors = @json($favoriteDoctors);
    let markers = [];
    let activeFilters = {
        search: '',
        specialty: '',
        maxPrice: 10000,
        maxDistance: 0, // Default 0 means no distance filter
        userLocation: null // To store user's location
    };

    // Distance options for filter dropdown
    const distanceOptions = [
        { value: 0, label: 'Any distance' },
        { value: 1, label: '1 km' },
        { value: 2, label: '2 km' },
        { value: 5, label: '5 km' },
        { value: 10, label: '10 km' },
        { value: 25, label: '25 km' }
    ];

    // Add distance filter to HTML
    const distanceFilterHTML = `
        <div class="search-container flex-1">
            <select id="distanceFilter" class="w-full appearance-none">
                ${distanceOptions.map(option =>
                  `<option value="${option.value}">${option.label}</option>`).join('')}
            </select>
        </div>
    `;

    // Insert the distance filter after the specialty filter
    document.querySelector('#specialtyFilter').closest('.search-container').insertAdjacentHTML('afterend', distanceFilterHTML);

    // Enhanced Heart Icon for Favorites with glow effect
    const heartIcon = L.divIcon({
        html: `
            <div class="icon-container" style="filter: drop-shadow(0 0 5px rgba(255, 50, 50, 0.8));">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#ff3232" class="w-8 h-8" viewBox="0 0 24 24"
                     style="filter: drop-shadow(0 0 3px rgba(255, 50, 50, 0.5));">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                             2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09
                             C13.09 3.81 14.76 3 16.5 3
                             19.58 3 22 5.42 22 8.5
                             c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            </div>
        `,
        className: '',
        iconSize: [32, 32],
        iconAnchor: [16, 32],
    });

    // Enhanced Medical Icon with glow effect
    const medicalIcon = L.divIcon({
        html: `
            <div class="icon-container" style="filter: drop-shadow(0 0 5px rgba(0, 153, 255, 0.8));">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#00CCCC" class="w-8 h-8" viewBox="0 0 24 24"
                     style="filter: drop-shadow(0 0 3px rgba(0, 204, 204, 0.5));">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/>
                </svg>
            </div>
        `,
        className: '',
        iconSize: [32, 32],
        iconAnchor: [16, 32],
    });

    // User location marker
    let userLocationMarker = null;
    let userRadiusCircle = null;

    // Function to calculate distance between two coordinates
    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius of the earth in km
        const dLat = deg2rad(lat2-lat1);
        const dLon = deg2rad(lon2-lon1);
        const a =
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
            Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c; // Distance in km
    }

    function deg2rad(deg) {
        return deg * (Math.PI/180);
    }

    function clearMarkers() {
        markers.forEach(m => map.removeLayer(m));
        markers = [];
    }

    function addDoctorMarkers(filteredDoctors) {
        const positions = [];

        filteredDoctors.forEach(doctor => {
            if (doctor.latitude && doctor.longitude) {
                const position = [parseFloat(doctor.latitude), parseFloat(doctor.longitude)];
                const isFavorite = favoriteDoctors.includes(doctor.id);

                // Add distance to doctor info if user location is available
                let distanceInfo = '';
                if (activeFilters.userLocation) {
                    const distance = calculateDistance(
                        activeFilters.userLocation[0],
                        activeFilters.userLocation[1],
                        position[0],
                        position[1]
                    );
                    doctor.distance = distance;
                    distanceInfo = `<div class="popup-distance text-teal-400 mt-1">${distance.toFixed(2)} km from you</div>`;
                }

                // Create popup with distance and directions
                const popupContent = `
                    <div class="doctor-popup rounded-lg p-3">
                        <div class="flex items-start space-x-4">
                            <img src="/storage/${doctor.user.profile_picture || 'default-avatar.png'}" alt="${doctor.user.name}"
                                 class="w-16 h-16 rounded-full object-cover">
                            <div class="flex-1">
                                <strong class="text-lg font-bold text-white">${doctor.user.name}</strong>
                                <div class="popup-specialty">${doctor.specialty}</div>
                                <div class="popup-fee text-gray-300">Consultation: <span class="text-white">${doctor.fee} DZD</span></div>
                                ${distanceInfo}
                                <div class="flex mt-2 space-x-2">
                                    <a href="/patient/doctor/${doctor.user_id}" class="popup-view-profile">View Profile</a>
                                    ${activeFilters.userLocation ?
                                      `<a href="#" class="get-directions text-teal-400 text-sm" data-lat="${position[0]}" data-lng="${position[1]}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>Directions</a>` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                const marker = L.marker(position, {
                    icon: isFavorite ? heartIcon : medicalIcon
                }).bindPopup(popupContent, {
                    className: 'custom-popup',
                    maxWidth: 300,
                    minWidth: 250
                }).addTo(map);

                markers.push(marker);
                positions.push(position);

                // Add click event for directions
                marker.on('popupopen', function() {
                    const directionsBtn = document.querySelector('.get-directions');
                    if (directionsBtn) {
                        directionsBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            const destLat = this.getAttribute('data-lat');
                            const destLng = this.getAttribute('data-lng');

                            // Open in Google Maps
                            window.open(`https://www.google.com/maps/dir/?api=1&origin=${activeFilters.userLocation[0]},${activeFilters.userLocation[1]}&destination=${destLat},${destLng}`, '_blank');
                        });
                    }
                });
            }
        });

        // If we have positions, fit the map to include all markers
        if (positions.length > 0) {
            map.fitBounds(positions);
        } else {
            // If no doctors match filters, show a message
            const noResultsDiv = document.createElement('div');
            noResultsDiv.className = 'bg-gray-800 text-white p-4 rounded-lg';
            noResultsDiv.innerHTML = 'No doctors match your current filters.';
            map.getContainer().appendChild(noResultsDiv);
            setTimeout(() => {
                map.getContainer().removeChild(noResultsDiv);
            }, 3000);
        }

        // Update doctor count
        document.getElementById('doctorCount').textContent = `Showing ${filteredDoctors.length} doctors`;
    }

    // Initial marker setup
    addDoctorMarkers(doctors);

    // Add geolocation control with enhanced functionality
    const geolocateControl = L.control({ position: 'topleft' });
    geolocateControl.onAdd = function() {
        const div = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
        div.innerHTML = `
            <a href="#" title="Find my location" style="display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; background-color: #1E1E1E; border: 1px solid #444;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00CCCC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <circle cx="12" cy="12" r="1"></circle>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
            </a>
        `;
        div.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;

                        // Store user location for filtering
                        activeFilters.userLocation = [userLat, userLng];

                        // Remove previous user location marker if exists
                        if (userLocationMarker) {
                            map.removeLayer(userLocationMarker);
                        }
                        if (userRadiusCircle) {
                            map.removeLayer(userRadiusCircle);
                        }

                        // Add user location marker with pulsing effect
                        userLocationMarker = L.marker([userLat, userLng], {
                            icon: L.divIcon({
                                html: `
                                    <div class="icon-container" style="animation: pulse 1.5s infinite;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="#00CCCC">
                                            <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8zm0-14a6 6 0 1 0 6 6 6 6 0 0 0-6-6zm0 10a4 4 0 1 1 4-4 4 4 0 0 1-4 4z"/>
                                        </svg>
                                    </div>
                                `,
                                className: '',
                                iconSize: [32, 32],
                                iconAnchor: [16, 16],
                            })
                        }).addTo(map);

                        // Create a circle to show radius if distance filter is active
                        if (activeFilters.maxDistance > 0) {
                            userRadiusCircle = L.circle([userLat, userLng], {
                                color: 'rgba(0, 204, 204, 0.5)',
                                fillColor: 'rgba(0, 204, 204, 0.1)',
                                fillOpacity: 0.5,
                                radius: activeFilters.maxDistance * 1000 // Convert km to meters
                            }).addTo(map);
                        }

                        // Pan to user location
                        map.setView([userLat, userLng], 14);

                        // Show nearest doctors panel
                        showNearestDoctors(userLat, userLng);

                        // Reapply filters with distance
                        filterDoctors();

                        // Show toast notification
                        const toast = document.createElement('div');
                        toast.className = 'fixed bottom-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in';
                        toast.innerHTML = 'Location found! Showing nearest doctors.';
                        document.body.appendChild(toast);
                        setTimeout(() => {
                            document.body.removeChild(toast);
                        }, 3000);
                    },
                    function(error) {
                        console.error("Error getting location", error);
                        // Show error notification
                        const toast = document.createElement('div');
                        toast.className = 'fixed bottom-4 right-4 bg-red-800 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                        toast.innerHTML = 'Could not access your location. Please check your browser permissions.';
                        document.body.appendChild(toast);
                        setTimeout(() => {
                            document.body.removeChild(toast);
                        }, 3000);
                    }
                );
            }
            return false;
        };
        return div;
    };
    geolocateControl.addTo(map);

    // Create a panel for nearest doctors
    function showNearestDoctors(userLat, userLng) {
        // Calculate distances to all doctors
        let doctorsWithDistance = doctors.map(doctor => {
            if (doctor.latitude && doctor.longitude) {
                const distance = calculateDistance(
                    userLat, userLng,
                    parseFloat(doctor.latitude),
                    parseFloat(doctor.longitude)
                );
                return {
                    ...doctor,
                    distance: distance
                };
            }
            return null;
        }).filter(d => d !== null);

        // Sort by distance
        doctorsWithDistance.sort((a, b) => a.distance - b.distance);

        // Create or update nearest doctors panel
        let nearestPanel = document.getElementById('nearestDoctorsPanel');
        if (!nearestPanel) {
            nearestPanel = document.createElement('div');
            nearestPanel.id = 'nearestDoctorsPanel';
            nearestPanel.className = 'fixed top-4 right-4 bg-gray-800 text-white p-4 rounded-lg shadow-lg z-40 w-64 max-h-96 overflow-y-auto';
            document.body.appendChild(nearestPanel);
        }

        // Take 5 nearest doctors
        const nearestDoctors = doctorsWithDistance.slice(0, 5);

        let panelContent = `
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-semibold text-teal-400">Nearest Doctors</h3>
                <button id="closeNearestPanel" class="text-gray-400 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        `;

        if (nearestDoctors.length === 0) {
            panelContent += `<p class="text-gray-400 text-sm">No doctors found nearby.</p>`;
        } else {
            panelContent += `<div class="space-y-3">`;
            nearestDoctors.forEach(doctor => {
                panelContent += `
                    <div class="flex items-start space-x-2 p-2 hover:bg-gray-700 rounded transition-colors">
                        <img src="/storage/${doctor.user.profile_picture || 'default-avatar.png'}" alt="${doctor.user.name}"
                             class="w-10 h-10 rounded-full object-cover">
                        <div class="flex-1">
                            <div class="font-medium text-sm">${doctor.user.name}</div>
                            <div class="text-xs text-gray-400">${doctor.specialty}</div>
                            <div class="text-teal-400 text-xs">${doctor.distance.toFixed(2)} km</div>
                        </div>
                        <a href="#" class="view-on-map text-xs text-teal-400"
                           data-lat="${doctor.latitude}" data-lng="${doctor.longitude}">View</a>
                    </div>
                `;
            });
            panelContent += `</div>`;
        }

        nearestPanel.innerHTML = panelContent;

        // Add event listeners
        document.getElementById('closeNearestPanel').addEventListener('click', function() {
            nearestPanel.remove();
        });

        // Add click events for "View on map" links
        setTimeout(() => {
            document.querySelectorAll('.view-on-map').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const doctorLat = parseFloat(this.getAttribute('data-lat'));
                    const doctorLng = parseFloat(this.getAttribute('data-lng'));

                    // Pan to doctor location
                    map.setView([doctorLat, doctorLng], 16);

                    // Find and open the doctor's popup
                    markers.forEach(marker => {
                        const markerPos = marker.getLatLng();
                        if (markerPos.lat === doctorLat && markerPos.lng === doctorLng) {
                            marker.openPopup();
                        }
                    });
                });
            });
        }, 100);
    }

    // Filter functions
    function filterDoctors() {
        clearMarkers();

        const filtered = doctors.filter(doctor => {
            // Filter by name
            const nameMatch = doctor.user.name.toLowerCase().includes(activeFilters.search.toLowerCase());

            // Filter by specialty
            const specialtyMatch = activeFilters.specialty === '' ||
                                   doctor.specialty.toLowerCase() === activeFilters.specialty.toLowerCase();

            // Filter by price
            const priceMatch = parseFloat(doctor.fee) <= activeFilters.maxPrice;

            // Filter by distance (if user location is set and max distance is greater than 0)
            let distanceMatch = true;
            if (activeFilters.userLocation && activeFilters.maxDistance > 0 && doctor.latitude && doctor.longitude) {
                const distance = calculateDistance(
                    activeFilters.userLocation[0],
                    activeFilters.userLocation[1],
                    parseFloat(doctor.latitude),
                    parseFloat(doctor.longitude)
                );
                distanceMatch = distance <= activeFilters.maxDistance;
            }

            return nameMatch && specialtyMatch && priceMatch && distanceMatch;
        });

        addDoctorMarkers(filtered);

        // Update active filter tags UI
        updateFilterTags();

        // Update radius circle if user location is set
        if (activeFilters.userLocation && userLocationMarker) {
            // Remove previous circle if exists
            if (userRadiusCircle) {
                map.removeLayer(userRadiusCircle);
            }

            // Add new circle if distance filter is active
            if (activeFilters.maxDistance > 0) {
                userRadiusCircle = L.circle(activeFilters.userLocation, {
                    color: 'rgba(0, 204, 204, 0.5)',
                    fillColor: 'rgba(0, 204, 204, 0.1)',
                    fillOpacity: 0.5,
                    radius: activeFilters.maxDistance * 1000 // Convert km to meters
                }).addTo(map);
            }
        }
    }

    // Search input handler
    document.getElementById('doctorSearch').addEventListener('input', function(e) {
        activeFilters.search = e.target.value;
        filterDoctors();
    });

    // Specialty filter handler
    document.getElementById('specialtyFilter').addEventListener('change', function(e) {
        activeFilters.specialty = e.target.value;
        filterDoctors();
    });

    // Distance filter handler
    document.getElementById('distanceFilter').addEventListener('change', function(e) {
        activeFilters.maxDistance = parseInt(e.target.value);
        filterDoctors();

        // If user hasn't set location yet, prompt them
        if (activeFilters.maxDistance > 0 && !activeFilters.userLocation) {
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in';
            toast.innerHTML = 'Please click the location button to set your current position.';
            document.body.appendChild(toast);
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 3000);
        }
    });

    // Price range handler
    document.getElementById('priceRange').addEventListener('input', function(e) {
        activeFilters.maxPrice = parseInt(e.target.value);
        document.getElementById('priceValue').textContent = `${activeFilters.maxPrice} DZD`;
        filterDoctors();
    });

    // Function to update filter tags display
    function updateFilterTags() {
        const tagsContainer = document.getElementById('activeFilters');
        tagsContainer.innerHTML = '';

        // If we have a search term
        if (activeFilters.search) {
            const tag = document.createElement('div');
            tag.className = 'filter-tag';
            tag.innerHTML = `
                <span>Name: ${activeFilters.search}</span>
                <span class="close" data-filter="search">&times;</span>
            `;
            tagsContainer.appendChild(tag);
            tag.querySelector('.close').addEventListener('click', function() {
                activeFilters.search = '';
                document.getElementById('doctorSearch').value = '';
                filterDoctors();
            });
        }

        // If we have a specialty selected
        if (activeFilters.specialty) {
            const tag = document.createElement('div');
            tag.className = 'filter-tag';
            tag.innerHTML = `
                <span>Specialty: ${activeFilters.specialty}</span>
                <span class="close" data-filter="specialty">&times;</span>
            `;
            tagsContainer.appendChild(tag);
            tag.querySelector('.close').addEventListener('click', function() {
                activeFilters.specialty = '';
                document.getElementById('specialtyFilter').value = '';
                filterDoctors();
            });
        }

        // If distance filter is active
        if (activeFilters.maxDistance > 0) {
            const tag = document.createElement('div');
            tag.className = 'filter-tag';
            tag.innerHTML = `
                <span>Distance: ≤ ${activeFilters.maxDistance} km</span>
                <span class="close" data-filter="distance">&times;</span>
            `;
            tagsContainer.appendChild(tag);
            tag.querySelector('.close').addEventListener('click', function() {
                activeFilters.maxDistance = 0;
                document.getElementById('distanceFilter').value = '0';
                filterDoctors();
            });
        }

        // If price is less than maximum
        if (activeFilters.maxPrice < 10000) {
            const tag = document.createElement('div');
            tag.className = 'filter-tag';
            tag.innerHTML = `
                <span>Max Price: ${activeFilters.maxPrice} DZD</span>
                <span class="close" data-filter="price">&times;</span>
            `;
            tagsContainer.appendChild(tag);
            tag.querySelector('.close').addEventListener('click', function() {
                activeFilters.maxPrice = 10000;
                document.getElementById('priceRange').value = 10000;
                document.getElementById('priceValue').textContent = '10000 DZD';
                filterDoctors();
            });
        }
    }

    // Add keyboard support for ESC to clear all filters
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            // Clear all filters
            activeFilters.search = '';
            activeFilters.specialty = '';
            activeFilters.maxPrice = 10000;
            activeFilters.maxDistance = 0;

            // Reset UI
            document.getElementById('doctorSearch').value = '';
            document.getElementById('specialtyFilter').value = '';
            document.getElementById('distanceFilter').value = '0';
            document.getElementById('priceRange').value = 10000;
            document.getElementById('priceValue').textContent = '10000 DZD';

            // Apply filters
            filterDoctors();

            // Show notification
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in';
            toast.innerHTML = 'All filters cleared!';
            document.body.appendChild(toast);
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 2000);
        }
    });

    // Add CSS for the animations
    const styleElement = document.createElement('style');
    styleElement.textContent = `
        @keyframes pulse {
            0% {
                transform: scale(0.95);
                opacity: 0.7;
            }
            50% {
                transform: scale(1.05);
                opacity: 1;
            }
            100% {
                transform: scale(0.95);
                opacity: 0.7;
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    `;
    document.head.appendChild(styleElement);

    // Handle window resize to maintain map display
    window.addEventListener('resize', function() {
        map.invalidateSize();
    });
});

</script>
</body>
</html>
