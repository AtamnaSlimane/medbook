<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'date_of_birth',
        'specialty',
        'fee',
        'latitude',
        'longitude',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
 public function appointmentsAsDoctor()
    {
        return $this->hasMany(Appointment::class); // Adjust the relationship if needed
    }
  public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
public function patients()
    {
        return $this->hasMany(Patient::class);
    }

public function reviews()
{
    return $this->hasMany(Review::class);
}

public function averageRating()
{
    return $this->reviews()->avg('rating');
}

public function reviewsCount()
{
    return $this->reviews()->count();
}



// Add these methods to your Patient model

/**
 * Get the doctors favorited by the patient.
 */
public function favoriteDoctors()
{
    return $this->belongsToMany(Doctor::class, 'favorites', 'patient_id', 'doctor_id')
                ->withTimestamps();
}
public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'doctor_favorites', 'doctor_id', 'user_id');
    }
public function getIsFavoritedAttribute()
{
    if (!auth()->check()) return false;
    return $this->favoritedBy->contains(auth()->user());
}
}
