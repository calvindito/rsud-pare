<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <style>
        .fs-9 {
            font-size: 9px;
        }

        .fw-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .mb-5 {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <h5 class="text-center mb-5 fw-bold">E-Tiket Pasien</h5>
    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($data->id, 'C39+') }}" height="30" width="100%" class="mb-5">
    <table width="100%">
        <tr>
            <td class="fs-9 fw-bold text-center" colspan="3">{{ $data->name }}</td>
        </tr>
        <tr>
            <td class="fs-9">Tanggal Lahir</td>
            <td class="fs-9">:</td>
            <td class="fs-9">{{ $data->date_of_birth ? \Carbon\Carbon::parse($data->date_of_birth)->isoFormat('D MMMM Y') : '-' }}</td>
        </tr>
        <tr>
            <td class="fs-9">Jenis Kelamin</td>
            <td class="fs-9">:</td>
            <td class="fs-9">{{ $data->gender ? $data->gender() : '-' }}</td>
        </tr>
        <tr>
            <td class="fs-9">Alamat</td>
            <td class="fs-9">:</td>
            <td class="fs-9">
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
