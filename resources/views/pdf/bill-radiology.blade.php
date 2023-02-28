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
            <td>{{ $data->radiologyRequestable->type_format_result ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Tanggal Permintaan</td>
            <td>:</td>
            <td>{{ date('d-m-Y', strtotime($data->date_of_request)) }}</td>
            <td style="font-weight:bold;">Ref</td>
            <td>:</td>
            <td>{{ $data->ref() }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Jam Permintaan</td>
            <td>:</td>
            <td>{{ date('H:i:s', strtotime($data->date_of_request)) }}</td>
            <td style="font-weight:bold;">Pemeriksa</td>
            <td>:</td>
            <td>{{ $data->user->employee->name ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Tangal Lahir</td>
            <td>:</td>
            <td>{{ $data->patient->date_of_birth }}</td>
            <td style="font-weight:bold;">Tindakan</td>
            <td>:</td>
            <td>{{ $data->radiology->type . ' - ' . $data->radiology->object . ' - ' . $data->radiology->projection }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Klinis</td>
            <td>:</td>
            <td>{{ $data->clinical }}</td>
            <td style="font-weight:bold;">Kritis</td>
            <td>:</td>
            <td>{{ $data->critical ? 'Ya' : 'Tidak' }}</td>
        </tr>
    </table>
    <hr style="margin-top:20px; margin-bottom:20px;">
    <div style="text-align:center; margin-bottom:10px;">NOMINAL YANG TERBAYAR</div>
    <div style="text-align:center; font-weight:bold; font-size:25px;">{{ Simrs::formatRupiah($data->total()) }}</div>
    <div style="text-align:center; font-weight:400; font-style:italic; margin-top:10px; font-size:14px;">
        Terbilang : {{ Simrs::numerator($data->total()) }}
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
