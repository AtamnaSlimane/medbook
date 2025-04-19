<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'duration',
        'status',
        'notes'
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'duration' => 'integer'
    ];

    public static function statuses(): array
    {
        return ['pending', 'booked','completed', 'canceled','rejected'];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
public function scopeByDoctor($query, $doctorId)
{
    return $query->where('doctor_id', $doctorId);
}

public function scopeUpcoming($query)
{
    return $query->where('appointment_date', '>=', now())
        ->whereIn('status', ['pending', 'booked']);
}

}
