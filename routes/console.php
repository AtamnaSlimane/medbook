<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Carbon\Carbon;
use App\Models\Appointment;

// This command is just for fun/inspiration
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule a task
Schedule::call(function () {
    try {
        // Get only the booked appointments
        $appointments = Appointment::where('status', 'booked')->get();

        foreach ($appointments as $appointment) {
            // Check if the appointment is still booked, and if the time has passed
            if (
                $appointment->status === 'booked' &&
                Carbon::parse($appointment->appointment_date)->lt(now())
            ) {
                // Update the status to 'completed'
                $appointment->status = 'completed';
                $appointment->save();
            }
        }
    } catch (\Exception $e) {
        \Log::error("Appointment Check Error: " . $e->getMessage());
    }
})->everyMinute();
