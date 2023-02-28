<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $title }}</title>
</head>
<body>
    @include('pdf.header')
    <table style="width:100%;">
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Pasien</td>
            <td>:</td>
            <td>{{ $data->patient->name }}</td>
            <td style="font-weight:bold;">Dokter</td>
            <td>:</td>
            <td>{{ $data->doctor->name ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $data->patient->gender_format_result }}</td>
            <td style="font-weight:bold;">Golongan</td>
            <td>:</td>
            <td>{{ $data->type_format_result ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Tanggal Masuk</td>
            <td>:</td>
            <td>{{ date('d-m-Y', strtotime($data->date_of_entry)) }}</td>
            <td style="font-weight:bold;">Kamar</td>
            <td>:</td>
            <td>{{ $data->roomType->name ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Jam Masuk</td>
            <td>:</td>
            <td>{{ date('H:i:s', strtotime($data->date_of_request)) }}</td>
            <td style="font-weight:bold;">Didata Oleh</td>
            <td>:</td>
            <td>{{ $data->user->employee->name ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Tangal Lahir</td>
            <td>:</td>
            <td>{{ $data->patient->date_of_birth }}</td>
            <td style="font-weight:bold;">Hasil</td>
            <td>:</td>
            <td>{{ $data->ending_format_result }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Tangal Cetak</td>
            <td>:</td>
            <td>{{ now() }}</td>
            <td style="font-weight:bold;">Kode</td>
            <td>:</td>
            <td>{{ $data->code() }}</td>
        </tr>
    </table>
    <hr style="margin-top:20px; margin-bottom:20px;">
    <div style="text-align:center; margin-bottom:10px;">NOMINAL YANG TERBAYAR</div>
    <div style="text-align:center; font-weight:bold; font-size:25px;">{{ Simrs::formatRupiah($data->totalAction()) }}</div>
    <div style="text-align:center; font-weight:400; font-style:italic; margin-top:10px; font-size:14px;">
        Terbilang : {{ Simrs::numerator($data->totalAction()) }}
    </div>
    <hr style="margin-top:20px; margin-bottom:20px;">
    <table style="width:100%;">
        <tr style="text-align:center;">
            <td width="50%">
                <div style="font-size:14px; margin-bottom:60px;">Penyetor</div>
                <div style="font-size:14px; margin-bottom:3px; text-decoration:underline;">(.............................)</div>
            </td>
            <td width="50%">
                <div style="font-size:14px; margin-bottom:60px;">Kasir</div>
                <div style="font-size:14px; margin-bottom:3px; text-decoration:underline;">({{ auth()->user()->employee->name }})</div>
            </td>
        </tr>
    </table>
</body>
</html>
