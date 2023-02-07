<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $title }}</title>
    <style>
        @page {
            margin: 5px;
        }
    </style>
</head>
<body>
    <div style="font-size:15px; text-align:center;">Gelang Pasien</div>
    <hr style="margin: 10px 0 10px 0;">
    <center>
        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG("$data->id", 'QRCODE') }}" style="max-width:100px;">
    </center>
</body>
</html>
