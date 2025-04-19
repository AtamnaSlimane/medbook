<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDBook - Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        html {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        body {
            background: linear-gradient(135deg, #001a1a 0%, #003333 100%);
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        .med-teal {
            color: #00CCCC;
            transition: color 0.3s ease;
        }
        .btn-teal {
            background-color: #00CCCC;
            transition: box-shadow 0.5s cubic-bezier(0.25, 0.1, 0.25, 1);
        }
        .btn-teal:hover {
            box-shadow: 0 4px 10px rgba(0, 204, 204, 0.3);
        }
        .login-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: box-shadow 0.5s cubic-bezier(0.25, 0.1, 0.25, 1);
        }
        .login-card:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }
        .input-field {
            background-color: #333333;
            border-color: #666666;
            color: white;
            transition: all 0.3s ease;
        }
        .input-field:focus {
            border-color: #00CCCC;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 204, 204, 0.2);
        }
        .login-link {
            position: relative;
            display: inline-block;
        }
        .login-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 50%;
            background-color: #00CCCC;
            transition: width 0.3s ease, left 0.3s ease;
        }
        .login-link:hover::after {
            width: 100%;
            left: 0;
        }
        .logo-link {
            text-decoration: none;
        }
    </style>
</head>
<body class="text-white">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <nav class="flex justify-between items-center py-6">
            <div>
                <a href="{{ route('home') }}" class="logo-link">
                    <span class="med-teal text-2xl font-bold">MED</span><span class="text-2xl font-bold text-white">Book</span>
                </a>
            </div>
            <div>
                <a href="{{ route('register') }}" class="btn-teal text-white font-medium py-2 px-6 rounded-lg">Sign up</a>
                <a href="{{ route('login') }}" class="text-white ml-4 login-link">Login</a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="flex flex-col items-center justify-center py-24">
            <div class="w-full max-w-md login-card p-8 rounded-2xl">
                <h1 class="text-4xl font-bold mb-12 text-center">Welcome Back</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium mb-2">Email address</label>
                        <input type="email" id="email" name="email"
                               class="w-full px-4 py-3 rounded-lg input-field"
                               placeholder="Enter your email"
                               required>
                    </div>
                    <div class="mb-8">
                        <label for="password" class="block text-sm font-medium mb-2">Password</label>
                        <input type="password" id="password" name="password"
                               class="w-full px-4 py-3 rounded-lg input-field"
                               placeholder="Enter your password"
                               required>
                        <a href="#" class="text-sm med-teal block text-right mt-2">Forgot password?</a>
                    </div>
                    <button type="submit" class="w-full btn-teal py-3 px-4 rounded-lg text-white font-medium">
                        Login
                    </button>
                </form>
                <p class="text-center mt-8">
                    Don't have an account? <a href="{{ route('register') }}" class="med-teal">Sign up</a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="py-8 mt-12">
            <div class="flex justify-between items-center">
                <div>
                    <a href="{{ route('home') }}" class="logo-link">
                        <span class="med-teal text-2xl font-bold">MED</span><span class="text-2xl font-bold text-white">Book</span>
                    </a>
                </div>
                <div>
                    <a href="#" class="text-white mx-3">Contact</a>
                    <a href="#" class="text-white mx-3">About us</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>

