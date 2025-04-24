<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>QR Code - {{ $library->name }}</title>
    <style>
        body { font-family: sans-serif; text-align: center; margin-top: 50px; }
        .qr-container { margin: 20px auto; width: 200px; }
    </style>
</head>
<body>
<h2>{{ $library->name }}</h2>
<p>Scan untuk absen pustakawan:</p>
<div class="qr-container">
    {!! $qrSvg !!}
</div>
</body>
</html>
