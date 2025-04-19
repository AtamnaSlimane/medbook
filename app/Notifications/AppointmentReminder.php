<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\VonageMessage;
class AppointmentReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Appointment $appointment)
    {
    }

    public function via($notifiable)
    {
        return ['mail']; // Add 'vonage' for SMS
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Appointment Reminder')
            ->line('You have an upcoming appointment with Dr. '.$this->appointment->doctor->name)
            ->line('Date: '.$this->appointment->appointment_date->format('M j, Y H:i'))
            ->action('View Appointment', url('/dashboard'))
            ->line('Thank you for using our service!');
    }

    public function toVonage($notifiable)
    {
        return (new VonageMessage)
            ->content('Reminder: Appointment on '.$this->appointment->appointment_date->format('M j H:i'));
    }
}
