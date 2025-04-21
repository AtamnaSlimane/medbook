<!DOCTYPE html>
<html>
<head>
    <title>Appointment Accepted</title>
</head>
<body>
    <p>Hi {{ $patientName }},</p>
    <p>Your appointment with Dr. {{ $doctorName }} has been accepted and confirmed.</p>
    <p>Appointment Date: {{ $appointmentDate }}</p>
    <p>Duration: {{ $duration }} minutes</p>
</body>
</html>
