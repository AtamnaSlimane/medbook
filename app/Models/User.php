<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'profile_picture',
        'sex',
        'blood_type',
        'date_of_birth',
        'emergency_contact_name',
        'emergency_contact_phone',
        'last_login',
        'medical_history',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'profile_picture' => 'string',
        'date_of_birth' => 'date',
        'last_login' => 'datetime',
    ];

    public static function roles(): array
    {
        return ['patient', 'doctor', 'admin'];
    }

    public function appointmentsAsPatient(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function appointmentsAsDoctor(): HasMany
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
   public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    // Scope to easily query doctors
    public function scopeDoctors($query)
    {
        return $query->where('role', 'doctor');
    }
public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

public function doctor()
{
    return $this->hasOne(Doctor::class);
}

public function doctorProfile()
{
    return $this->hasOne(Doctor::class);
}
public function patient()
{
    return $this->hasOne(Patient::class);
}
// In User model
public function scopePatients($query)
{
    return $query->where('role', 'patient');
}

public function scopeAgeGroups($query)
{
    return $query->selectRaw('
        CASE
            WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 18 AND 30 THEN "18-30"
            WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 31 AND 45 THEN "31-45"
            WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 46 AND 60 THEN "46-60"
            ELSE "60+"
        END as age_group,
        COUNT(*) as count'
    )->groupBy('age_group');
}

public function favoriteDoctors()
{
    return $this->belongsToMany(Doctor::class, 'favorites', 'patient_id', 'doctor_id');
}

}
