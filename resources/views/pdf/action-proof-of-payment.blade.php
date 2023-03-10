<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $title }}</title>
    <style>
        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table td, .table th {
            border: solid thin;
            padding: 0.5rem;
            font-size: 12px;
        }

        .table th {
            font-weight: bold;
        }

        .table td {
            vertical-align: middle;
        }

        .table tbody td:first-child::after {
            content: leader(". ");
        }
    </style>
</head>
<body>
    @include('pdf.header')
    <table style="width:100%; margin-bottom:20px;">
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Pasien</td>
            <td>:</td>
            <td>{{ $data->outpatient->patient->name }}</td>
            <td style="font-weight:bold;">Dokter</td>
            <td>:</td>
            <td>{{ $data->doctor->name ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $data->outpatient->patient->gender_format_result }}</td>
            <td style="font-weight:bold;">Golongan</td>
            <td>:</td>
            <td>{{ $data->outpatient->type_format_result ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Tanggal Masuk</td>
            <td>:</td>
            <td>{{ $data->outpatient->date_of_entry }}</td>
            <td style="font-weight:bold;">Kehadiran</td>
            <td>:</td>
            <td>{{ $data->outpatient->presence_format_result }}</td>
        </tr>
    </table>
    <table class="table" style="margin-bottom:20px;">
        <tbody>
            <tr>
                <td colspan="3">
                    <div style="text-align:center; margin-bottom:10px;">NOMINAL YANG SUDAH DIBAYAR</div>
                    <div style="text-align:center; font-weight:bold; font-size:25px;">{{ Simrs::formatRupiah($data->total()) }}</div>
                </td>
            </tr>
            <tr>
                <td>Terbilang</td>
                <td width="1%">:</td>
                <td>{{ Simrs::numerator($data->total()) }}</td>
            </tr>
            <tr>
                <td>Tindakan</td>
                <td width="1%">:</td>
                <td>{{ $data->unitAction->action->name }}</td>
            </tr>
            <tr>
                <td>Poli</td>
                <td width="1%">:</td>
                <td>{{ $data->outpatient->unit->name }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td width="1%">:</td>
                <td>{{ now() }}</td>
            </tr>
        </tbody>
    </table>
    <table style="width:100%;">
        <tr style="text-align:center;">
            <td>
                <div style="font-size:14px; margin-bottom:60px;">Penyetor</div>
                <div style="font-size:14px; text-decoration:underline;">(.............................)</div>
            </td>
            <td>
                <div style="font-size:14px; margin-bottom:60px;">Petugas Poli</div>
                <div style="font-size:14px; text-decoration:underline;">(.............................)</div>
            </td>
        </tr>
    </table>
</body>
</html>
