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

        .fs-13 {
            font-size: 13px;
        }

        .fs-11 {
            font-size: 11px;
        }

        .fw-bold {
            font-weight: bold;
        }

        .fw-200 {
            font-weight: 200;
        }

        .text-center {
            text-align: center;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .mt-0 {
            margin-top: 0;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-8 {
            margin-bottom: 8px;
        }

        .mb-2 {
            margin-bottom: 2px;
        }

        img {
            max-height: 50px;
        }
    </style>
</head>
<body>
    <h4 class="text-center mb-8 fw-bold">Kartu Pasien</h4>
    <hr class="mt-0">
    <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG("$data->id", 'QRCODE') }}" class="mb-10">
    <div class="fw-bold fs-13 mb-2">{{ $data->id }}</div>
    <div class="fw-200 fs-11 mb-2">{{ $data->name }}</div>
    <div class="fw-200 fs-11">{{ $data->address }}</div>
</body>
</html>
