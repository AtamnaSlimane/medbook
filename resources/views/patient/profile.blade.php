<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDBook - My Profile</title>
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
        .profile-pic-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 204, 204, 0.7);
            overflow: hidden;
            width: 100%;
            height: 0;
            transition: .5s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .profile-pic-wrapper:hover .profile-pic-overlay {
            height: 100%;
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
                    <a href="{{ route('profile.view') }}" class="sidebar-link active">
                    <svg class="h-5 w-5 mr-3 med-teal" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold">My Profile</h1>
                        <p class="text-gray-400 mt-1">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-500 bg-opacity-20 border border-green-500 text-green-400 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-500 bg-opacity-20 border border-red-500 text-red-400 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>There are some errors with your submission</span>
                    </div>
                    <ul class="list-disc list-inside mt-2 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Profile Form -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Left Column - Profile Picture -->
                    <div class="lg:w-1/3">
                        <div class="card p-6">
                            <div class="flex flex-col items-center">
                                <div class="profile-pic-wrapper mb-6">
                                    @if($user->profile_picture)
                                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="profile-pic">
                                    @else
                                        <div class="profile-pic flex items-center justify-center bg-gray-700 text-white text-5xl font-bold">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                    @endif
                                    <div class="profile-pic-overlay">
                                        <label for="profile_picture" class="cursor-pointer text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="text-sm">Change Photo</span>
                                        </label>
                                    </div>
                                </div>
                                <input type="file" id="profile_picture" name="profile_picture" class="hidden" accept="image/*">
                                <h3 class="text-lg font-semibold">{{ $user->name }}</h3>
                                <p class="text-gray-400">{{ $user->email }}</p>

                                <div class="w-full mt-6">
                                    <div class="section-title">Account Status</div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-gray-400">Member since</span>
                                        <span>{{ $user->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-gray-400">Last updated</span>
                                        <span>{{ $user->updated_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-gray-400">Account type</span>
                                        <span class="px-3 py-1 rounded-full bg-teal-900 bg-opacity-30 text-teal-400 text-xs">
                                            {{ $user->isPatient() ? 'Patient' : 'Doctor' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-8 w-full">
                                    <div class="section-title">Delete Account</div>
                                    <p class="text-gray-400 text-sm mb-4">
                                        Once you delete your account, there is no going back. Please be certain.
                                    </p>
                                    <button type="button" id="deleteAccountBtn" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg text-sm font-medium transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete Account
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Profile Tabs -->
                    <div class="lg:w-2/3">
                        <div class="mb-6">
                            <div class="flex">
                                <button type="button" class="tab-button active" data-tab="personal">Personal Information</button>
                                <button type="button" class="tab-button" data-tab="security">Security</button>
                                @if($user->isPatient())
                                <button type="button" class="tab-button" data-tab="medical">Medical Information</button>
                                @endif
                            </div>

                            <!-- Personal Information Tab -->
                            <div class="tab-content active" id="personal-tab">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name" class="block text-gray-400 mb-2">Full Name</label>
                                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2 rounded-lg input-field">
                                    </div>
                                    <div>
                                        <label for="email" class="block text-gray-400 mb-2">Email Address</label>
                                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2 rounded-lg input-field">
                                    </div>
                                    <div>
                                        <label for="phone" class="block text-gray-400 mb-2">Phone Number</label>
                                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-2 rounded-lg input-field">
                                    </div>
                                    @if($user->isPatient())
                                    <div>
                                        <label for="date_of_birth" class="block text-gray-400 mb-2">Date of Birth</label>

<input
    type="date"
    id="date_of_birth"
    name="date_of_birth"
    value="{{ old('date_of_birth', \Carbon\Carbon::parse($profile->date_of_birth)->format('Y-m-d')) }}"
    class="w-full px-4 py-2 rounded-lg input-field" />
                                    </div>
                                    <div>
                                        <label for="sex" class="block text-gray-400 mb-2">Sex</label>
                                        <select id="sex" name="sex" class="w-full px-4 py-2 rounded-lg input-field">
                                            <option value="">Select</option>
                                            <option value="male" {{ old('sex', $profile->sex) == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('sex', $profile->sex) == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('sex', $profile->sex) == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Security Tab -->
                            <div class="tab-content" id="security-tab">
                                <div class="mb-6">
                                    <div class="section-title">Change Password</div>
                                    <p class="text-gray-400 text-sm mb-4">
                                        To change your password, please enter your current password first.
                                    </p>
                                </div>
                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <label for="current_password" class="block text-gray-400 mb-2">Current Password</label>
                                        <input type="password" id="current_password" name="current_password" class="w-full px-4 py-2 rounded-lg input-field">
                                        @error('current_password')
                                            <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="password" class="block text-gray-400 mb-2">New Password</label>
                                        <input type="password" id="password" name="password" class="w-full px-4 py-2 rounded-lg input-field">
                                        @error('password')
                                            <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="password_confirmation" class="block text-gray-400 mb-2">Confirm New Password</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2 rounded-lg input-field">
                                    </div>
                                </div>
                            </div>

                            <!-- Medical Information Tab (Patients Only) -->
                            @if($user->isPatient())
                            <div class="tab-content" id="medical-tab">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="blood_type" class="block text-gray-400 mb-2">Blood Type</label>
                                        <select id="blood_type" name="blood_type" class="w-full px-4 py-2 rounded-lg input-field">
                                            <option value="">Select</option>
                                            <option value="A+" {{ old('blood_type', $profile->blood_type) == 'A+' ? 'selected' : '' }}>A+</option>
                                            <option value="A-" {{ old('blood_type', $profile->blood_type) == 'A-' ? 'selected' : '' }}>A-</option>
                                            <option value="B+" {{ old('blood_type', $profile->blood_type) == 'B+' ? 'selected' : '' }}>B+</option>
                                            <option value="B-" {{ old('blood_type', $profile->blood_type) == 'B-' ? 'selected' : '' }}>B-</option>
                                            <option value="AB+" {{ old('blood_type', $profile->blood_type) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                            <option value="AB-" {{ old('blood_type', $profile->blood_type) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                            <option value="O+" {{ old('blood_type', $profile->blood_type) == 'O+' ? 'selected' : '' }}>O+</option>
                                            <option value="O-" {{ old('blood_type', $profile->blood_type) == 'O-' ? 'selected' : '' }}>O-</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="emergency_contact_name" class="block text-gray-400 mb-2">Emergency Contact Name</label>
                                        <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name', $profile->emergency_contact_name) }}" class="w-full px-4 py-2 rounded-lg input-field">
                                    </div>
                                    <div>
                                        <label for="emergency_contact_phone" class="block text-gray-400 mb-2">Emergency Contact Phone</label>
                                        <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $profile->emergency_contact_phone) }}" class="w-full px-4 py-2 rounded-lg input-field">
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <label for="medical_history" class="block text-gray-400 mb-2">Medical History</label>
                                    <textarea id="medical_history" name="medical_history" rows="6" class="w-full px-4 py-2 rounded-lg input-field">{{ old('medical_history', $profile->medical_history) }}</textarea>
                                    <p class="text-gray-500 text-xs mt-2">Include any chronic conditions, allergies, or significant medical history that doctors should know about.</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="flex justify-end gap-4 mt-6">
                            <a href="{{ route('patient.dashboard') }}" class="px-6 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 text-white transition-colors">Cancel</a>
                            <button type="submit" class="px-6 py-2 rounded-lg btn-teal">Save Changes</button>
                        </div>
                    </div>
                </div>
            </form>

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

    <!-- Delete Account Modal -->
    <div id="deleteAccountModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-gray-800 p-6 rounded-lg max-w-md w-full">
            <h3 class="text-xl font-bold text-red-500 mb-4">Delete Account</h3>
            <p class="text-gray-300 mb-6">Are you sure you want to delete your account? This action cannot be undone, and all your data will be permanently removed.</p>
            <form action="{{ route('profile.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="mb-4">
                    <label for="confirmation" class="block text-gray-400 mb-2">Type "DELETE" to confirm</label>
                    <input type="text" id="confirmation" name="confirmation" class="w-full px-4 py-2 rounded-lg input-field" required>
                </div>
                <div class="flex justify-end gap-4">
                    <button type="button" id="cancelDeleteBtn" class="px-6 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 text-white transition-colors">Cancel</button>
                    <button type="submit" id="confirmDeleteBtn" class="px-6 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white transition-colors" disabled>Delete Permanently</button>
                </div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab Switching
        const tabButtons = document.querySelectorAll('[data-tab]');
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabId = button.getAttribute('data-tab');

                // Remove active class from all buttons and tabs
                tabButtons.forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(tab => {
                    tab.classList.remove('active');
                });

                // Add active class to clicked button and corresponding tab
                button.classList.add('active');
                document.getElementById(`${tabId}-tab`).classList.add('active');
            });
        });

        // Delete Account Modal
        const deleteAccountBtn = document.getElementById('deleteAccountBtn');
        const deleteAccountModal = document.getElementById('deleteAccountModal');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const confirmationInput = document.getElementById('confirmation');

        deleteAccountBtn.addEventListener('click', () => {
            deleteAccountModal.classList.remove('hidden');
        });

        cancelDeleteBtn.addEventListener('click', () => {
            deleteAccountModal.classList.add('hidden');
            confirmationInput.value = '';
            confirmDeleteBtn.disabled = true;
        });

        confirmationInput.addEventListener('input', (e) => {
            confirmDeleteBtn.disabled = e.target.value.toUpperCase() !== 'DELETE';
        });

        // Close modal when clicking outside
        window.addEventListener('click', (e) => {
            if (e.target === deleteAccountModal) {
                deleteAccountModal.classList.add('hidden');
                confirmationInput.value = '';
                confirmDeleteBtn.disabled = true;
            }
        });

        // Profile Picture Preview
        const profilePicInput = document.getElementById('profile_picture');
        const profilePic = document.querySelector('.profile-pic');
        const profilePicInitials = document.querySelector('.profile-pic-wrapper .profile-pic:not(img)');

        profilePicInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (profilePicInitials) {
                        profilePicInitials.remove();
                    }
                    if (profilePic) {
                        profilePic.src = e.target.result;
                    } else {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('profile-pic');
                        document.querySelector('.profile-pic-wrapper').prepend(img);
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
