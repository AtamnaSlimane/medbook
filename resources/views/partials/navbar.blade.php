nav class="flex flex-wrap justify-between items-center py-6">
    <div>
        <span class="med-teal text-2xl font-bold">MED</span><span class="text-2xl font-bold text-white">Book</span>
    </div>

    <div>
        @if(Auth::check())
            <!-- Show logout button if user is logged in -->
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="btn-teal text-white font-medium py-2 px-6 rounded-lg">
                    Logout
                </button>
            </form>
        @else
            <!-- Show login and sign-up buttons if user is NOT logged in -->
            <a href="{{ route('login') }}" class="text-white mr-6">Login</a>
            <a href="{{ route('register') }}" class="btn-teal text-white font-medium py-2 px-6 rounded-lg">Sign up</a>
        @endif
    </div>
</nav>
