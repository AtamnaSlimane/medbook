<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
public function showLoginForm()
    {
        return view('auth.login');
    }
public function login(Request $request)
{

    $this->validateLogin($request);

    if ($this->attemptLogin($request)) {
       $user = Auth::user(); // Get the authenticated user
        $user->update(['last_login' => now()]); // Update last login time
        return $this->sendLoginResponse($request);
    }

    return $this->sendFailedLoginResponse($request);
}

protected function redirectTo()
{
    return match(auth()->user()->role) {
        'doctor' => route('doctor.dashboard'),
        'patient' => route('patient.dashboard'),
        'admin' => route('admin.dashboard'),
        default => '/home'
    };
}
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {

 \Log::debug('Authentication Debug', [
        'user_id' => $user->id,
        'session_id' => session()->getId(),
        'session_data' => session()->all()
    ]);
        if ($user->role === 'doctor') {
            return redirect()->route('doctor.dashboard');
        }

        return redirect()->route('patient.dashboard');
    }
public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/home'); // Redirect to home
}

}
