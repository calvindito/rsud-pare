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
            <td style="font-weight:bold;">Poli</td>
            <td>:</td>
            <td>{{ $data->outpatient->unit->name }}</td>
            <td style="font-weight:bold;">Kehadiran</td>
            <td>:</td>
            <td>{{ $data->outpatient->presence_format_result }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Tanggal Masuk</td>
            <td>:</td>
            <td>{{ $data->outpatient->date_of_entry }}</td>
            <td style="font-weight:bold;">Tanggal Cetak</td>
            <td>:</td>
            <td>{{ now() }}</td>
        </tr>
    </table>
    <table class="table" style="margin-bottom:20px;">
        <tbody>
            <tr>
                <td>
                    <div style="text-align:center; margin-bottom:10px;">NOMINAL YANG HARUS DIBAYAR</div>
                    <div style="text-align:center; font-weight:bold; font-size:25px;">{{ Simrs::formatRupiah($data->total()) }}</div>
                    <div style="text-align:center; font-weight:400; font-style:italic; margin-top:10px; font-size:14px;">
                        Terbilang : {{ Simrs::numerator($data->total()) }}
                    </div>
                </td>
            </tr>
            <tr>
                <td style="text-align:center;">{{ $data->unitAction->action->name }}</td>
            </tr>
        </tbody>
    </table>
    <table style="width:100%;">
        <tr style="text-align:center;">
            <td style="text-align:right;">
                <div style="font-size:14px;">Pare, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</div>
                <div style="font-size:14px; margin-bottom:60px;">Petugas Poli</div>
                <div style="font-size:14px; text-decoration:underline;">(.............................)</div>
            </td>
        </tr>
    </table>
</body>
</html>
