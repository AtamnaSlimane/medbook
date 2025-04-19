<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDBook - Health is Wealth</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #001a1a 0%, #003333 100%);
            min-height: 100vh;
        }
        .med-teal { color: #00CCCC; }
        .btn-teal {
            background-color: #00CCCC;
            transition: background 0.3s;
            padding: 10px 24px;
            border-radius: 8px;
        }
        .btn-teal:hover { background-color: #009999; }
        .highlight-teal {
            background-color: #00CCCC;
            display: inline-block;
            padding: 0 8px;
        }

    </style>
</head>
<body class="text-white">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header -->
        <nav class="flex flex-wrap justify-between items-center py-6">
            <div>
                <span class="med-teal text-2xl font-bold">MED</span><span class="text-2xl font-bold text-white">Book</span>
            </div>
            <div>
        @guest
            <!-- Show these only if the user is NOT logged in -->
            <a href="{{ route('register') }}" class="btn-teal text-white font-medium py-2 px-6 rounded-lg">Sign up</a>
            <a href="{{ route('login') }}" class="text-white ml-4">Login</a>
        @endguest

        @auth
            <!-- Show this only if the user IS logged in -->
           @if(Auth::user()->role === 'doctor')
           <a href="{{ route('doctor.dashboard') }}" class="btn-teal text-white font-medium py-2 px-6 rounded-lg">Dashboard</a>
           @elseif(Auth::user()->role === 'patient')
           <a href="{{ route('patient.dashboard') }}" class="btn-teal text-white font-medium py-2 px-6 rounded-lg">Dashboard</a>
           @endif
           <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-white ml-4">Logout</button>
            </form>
            <form method="GET" action="{{ route('profile.view') }}" class="inline">
                @csrf
                <button type="submit" class="text-white ml-4">profile</button>
            </form>

        @endauth
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <h1 class="text-6xl font-bold mb-12">Health is <span class="highlight-teal">Wealth</span></h1>

            <div class="max-w-3xl mx-auto mb-12">
                <h2 class="text-3xl font-bold mb-4">Finding the right doctor has never been Easier</h2>
                <p class="text-xl">Skip the long waits and book your appointments in just a few clicks</p>
            </div>

            <div class="mb-16">
                <h3 class="text-2xl mb-8">Get quality healthcare on your schedule, <span class="med-teal">Anytime</span>, <span class="med-teal">Anywhere</span>!</h3>
                <a href="{{ route('register') }}" class="btn-teal text-white font-medium inline-flex items-center">
                    Make Appointment
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Footer -->
        <footer class="py-8 mt-12">
            <div class="flex justify-between items-center">
                <div>
                    <span class="med-teal text-2xl font-bold">MED</span><span class="text-2xl font-bold text-white">Book</span>
                </div>
                <div>
                    <a href="#" class="text-white mx-3">Contact</a>
                    <a href="#" class="text-white mx-3">About Us</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>

