<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class AppointmentCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $doctorName,
        public string $patientName,
        public string $appointmentDate,
        public int $duration
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Appointment Request',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-created',
            with: [
                'doctorName' => $this->doctorName,
                'patientName' => $this->patientName,
                'appointmentDate' => $this->appointmentDate,
                'duration' => $this->duration,
            ]
        );
    }
}
