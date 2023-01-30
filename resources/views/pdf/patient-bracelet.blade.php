<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <style>
        body {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .mb-5 {
            margin-bottom: 5px;
        }

        img {
            max-height: 100%;
        }

        .rotate {
            position: fixed;
            bottom: 0;
            rotate: -90;
            text-align: center;
            height: 100%;
        }
    </style>
</head>
<body>
    <div class="rotate">
        <h5 class="text-center mb-5 fw-bold rotate">Gelang Pasien</h5>
        <hr>
        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG("$data->id", 'QRCODE') }}" class="mb-5 rotate">
    </div>
</body>
</html>
