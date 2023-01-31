<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <style>
        @page {
            margin: 0;
        }

		.id-card {
            border: 4px solid #86c1ff;
            shadow: none;
			padding: 10px;
			text-align: center;
            height: 100%;
		}
    </style>
</head>
<body>
    <div class="id-card">
        <div class="header">
            <img src="{{ asset('assets/icon.png') }}" style="max-width:70px;">
        </div>
        <h2 style="margin-top:7px; margin-bottom:7px; font-size:12px; color:#06407d;">{{ $data->name }}</h2>
        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG("$data->id", 'QRCODE', 3.5, 3.5, [12, 131, 255]) }}" style="margin-bottom:5px;">
        <div style="margin-top:5px; margin-bottom:5px; font-size:12px; color:#06407d;">https://rsud.kedirikab.go.id/</div>
        <hr style="margin-top:5px; margin-bottom:5px;">
        <table style="width:100px;">
            <tr>
                <th style="font-size:9px; text-align:left; white-space:nowrap; color:#06407d;">No RM</th>
                <td style="font-size:9px;">:</td>
                <td style="font-size:9px; color:#064a8f;">{{ $data->no_medical_record }}</td>
            </tr>
            <tr>
                <th style="font-size:9px; text-align:left; white-space:nowrap; color:#06407d;">Lahir</th>
                <td style="font-size:9px;">:</td>
                <td style="font-size:9px; color:#064a8f;">{{ $data->date_of_birth ? date('d-m-Y', strtotime($data->date_of_birth)) : '-' }}</td>
            </tr>
            <tr>
                <th style="font-size:9px; text-align:left; white-space:nowrap; color:#06407d;">Alamat</th>
                <td style="font-size:9px;">:</td>
                <td style="font-size:9px; color:#064a8f;">
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
    </div>
</body>
</html>
