<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - MEDBook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('profile-picture-preview');
                output.src = reader.result;
                output.classList.remove('hidden');
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</head>
<body class="bg-blue-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 p-6 text-center relative">
            <h1 class="text-3xl font-bold text-white">Edit Profile</h1>
            <p class="text-blue-200">Update your personal and professional information</p>
        </div>

        <!-- Edit Form -->
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-8">
            @csrf
            @method('PUT')

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <!-- Profile Picture -->
                    <div class="mb-6 text-center">
                        <div class="relative inline-block">
                            <img id="profile-picture-preview"
                                 src="{{ $user->profile_picture ? asset('storage/'.$user->profile_picture) : asset('images/default-profile.png') }}"
                                 class="w-32 h-32 rounded-full border-4 border-white shadow-lg mb-4">
                            <label class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full cursor-pointer shadow-md hover:bg-blue-700">
                                <input type="file" name="profile_picture" class="hidden" onchange="previewImage(event)">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </label>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="text-blue-600 font-semibold mb-4">Personal Information</h3>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('email')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Phone Number</label>
                                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('phone')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Security -->
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <h3 class="text-yellow-600 font-semibold mb-4">Security</h3>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Current Password</label>
                                <input type="password" name="current_password"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500" required>
                                @error('current_password')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label class="block text-sm text-gray-600 mb-1">New Password</label>
                                <input type="password" name="password"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                @error('password')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Confirm New Password</label>
                                <input type="password" name="password_confirmation"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4">
                    @if($user->isPatient())
                    <!-- Patient Medical Information -->
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="text-green-600 font-semibold mb-4">Medical Details</h3>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Sex</label>
                                <select name="sex" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('sex', $profile->sex) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('sex', $profile->sex) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('sex', $profile->sex) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('sex')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Blood Type</label>
                                <select name="blood_type" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="">Select Blood Type</option>
                                    <option value="A+" {{ old('blood_type', $profile->blood_type) == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ old('blood_type', $profile->blood_type) == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ old('blood_type', $profile->blood_type) == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ old('blood_type', $profile->blood_type) == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="AB+" {{ old('blood_type', $profile->blood_type) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ old('blood_type', $profile->blood_type) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                    <option value="O+" {{ old('blood_type', $profile->blood_type) == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ old('blood_type', $profile->blood_type) == 'O-' ? 'selected' : '' }}>O-</option>
                                </select>
                                @error('blood_type')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Date of Birth</label>
                                <input type="date" name="date_of_birth"
                                    value="{{ old('date_of_birth', optional($profile->date_of_birth)->format('Y-m-d')) }}"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                @error('date_of_birth')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="bg-red-50 p-4 rounded-lg">
                        <h3 class="text-red-600 font-semibold mb-4">Emergency Contact</h3>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Contact Name</label>
                                <input type="text" name="emergency_contact_name"
                                    value="{{ old('emergency_contact_name', $profile->emergency_contact_name) }}"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                @error('emergency_contact_name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Contact Phone</label>
                                <input type="tel" name="emergency_contact_phone"
                                    value="{{ old('emergency_contact_phone', $profile->emergency_contact_phone) }}"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                @error('emergency_contact_phone')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Medical History -->
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <h3 class="text-purple-600 font-semibold mb-4">Medical History</h3>
                        <textarea name="medical_history" rows="4"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                            placeholder="Describe your medical history...">{{ old('medical_history', $profile->medical_history) }}</textarea>
                        @error('medical_history')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                    @elseif($user->isDoctor())
                    <!-- Doctor Professional Information -->
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="text-green-600 font-semibold mb-4">Professional Details</h3>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Specialty</label>
                                <input type="text" name="specialty"
                                    value="{{ old('specialty', $profile?->specialty ?? '') }}"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                @error('specialty')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Consultation Fee (DZD)</label>
                                <input type="number" name="fee" step="0.01"
                                    value="{{ $profile?->fee ? '$' . number_format($profile->fee, 2) : 'N/A' }}"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                @error('fee')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>
 </div>
                    </div>

                    <!-- Doctor Availability -->

                    @endif
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex flex-col sm:flex-row justify-end gap-4 border-t pt-6">
                <a href="{{ route('profile.view') }}"
                   class="px-6 py-2 text-gray-600 hover:text-gray-800 font-semibold transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full font-semibold transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</body>
</html>
