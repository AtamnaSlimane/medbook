<?php
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentAcceptedMail;
use App\Models\Appointment;
// Home route
Route::view('/', 'home')->name('home');
Route::view('/home', 'home')->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Common Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Profile
    Route::get('/profile/view', [ProfileController::class, 'index'])->name('profile.view');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'deleteAccount'])->name('profile.delete');
    // Patient Routes
    Route::middleware('role:patient')->group(function () {
        Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
        Route::resource('appointments', AppointmentController::class)->only(['create', 'store', 'destroy']);
        Route::post('/appointments/book', [PatientController::class, 'bookAppointment'])->name('appointments.book');
        Route::patch('/appointments/{appointment}/cancel', [PatientController::class, 'cancel'])->name('appointments.cancel');
        Route::get('/patient/doctor/{id}', [PatientController::class, 'showDoctorProfile'])->name('patient.doctor.profile');

        Route::get('/patient/appointments', [PatientController::class, 'appointments'])->name('patient.appointments');
    });

    // Doctor Routes
    Route::middleware('role:doctor')->group(function () {
        Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
        Route::patch('/doctor/appointments/{appointment}/accept', [DoctorController::class, 'accept'])->name('doctor.appointments.accept');
        Route::patch('/doctor/appointments/{appointment}/reject', [DoctorController::class, 'reject'])->name('doctor.appointments.reject');
        Route::post('/doctor/appointments/{appointment}/complete', [DoctorController::class, 'complete'])->name('doctor.appointments.complete');
        Route::patch('/doctor/appointments/{appointment}/status', [DoctorController::class, 'updateStatus'])->name('doctor.appointments.updateStatus');
        Route::get('/doctor/appointments', [DoctorController::class, 'appointments'])->name('doctor.appointments');
        Route::get('/doctor/patients', [DoctorController::class, 'patients'])->name('doctor.patients');
        Route::get('/doctor/schedule', [DoctorController::class, 'getAppointmentEvents'])->name('doctor.schedule');
        Route::get('/doctor/patient/{id}', [DoctorController::class, 'showPatientProfile'])->name('doctor.patient.profile');
// Update existing reject route to delete
Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])
     ->name('doctor.appointments.destroy');
    });

    // Appointment Actions (for both doctor and patient)
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::patch('/appointments/{appointment}/accept', [AppointmentController::class, 'accept'])->name('appointments.accept');
    Route::patch('/appointments/{appointment}/reject', [AppointmentController::class, 'reject'])->name('appointments.reject');
});

// Debugging Routes (Remove in production)
Route::get('/session-check', function() {
    return response()->json([
        'session_id' => session()->getId(),
        'auth_check' => auth()->check(),
        'user' => auth()->user()?->toArray()
    ]);
});

Route::get('/force-login/{id}', function($id) {
    auth()->loginUsingId($id);
    return redirect('/session-check');
});
Route::get('/test-mail', function () {
    Mail::to('atamnamohamedslimane@gmail.com')->send(new AppointmentAcceptedMail(
        'John Doe', 'Dr. Smith', '2025-04-23 15:00', 30
    ));
});
Route::get('/test-notification', function() {
    $appointment = Appointment::first();

    // Test patient notification
    try {
        $appointment->patient->notify(new \App\Notifications\AppointmentCreated($appointment));
        $appointment->doctor->notify(new \App\Notifications\AppointmentAccepted($appointment));
        return 'Notifications sent successfully!';
    } catch (\Exception $e) {
        \Log::error('Notification send error: ' . $e->getMessage());
        return 'Error: ' . $e->getMessage();
    }
});
Route::get('/notification/index', [NotificationController::class,'index']);
Route::get('/send-email', [EmailController::class, 'sendEmail']);

Route::get('/doctors/{doctor}/available-times', [PatientController::class, 'getAvailableTimes'])
    ->name('patient.doctors.availableTimes');


// Submit a review for a doctor
Route::post('/doctors/{doctor}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Show reviews for a specific doctor
Route::get('/doctors/{doctor}/reviews', [ReviewController::class, 'show'])->name('reviews.show');

// Update a review
Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');

// Delete a review
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
Route::get('/reviews/{doctorId}', 'App\Http\Controllers\ReviewController@index')->name('reviews.index');
Route::delete('/reviews/{doctorId}/{reviewId}', 'App\Http\Controllers\ReviewController@destroy')->name('reviews.destroy');

// Favorites Routes
Route::get('/patient/favorites', [FavoriteController::class,'favorites'])->name('patient.favorites');
Route::post('/patient/favorite/{doctor}', [FavoriteController::class, 'toggleFavorite'])->name('patient.toggleFavorite');
Route::match(['get', 'post'], '/patient/explore', [PatientController::class, 'explore'])->name('patient.explore');
Route::get('/test-success', function () {
    return redirect()->back()->with('success', 'Test success message!');
});
Route::get('/patient/map', [PatientController::class, 'mapview'])->name('patient.map');
