<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Appointment Request</title>
</head>
<body>
    <h2>Hello Dr. {{ $doctorName }},</h2>
    <p>You have a new appointment request from <strong>{{ $patientName }}</strong>.</p>
    <p><strong>Date:</strong> {{ $appointmentDate }}</p>
    <p><strong>Duration:</strong> {{ $duration }} minutes</p>
    <p>Please log in to your dashboard to accept or reject the request.</p>

    <br>
    <p>— Medical Appointment Team</p>
</body>
</html>
