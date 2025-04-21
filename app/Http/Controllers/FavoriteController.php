<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class FavoriteController extends Controller
{

public function favorites()
{
$user = auth()->user();
    $patient = \App\Models\Patient::where('user_id', $user->id)->firstOrFail();

    $favoriteDoctors = $patient->favoriteDoctors()->with('doctorProfile')->get();

    return view('patient.favorites', [
        'favoriteDoctors' => $favoriteDoctors,
        'user'=>$user,
    ]);
}

public function toggleFavorite($doctorId, Request $request)
{
    // Get the authenticated user
    $patient = auth()->user()->patient;

    // Ensure that the patient exists (in case of a failed relationship)
    if (!$patient) {
        return redirect()->back()->with('error', 'Patient profile not found.');
    }

    // Ensure the doctor exists and has the "doctor" role
    $doctorUser = \App\Models\User::where('id', $doctorId)->where('role', 'doctor')->firstOrFail();
    $doctor = $doctorUser->doctorProfile;

    // Check if the doctor is already a favorite
    $favorite = $patient->favoriteDoctors()->where('doctor_id', $doctorId)->exists();

    // Toggle favorite (add/remove)
    if ($favorite) {
        // Remove from favorites
        $patient->favoriteDoctors()->detach($doctorId);
    } else {
        // Add to favorites
        $patient->favoriteDoctors()->attach($doctorId);
    }

    // Redirect back to the explore page
    return redirect()->back()->with('success', 'Favorite updated successfully.');
}
}
