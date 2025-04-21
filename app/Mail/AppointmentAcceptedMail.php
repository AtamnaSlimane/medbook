<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $patientName,
        public string $doctorName,
        public string $appointmentDate,
        public int $duration
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Appointment Has Been Accepted!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-accepted',
            with: [
                'patientName' => $this->patientName,
                'doctorName' => $this->doctorName,
                'appointmentDate' => $this->appointmentDate,
                'duration' => $this->duration,
            ]
        );
    }
}
