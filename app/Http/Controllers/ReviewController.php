<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
class ReviewController extends Controller
{
 public function index($doctorId)
    {
        $doctor = Doctor::findOrFail($doctorId);
        $reviews = $doctor->reviews;  // Fetch reviews related to the doctor

        return view('reviews.index', compact('doctor', 'reviews'));
    }

    // Store a new review for a doctor
    public function store(Request $request, $doctorId)
    {
        // Validate the request
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $doctor = Doctor::findOrFail($doctorId);
        $patient = Auth::user(); // Assuming the patient is authenticated

        // Check if the patient has already reviewed the doctor
        if ($doctor->reviews()->where('patient_id', $patient->id)->exists()) {
            return redirect()->route('reviews.index', $doctorId)
                             ->with('error', 'You have already reviewed this doctor.');
        }

        // Create the review
        $review = new Review([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'patient_id' => $patient->id,
        ]);

        // Attach the review to the doctor
        $doctor->reviews()->save($review);

        return redirect()->route('reviews.index', $doctorId)
                         ->with('success', 'Your review has been added successfully.');
    }

    // Optional: Delete a review (if needed)
    public function destroy($doctorId, $reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $doctor = Doctor::findOrFail($doctorId);

        // Ensure the authenticated patient is the one who created the review
        if ($review->patient_id !== Auth::id()) {
            return redirect()->route('reviews.index', $doctorId)
                             ->with('error', 'You are not authorized to delete this review.');
        }

        // Delete the review
        $review->delete();

        return redirect()->route('reviews.index', $doctorId)
                         ->with('success', 'Review deleted successfully.');
    }
}
