<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class FavoriteController extends Controller
{


public function toggle($doctorId)
{
    $user = auth()->user();
    $doctor = Doctor::findOrFail($doctorId);

    $user->favoriteDoctors()->toggle($doctorId);

    return response()->json([
        'status' => 'success',
        'favorited' => $user->favoriteDoctors->contains($doctorId),
    ]);
}


}
