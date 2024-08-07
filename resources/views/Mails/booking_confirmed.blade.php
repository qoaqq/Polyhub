<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmed</title>
</head>
<body>
    <h1>Booking Confirmed</h1>
    <p>Thank you for your booking!</p>
    <p><strong>Bill Details:</strong></p>
    <p>User ID: {{ $bill->user_id }}</p>
    <p>Grand Total: {{ $bill->grand_total }}</p>
    <p><strong>Checkin Details:</strong></p>
    <p>Name: {{ $checkin->name }}</p>
    <p>Checkin Code: {!! DNS1D::getBarcodeHTML($checkin->checkin_code, 'C128') !!} </p>
</body>
</html>
