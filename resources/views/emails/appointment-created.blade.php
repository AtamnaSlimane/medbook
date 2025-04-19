@component('mail::message')
# New Appointment Created

Hello {{ $user->name }},

A new appointment has been scheduled:

**Patient:** {{ $appointment->patient->name }}
**Doctor:** {{ $appointment->doctor->name }}
**Date:** {{ $appointment->appointment_date->format('l, F jS Y \a\t g:i A') }}
**Duration:** {{ $appointment->duration }} minutes

@component('mail::button', ['url' => route('login')])
View Appointment
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
