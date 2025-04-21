<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Appointment Rejected</title>
</head>
<body>
    <h2>Hello {{ $patientName }},</h2>
    <p>We're sorry to inform you that your appointment with Dr. {{ $doctorName }} on <strong>{{ $appointmentDate }}</strong> has been <strong>rejected</strong>.</p>
    <p>You can try booking with another doctor or reschedule at a different time.</p>

    <br>
    <p>— Medical Appointment Team</p>
</body>
</html>
