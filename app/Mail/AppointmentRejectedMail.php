<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class AppointmentRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $patientName,
        public string $doctorName,
        public string $appointmentDate
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Request Rejected',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-rejected',
            with: [
                'patientName' => $this->patientName,
                'doctorName' => $this->doctorName,
                'appointmentDate' => $this->appointmentDate,
            ]
        );
    }
}
