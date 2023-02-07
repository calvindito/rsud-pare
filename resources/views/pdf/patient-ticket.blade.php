<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $title }}</title>

    <style>
        @page {
            margin: 10px;
        }
    </style>
</head>
<body>
    <center>
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/icon.png'))) }}" style="max-width:100px; margin-bottom:10px;">
        <div style="font-size:18px; font-weight:bold; text-transform:uppercase; margin-bottom:10px;">{{ $title }}</div>
        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG("$data->id", 'QRCODE', 3.5, 3.5) }}" style="margin-bottom:10px;">
        <div style="font-size:14px; font-weight:bold; text-transform:uppercase;">{{ $data->name }}</div>
        <hr style="margin:10px 0 10px 0; width:100%;">
    </center>
    <table style="width:100%;">
        <tr style="font-size:12px;">
            <td style="font-weight:bold;">No RM</td>
            <td>:</td>
            <td>{{ $data->id }}</td>
        </tr>
        <tr style="font-size:12px;">
            <td style="font-weight:bold;">Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $data->gender_format_result }}</td>
        </tr>
        <tr style="font-size:12px;">
            <td style="font-weight:bold;">Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $data->date_of_birth }}</td>
        </tr>
        <tr style="font-size:12px;">
            <td style="font-weight:bold;">Agama</td>
            <td>:</td>
            <td>{{ $data->religion->name ?? '-' }}</td>
        </tr>
    </table>
</body>
</html>
