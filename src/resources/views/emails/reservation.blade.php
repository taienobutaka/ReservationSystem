<!DOCTYPE html>
<html>
<head>
    <title>Reservation Confirmation</title>
</head>
<body>
    <h1>Reservation Confirmation</h1>
    <p>Thank you for your reservation.</p>
    <p>Reservation Date: {{ $reservation->start_at }}</p>
    <p>Number of Users: {{ $reservation->num_of_users }}</p>
    <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
</body>
</html>