<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->isPatient() ? $user->patient : $user->doctor;

        return view('profile-edit', compact('user', 'profile'));
    }

public function update(Request $request)
{
    $user = Auth::user();

    // Validate user data
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        'phone' => ['nullable', 'string', 'max:20'],
        //'current_password' => ['required_with:password', 'current_password'],
        'password' => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()],
        'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
    ]);

    // Handle current password verification if password is being updated
    if ($request->filled('password')) {
        $currentPasswordValid = Hash::check($request->current_password, $user->password);
        if (!$currentPasswordValid) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Hash new password
        $validated['password'] = Hash::make($validated['password']);
    } else {
        unset($validated['password']);
    }

    // Handle profile picture upload
    if ($request->hasFile('profile_picture')) {
        // Delete old profile picture if it exists
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }
        // Store new profile picture
        $path = $request->file('profile_picture')->store('profile-pictures', 'public');
        $validated['profile_picture'] = $path;
    }

    // Remove current_password before update
    unset($validated['current_password']);

    // Update user table data
    $user->update($validated);

    // Handle patient-specific data update
    if ($user->isPatient()) {
        $patientData = $request->only([
            'sex',
            'blood_type',
            'date_of_birth',
            'emergency_contact_name',
            'emergency_contact_phone',
            'medical_history',
        ]);

        // Update patient data in the patients table
        $user->patient()->updateOrCreate(
            ['user_id' => $user->id],
            $patientData
        );
    }

    // Handle doctor-specific data update
    if ($user->isDoctor()) {
        $doctorData = $request->only([
            'specialty',
            'date_of_birth',
            'fee',
            'latitude',
            'longitude',
        ]);

        // Update doctor data in the doctors table
        $user->doctor()->updateOrCreate(
            ['user_id' => $user->id],
            $doctorData
        );
    }

    return redirect()->route('profile.view')->with('success', 'Profile updated successfully!');
}

    public function index()
    {
  $user = Auth::user();
        $profile = $user->isPatient() ? $user->patient : $user->doctor;
if ($user->isPatient()) {
    return view('patient.profile', compact('user', 'profile'));
} else {
    return view('doctor.profile', compact('user', 'profile'));
}
    }

    public function showPatientProfile($patient_id)
    {
        $doctor = Auth::user();

        $patientUser = User::where('id', $patient_id)
            ->where('role', 'patient')
            ->firstOrFail();

        $appointmentExists = Appointment::where('doctor_id', $doctor->id)
            ->where('patient_id', $patient_id)
            ->exists();

        if (!$appointmentExists) {
            abort(403, 'Unauthorized action.');
        }

        $patientData = $patientUser->patient;

        return view('patient-profile', [
            'patient' => $patientUser,
            'profile' => $patientData
        ]);
    }
public function deleteAccount(Request $request)
{
    $request->validate([
        'password' => 'required|string',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->password, $user->password)) {
        return back()->withErrors(['password' => 'Incorrect password.']);
    }

    Auth::logout();
    $user->delete();

    return redirect('/')->with('message', 'Account deleted successfully.');
}
}
