<!DOCTYPE html>
<html>
<head>
    <title>QR Codes</title>
</head>
<body>
<p>Below are the QR codes for your order:</p>
@foreach($qrCodes as $qrCode)
    <img src="https://simdata5g.com/storage/{{ $qrCode }}" width="250px" alt="QR Code" style="margin: 0 auto;">
@endforeach
</body>
</html>
