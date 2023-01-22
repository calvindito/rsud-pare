<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <style>
        .fs-10 {
            font-size: 10px;
        }

        .fw-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .mb-10 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h4 class="text-center mb-10 fw-bold">Kartu Pasien</h4>
    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($data->id, 'C39+') }}" height="50" width="100%" class="mb-10">
    <table>
        <tr>
            <td class="fs-10">No RM</td>
            <td class="fs-10">:</td>
            <td class="fs-10 fw-bold">{{ $data->id }}</td>
        </tr>
        <tr>
            <td class="fs-10">Nama</td>
            <td class="fs-10">:</td>
            <td class="fs-10">{{ $data->name }}</td>
        </tr>
        <tr>
            <td class="fs-10">Alamat</td>
            <td class="fs-10">:</td>
            <td class="fs-10">
                @if(isset($data->district) && isset($data->village))
                    {{ $data->district->name . ' ' . $data->village }}
                @elseif(isset($data->district))
                    {{ $data->district->name }}
                @elseif(isset($data->village))
                    {{ $data->village }}
                @else
                    -
                @endif
            </td>
        </tr>
    </table>
</body>
</html>
