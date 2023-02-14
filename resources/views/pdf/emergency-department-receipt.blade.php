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
            <td style="font-weight:bold;">Kode</td>
            <td>:</td>
            <td>{{ $data->code() }}</td>
            <td style="font-weight:bold;">Status</td>
            <td>:</td>
            <td>{{ $data->status_format_result ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Pasien</td>
            <td>:</td>
            <td>{{ $data->patient->name ?? '-' }}</td>
            <td style="font-weight:bold;">Agama</td>
            <td>:</td>
            <td>{{ $data->patient->religion->name ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">No RM</td>
            <td>:</td>
            <td>{{ $data->patient->id ?? '-' }}</td>
            <td style="font-weight:bold;">Umur</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($data->patient->date_of_birth)->age . ' Tahun' ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $data->patient->gender_format_result ?? '-' }}</td>
            <td style="font-weight:bold;">Dokter</td>
            <td>:</td>
            <td>{{ $data->doctor->name ?? '-' }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">UPF</td>
            <td>:</td>
            <td>{{ $data->functionalService->name ?? '-' }}</td>
            <td style="font-weight:bold;">Tanggal Cetak</td>
            <td>:</td>
            <td>{{ now() }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Golongan</td>
            <td>:</td>
            <td>{{ $data->type_format_result }}</td>
            <td style="font-weight:bold;">Tanggal Masuk</td>
            <td>:</td>
            <td>{{ $data->date_of_entry }}</td>
        </tr>
        <tr style="font-size:14px;">
            <td style="font-weight:bold;">Hasil</td>
            <td>:</td>
            <td>{{ $data->ending_format_result }}</td>
            <td style="font-weight:bold;">Tanggal Keluar</td>
            <td>:</td>
            <td>{{ !empty($data->date_of_out) ? $data->date_of_out : '-' }}</td>
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
        </tbody>
    </table>
    <table style="width:100%;">
        <tr style="text-align:center;">
            <td>
                <div style="font-size:14px; margin-bottom:60px;">Yang Bersangkutan</div>
                <div style="font-size:14px; text-decoration:underline;">(.............................)</div>
            </td>
            <td>
                <div style="font-size:14px; margin-bottom:60px;">Petugas</div>
                <div style="font-size:14px; text-decoration:underline;">(.............................)</div>
            </td>
        </tr>
    </table>
</body>
</html>
