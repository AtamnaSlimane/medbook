<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDBook - Sign Up</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #001a1a 0%, #003333 100%);
            min-height: 100vh;
        }
        .med-teal {
            color: #00CCCC;
        }
        .btn-teal {
            background-color: #00CCCC;
        }
        .role-selected {
            border: 2px solid #00CCCC;
            background-color: rgba(0, 204, 204, 0.1);
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #003333;
        }
        ::-webkit-scrollbar-thumb {
            background: #00CCCC;
            border-radius: 4px;
        }
    </style>
</head>
<body class="text-white antialiased">
    <div class="container mx-auto px-4 py-8">
        <!-- Animated Gradient Header -->
        <nav class="flex justify-between items-center py-6 animate-pulse">
            <div>
                <span class="med-teal text-2xl font-bold tracking-wider">MED</span>
                <span class="text-2xl font-bold text-white tracking-wider">Book</span>
            </div>
            <div class="space-x-4">
                <a href="{{ route('login') }}" class="text-white hover:text-[#00CCCC] transition-colors">
                    Login
                </a>
                <a href="#" class="text-white hover:text-[#00CCCC] transition-colors">
                    Help
                </a>
            </div>
        </nav>

        <!-- Main Content with Grid Layout -->
        <div class="grid md:grid-cols-2 gap-8 mt-8">
            <!-- Left Side - Form -->
            <div class="bg-gray-900 rounded-xl shadow-2xl p-8 transform transition-all hover:scale-[1.02]">
                <div class="mb-8">
                    <h1 class="text-4xl font-bold mb-2 text-transparent bg-clip-text bg-gradient-to-r from-[#00CCCC] to-white">
                        Create Your Account
                    </h1>
                    <p class="text-gray-400">Join MEDBook and manage your healthcare journey</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Error Handling with Animated Alert -->
                    @if($errors->any())
                    <div class="bg-red-900/50 border border-red-600 p-4 rounded-lg animate-shake">
                        <ul class="space-y-2">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Role Selection with Hover Effects -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-3">Choose Your Role</label>
                        <div class="grid grid-cols-2 gap-4" x-data="{ role: 'patient' }">
                            <!-- Patient Role -->
                            <label
                                class="p-4 border border-gray-700 rounded-lg flex items-center cursor-pointer transition-all duration-300 hover:border-[#00CCCC] hover:bg-gray-800"
                                :class="{'role-selected': role === 'patient'}"
                            >
                                <input
                                    type="radio"
                                    name="role"
                                    value="patient"
                                    x-model="role"
                                    class="hidden"
                                >
                                <svg class="h-6 w-6 med-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span class="ml-2 font-medium">Patient</span>
                            </label>

                            <!-- Doctor Role -->
                            <label
                                class="p-4 border border-gray-700 rounded-lg flex items-center cursor-pointer transition-all duration-300 hover:border-[#00CCCC] hover:bg-gray-800"
                                :class="{'role-selected': role === 'doctor'}"
                            >
                                <input
                                    type="radio"
                                    name="role"
                                    value="doctor"
                                    x-model="role"
                                    class="hidden"
                                >
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="ml-2 font-medium">Doctor</span>
                            </label>
                        </div>
                    </div>

                    <!-- Form Fields with Enhanced Styling -->
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium mb-2">Full Name</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white border border-gray-700 focus:ring-2 focus:ring-[#00CCCC] focus:border-transparent transition-all"
                                value="{{ old('name') }}"
                                required
                                autofocus
                            >
                        </div>

                        <!-- Similar styling for other input fields -->
                        <div>
                            <label for="email" class="block text-sm font-medium mb-2">Email Address</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white border border-gray-700 focus:ring-2 focus:ring-[#00CCCC] focus:border-transparent transition-all"
                                value="{{ old('email') }}"
                                required
                            >
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium mb-2">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white border border-gray-700 focus:ring-2 focus:ring-[#00CCCC] focus:border-transparent transition-all"
                                required
                            >
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium mb-2">Confirm Password</label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white border border-gray-700 focus:ring-2 focus:ring-[#00CCCC] focus:border-transparent transition-all"
                                required
                            >
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium mb-2">Phone Number</label>
                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                placeholder="+1234567890"
                                class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white border border-gray-700 focus:ring-2 focus:ring-[#00CCCC] focus:border-transparent transition-all"
                                value="{{ old('phone') }}"
                            >
                        </div>
                    </div>

                    <!-- Submit Button with Hover Effect -->
                    <button
                        type="submit"
                        class="w-full btn-teal py-3 px-4 rounded-lg text-white font-medium hover:bg-[#00b3b3] transition-colors duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-[#00CCCC] focus:ring-opacity-50"
                    >
                        Create Account
                    </button>
                </form>
            </div>

            <!-- Right Side - Image with Overlay -->
            <div class="hidden md:block relative overflow-hidden rounded-xl shadow-2xl">
                <img
                    src="/images/medical-gloves.jpg"
                    alt="Medical illustration"
                    class="absolute inset-0 w-full h-full object-cover opacity-70"
                >
                <div class="absolute inset-0 bg-gradient-to-r from-[#001a1a] to-transparent opacity-90"></div>
                <div class="relative z-10 p-8 flex flex-col justify-end h-full text-white">
                    <h2 class="text-3xl font-bold mb-4 text-[#00CCCC]">Welcome to MEDBook</h2>
                    <p class="text-lg mb-6">
                        A comprehensive healthcare platform connecting patients and doctors seamlessly.
                    </p>
                    <div class="flex space-x-4">
                        <div class="flex items-center space-x-2">
                            <svg class="h-6 w-6 text-[#00CCCC]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                            <span>Secure</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="h-6 w-6 text-[#00CCCC]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Convenient</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional: Alpine.js for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
```
