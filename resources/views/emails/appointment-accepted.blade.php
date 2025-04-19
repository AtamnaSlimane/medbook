@component('mail::message')
# Appointment Accepted!

**Patient:** {{ $appointment->patient->name }}
**Date:** {{ $appointment->appointment_date->format('M j, Y H:i') }}
**Duration:** {{ $appointment->duration }} minutes

@component('mail::button', ['url' => route('appointments.show', $appointment)])
View Details
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

