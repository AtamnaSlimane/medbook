<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Patient extends Model
{
     protected $fillable = [
        'user_id',
        'sex',
        'blood_type',
        'date_of_birth',
        'emergency_contact_name',
        'emergency_contact_phone',
        'medical_history',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
 public function appointmentsAsPatient()
    {
        return $this->hasMany(Appointment::class); // Adjust the relationship if needed
    }
  public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

public function reviews()
{
    return $this->hasMany(Review::class);
}
public function favoriteDoctors()
{
    return $this->belongsToMany(User::class, 'favorites', 'patient_id', 'doctor_id')
                ->where('role', 'doctor');
}
}
