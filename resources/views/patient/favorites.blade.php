<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDBook - My Appointments</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
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
                <a href="{{route('patient.appointments')}}" class="sidebar-link ">
                    <svg class="h-5 w-5 mr-3 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    My Appointments
                </a>
                <a href="{{route('patient.favorites')}}" class="sidebar-link active">
                    <svg class="h-5 w-5 mr-3 med-teal" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

<a href="{{ route('patient.map') }}" class="sidebar-link ">
    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

<div class="container mx-auto mt-12 px-4">
    <h1 class="text-4xl font-bold text-white mb-10 animate-fade-in">My Favorite Doctors</h1>

    @if($favoriteDoctors->isEmpty())
        <div class="text-center text-gray-400 text-lg mt-10 animate-fade-in-slow">
            You haven't favorited any doctors yet. Explore and bookmark your favorites!
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 animate-fade-in-slow">
            @foreach($favoriteDoctors as $doctor)
                <div class="doctor-card p-6 transform transition-transform hover:scale-105 duration-300 ease-in-out">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center space-x-4">
                            <div class="h-16 w-16 rounded-full bg-gray-700 overflow-hidden flex items-center justify-center">
                                @if($doctor->profile_picture)
                                    <img src="{{ asset('storage/' . $doctor->profile_picture) }}" alt="{{ $doctor->name }}" class="object-cover h-full w-full">
                                @else
                                    <span class="text-white font-bold text-xl">
                                        {{ strtoupper(substr($doctor->name, 0, 2)) }}
                                    </span>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('patient.doctor.profile', $doctor->id) }}" class="text-teal-400 font-semibold text-lg hover:underline">
                                    Dr. {{ $doctor->name }}
                                </a>
                                @if($doctor->doctorProfile && $doctor->doctorProfile->specialty)
                                    <p class="text-gray-400 text-sm mt-1">
                                        {{ $doctor->doctorProfile->specialty }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <form action="{{ route('patient.toggleFavorite', $doctor->id) }}" method="POST">
                            @csrf
                            <button type="submit" title="Remove from Favorites" class="remove-btn hover:bg-red-600">
                                <i class="fas fa-trash-alt text-white"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

    </html>
