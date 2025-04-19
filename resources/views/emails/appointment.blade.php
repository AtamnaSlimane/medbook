<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
</head>
<body>
    <h2>Hello {{ $appointment['patient_name'] }},</h2>
    <p>Your appointment with Dr. {{ $appointment['doctor_name'] }} has been confirmed.</p>
    <p><strong>Date:</strong> {{ $appointment['date'] }}</p>
    <p><strong>Time:</strong> {{ $appointment['time'] }}</p>
    <p>Thank you for using MEDBook!</p>
</body>
</html>
